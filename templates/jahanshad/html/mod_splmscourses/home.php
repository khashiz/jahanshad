<?php
/**
* @package com_splms
* @subpackage  mod_splmscourses
*
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2022 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Resticted Aceess');

use Joomla\CMS\Language\Text;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Component\ComponentHelper;

//Joomla Component Helper & Get LMS Params
$splmsparams = ComponentHelper::getParams('com_splms');

//Get Currency
$currency = explode(':', $splmsparams->get('currency', 'USD:$'));
$currency =  $currency[1];

// Get image thumb
$thumb_size = strtolower($splmsparams->get('course_thumbnail_small', '100X60'));

?>
<div class="uk-container uk-container-large">
    <div class="uk-position-relative">
        <div class="uk-slider-container-offset" data-uk-slider>
            <div class="uk-position-relative">
                <div class="uk-slider-items uk-child-width-1-1 uk-child-width-1-4@s uk-grid" data-uk-scrollspy="cls: uk-animation-slide-bottom-small; target: > div; delay: 250;">
				    <?php foreach ($items as $item) {
//                    print_r($item);
					    $discount_percentage = '';
					    if( $show_discount && ($item->price > $item->sale_price) && ($item->sale_price != '0.00' && $item->price != '0.00') ) {
						    $discount_percentage = (($item->price - $item->sale_price)*100) /$item->price;
					    } ?>

					    <?php
					    $filename = basename($item->image);
					    $path = JPATH_BASE .'/'. dirname($item->image) . '/thumbs/' . File::stripExt($filename) . '_' . $thumb_size . '.' . File::getExt($filename);
					    $src = JURI::base(true) . '/' . dirname($item->image) . '/thumbs/' . File::stripExt($filename) . '_' . $thumb_size . '.' . File::getExt($filename);

					    if(File::exists($path)) {
						    $thumb = $src;
					    } else {
						    $thumb = $item->image;
					    }
					    ?>

                        <div>
                            <div class="uk-box-shadow-small uk-border-rounded uk-overflow-hidden uk-height-1-1 uk-flex uk-flex-column">
                                <div class="uk-position-relative">
                                    <div class="uk-position-small uk-position-top-right badges uk-position-z-index">
									    <?php if ($item->featured_course) { ?>
                                            <span class="uk-badge uk-badge-primary uk-box-shadow-small ss02"><?php echo JText::_('COM_SPLMS_FEATURED_COURSE'); ?></span>
									    <?php } ?>
                                    </div>
                                    <div class="uk-position-small uk-position-top-left badges uk-position-z-index">
									    <?php if ($item->price == 0) { ?>
                                            <span class="uk-badge uk-badge-success uk-box-shadow-small"><?php echo Text::_('COM_SPLMS_FREE'); ?></span>
									    <?php } ?>
									    <?php if($show_discount && isset($discount_percentage) && $discount_percentage) { ?>
                                            <span class="uk-badge uk-badge-success uk-box-shadow-small ss02"><?php echo Text::sprintf('COM_SPLMS_COURSES_PERCENT_OFF', round($discount_percentage)); ?></span>
									    <?php }?>
                                    </div>
                                    <div class="uk-position-small uk-position-bottom-right badges uk-position-z-index">
									    <?php if ($item->duration) { ?>
                                            <span class="uk-badge uk-badge-default uk-box-shadow-small ss02"><?php echo $item->duration; ?></span>
									    <?php } ?>
                                    </div>
                                    <a href="<?php echo $item->url; ?>" class="uk-display-block uk-cover-container">
                                        <canvas width="400" height="300"></canvas>
                                        <img src="<?php echo !empty($thumb) ? $thumb : 'images/placeholder-med.svg'; ?>" class="" alt="<?php echo $item->title; ?>" data-uk-cover>
                                    </a>
                                </div>
                                <div class="uk-padding-small uk-flex-1">
                                    <div class="uk-flex uk-flex-column uk-flex-between uk-height-1-1">
                                        <div>
                                            <h3 class="uk-text-zero uk-margin-remove-top uk-margin-small-bottom">
                                                <a href="<?php echo $item->url; ?>" class="uk-display-block uk-h5 uk-margin-remove font f700 uk-text-secondary"><?php echo $item->title; ?></a>
                                            </h3>
										    <?php if(isset($item->short_description) && !empty($item->short_description)) { ?>
                                                <p class="uk-text-muted uk-text-tiny uk-text-justify f500"><?php echo $item->short_description; ?></p>
										    <?php } ?>
                                        </div>
                                        <div>
                                            <div class="uk-margin-bottom">
                                                <ul class="uk-grid-divider uk-grid-small" data-uk-grid>
                                                    <li>
                                                        <?php if ($item->price == 0) { ?>
                                                            <span class="uk-display-block uk-text-success uk-text-small font ss02 f900"><?php echo Text::_('COM_SPLMS_FREE'); ?></span>
                                                        <?php } else { ?>
                                                            <?php echo SplmsHelper::getPrice($item->price, $item->sale_price); ?>
                                                        <?php } ?>
                                                    </li>
												    <?php if ($item->lessonsCount) { ?>
                                                        <li class="uk-flex uk-flex-bottom"><span class="uk-display-block uk-text-secondary uk-text-small font ss02 f900"><?php echo Text::sprintf('COM_SPLMS_COMMON_LESSONS', $course->lessonsCount); ?></span></li>
												    <?php } ?>
                                                </ul>
                                            </div>
                                            <a href="<?php echo $item->url; ?>" class="uk-button uk-button-primary uk-button-large uk-border-rounded uk-box-shadow-small uk-flex-center uk-width-1-1">
                                                <i class="far fa-info-circle"></i>
                                                <span><?php echo JText::_('COM_SPLMS_DETAILS'); ?></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
				    <?php } ?>
                </div>
            </div>
            <span class="uk-position-center-left-out uk-position-medium uk-flex uk-flex-middle uk-flex-center sliderArrow previous uk-border-circle cursorPointer uk-box-shadow-small uk-box-shadow-hover-medium uk-visible@s" data-uk-slider-item="previous"><i class="fas fa-chevron-left"></i></span>
            <span class="uk-position-center-right-out uk-position-medium uk-flex uk-flex-middle uk-flex-center sliderArrow next uk-border-circle cursorPointer uk-box-shadow-small uk-box-shadow-hover-medium uk-visible@s" data-uk-slider-item="next"><i class="fas fa-chevron-right"></i></span>
            <ul class="uk-dotnav uk-flex-center uk-margin-remove-bottom uk-margin-medium-top dark uk-hidden@s">
			    <?php $d=0; foreach ($items as $item) { ?>
                    <li data-uk-slider-item="<?php echo $d; ?>"><span></span></li>
				    <?php $d++; } ?>
            </ul>
        </div>
    </div>
</div>