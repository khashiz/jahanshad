<?php

/**
 * @package com_splms
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2022 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */

// No Direct Access
defined('_JEXEC') or die('Resticted Aceess');

use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

$show_filter = $this->params->get('show_course_filter', 1);
$filter_position = $this->params->get('course_filter_position', 'left');
$hide_search = $this->params->get('hide_course_filter_search', false);
$columns = $this->params->get('columns', 2);
?>
<div id="splms">
	<?php if ($show_filter && ($filter_position == 'left' || $filter_position == 'right')) { ?>
		<div class="uk-grid-divider" data-uk-grid>
			<?php echo LayoutHelper::render('courses.sidebar_filters', array('categories' => $this->course_categories, 'levels' => $this->course_lavels, 'types' => $this->filter_course_types, 'position' => $filter_position, 'hide_search' => $hide_search)); ?>
			<div class="uk-width-1-1 uk-width-expand@s">
			<?php } elseif ($show_filter && $filter_position == 'top') { ?>
				<?php echo LayoutHelper::render('courses.top_filters', array('categories' => $this->course_categories, 'levels' => $this->course_lavels, 'types' => $this->filter_course_types, 'hide_search' => $hide_search)); ?>
			<?php } ?>
			<?php if (count($this->items)) { ?>
				<div>
					<div class="uk-child-width-1-1 uk-child-width-1-3@s" data-uk-grid data-uk-scrollspy="cls: uk-animation-slide-bottom-small; target: > div; delay: 250;">
						<?php foreach ($this->items as $course) { ?>
							<div class="courseListItem" data-groups='["all","<?php echo $course->coursecategory_alias[0]; ?>"]'>
								<?php echo LayoutHelper::render('courses.course', array('course' => $course)); ?>
							</div>
						<?php } ?>
					</div>
				</div>
				<div class="pagination"><?php echo $this->pagination->getPagesLinks(); ?></div>
			<?php } else { ?>
                <div class="uk-placeholder uk-margin-remove uk-text-center uk-padding-large">
                    <div class="uk-margin-bottom"><i class="far fa-5x fa-graduation-cap uk-text-muted"></i></div>
                    <p class="font uk-text-secondary uk-margin-remove f700"><?php echo Text::_('COM_SPLMS_EVENTS_NO_ITEM_FOUND'); ?></p>
                </div>
			<?php } ?>
			<?php if ($show_filter && ($filter_position == 'left' || $filter_position == 'right')) { ?>
			</div>
		</div>
	<?php } ?>
</div>