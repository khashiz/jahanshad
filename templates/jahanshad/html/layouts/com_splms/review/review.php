<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2021 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

use Joomla\CMS\Layout\LayoutHelper;

$review = $displayData['review'];

if(isset($review) && $review) {
?>
<div class="review-wrap review-item uk-text-zero" id="review-id-<?php echo $review->id; ?>" data-review_id="<?php echo $review->id; ?>">
    <div class="uk-grid-small" data-uk-grid>
        <div class="uk-width-auto uk-visible@s">
            <img src="<?php echo SplmsHelper::getAvatar($review->created_by); ?>" alt="" class="uk-border-circle uk-box-shadow-small" width="64" height="64">
        </div>
        <div class="uk-width-1-1 uk-width-expand@s">
            <div>
                <div class="uk-child-width-auto uk-grid-divider uk-grid-small" data-uk-grid>
                    <div class="uk-flex uk-flex-middle">
                        <i class="far fa-user-alt uk-text-muted icon16 uk-margin-small-left"></i>
                        <span class="uk-text-secondary uk-text-tiny font f500"><?php echo $review->name; ?></span>
                    </div>
                    <div class="uk-flex uk-flex-middle">
                        <i class="far fa-clock uk-text-muted icon16 uk-margin-small-left"></i>
                        <span class="uk-text-secondary uk-text-tiny font f500 ss02" itemprop="dateCreated"><?php echo SplmsHelper::timeago($review->created); ?></span>
                    </div>
                    <div class="uk-flex uk-flex-middle"><?php echo LayoutHelper::render('review.ratings', array('rating'=>$review->rating)); ?></div>
                </div>
            </div>
	        <?php if(isset($review->review) && $review->review) { ?>
                <p class="uk-text-secondary uk-text-small uk-text-justify font f700"><?php echo nl2br($review->review); ?></p>
            <?php } ?>
        </div>
    </div>
</div>
<?php }