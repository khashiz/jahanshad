<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_news
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

if (!$list) {
    return;
}

?>
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
        <div class="uk-slider-container-offset" data-uk-slider="autoplay: true; autoplay-interval: 2000; velocity: 5;">
            <div class="uk-position-relative">
                <div class="uk-slider-items uk-child-width-1-1 uk-child-width-1-4@s uk-grid" data-uk-scrollspy="cls: uk-animation-slide-bottom-small; target: > div; delay: 250;">
				    <?php foreach ($list as $item) : ?>
                        <div class="mod-articlesnews__item" itemscope itemtype="https://schema.org/Article">
						    <?php require ModuleHelper::getLayoutPath('mod_articles_news', '_homeitem'); ?>
                        </div>
				    <?php endforeach; ?>
                </div>
            </div>
            <span class="uk-position-center-left-out uk-position-medium uk-flex uk-flex-middle uk-flex-center sliderArrow previous uk-border-circle cursorPointer uk-box-shadow-small uk-box-shadow-hover-medium uk-visible@s" data-uk-slider-item="previous"><i class="fas fa-chevron-left"></i></span>
            <span class="uk-position-center-right-out uk-position-medium uk-flex uk-flex-middle uk-flex-center sliderArrow next uk-border-circle cursorPointer uk-box-shadow-small uk-box-shadow-hover-medium uk-visible@s" data-uk-slider-item="next"><i class="fas fa-chevron-right"></i></span>
            <ul class="uk-dotnav uk-flex-center uk-margin-remove-bottom uk-margin-medium-top dark uk-hidden@s">
			    <?php $d=0; ?>
			    <?php foreach ($list as $item) { ?>
                    <li data-uk-slider-item="<?php echo $d; ?>">
                        <span></span>
                    </li>
				    <?php $d++; ?>
			    <?php } ?>
            </ul>
        </div>
    </div>
</div>