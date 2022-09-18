<?php
/**
 * @package     SP SPLMS
 *
 * @copyright   Copyright (C) 2010 - 2021 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;
use Joomla\Utilities\ArrayHelper;

$categories  = (isset( $displayData['categories']) && $displayData['categories'] ) ? $displayData['categories'] : array();
$levels      = (isset( $displayData['levels']) && $displayData['levels'] ) ? $displayData['levels'] : array();
$types       = (isset( $displayData['types']) && $displayData['types'] ) ? $displayData['types'] : array();
$position    = (isset( $displayData['position']) && $displayData['position'] ) ? $displayData['position'] : 'left';
$hide_search = (isset( $displayData['hide_search']) && $displayData['hide_search'] ) ? $displayData['hide_search'] : false;
$hide_search = (isset( $displayData['hide_search']) && $displayData['hide_search'] ) ? $displayData['hide_search'] : false;

$input          = Factory::getApplication()->input;
$view           = $input->get('view', '', 'STRING');
$item_id        = $input->get('Itemid', '', 'INT');

// Filter by category
$cate_filters  = $input->get('category', NULL, 'RAW');
if (is_array($cate_filters)) {
    $cate_filters = ArrayHelper::toInteger($cate_filters);
} else {
    $cate_filters = explode(',', $cate_filters);
    $cate_filters = ArrayHelper::toInteger($cate_filters);
}

// Filter by levels
$level_filters  = $input->get('level', NULL, 'STRING');
$level_filters = explode(',', $level_filters);

// Filter by course type
$course_type    = $input->get('course_type', '', 'STRING');

// Terms
$terms    = htmlspecialchars($input->get('terms', '', 'STRING'));
?>

<div class="uk-width-1-1 uk-width-1-4@s">
    <aside data-uk-sticky="offset: 125; bottom: true;">
        <h3 class="font f900 uk-h4 uk-hidden"><?php echo Text::_('COM_SPLMS_FILTERS_TITLE'); ?></h3>
        <form action="<?php echo Route::_('index.php?option=com_splms&view=courses', false); ?>" id="splms-courses-filters-form" class="splms-courses-filters">
            <div class="uk-child-width-1-1 uk-grid-medium uk-grid-divide" data-uk-grid>
	            <?php if(!$hide_search) { ?>
                    <div class="splms-course-filter-terms">
                        <input type="text" name="terms" class="uk-input" value="<?php echo $terms; ?>" placeholder="<?php echo Text::_('COM_SPLMS_COURSE_SEARCH'); ?>" />
                    </div>
	            <?php } ?>

	            <?php if(count((array)$categories) ) { ?>
                    <div>
                        <h4 class="font f900 uk-h6 uk-margin-small-bottom"><?php echo Text::_('COM_SPLMS_FILTERS_CATEGORY'); ?></h4>
                        <ul id="splms-filter-categories" class="uk-grid-collapse uk-child-width-1-1" data-uk-grid>
				            <?php foreach ($categories as $key => $category) { ?>
                                <li>
                                    <label class="uk-position-relative cursorPointer uk-display-block">
                                        <input type="checkbox" class="uk-checkbox" value="<?php echo $category->id; ?>" name="category[]" <?php echo ( in_array($category->id, $cate_filters) ) ? 'checked="checked"': ''; ?> >
                                        <span class="checkmark"><?php echo $category->title; ?></span>
                                        <span class="uk-hidden ss02 font uk-text-tiny f900 uk-border-circle uk-flex uk-flex-middle uk-flex-center uk-position-center-left filtersCourseCount"><?php echo $category->count; ?></span>
                                    </label>
                                </li>
				            <?php } ?>
                        </ul>
                    </div>
	            <?php } ?>
	            <?php if(count((array)$levels) ) { ?>
                    <div>
                        <h4 class="font f900 uk-h6 uk-margin-small-bottom"><?php echo Text::_('COM_SPLMS_FILTERS_LEVEL'); ?></h4>
                        <ul id="splms-filter-levels" class="uk-grid-collapse uk-child-width-1-1" data-uk-grid>
				            <?php foreach ($levels as $key => $level) { ?>
                                <li>
                                    <label class="cursorPointer">
                                        <input type="checkbox" class="uk-checkbox" name="level[]" value="<?php echo strtolower($level); ?>" <?php echo ( in_array(strtolower($level), $level_filters) ) ? 'checked="checked"': ''; ?>  >
                                        <span class="checkmark"><?php echo $level; ?></span>
                                    </label>
                                </li>
				            <?php } ?>
                        </ul>
                    </div>
	            <?php } ?>
	            <?php if(count((array)$types) ) { ?>
                    <div>
                        <h4 class="font f900 uk-h6 uk-margin-small-bottom"><?php echo Text::_('COM_SPLMS_FILTERS_TYPE'); ?></h4>
                        <ul id="splms-filter-types" class="uk-grid-collapse uk-child-width-1-1" data-uk-grid>
				            <?php foreach ($types as $key => $type) { ?>
                                <li>
                                    <label class="cursorPointer">
                                        <input type="radio" class="uk-radio" name="course_type" value="<?php echo strtolower($type); ?>" <?php echo ( $course_type == strtolower($type) ) ? 'checked="checked"': ''; ?>  >
                                        <span class="checkmark"><?php echo JText::_($type); ?></span>
                                    </label>
                                </li>
				            <?php } ?>
                        </ul>
                    </div>
	            <?php } ?>
                <div>
                    <div>
                        <button type="submit" class="uk-button uk-button-primary uk-button-large uk-border-rounded uk-box-shadow-small uk-flex-center uk-width-1-1">
                            <i class="far fa-filter"></i>
                            <span><?php echo Text::_('COM_SPLMS_DO_FILTER'); ?></span>
                        </button>
                    </div>
                    <div class="uk-margin-small-top">
                        <button type="reset" class="uk-button uk-button-default uk-button-small uk-border-rounded uk-box-shadow-small uk-flex-center uk-width-1-1">
                            <i class="far fa-repeat"></i>
                            <span><?php echo Text::_('COM_SPLMS_BTN_RESET_FILTER'); ?></span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </aside>
</div>