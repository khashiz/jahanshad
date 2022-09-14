<?php

/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2021 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

use Joomla\CMS\Language\Text;

$contents     = $displayData['contents'];
list($content, $price, $isAuthorised, $active) = $contents;
?>

<?php if ( $content->lesson_type == 0 || $price == 0 || $isAuthorised != '' ) { ?>
    <div class="<?php echo (!empty($active) && $active == $content->id) ? 'active' : ''; ?>">
        <div class="uk-background-muted uk-border-rounded uk-padding-small">
            <div class="uk-grid-small" data-uk-grid>
                <div class="uk-flex uk-flex-middle"><i class="far fa-<?php echo $price == 0 ? 'home' : 'check-circle'; ?> uk-text-success fa-fw icon24"></i></div>
	            <?php if (!empty($content->video_url)) :?>
                    <div class="uk-width-expand uk-flex uk-flex-middle"><a href="<?php echo $content->lesson_url; ?>" class="uk-text-small font ss02 uk-text-secondary f700"><?php echo $content->title; ?></a></div>
		            <?php if (!empty($content->video_duration)) :?>
                        <div class="uk-width-auto uk-text-small font ss02 uk-text-secondary f700"><?php echo '<span class="uk-text-muted">'.JText::sprintf('COM_SPLMS_COMMON_DURATION').' : </span>'.$content->video_duration; ?></div>
		            <?php endif;?>
	            <?php else :?>
                    <div><a href="<?php echo $content->lesson_url; ?>" class="uk-text-small font ss02 uk-text-secondary f700"><?php echo $content->title; ?></a></div>
	            <?php endif;?>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div>
        <div class="uk-background-muted uk-border-rounded uk-padding-small">
            <div class="uk-grid-small" data-uk-grid>
                <div class="uk-flex uk-flex-middle"><i class="far fa-lock-alt uk-text-danger fa-fw icon24"></i></div>
			    <?php if (!empty($content->video_url)) :?>
                    <div class="uk-width-expand uk-flex uk-flex-middle"><a href="<?php echo $content->lesson_url; ?>" class="uk-text-small font ss02 uk-text-secondary f700"><?php echo $content->title; ?></a></div>
				    <?php if (!empty($content->video_duration)) :?>
                        <div class="uk-width-auto uk-text-small font ss02 uk-text-secondary f700"><?php echo '<span class="uk-text-muted">'.JText::sprintf('COM_SPLMS_COMMON_DURATION').' : </span>'.$content->video_duration; ?></div>
				    <?php endif;?>
			    <?php else :?>
                    <div><a href="<?php echo $content->lesson_url; ?>" class="uk-text-small font ss02 uk-text-secondary f700"><?php echo $content->title; ?></a></div>
			    <?php endif;?>
            </div>
        </div>
    </div>
<?php } ?>