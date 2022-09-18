<?php
/**
 * @package com_splms
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2022 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */

// No Direct Access
defined ('_JEXEC') or die('Resticted Aceess');

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\LayoutHelper;

HTMLHelper::_('jquery.framework');
$input = Factory::getApplication()->input;
$doc = Factory::getDocument();
$user = Factory::getUser();

?>

<div id="splms">
	<div data-uk-grid>
        <div class="uk-width-1-1 uk-width-1-6@s uk-visible@s">
            <div class="" data-uk-sticky="offset: 125; bottom: true;">
                <ul class="uk-padding-remove uk-margin-remove listContainer" data-uk-scrollspy-nav="closest: li; scroll: true; offset: 85">
                    <li class="nav-item item-133"><a href="#info"><i class="far fa-fw fa-info-circle"></i><span><?php echo JText::_('COURSE_INFO'); ?></span></a></li>
                    <?php if ($this->item->description) { ?>
                        <li class="nav-item item-133"><a href="#intro"><i class="far fa-fw fa-bullhorn"></i><span><?php echo JText::_('COURSE_INTRO'); ?></span></a></li>
                    <?php } ?>
                    <?php if ((!empty($this->item->topics) && count($this->item->topics)) || (!empty($this->item->lessons) && count($this->item->lessons))) { ?>
                        <li class="nav-item item-133"><a href="#lessons"><i class="far fa-fw fa-book-alt"></i><span><?php echo JText::_('COM_SPLMS_LESSONS'); ?></span></a></li>
                    <?php } ?>
                    <?php if (isset($this->item->course_schedules) && $this->item->course_schedules && count($this->item->course_schedules) && $this->item->course_schedules ) { ?>
                        <li class="nav-item item-133"><a href="#faq"><i class="far fa-fw fa-messages-question"></i><span><?php echo JText::_('COM_SPLMS_FAQ'); ?></span></a></li>
                    <?php } ?>
                    <?php if($this->review) { ?>
                        <li class="nav-item item-133"><a href="#comments"><i class="far fa-fw fa-comment-alt"></i><span><?php echo JText::_('COM_SPLMS_REVIEWS'); ?></span></a></li>
                    <?php } ?>
                    <li></li>
                </ul>
            </div>
        </div>
		<div class="uk-width-1-1 uk-width-expand@s">
            <div>
                <div class="uk-child-width-1-1 uk-grid-collapse" data-uk-grid>
                    <div id="info">
                        <h2 class="font uk-h2 f900 uk-margin-small-bottom"><?php echo $this->item->title; ?></h2>
                        <div class="uk-grid-small uk-child-width-auto" data-uk-grid>
		                    <?php if ($this->item->price == 0) {  ?>
                                <div><span class="uk-badge uk-badge-success"><?php echo Text::_('COM_SPLMS_FREE'); ?></span></div>
		                    <?php } ?>
		                    <?php if ($this->review){ ?>
                                <div class="uk-flex uk-flex-middle">
				                    <?php if (isset($this->ratings) && $this->ratings->count) {
					                    $rating = round($this->ratings->total/$this->ratings->count);
				                    } else {
					                    $rating = 0;
				                    } ?>
				                    <?php echo LayoutHelper::render('review.ratings', array('rating'=>$rating)); ?>
                                </div>
                                <div class="uk-flex uk-flex-middle"><a href="#comments" class="font f700 uk-link-reset uk-text-secondary uk-text-small ss02" data-uk-scroll><?php echo Text::sprintf('COM_SPLMS_RATINGS', $this->ratings->count); ?></a></div>
		                    <?php } ?>
                        </div>
	                    <?php if ($this->item->short_description){ ?>
                            <div class="uk-margin-small-top">
                                <p class="uk-margin-remove uk-text-small uk-text-justify uk-text-secondary font f500"><?php echo $this->item->short_description; ?></p>
                            </div>
	                    <?php } ?>
                        <ul class="uk-grid-divider uk-child-width-1-2 uk-child-width-1-4@s uk-text-center uk-grid-small uk-margin-medium-top" data-uk-grid>
                            <li>
                                <span class="uk-display-block"><i class="far fa-timer fa-2x uk-text-accent"></i></span>
                                <span class="uk-text-muted uk-text-tiny font f500"><?php echo JText::_('DURATION'); ?></span>
                                <span class="uk-display-block uk-text-secondary uk-text-small f700 ss02"><?php echo $this->item->duration; ?></span>
                            </li>
                            <li class="total-studnets">
                                <span class="uk-display-block"><i class="far fa-users-class fa-2x uk-text-accent"></i></span>
                                <span class="uk-text-muted uk-text-tiny font f500"><?php echo JText::_('STUDENTS'); ?></span>
                                <span class="uk-display-block uk-text-secondary uk-text-small f700 ss02"><?php echo $this->total_enrolled == 0 ? 'اولین نفر باشید!' : JText::sprintf('STUDENTS_COUNT', $this->total_enrolled); ?></span>
                            </li>
		                    <?php if ($this->item->lessonsCount) { ?>
                                <li class="total-studnets">
                                    <span class="uk-display-block"><i class="far fa-book-copy fa-2x uk-text-accent"></i></span>
                                    <span class="uk-text-muted uk-text-tiny font f500"><?php echo JText::_('LESSONS_COUNT'); ?></span>
                                    <span class="uk-display-block uk-text-secondary uk-text-small f700 ss02"><?php echo JText::sprintf('COM_SPLMS_COMMON_LESSONS', $this->item->lessonsCount); ?></span>
                                </li>
		                    <?php } ?>
		                    <?php if ($this->item->level) { ?>
                                <li class="total-studnets">
                                    <span class="uk-display-block"><i class="far fa-chart-simple fa-2x uk-text-accent"></i></span>
                                    <span class="uk-text-muted uk-text-tiny font f500"><?php echo JText::_('COURSE_LEVEL'); ?></span>
                                    <span class="uk-display-block uk-text-secondary uk-text-small f700 ss02"><?php echo $this->item->level; ?></span>
                                </li>
		                    <?php } ?>
		                    <?php if (isset($this->item->admission_deadline) && $this->item->admission_deadline != '0000-00-00 00:00:00') { ?>
                                <li class="admission-deadline" title="<?php echo Text::_('COM_SPLMS_ADMISSION_DEADLINE'); ?>"><i class="splms-icon-calendar"></i> <?php echo HTMLHelper::_('date', $this->item->admission_deadline, 'DATE_FORMAT_LC3'); ?></li>
		                    <?php } ?>
	                        <?php if (isset($this->item->course_infos) && $this->item->course_infos && count($this->item->course_infos)) { ?>
		                        <?php foreach ($this->item->course_infos as $course_info) { ?>
                                    <li>
                                        <span class="uk-display-block"><i class="far fa-<?php echo $course_info['icon'] ?> fa-2x uk-text-accent"></i></span>
                                        <span class="uk-text-muted uk-text-tiny font f500"><?php echo $course_info['info_text'] ?></span>
                                        <span class="uk-display-block uk-text-secondary uk-text-small f700 ss02"><?php echo $course_info['info_number'] ?></span>
                                    </li>
		                        <?php } ?>
	                        <?php } ?>
                        </ul>
	                    <?php if(!empty($this->item->video_url)) { ?>
                            <div class="uk-margin-medium-top">
                                <div class="uk-border-rounded uk-overflow-hidden uk-box-shadow-small">
                                    <div id="r1p_container">
                                        <div id="r1p" class="arvanplayer" config="<?php echo $this->item->video_url; ?>" data-config='{"currenttime": 0, "autostart": false, "repeat": false, "mute": false, "preload": "auto", "controlbarautohide": true, "lang": "en", "aspectratio": "", "color": "#ffcc00", "controls": true, "touchnativecontrols": false, "displaytitle": true, "displaycontextmenu": true, "logoautohide": true}'></div>
                                    </div>
                                </div>
                            </div>
	                    <?php } ?>
                        <?php /* if($this->item->image) { ?>
                            <div><img src="<?php echo $this->item->image; ?>" alt="<?php echo $this->item->title; ?>"></div>
	                    <?php } */ ?>
                    </div>
	                <?php if ($this->item->description) { ?>
                        <div id="intro">
                            <i></i>
                            <h3 class="font f900 uk-text-secondary uk-margin-bottom uk-h5 uk-margin-small-bottom"><?php echo JText::_('COURSE_INTRO'); ?></h3>
                            <div class="uk-text-justify uk-text-secondary uk-text-small font"><?php echo $this->item->description; //echo HTMLHelper::_('content.prepare', $this->item->description); ?></div>
                        </div>
	                <?php } ?>
	                <?php if ((!empty($this->item->topics) && count($this->item->topics)) || (!empty($this->item->lessons) && count($this->item->lessons))) { ?>
                        <div id="lessons">
                            <i></i>
                            <h3 class="font f900 uk-text-secondary uk-margin-bottom uk-h5 uk-margin-small-bottom"><?php echo JText::_('COM_SPLMS_LESSONS'); ?></h3>
			                <?php if (!empty($this->item->topics) && count($this->item->topics)) { ?>
                                <div>
					                <?php foreach ($this->item->topics as $key => $topic) { ?>
                                        <h6 class="font f900 uk-text-secondary uk-margin-bottom uk-h6 uk-margin-small-bottom"><?php echo $topic->title; ?></h6>
                                        <div class="uk-text-zero uk-child-width-1-1 uk-grid-small" data-uk-grid>
							                <?php foreach ($topic->lessons as $lesson) { ?>
								                <?php echo LayoutHelper::render('course.content', array('contents'=>array($lesson, $this->item->price, $this->isAuthorised, 0))); ?>
							                <?php } ?>
                                        </div>
					                <?php } ?>
                                </div>
			                <?php } else { ?>
                                <div class="uk-text-zero uk-child-width-1-1 uk-grid-small" data-uk-grid>
					                <?php foreach ($this->item->lessons as $key => $lesson) { ?>
						                <?php echo LayoutHelper::render('course.content', array('contents'=>array($lesson, $this->item->price, $this->isAuthorised, 0))); ?>
					                <?php } ?>
                                </div>
			                <?php } ?>
                        </div>
	                <?php } ?>
                    <?php if (isset($this->item->course_schedules) && $this->item->course_schedules && count($this->item->course_schedules) && $this->item->course_schedules ) { ?>
                        <?php $questions = array_values($this->item->course_schedules); ?>
                        <div id="faq">
                            <i></i>
                            <h3 class="font f900 uk-text-secondary uk-margin-bottom uk-h5 uk-margin-small-bottom"><?php echo JText::_('COM_SPLMS_FAQ'); ?></h3>
                            <ul data-uk-accordion>
	                            <?php for($q=0;$q<count($questions);$q++) { ?>
                                    <li>
                                        <a class="uk-text-secondary uk-text-small f700 uk-flex uk-flex-middle uk-accordion-title uk-position-relative" href="#"><i class="far fa-question-circle uk-margin-small-left icon16"></i><?php echo $questions[$q]['q']; ?></a>
                                        <div class="uk-accordion-content uk-margin-remove">
                                            <div class="uk-padding-small font f500 uk-text-justify uk-text-small"><?php echo $questions[$q]['a']; ?></div>
                                        </div>
                                    </li>
	                            <?php } ?>
                            </ul>
                        </div>
	                <?php } ?>
	                <?php if($this->review) { ?>
                        <div id="comments">
                            <i></i>
                            <h3 class="font f900 uk-text-secondary uk-margin-bottom uk-h5 uk-margin-small-bottom"><?php echo JText::_('COM_SPLMS_REVIEWS'); ?></h3>
	                        <?php if($this->myReview) { ?>
                                <div class="uk-alert uk-alert-success uk-text-center uk-border-rounded uk-text-small f700 uk-padding-small uk-margin-remove-top uk-margin-large-bottom">
                                    <span><?php echo Text::_('COM_SPLMS_ALREADY_COMMENTED'); ?></span>
                                    <a id="splms-my-review" class="uk-text-success uk-margin-right" href="#"><i class="fas fa-pencil-alt uk-margin-small-left"></i><?php echo Text::_('COM_SPLMS_EDIT_REVIEW'); ?></a>
                                </div>
	                        <?php } ?>
	                        <?php if($user->guest) { ?>
                                <div class="uk-margin-large-bottom">
                                    <div class="uk-placeholder uk-border-rounded uk-margin-remove uk-text-center uk-padding-large">
                                        <div class="uk-margin-bottom"><i class="far fa-3x fa-comment-alt-dots uk-text-muted"></i></div>
                                        <p class="font uk-text-secondary uk-margin-medium-bottom uk-margin-remove-top f700"><?php echo JText::_('COM_SPLMS_LOGIN_TO_REVIEW'); ?></p>
                                        <div class="uk-width-1-1 uk-width-1-2@s uk-margin-auto">
                                            <a class="uk-button uk-button-primary uk-button-large uk-border-rounded uk-box-shadow-small uk-flex-center" href="#authModal" data-uk-toggle><i class="far fa-user-plus"></i><span><?php echo JText::_('LOGIN_REGISTER'); ?></span></a>
                                        </div>
                                    </div>
                                </div>
	                        <?php } ?>
                            <div class="uk-hidden">
                                <div class="reviews-status">
			                        <?php if(isset($this->ratings) && $this->ratings->count) {
				                        $rating = round($this->ratings->total/$this->ratings->count);
			                        } else {
				                        $rating = 0;
			                        } ?>
                                    <span class="total"><?php echo $rating; ?></span>
                                    <div class="sp-lms-rating ">
				                        <?php echo LayoutHelper::render('review.ratings', array('rating'=>$rating)); ?>
                                    </div>
                                    <p class="avg-rating"><?php echo Text::_('COM_SPLMS_REVIEW_AVARAGE_RATING'); ?></p>
                                </div>
                                <div class="total-reviews">
                                    <div class="sp-lms-rating ">
				                        <?php echo LayoutHelper::render('review.ratings', array('rating'=>$rating)); ?>
                                    </div>
			                        <?php echo round($rating / (5 / 100),2); ?>% <span class="total-review"><?php echo count($this->reviews); ?> Ratings</span>
                                </div>
                            </div>

			                <?php if(!$user->guest) { echo LayoutHelper::render('review.form', array('review'=>$this->myReview, 'item_id'=>$this->item->id, 'url'=>'index.php?option=com_splms&view=course&id=' . $this->item->id . ':' . $this->item->alias . SplmsHelper::getItemid('courses'))); } ?>

                            <div id="reviews">
                                <div class="uk-child-width-1-1" data-uk-grid>
	                                <?php foreach ($this->reviews as $key => $this->review) {
		                                echo LayoutHelper::render('review.review', array('review'=>$this->review));
	                                } ?>
                                </div>
                            </div>

			                <?php if($this->showLoadMore) { ?>
                                <a id="splms-load-review" class="btn btn-link btn-lg btn-block" data-item_id="<?php echo $this->item->id; ?>" href="#"><i class="fa fa-refresh"></i> <?php echo Text::_('COM_SPLMS_REVIEW_LOAD_MORE'); ?></a>
			                <?php } ?>
                        </div>
	                <?php } ?>
	                <?php if ( !empty($this->quizzes) && count($this->quizzes) && $this->quizzes ) { ?>
                        <div class="splms-course-quizzes">
                            <h3><?php echo Text::_('COM_SPLMS_QUIZ'); ?></h3>
                            <ul class="list-unstyled">
				                <?php foreach ($this->quizzes as $quiz) {
					                $qtype = ($quiz->quiz_type == 1) ? Text::_('COM_SPLMS_PAID') : Text::_('COM_SPLMS_FREE');
					                ?>
                                    <li>
							<span>
								<i class="fa fa-question-circle"></i>
								<a href="<?php echo $quiz->url; ?>">
									<?php echo $quiz->title; ?>
								</a>
							</span>
                                        <span class="pull-right">
								<?php echo $qtype; ?>
							</span>
                                    </li>
				                <?php } // END:: foreach ?>
                            </ul>
                        </div>
	                <?php } ?>
                </div>
            </div>
		</div>
        <div class="uk-width-1-1 uk-width-1-4@s">
            <div data-uk-sticky="offset: 125; bottom: true;">
                <div class="uk-child-width-1-1 uk-grid-divider uk-grid-medium uk-text-center" data-uk-grid>
                    <div>
		                <?php if (($this->item->price != 0) && ($this->isAuthorised == '') ) { ?>
                            <div class="uk-margin-bottom coursePrice"><?php echo $this->coursePrice; ?></div>
                            <a href="#" id="addtocart" data-course="<?php echo $this->item->id; ?>" data-user="<?php echo $this->user->id; ?>" data-price="<?php echo $this->item->price; ?>" class="uk-button uk-button-primary uk-button-large uk-border-rounded uk-box-shadow-small uk-flex-center uk-width-1-1">
                                <i class="fas fa-shopping-bag addToCartIcon"></i>
                                <span><?php echo Text::_('COM_SPLMS_BUY_NOW'); ?></span>
                            </a>
		                <?php } elseif ($this->isAuthorised != '') { ?>
                            <a href="#lessons<?php // echo JUri::base().'my-courses'; ?>" data-uk-scroll="offset: 85" class="uk-button uk-button-success uk-button-large uk-border-rounded uk-box-shadow-small uk-flex-center uk-width-1-1">
                                <i class="fas fa-check-circle"></i>
				                <span><?php echo Text::_('COM_SPLMS_PURCHASED'); ?></span>
                            </a>
		                <?php } ?>
                    </div>
	                <?php if (!empty($this->teachers)) {?>
                        <div class="uk-text-zero">
                            <div class="uk-child-width-1-1 uk-grid-medium" data-uk-grid>
				                <?php foreach ($this->teachers as $teacher) { ?>
                                    <div>
                                        <?php if (!empty($teacher->image)) { ?>
                                            <a href="<?php echo $teacher->url; ?>" class="uk-margin-small-bottom uk-display-inline-block uk-border-circle uk-overflow-hidden uk-box-shadow-small"><img src="<?php echo $teacher->image; ?>" alt="<?php echo $teacher->title; ?>" width="48" height="48"></a>
                                        <?php } else { ?>
                                            <i class="fas fa-user-tie icon48 uk-margin-small-bottom uk-text-accent"></i>
                                        <?php } ?>
                                        <span class="uk-display-block uk-text-tiny font f500"><?php echo JText::_('TEACHERS'); ?></span>
                                        <h4 class="uk-margin-remove uk-text-zero"><a class="uk-display-block uk-text-secondary font uk-text-small f700" href="<?php echo $teacher->url; ?>"><?php echo $teacher->title; ?></a></h4>
                                    </div>
				                <?php } ?>
                            </div>
                        </div>
	                <?php } ?>
	                <?php if ($this->params->get('course_social_share', 1)) { ?>
                        <div class="splms-section splms-course-social-share">
                            <span class="uk-display-block uk-text-tiny uk-margin-small-bottom font f500"><?php echo Text::_('COM_SPLMS_SOCIAL_SHARE'); ?></span>
			                <?php echo LayoutHelper::render('social_share', array('url'=> $this->item->link, 'title'=> $this->item->title)); ?>
                        </div>
	                <?php } ?>
                </div>
            </div>
        </div>
	</div>
