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
<div>
    <div class="item-content">
        <figure class="uk-margin-bottom left item-image">
            <a href="<?php echo $item->link; ?>" class="uk-display-block uk-cover-container uk-border-rounded uk-overflow-hidden uk-box-shadow-small" itemprop="url" title="<?php echo $item->title; ?>">
                <canvas width="400" height="300"></canvas>
                <?php
                if (!empty($item->imageSrc)) {
                    echo LayoutHelper::render(
                        'joomla.html.image',
                        [
                            'data-uk-cover' => '',
                            'src' => $item->imageSrc,
                            'alt' => $item->imageAlt,
                        ]
                    );
                } else {
                    echo LayoutHelper::render(
                        'joomla.html.image',
                        [
                            'data-uk-cover' => '',
                            'src' => JUri::base().'images/placeholder.svg',
                            'alt' => $item->imageAlt,
                        ]
                    );
                }
                ?>
            </a>
            <?php if (!empty($item->imageCaption)) : ?>
                <figcaption>
                    <?php echo $item->imageCaption; ?>
                </figcaption>
            <?php endif; ?>
        </figure>
        <div class="uk-margin-bottom">
            <dl class="uk-child-width-auto uk-grid-divider uk-grid-small" data-uk-grid>
                <dd class="uk-flex uk-flex-middle">
                    <i class="far fa-calendar-o uk-text-muted icon16 uk-margin-small-left"></i>
                    <time class="uk-text-secondary uk-text-tiny font f500 ss02" datetime="<?php echo $item->publish_up; ?>" itemprop="datePublished"><?php echo Jhtml::date($item->publish_up, 'D m Y'); ?></time>
                </dd>
                <dd class="uk-flex uk-flex-middle">
                    <i class="far fa-chart-line uk-text-muted icon16 uk-margin-small-left"></i>
                    <meta itemprop="interactionCount" content="UserPageVisits:<?php echo $item->hits; ?>">
                    <span class="uk-text-secondary uk-text-tiny font f500 ss02"><?php echo JText::sprintf('COM_CONTENT_ARTICLE_HITS', $item->hits); ?></span>
                </dd>
            </dl>
        </div>
	    <?php if ($params->get('item_title')) : ?>
        <?php $item_heading = $params->get('item_heading', 'h4'); ?>
        <div class="page-header">
            <<?php echo $item_heading; ?> itemprop="name" class="uk-text-zero uk-margin-remove">
                <?php if ($item->link !== '' && $params->get('link_titles')) : ?>
                    <a href="<?php echo $item->link; ?>" title="<?php echo $item->title; ?>" itemprop="url" class="uk-display-block uk-h5 uk-margin-remove font f700 uk-text-secondary">
                        <?php echo $item->title; ?>
                    </a>
                <?php else : ?>
                    <?php echo $item->title; ?>
                <?php endif; ?>
            </<?php echo $item_heading; ?>>
        </div>
        <?php endif; ?>
    </div>
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