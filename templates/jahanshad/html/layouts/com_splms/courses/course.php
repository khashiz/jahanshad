<?php
/**
 * @package     SP SPLMS
 *
 * @copyright   Copyright (C) 2010 - 2021 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');


use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

$app = Factory::getApplication('com_splms');
$params = $app->getParams();

$course = $displayData['course'];

$show_discount = $params->get('show_discount', 1);
$discount_percentage = '';
if( $show_discount && ($course->price > $course->sale_price) && $course->sale_price && ($course->sale_price != '0.00' && $course->price != '0.00') ) {
    $discount_percentage = (($course->price - $course->sale_price)*100) /$course->price;
}
?>

<div class="uk-box-shadow-small uk-border-rounded uk-overflow-hidden uk-height-1-1 uk-flex uk-flex-column">
    <div class="uk-position-relative">
        <div class="uk-position-small uk-position-top-right badges">
            <?php if ($course->featured_course) { ?>
            <span class="uk-badge uk-badge-primary uk-box-shadow-small ss02"><?php echo JText::_('COM_SPLMS_FEATURED_COURSE'); ?></span>
            <?php } ?>
        </div>
        <div class="uk-position-small uk-position-top-left badges">
	        <?php if ($course->price == 0) { echo '<span class="uk-badge uk-badge-success uk-box-shadow-small">' . Text::_('COM_SPLMS_FREE') . '</span>'; } ?>
	        <?php if( $show_discount && $course->sale_price && isset($discount_percentage) && $discount_percentage) { ?>
                <span class="uk-badge uk-badge-success uk-box-shadow-small ss02"><?php echo Text::sprintf('COM_SPLMS_COURSES_PERCENT_OFF', round($discount_percentage)); ?></span>
	        <?php }?>
        </div>
        <div class="uk-position-small uk-position-bottom-right badges">
            <?php if ($course->duration) { ?>
                <span class="uk-badge uk-badge-default uk-box-shadow-small ss02"><?php echo $course->duration; ?></span>
            <?php } ?>
        </div>
        <img src="<?php echo !empty($course->image) ? $course->thumbnail : 'images/placeholder-med.svg'; ?>" class="" alt="<?php echo $course->title; ?>">
    </div>
    <div class="uk-padding-small uk-flex-1">
        <div class="uk-flex uk-flex-column uk-flex-between uk-height-1-1">
            <div>
                <h3 class="uk-text-zero uk-margin-remove-top uk-margin-small-bottom">
                    <a href="<?php echo $course->url; ?>" class="uk-display-block uk-h5 uk-margin-remove font f700 uk-text-secondary"><?php echo $course->title; ?></a>
                </h3>
                <span class="uk-flex uk-flex-middle uk-text-muted uk-text-tiny f700"><i class="uk-text-warning fas fa-folder-open uk-margin-small-left"></i><?php echo $course->category_name; ?></span>
	            <?php if(isset($course->short_description) && !empty($course->short_description)) { ?>
                    <p class="uk-text-muted uk-text-tiny uk-text-justify f500"><?php echo $course->short_description; ?></p>
	            <?php } ?>
            </div>
            <div>
                <div class="uk-margin-bottom">
                    <ul class="uk-grid-divider uk-grid-small" data-uk-grid>
                        <li>
                            <?php if ($course->price == 0) { ?>
                                <span class="uk-display-block uk-text-success uk-text-small font ss02 f900"><?php echo JText::_('COM_SPLMS_FREE'); ?></span>
                            <?php } else { ?>
	                            <?php echo SplmsHelper::getPrice($course->price, $course->sale_price); ?>
                            <?php } ?>
                            <div class="uk-hidden">
                                <span class="uk-display-block uk-text-muted uk-text-tiny font f500">مجموع مبلغ</span>
                                <span class="uk-display-block uk-text-secondary uk-text-small font ss02 f900"><div class="splms-price-box">2,500,000 تومانء</div></span>
                            </div>
                        </li>
			            <?php if ($course->lessonsCount) { ?>
                            <li class="uk-flex uk-flex-bottom"><span class="uk-display-block uk-text-secondary uk-text-small font ss02 f900"><?php echo Text::sprintf('COM_SPLMS_COMMON_LESSONS', $course->lessonsCount); ?></span></li>
			            <?php } ?>
                    </ul>
                </div>
                <a href="<?php echo $course->url; ?>" class="uk-button uk-button-primary uk-button-large uk-border-rounded uk-box-shadow-small uk-flex-center uk-width-1-1">
                    <i class="far fa-info-circle"></i>
                    <span><?php echo JText::_('COM_SPLMS_DETAILS'); ?></span>
                </a>
            </div>
        </div>
    </div>
	<?php if (!empty($course->teachers)) { ?>
        <div class="splms-course-teacher">
			<?php if(count($course->teachers) == 1) { ?>
                <i class="splms-icon-teacher"></i>
				<?php foreach ($course->teachers as $teacher) { ?>
                    <a href="<?php echo $teacher->url; ?>">
						<?php echo $teacher->title;?>
                    </a>
				<?php } ?>
			<?php } elseif (count($course->teachers)  > 1 ) { ?>
                <i class="splms-icon-users"></i>
                <a href="javascipt:void(0);" id="splms-multiteacher-toogle" multiple-teachers-toggler><?php echo Text::_('COM_SPLMS_COMMON_MULTIPLE_TEACHERS');?></a>
                <ul class="splms-course-multi-teachers">
					<?php foreach ($course->teachers as $teacher) { ?>
                        <li><a href="<?php echo $teacher->url; ?>"><?php echo $teacher->title; ?></a></li>
					<?php } ?>
                </ul>
			<?php } ?>
        </div>
	<?php } ?>
</div>