</div>
<?php if($this->show_related_courses && count($this->related_courses) > 0) { ?>
    <?php if (isset($this->related_courses) && is_array($this->related_courses)) { ?>
        <hr class="uk-divider-icon uk-margin-large-top uk-margin-large-bottom">
        <div>
            <h5 class="font uk-h4 f900 uk-margin-bottom uk-text-center"><?php echo Text::_('COM_SPLMS_SIMILAR_CLASSES'); ?></h5>
            <div>
                <div class="uk-child-width-1-1 uk-child-width-1-4@s" data-uk-grid>
			        <?php foreach ($this->related_courses as $related_course) { ?>
                        <div class="courseListItem">
                            <div class="uk-box-shadow-small uk-border-rounded uk-overflow-hidden uk-height-1-1 uk-flex uk-flex-column">
                                <div class="uk-position-relative">
                                    <div class="uk-position-small uk-position-top-left badges uk-position-z-index">
								        <?php if ($related_course->price == 0) { echo '<span class="uk-badge uk-badge-success uk-box-shadow-small">' . Text::_('COM_SPLMS_FREE') . '</span>'; } ?>
                                    </div>
                                    <div class="uk-position-small uk-position-bottom-right badges uk-text-small uk-position-z-index">
								        <?php echo $related_course->course_time; ?>
                                    </div>
                                    <a href="<?php echo $related_course->url; ?>" class="uk-display-block uk-cover-container">
                                        <canvas width="400" height="300"></canvas>
                                        <img src="<?php echo !empty($related_course->image) ? $related_course->thumb : 'images/placeholder-med.svg'; ?>" class="" alt="<?php echo $related_course->title; ?>" data-uk-cover>
                                    </a>
                                </div>
                                <div class="uk-padding-small uk-flex-1">
                                    <div class="uk-flex uk-flex-column uk-flex-between uk-height-1-1">
                                        <div class="uk-margin-bottom">
                                            <h3 class="uk-text-zero uk-margin-remove-top uk-margin-small-bottom">
                                                <a href="<?php echo $related_course->url; ?>" class="uk-display-block uk-h5 uk-margin-remove font f700 uk-text-secondary"><?php echo $related_course->title; ?></a>
                                            </h3>
                                            <span class="uk-flex uk-flex-middle uk-text-muted uk-text-tiny f500 uk-display-block"><i class="uk-text-accent fas fa-folder-open fa-fw uk-margin-small-left"></i><?php echo $related_course->category_name; ?></span>
                                        </div>
                                        <div>
                                            <div class="uk-margin-bottom">
                                                <ul class="uk-grid-divider uk-grid-small" data-uk-grid>
                                                    <li>
												        <?php if ($related_course->price == 0) { ?>
                                                            <span class="uk-display-block uk-text-success uk-text-small font ss02 f900"><?php echo JText::_('COM_SPLMS_FREE'); ?></span>
												        <?php } else { ?>
													        <?php echo SplmsHelper::getPrice($related_course->price, $related_course->sale_price); ?>
												        <?php } ?>
                                                    </li>
                                                </ul>
                                            </div>
                                            <a href="<?php echo $related_course->url; ?>" class="uk-button uk-button-primary uk-button-large uk-border-rounded uk-box-shadow-small uk-flex-center uk-width-1-1">
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
            </div>
        </div>
	<?php } ?>
<?php } ?>