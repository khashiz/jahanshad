<?php

use Joomla\CMS\Uri\Uri;
/**
* @package com_splms
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2022 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Resticted Aceess');

$columns = $this->params->get('columns', '4');
?>
<?php if ($this->params->get('show_page_heading')) : ?>
    <div class="page-header">
        <h1 class="font uk-h3 f900 uk-text-white uk-text-center uk-margin-medium-bottom"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
    </div>
<?php endif; ?>
<div id="splms" class="uk-slider-container-offset" data-uk-slider>
	<?php if(count($this->items)) { ?>
		<?php foreach(array_chunk($this->items, $columns) as $this->items) { ?>
            <div class="uk-position-relative uk-visible-toggle">
                <div class="uk-slider-items uk-child-width-1-2 uk-child-width-1-5@s uk-grid" data-uk-scrollspy="cls: uk-animation-slide-bottom-small; target: > div; delay: 250;">
					<?php foreach ($this->items as $item) { ?>
                        <div>
                            <a href="<?php echo $item->url; ?>" class="uk-box-shadow-small uk-border-rounded uk-padding uk-display-block uk-background-white uk-link-reset uk-text-center">
                                <div class="uk-margin-small-bottom">
                                    <span class="uk-text-secondary uk-display-block">
                                        <?php if($item->show == 1 && $item->image){ ?>
                                            <img src="<?php echo Uri::root() . $item->image; ?>">
                                        <?php } else { ?>
                                            <i class="uk-text-accent <?php echo $item->icon; ?>"></i>
                                        <?php } ?>
                                    </span>
                                </div>
                                <span class="uk-display-block uk-text-secondary uk-text-small font f900 ss02 uk-margin-small-bottom"><?php echo $item->title; ?></span>
                                <span class="uk-display-block uk-text-muted uk-text-tiny font f700 ss02"><?php echo JText::sprintf('COURSE_COUNT', $item->courses); ?></span>
								<?php
								if($this->subcategoryEnabled){
									$subCatLinks = [];
									foreach($item->subcategories as $subCat){
										$subCatLinks[] = "<a href='{$subCat->url}'>{$subCat->title} ({$subCat->courses})</a>";
									}
									echo implode(', ',$subCatLinks);
								}
								?>
                            </a>
                        </div>
					<?php } ?>
                </div>
                <a class="uk-position-center-left uk-position-small uk-hidden-hover" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
                <a class="uk-position-center-right uk-position-small uk-hidden-hover"  data-uk-slidenav-next data-uk-slider-item="next"></a>
            </div>
            <ul class="uk-dotnav uk-flex-center uk-margin-remove-bottom uk-margin-medium-top">
                <?php $i=0; foreach ($this->items as $item) { ?>
                    <li data-uk-slider-item="<?php echo $i; ?>"><span></span></li>
                <?php $i++; } ?>
            </ul>
		<?php } ?>
	<?php } ?>
	<?php if ($this->params->get('hide_pagination') == 0) { ?>
		<?php if ($this->pagination->pagesTotal > 1) { ?>
			<div><?php echo $this->pagination->getPagesLinks(); ?></div>
		<?php } ?>
	<?php } ?>
</div>