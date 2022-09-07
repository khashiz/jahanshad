<?php
/**
 * @package com_splms
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2022 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */

// No Direct Access
defined ('_JEXEC') or die('Resticted Aceess');

use Joomla\CMS\Language\Text;
?>

<div id="splms" class="splms splms-view-purchases uk-hidden">
	<?php if ($this->purchases) { ?>
	<!-- START purchased courses list -->
	<table class="table table-bordered table-striped">
	  	<thead>
			<th>#</th>
			<th><?php echo Text::_('COM_SPLMS_PURCHASED_COURSE_NAME'); ?></th>
			<th><?php echo Text::_('JSTATUS'); ?></th>
		</thead>

		<?php foreach ($this->purchases as $key=>$purchased_course) { 
			// Check course purchase status
		  	$course_status = ($purchased_course->published == 1) ? '<span class="label label-success">' . Text::_('JENABLED') . '</span>' : '<span class="label label-danger">' . Text::_('COM_SPLMS_PURCHASED_DISABLED_PENDING') . '</span>';
			?>
		<tr>
			<td width="20">
				<?php echo $key + 1; ?>
			</td>

			<td>
				<a href="<?php echo $purchased_course->url; ?>">
					<?php echo $purchased_course->course_name; ?>
				</a>
			</td>
			<td width="100">
				<?php echo $course_status; ?>
			</td>
		</tr>
		<?php } ?>
	</table>
	<!-- END:: purchased courses list -->
	<?php } else { ?>
        <div>
            <div class="uk-placeholder uk-margin-remove uk-text-center uk-padding-large">
                <div class="uk-margin-bottom"><i class="far fa-5x fa-graduation-cap uk-text-muted"></i></div>
                <p class="font uk-text-secondary uk-margin-medium-bottom uk-margin-remove-top f700"><?php echo JText::_('RST_NO_RECENT_ACTIVITY'); ?></p>
                <div class="uk-width-1-1 uk-width-1-3@s uk-margin-auto">
                    <a href="<?php echo JRoute::_("index.php?Itemid=151"); ?>" class="uk-button uk-button-primary uk-button-large uk-border-rounded uk-box-shadow-small uk-flex-center"><i class="far fa-message-medical"></i><span><?php echo JText::_('RST_SUBMIT_FIRST_TICKET'); ?></span></a>
                </div>
            </div>
        </div>
    <?php } ?>


	<?php if ($this->quiz_results) { ?>
	<!-- START Quiz Result list -->
	<table class="table table-bordered table-striped">
	  	<thead>
			<th>#</th>
			<th><?php echo Text::_('COM_SPLMS_QUIZ_NAME'); ?></th>
			<th><?php echo Text::_('COM_SPLMS_COURSE_NAME'); ?></th>
			<th><?php echo Text::_('COM_SPLMS_QUIZ_RESULT'); ?></th>
		</thead>

		<?php foreach ($this->quiz_results as $key=>$quiz_result) { ?>
		<tr>
			<td width="20">
				<?php echo $key + 1; ?>
			</td>

			<td width="30%">
				<?php echo $quiz_result->quiz_name; ?>
			</td>

			<td>
				<a href="<?php echo $quiz_result->course_url; ?>">
					<?php echo $quiz_result->course_name; ?>
				</a>
			</td>

			<td width="120">
				<?php echo $quiz_result->point . '/' .$quiz_result->total_marks . ' (' . round((($quiz_result->point/$quiz_result->total_marks)*100), 2) . '%)'; ?>
			</td>
		</tr>
		<?php } ?>
	</table>
	<!-- END:: Quiz Result list -->
	<?php } ?>


	<?php if ($this->user_certificates) { ?>
	<!-- START Quiz Result list -->
	<table class="table table-bordered table-striped">
	  	<thead>
			<th>#</th>
			<th><?php echo Text::_('COM_SPLMS_CERTIFICATE_NAME'); ?></th>
			<th><?php echo Text::_('COM_SPLMS_COURSE_INSTRUCTOR'); ?></th>
		</thead>

		<?php foreach ($this->user_certificates as $key=> $certicate) { ?>
		<tr>
			<td width="20">
				<?php echo $key + 1; ?>
			</td>

			<td width="30%">
				<a href="<?php echo $certicate->certificate_url; ?>">
					<?php echo $certicate->title; ?>
				</a>
			</td>

			<td>
				<?php echo $certicate->instructor; ?>
			</td>
		</tr>
		<?php } ?>
	</table>
	<!-- END:: Quiz Result list -->
	<?php } ?>

</div>