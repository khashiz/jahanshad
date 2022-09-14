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

<div id="splms">
	<?php if ($this->purchases) { ?>
        <div class="uk-child-width-1-1 uk-child-width-1-3@s" data-uk-grid data-uk-scrollspy="cls: uk-animation-slide-bottom-small; target: > div; delay: 250;">
			<?php foreach ($this->purchases as $key=>$purchased_course) { ?>
                <div class="courseListItem">
                    <div class="uk-box-shadow-small uk-border-rounded uk-overflow-hidden uk-height-1-1 uk-flex uk-flex-column">
                        <div class="uk-position-relative">
                            <div class="uk-position-small uk-position-top-left badges">
                                <?php if ($purchased_course->published == 1) { ?>
                                    <span class="uk-badge uk-badge-success uk-box-shadow-small"><?php echo Text::_('JENABLED'); ?></span>
                                <?php } else { ?>
                                    <span class="uk-badge uk-badge-warning uk-box-shadow-small"><?php echo Text::_('COM_SPLMS_PURCHASED_DISABLED_PENDING'); ?></span>
                                <?php } ?>
                            </div>
                            <img src="<?php echo !empty($purchased_course->course_info->image) ? $purchased_course->course_info->image : 'images/placeholder-med.svg'; ?>" class="" alt="<?php echo $purchased_course->course_name; ?>">
                        </div>
                        <div class="uk-padding-small uk-flex-1">
                            <div class="uk-flex uk-flex-column uk-flex-between uk-height-1-1">
                                <div class="uk-margin-bottom">
                                    <h3 class="uk-text-zero uk-margin-remove-top uk-margin-small-bottom">
                                        <a href="<?php echo $purchased_course->url; ?>" class="uk-display-block uk-h5 uk-margin-remove font f700 uk-text-secondary"><?php echo $purchased_course->course_name; ?></a>
                                    </h3>
                                    <span class="uk-flex uk-flex-middle uk-text-muted uk-text-tiny f500 uk-display-block"><i class="uk-text-accent fas fa-folder-open fa-fw uk-margin-small-left"></i><?php echo $purchased_course->course_info->category_name; ?></span>
                                </div>
                                <div>
                                    <a href="<?php echo $purchased_course->url; ?>" class="uk-button uk-button-primary uk-button-large uk-border-rounded uk-box-shadow-small uk-flex-center uk-width-1-1">
                                        <i class="far fa-info-circle"></i>
                                        <span><?php echo Text::_('COM_SPLMS_DETAILS'); ?></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			<?php } ?>
        </div>
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