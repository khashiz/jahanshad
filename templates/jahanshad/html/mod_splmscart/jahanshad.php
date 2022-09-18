<?php

/**
 * @package com_splms
 * @subpackage  mod_splmscart
 *
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2022 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */

// No Direct Access
defined ('_JEXEC') or die('Resticted Aceess');

use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Component\ComponentHelper;

//Joomla Component Helper & Get LMS Params
jimport('joomla.application.component.helper');
$splmsparams = ComponentHelper::getParams('com_splms');

//Get Currency
$currency = explode(':', $splmsparams->get('currency', 'USD:$'));
$currency =  $currency[1];

// Get image thumb
$thumb_size = strtolower($splmsparams->get('course_thumbnail_small', '100X60'));
$cart_url = Route::_('index.php?option=com_splms&view=cart'. splmshelper::getItemid('cart'));

?>
<div class="uk-width-auto uk-flex uk-flex-middle <?php echo $moduleclass_sfx; ?>">
	<?php if(count($items)) { ?>
        <span class="uk-button uk-button-default uk-button-large uk-border-rounded uk-button-icon uk-box-shadow-small"><i class="fas fa-shopping-bag"></i></span>
        <div data-uk-drop="pos: bottom; offset:17; animation: uk-animation-slide-bottom-small;">
            <div class="topDrop">
                <div class="topDropWrapper">
                    <div class="uk-padding-small uk-text-zero">
                        <div class="uk-grid-small uk-child-width-1-1 " data-uk-grid>
		                    <?php $total = 0; ?>
		                    <?php foreach ($items as $item) { ?>
			                    <?php $generate_price = SplmsHelper::getPrice($item->price, $item->sale_price); ?>
			                    <?php $cart_price = ($item->sale_price > 0) ? $item->sale_price : $item->price; ?>
                                <div>
                                    <div class="uk-grid-small" data-uk-grid>
                                        <div class="uk-width-1-3">
                                            <a href="<?php echo $item->url; ?>" class="uk-display-block uk-border-rounded uk-box-shadow-small uk-overflow-hidden uk-cover-container">
                                                <canvas width="100" height="100"></canvas>
                                                <img src="<?php echo !empty($item->image) ? $item->thumbnail : 'images/placeholder.svg'; ?>" alt="<?php echo $item->title; ?>" data-uk-cover>
                                            </a>
                                        </div>
                                        <div class="uk-width-expand uk-flex uk-flex-middle">
                                            <div class="uk-flex-1">
                                                <h3 class="uk-margin-remove uk-h5"><a class="uk-display-block uk-text-primary font f500" href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a></h3>
                                                <div><?php echo $generate_price; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
			                    <?php $total = $total + $cart_price; ?>
		                    <?php } ?>
                        </div>
                    </div>
                    <div class="uk-padding-small uk-padding-remove-vertical">
                        <hr class="uk-margin-remove">
                    </div>
                    <div class="uk-padding-small">
                        <div class="uk-grid-small" data-uk-grid>
                            <div class="uk-width-expand uk-flex uk-flex-middle">
                                <div>
                                    <span class="uk-display-block uk-text-muted uk-text-tiny font f500"><?php echo Text::_('MOD_SPLMS_CART_YOUR_TOTAL');?></span>
                                    <span class="uk-display-block"><?php echo SplmsHelper::getPrice($total); ?></span>
                                </div>
                            </div>
                            <div class="uk-width-auto">
                                <a href="<?php echo $cart_url; ?>" class="uk-button uk-button-primary">
                                    <i class="far fa-shopping-bag"></i>
                                    <span><?php echo Text::_('MOD_SPLMS_CART_GOTO_CART');?></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	<?php } else {?>
        <span class="uk-button uk-button-default uk-button-disabled uk-button-large uk-border-rounded uk-button-icon uk-box-shadow-small" data-uk-tooltip="title:<?php echo Text::_('MOD_SPLMS_CART_EMPTY');?>; pos: right;"><i class="fas fa-shopping-bag"></i></span>
    <?php } ?>
</div>