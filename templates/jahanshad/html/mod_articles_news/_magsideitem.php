<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_news
 *
 * @copyright   (C) 2010 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Layout\LayoutHelper;
?>
<div class="uk-grid-small" data-uk-grid>
    <div class="uk-width-1-3">
        <figure class="">
            <a href="<?php echo $item->link; ?>" title="<?php echo $item->title; ?>" class="uk-display-block uk-cover-container uk-border-rounded uk-box-shadow-small uk-overflow-hidden">
                <canvas width="100" height="100"></canvas>
	            <?php if ($params->get('img_intro_full') !== 'none' && !empty($item->imageSrc)) : ?>
		            <?php echo LayoutHelper::render(
			            'joomla.html.image',
			            [
				            'data-uk-cover' => '',
				            'src' => $item->imageSrc,
				            'alt' => $item->imageAlt,
			            ]
		            ); ?>
                <?php else: ?>
		            <?php echo LayoutHelper::render(
			            'joomla.html.image',
			            [
				            'data-uk-cover' => '',
				            'src' => JUri::base().'images/placeholder.svg',
				            'alt' => $item->imageAlt,
			            ]
		            ); ?>
	            <?php endif; ?>
                <?php if (!empty($item->imageCaption)) : ?>
                    <figcaption>
                        <?php echo $item->imageCaption; ?>
                    </figcaption>
                <?php endif; ?>
            </a>
        </figure>
    </div>
	<?php if ($params->get('item_title')) : ?>
        <div class="uk-width-expand uk-flex uk-flex-middle">
	        <?php $item_heading = $params->get('item_heading', 'h4'); ?>
            <<?php echo $item_heading; ?> class="uk-text-zero uk-margin-remove newsflash-title">
                <?php if ($item->link !== '' && $params->get('link_titles')) : ?>
                    <a href="<?php echo $item->link; ?>" class="uk-display-block uk-h5 uk-margin-remove font f700 uk-text-secondary">
                        <?php echo $item->title; ?>
                    </a>
                <?php else : ?>
                    <?php echo $item->title; ?>
                <?php endif; ?>
            </<?php echo $item_heading; ?>>
        </div>
    <?php endif; ?>
</div>


<?php /* if (!$params->get('intro_only')) : ?>
    <?php echo $item->afterDisplayTitle; ?>
<?php endif; ?>

<?php echo $item->beforeDisplayContent; ?>

<?php if ($params->get('show_introtext', 1)) : ?>
    <?php echo $item->introtext; ?>
<?php endif; ?>

<?php echo $item->afterDisplayContent; ?>

<?php if (isset($item->link) && $item->readmore != 0 && $params->get('readmore')) : ?>
    <?php echo LayoutHelper::render('joomla.content.readmore', array('item' => $item, 'params' => $item->params, 'link' => $item->link)); ?>
<?php endif; */ ?>
