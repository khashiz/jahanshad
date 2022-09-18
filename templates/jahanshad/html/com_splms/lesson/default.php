<?php
/**
 * @package com_splms
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2022 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */

// No Direct Access
defined ('_JEXEC') or die('Resticted Aceess');
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

?>

<div id="splms">
    <div data-uk-grid>
        <div class="uk-width-1-1 uk-width-expand@s">

	        <?php if(!empty($this->item->video_url)) { ?>
                <div class="uk-margin-medium-bottom">
			        <?php echo LayoutHelper::render('player', array('video'=> $this->item->video_url, 'thumbnail' => $this->item->vdo_thumb)); ?>
                </div>
	        <?php } elseif($this->item->vdo_thumb) { ?>
                <div class="uk-margin-medium-bottom">
                    <img src="<?php echo $this->item->vdo_thumb; ?>" alt="<?php echo $this->item->title; ?>">
                </div>
	        <?php } ?>

            <div class="uk-margin-medium-bottom">
                <h2 class="font uk-h2 f900 uk-margin-small-bottom"><?php echo $this->item->title; ?></h2>
                <div class="uk-text-justify uk-text-secondary uk-text-small font"><?php echo $this->item->description; ?></div>
            </div>

            <!-- Has lesson -->
	        <?php if(!empty($this->lessons) && count($this->lessons) && $this->lessons) { ?>
                <!-- start course-lessons  -->
                <div class="course-lessons">
                    <h3 class="font f900 uk-text-secondary uk-margin-bottom uk-h5 uk-margin-small-bottom"><?php echo Text::_('COM_SPLMS_LESOSNS_LIST'); ?></h3>
                    <div class="uk-text-zero uk-child-width-1-1 uk-grid-small" data-uk-grid>
				        <?php foreach ($this->lessons as $lesson) { ?>
					        <?php $active_lesson = ( $this->item->id == $lesson->id ) ? ' activeCourse': ''; ?>
					        <?php if ($lesson->lesson_type == 0 || $this->isAuthorised != '' || $this->courese->price == 0) : ?>
                                <div>
                                    <div class="uk-background-muted uk-border-rounded uk-padding-small <?php echo $active_lesson; ?>">
                                        <div class="uk-grid-small uk-grid" data-uk-grid>
                                            <div class="uk-flex uk-flex-middle uk-first-column"><i class="far fa-check-circle uk-text-success fa-fw icon24"></i></div>
                                            <div class="uk-width-expand uk-flex uk-flex-middle"><a href="<?php echo $lesson->lesson_url; ?>s" class="uk-text-small font ss02 uk-text-secondary f700"><?php echo $lesson->title; ?></a></div>
			                                <?php if (!empty($lesson->video_url)) :?>
                                                <div class="uk-width-auto uk-text-small font ss02 uk-text-secondary f700"><?php echo '<span class="uk-text-muted">'.JText::sprintf('COM_SPLMS_COMMON_DURATION').' : </span>'.$lesson->video_duration; ?></div>
			                                <?php else :?>
                                                <a href="<?php echo $lesson->lesson_url; ?>"><?php echo $lesson->title; ?></a>
			                                <?php endif;?>
                                        </div>
                                    </div>
                                </div>
					        <?php else :?>
                                <div>
                                    <div class="uk-background-muted uk-border-rounded uk-padding-small">
                                        <div class="uk-grid-small uk-grid" data-uk-grid>
                                            <div class="uk-flex uk-flex-middle uk-first-column"><i class="far fa-lock-alt uk-text-danger fa-fw icon24"></i></div>
                                            <div class="uk-width-expand uk-flex uk-flex-middle"><a href="<?php echo $lesson->lesson_url; ?>" class="uk-text-small font ss02 uk-text-secondary f700"><?php echo $lesson->title; ?></a></div>
                                            <div class="uk-width-auto uk-text-small font ss02 uk-text-secondary f700"><?php echo '<span class="uk-text-muted">'.JText::sprintf('COM_SPLMS_COMMON_DURATION').' : </span>'.$lesson->video_duration; ?></div>
                                        </div>
                                    </div>
                                </div>
					        <?php endif; ?>
				        <?php } ?>
                    </div>
                </div>
	        <?php } ?>
        </div>
        <div class="uk-width-1-1 uk-width-1-4@s">
            <div data-uk-sticky="offset: 40; bottom: true;">
                <div class="uk-child-width-1-1 uk-grid-divider uk-grid-medium uk-text-center" data-uk-grid>
	                <?php if (isset($this->item->attachment) && $this->item->attachment) { ?>
                        <div>
                            <a class="uk-button uk-button-default uk-button-large uk-border-rounded uk-box-shadow-small uk-flex-center" target="_blank" href="<?php echo Uri::root(). $this->item->attachment; ?>" download>
                                <i class="fas fa-download"></i>
                                <span><?php echo Text::_('COM_SPLMS_LESSON_DOWNLOAD_ATTACHMENT')?></span>
                            </a>
                        </div>
	                <?php } ?>
	                <?php if($this->user->guest) {
		                $link =  base64_encode(Uri::getInstance()->toString());
		                $login_link = Route::_('index.php?option=com_users&view=login'. SplmsHelper::getItemid('login') .'&return=' . $link);
		                ?>
                        <div>
                            <a class="uk-button uk-button-primary uk-button-large uk-border-rounded uk-box-shadow-small uk-flex-center" href="#authModal" data-uk-toggle>
                                <i class="far fa-user-plus"></i>
                                <span><?php echo Text::_('LOGIN_REGISTER'); ?></span>
                            </a>
                        </div>
	                <?php } elseif(!$this->has_complete_lesson) { ?>
                        <form id="splms-completed-item-form" class="uk-hidden">
                            <input type="hidden" name="user_id" value="<?php echo $this->user->id; ?>">
                            <input type="hidden" name="item_id" value="<?php echo $this->item->id; ?>">
                            <input type="hidden" name="item_type" value="lesson">
                            <a class="btn btn-primary" id="splms-completed-item" href="#">
				                <?php echo Text::_('COM_SPLMS_LESSON_COMPLETE'); ?>
                            </a>
                        </form>
	                <?php } else { ?>
                        <a class="uk-button uk-button-default uk-button-large uk-border-rounded uk-box-shadow-small uk-flex-center uk-hidden" id="splms-completed-item" href="#">
                            <i class="fas fa-download"></i>
                            <span><?php echo Text::_('COM_SPLMS_LESSON_COMPLETED'); ?></span>
                        </a>
	                <?php } ?>
                    <?php if(isset($this->teacher) && $this->teacher){ ?>
                        <div class="uk-text-zero">
                            <div class="uk-child-width-1-1 uk-grid-medium" data-uk-grid>
                                <div>
                                    <a href="<?php echo $this->teacher->url; ?>" class="uk-margin-small-bottom uk-display-inline-block uk-border-circle uk-overflow-hidden uk-box-shadow-small" title="<?php echo $this->teacher->title; ?>"><img src="<?php echo $this->teacher->image; ?>" alt="<?php echo $this->teacher->title; ?>" width="48" height="48"></a>
                                    <span class="uk-display-block uk-text-tiny font f500"><?php echo JText::_('TEACHERS'); ?></span>
                                    <h4 class="uk-margin-remove uk-text-zero"><a class="uk-display-block uk-text-secondary font uk-text-small f700" href="/jahanshad/teachers/jahanshad"><?php echo $this->teacher->title;?></a></h4>
                                </div>
                            </div>
                        </div>
	                <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>