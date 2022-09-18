<?php
/**
* @package RSForm! Pro
* @copyright (C) 2007-2019 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/

defined('_JEXEC') or die('Restricted access');

$app  = JFactory::getApplication();
//$user = JFactory::getUser();
$params = $app->getTemplate(true)->params;
//$menu = $app->getMenu();
//$active = $menu->getActive();
//$pageparams = $menu->getParams( $active->id );
//$pageclass = $pageparams->get( 'pageclass_sfx' );
//$itemid   = $app->input->getCmd('Itemid', '');

$phone = sprintf("%s - %s %s",
	substr($params->get('phone'), 0, 3),
	substr($params->get('phone'), 3, 4),
	substr($params->get('phone'), 7));
$mobile = sprintf("%s %s %s",
	substr($params->get('mobile'), 0, 4),
	substr($params->get('mobile'), 4, 3),
	substr($params->get('mobile'), 7));
?>
<div class="uk-grid-divider uk-flex-center" data-uk-grid>
    <div class="uk-width-1-1 uk-width-expand@s"><?php echo RSFormProHelper::displayForm($this->formId); ?></div>
	<?php if ($this->formId == 4) { ?>
        <div class="uk-width-1-1 uk-width-1-3@s">
            <div>
                <div>
                    <div class="uk-child-width-1-1" data-uk-grid>
                        <div>
                            <h3 class="font uk-h4 f900"><?php echo JText::sprintf('CALL_US'); ?></h3>
                            <div class="uk-grid-column-small uk-grid-row-medium" data-uk-grid>
	                            <?php if (!empty($params->get('phone'))) { ?>
                                    <div class="uk-width-1-1">
                                        <div>
                                            <div class="uk-grid-small contactFields" data-uk-grid>
                                                <div class="uk-width-auto uk-text-primary uk-flex uk-flex-middle"><i class="fas fa-fw fa-2x fa-phone fa-flip-horizontal"></i></div>
                                                <div class="uk-width-expand uk-text-dark uk-flex uk-flex-middle uk-text-zero">
                                                    <a href="te:<?php echo $params->get('phone'); ?>" class="uk-display-block uk-link-reset">
                                                        <span class="uk-text-tiny font f500 uk-text-muted uk-display-block"><?php echo JText::_('PHONE').' :'; ?></span>
                                                        <span class="uk-text-small value font f500 ss02 uk-text-secondary ltr uk-display-inline-block"><?php echo $phone; ?></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
	                            <?php } ?>
	                            <?php if (!empty($params->get('mobile'))) { ?>
                                    <div class="uk-width-1-1">
                                        <div>
                                            <div class="uk-grid-small contactFields" data-uk-grid>
                                                <div class="uk-width-auto uk-text-primary uk-flex uk-flex-middle"><i class="fas fa-fw fa-2x fa-mobile-alt fa-flip-horizontal"></i></div>
                                                <div class="uk-width-expand uk-text-dark uk-flex uk-flex-middle uk-text-zero">
                                                    <a href="tel:<?php echo $params->get('mobile'); ?>" class="uk-display-block uk-link-reset">
                                                        <span class="uk-text-tiny font f500 uk-text-muted uk-display-block"><?php echo JText::_('MOBILE').' :'; ?></span>
                                                        <span class="uk-text-small value font f500 ss02 uk-text-secondary ltr uk-display-inline-block"><?php echo $mobile; ?></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
	                            <?php } ?>
	                            <?php if (!empty($params->get('email'))) { ?>
                                    <div class="uk-width-1-1">
                                        <div>
                                            <div class="uk-grid-small contactFields" data-uk-grid>
                                                <div class="uk-width-auto uk-text-primary uk-flex uk-flex-middle"><i class="fas fa-fw fa-2x fa-envelope"></i></div>
                                                <div class="uk-width-expand uk-text-dark uk-flex uk-flex-middle uk-text-zero">
                                                    <a href="mailto:<?php echo $params->get('email'); ?>" class="uk-display-block uk-link-reset">
                                                        <span class="uk-text-tiny font f500 uk-text-muted uk-display-block"><?php echo JText::_('EMAIL').' :'; ?></span>
                                                        <span class="uk-text-small value font f500 uk-text-secondary ltr uk-display-inline-block"><?php echo $params->get('email'); ?></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
	                            <?php } ?>
								<?php if (!empty($params->get('address'))) { ?>
                                    <div class="uk-width-1-1">
                                        <div>
                                            <div class="uk-grid-small contactFields" data-uk-grid>
                                                <div class="uk-width-auto uk-text-primary uk-flex uk-flex-middle"><i class="fas fa-fw fa-2x fa-map-signs"></i></div>
                                                <div class="uk-width-expand uk-text-dark uk-flex uk-flex-middle uk-text-zero">
                                                    <div>
                                                        <span class="uk-text-tiny font f500 uk-text-muted uk-display-block"><?php echo JText::_('ADDRESS').' :'; ?></span>
                                                        <span class="uk-text-small value font f500 uk-text-secondary"><?php echo $params->get('address'); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
								<?php } ?>
                            </div>
                        </div>
						<?php if (!empty($params->get('lat')) && !empty($params->get('lng'))) { ?>
                            <div class="uk-hidden@s">
                                <h3 class="font uk-h4 f900"><?php echo JText::sprintf('PATHFINDER'); ?></h3>
                                <div>
                                    <div class="uk-grid-small uk-child-width-1-2" data-uk-grid>
                                        <div><a href="https://waze.com/ul?ll=<?php echo $params->get('lat'); ?>,<?php echo $params->get('lng'); ?>&navigate=yes" class="uk-width-1-1 uk-padding-small uk-button uk-button-default uk-border-rounded uk-box-shadow-small" target="_blank" rel="noreferrer"><img src="<?php echo JURI::base().'images/waze-logo.svg' ?>" width="100" alt=""></a></div>
                                        <div><a href="http://maps.google.com/maps?daddr=<?php echo $params->get('lat'); ?>,<?php echo $params->get('lng'); ?>" class="uk-width-1-1 uk-padding-small uk-button uk-button-default uk-border-rounded uk-box-shadow-small" target="_blank" rel="noreferrer"><img src="<?php echo JURI::base().'images/google-maps-logo.svg'; ?>" width="100" alt=""></a></div>
                                    </div>
                                </div>
                            </div>
						<?php } ?>
                        <div class="uk-visible@s">
                            <h3 class="font uk-h4 f900"><?php echo JText::sprintf('OUR_LOCATION'); ?></h3>
                            <a class="uk-button uk-button-default uk-border-rounded uk-width-1-1 uk-button-large uk-box-shadow-small font uk-flex uk-flex-center uk-flex-middle" href="#ourLocation" data-uk-toggle><i class="fas fa-map-signs uk-margin-small-left"></i><?php echo JText::sprintf('SHOW_ON_MAP'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	<?php } ?>
</div>
<div id="ourLocation" class="uk-flex-top" data-uk-modal>
    <div class="uk-modal-dialog uk-width-auto uk-margin-auto-vertical">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1617.8537359170602!2d51.40547965821719!3d35.80711417029018!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x66d10737d1f5457!2zMzXCsDQ4JzI1LjYiTiA1McKwMjQnMjMuNyJF!5e0!3m2!1sen!2s!4v1662427888107!5m2!1sen!2s" width="1280" height="720" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" data-uk-responsive></iframe>
    </div>
</div>