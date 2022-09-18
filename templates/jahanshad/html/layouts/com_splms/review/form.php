<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2021 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

$review = $displayData['review'];
$user = Factory::getUser();
$can_rate = ($user->id) ? 'can-rate': '';

?>

<?php if($review) { ?>
<div id="reviewers-form-popup" style="display:none">
	<a class="close-popup" href="#"><i class="fa fa-times"></i></a>
	<?php } ?>
	<div>
		<div>
			<div class="uk-margin-large-bottom reviewers-form">
				<form id="form-item-review" class="uk-width-1-1">
                    <div class="uk-child-width-1-1 uk-grid-small" data-uk-grid>
                        <div class="uk-flex uk-flex-middle">
                            <span class="uk-text-secondary uk-text-tiny font f700 uk-margin-left"><?php echo JText::_('YOUR_VOTE_TO_THIS').' :'; ?></span>
	                        <?php
	                        if($review) {
		                        $rating = $review->rating;
	                        } else {
		                        $rating = 1;
	                        }
	                        echo LayoutHelper::render('review.ratings', array('rating'=>$rating, 'class'=>$can_rate));
	                        ?>
                        </div>
	                    <?php if($review) { ?>
                            <div>
                                <textarea name="review" id="input-review" class="uk-textarea" placeholder="<?php echo JText::_('WRITE_YOUR_REVIEW'); ?>" cols="30" rows="10"><?php echo $review->review; ?></textarea>
                                <input type="hidden" id="input-rating" name="rating" value="<?php echo $review->rating; ?>">
                                <input type="hidden" id="input-review-id" name="review_id" value="<?php echo $review->id; ?>">
                            </div>
	                    <?php } else { ?>
                            <div>
                                <textarea name="review" id="input-review" class="uk-textarea" placeholder="<?php echo JText::_('WRITE_YOUR_REVIEW'); ?>" cols="30" rows="10" <?php echo ($user->id) ? '': 'disabled="disabled"'; ?>></textarea>
                                <input type="hidden" id="input-rating" name="rating" value="1">
                                <input type="hidden" id="input-review-id" name="review_id" value="">
                            </div>
	                    <?php } ?>
                        <div>
                            <input type="hidden" name="item_id" value="<?php echo $displayData['item_id']; ?>">
		                    <?php if($user->id) { ?>
                                <button type="submit" name="form[submit]" id="submit-review" class="uk-box-shadow-small uk-box-shadow-hover-medium uk-border-rounded uk-width-1-1 uk-button-large uk-flex-center rsform-submit-button  uk-button uk-button-primary"><i class="far fa-comment-alt"></i><span><?php echo JText::_('COM_SPLMS_SUBMIT_REVIEW'); ?></span></button>
		                    <?php } ?>
                        </div>
                    </div>
				</form>
			</div>
		</div>
	</div>
	
<?php if($review) { ?>
	</div>
<?php } ?>