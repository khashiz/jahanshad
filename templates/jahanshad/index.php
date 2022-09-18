<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.cassiopeia
 *
 * @copyright   (C) 2017 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;
JHtml::_('jquery.framework');

/** @var Joomla\CMS\Document\HtmlDocument $this */

$app = Factory::getApplication();
$wa  = $this->getWebAssetManager();

$app  = JFactory::getApplication();
$user = JFactory::getUser();
$params = $app->getTemplate(true)->params;
$menu = $app->getMenu();
$active = $menu->getActive();

$pageparams = $menu->getParams( $active->id );
$pageclass = $pageparams->get( 'pageclass_sfx' );

// Add CSS
JHtml::_('stylesheet', 'fontawesome.min.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'brands.min.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'light.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'regular.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'solid.min.css', array('version' => 'auto', 'relative' => true));

JHtml::_('stylesheet', 'uikit-rtl.min.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'jahanshad.css', array('version' => 'auto', 'relative' => true));

// Add js
JHtml::_('script', 'uikit.min.js', array('version' => 'auto', 'relative' => true));
JHtml::_('script', 'uikit-icons.min.js', array('version' => 'auto', 'relative' => true));
JHtml::_('script', 'custom.js', array('version' => 'auto', 'relative' => true));

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8');
$menu     = $app->getMenu()->getActive();
$pageclass = $menu !== null ? $menu->getParams()->get('pageclass_sfx', '') : '';
$netparsi = "<a href='https://netparsi.com' class='netparsi' target='_blank' rel='nofollow'>".JTEXT::sprintf('NETPARSI')."</a>";

$this->setMetaData('viewport', 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no');
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-KCFN4Q6050"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-KCFN4Q6050');
    </script>
    <meta name="theme-color" media="(prefers-color-scheme: light)" content="<?php echo $params->get('presetcolor'); ?>">
    <meta name="theme-color" media="(prefers-color-scheme: dark)" content="#000000">
	<jdoc:include type="metas" />
	<jdoc:include type="styles" />
	<jdoc:include type="scripts" />
    <script type="application/javascript" src="https://player.arvancloud.com/arvanplayer.min.js"></script>
</head>
<body class="<?php echo $option . ' view-' . $view . ($layout ? ' layout-' . $layout : ' no-layout') . ($task ? ' task-' . $task : ' no-task') . ($itemid ? ' itemid-' . $itemid : '') . ($pageclass ? ' ' . $pageclass : '') . ($this->direction == 'rtl' ? ' rtl' : ''); ?>">
    <header class="uk-background-white" data-uk-sticky="start: 200; animation: uk-animation-slide-top">
        <nav class="uk-background-white uk-box-shadow-small">
            <div class="uk-container uk-container-large">
                <div class="uk-grid-small" data-uk-grid>
                    <div class="uk-width-auto uk-flex uk-flex-middle uk-hidden@s">
                        <span href="#hamMenu" data-uk-toggle class="uk-button uk-button-default uk-button-large uk-border-rounded uk-button-icon uk-box-shadow-small"><i class="fas fa-bars-staggered"></i></span>
                    </div>
                    <div class="uk-width-auto uk-flex uk-flex-middle">
                        <a href="<?php echo JUri::base(); ?>" title="<?php echo $sitename; ?>" class="uk-flex uk-flex-middle uk-padding-small uk-padding-remove-horizontal uk-text-primary logo">
                            <img src="<?php echo JUri::base().'images/sprite.svg#logo'; ?>" width="56" height="40" alt="<?php echo $sitename; ?>" data-uk-svg>
                            <span class="uk-text-secondary uk-margin-small-right f900"><?php echo $sitename; ?></span>
                        </a>
                    </div>
                    <jdoc:include type="modules" name="header" style="html5" />
                </div>
            </div>
        </nav>
    </header>
    <?php if ($pageparams->get('show_page_heading', 1) && $pageclass != 'home') { ?>
        <section class="uk-position-relative uk-background-primary uk-text-center uk-padding uk-padding-remove-horizontal pageHeader">
            <div class="uk-container uk-position-relative">
                <h1 class="f900 uk-text-white font uk-h2"><?php echo $pageparams->get('page_heading'); ?></h1>
            </div>
        </section>
    <?php } ?>
    <jdoc:include type="message" />
    <?php if ($pageclass == 'home') { ?>
        <div class="uk-background-muted">
            <div class="uk-container uk-container-large">
                <div class="uk-padding uk-padding-remove-horizontal">
                    <div data-uk-grid>
                        <div class="uk-width-1-1 uk-width-expand@s"><jdoc:include type="modules" name="slideshow" style="html5" /></div>
                        <div class="uk-width-1-1 uk-width-1-4@s"><jdoc:include type="modules" name="banners" style="html5" /></div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if ($this->countModules('topout', true)) : ?>
        <jdoc:include type="modules" name="topout" style="html5" />
    <?php endif; ?>
    <main class="uk-padding<?php if ($pageclass == 'home') {echo '-large uk-background-primary uk-overflow-hidden';} ?> uk-padding-remove-horizontal <?php if ($pageclass == 'home') {echo 'uk-background-primary';} ?>" data-uk-height-viewport="expand: true">
        <div class="uk-container uk-container-large">
	        <?php if ($this->countModules('topin', true)) : ?>
                <jdoc:include type="modules" name="topin" style="html5" />
	        <?php endif; ?>
            <div class="<?php echo $pageclass == 'tickets' ? 'uk-container' : ''; ?>">
                <div class="uk-grid-divider" data-uk-grid>
			        <?php if ($this->countModules('sidestart', true)) : ?>
                        <aside class="uk-width-1-1 uk-width-1-4@s uk-visible@s">
                            <div data-uk-sticky="offset: 40; bottom: true;">
                                <div class="uk-child-width-1-1" data-uk-grid><jdoc:include type="modules" name="sidestart" style="none" /></div>
                            </div>
                        </aside>
			        <?php endif; ?>
                    <article class="uk-width-1-1 uk-width-expand@s">
                        <jdoc:include type="component" />
                    </article>
			        <?php if ($this->countModules('sideend', true)) : ?>
                        <aside class="uk-width-1-1 uk-width-1-4@s uk-visible@s"><jdoc:include type="modules" name="sideend" style="none" /></aside>
			        <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
    <?php if ($this->countModules('bottomout', true)) : ?>
        <jdoc:include type="modules" name="bottomout" style="html5" />
    <?php endif; ?>
    <?php if ($this->countModules('reserve', true)) : ?>
        <jdoc:include type="modules" name="reserve" style="html5" />
    <?php endif; ?>
    <footer>
        <div class="uk-container uk-container-large">
            <div class="uk-padding uk-padding-remove-horizontal">
                <div class="uk-flex-between uk-grid-row-medium" data-uk-grid>
                    <div class="uk-width-1-1 uk-width-1-3@s">
                        <h6 class="uk-text-center uk-text-right@s"><?php echo $sitename; ?></h6>
                        <p class="uk-text-center uk-text-right@s uk-margin-remove uk-text-small"><?php echo $params->get('footer_text'); ?></p>
                        <ul class="uk-grid-auto uk-child-width-auto uk-grid-small uk-margin-top uk-flex-center uk-flex-right@s socials" data-uk-grid>
		                    <?php foreach ($params->get('socials') as $item) : ?>
			                    <?php if ($item->icon != '') { ?>
                                    <li><a href="<?php echo $item->link; ?>" target="_blank" title="<?php echo $item->title; ?>"><i class="fab fa-<?php echo $item->icon; ?>"></i></a></li>
			                    <?php } ?>
		                    <?php endforeach; ?>
                        </ul>
                    </div>
                    <jdoc:include type="modules" name="footer" style="html5" />
	                <?php
	                $phone = sprintf("%s - %s %s",
		                substr($params->get('phone'), 0, 3),
		                substr($params->get('phone'), 3, 4),
		                substr($params->get('phone'), 7));
	                $mobile = sprintf("%s %s %s",
		                substr($params->get('mobile'), 0, 4),
		                substr($params->get('mobile'), 4, 3),
		                substr($params->get('mobile'), 7));
	                ?>
                    <div class="uk-width-auto uk-visible@s">
                        <h6><?php echo JText::_('CONTACT_US'); ?></h6>
                        <ul class="uk-list uk-list-collapse contact">
                            <li class="uk-flex uk-flex-middle">
                                <i class="far fa-phone-alt fa-fw uk-text-primary"></i>
                                <span><?php echo JText::_('PHONE'); ?>&ensp;:&ensp;</span>
                                <a href="tel:<?php echo $params->get('phone'); ?>" class="uk-display-inline-block ltr ss02"><?php echo $phone; ?></a>
                            </li>
                            <li class="uk-flex uk-flex-middle">
                                <i class="far fa-mobile-alt fa-fw uk-text-primary"></i>
                                <span><?php echo JText::_('MOBILE'); ?>&ensp;:&ensp;</span>
                                <a href="tel:<?php echo $params->get('mobile'); ?>" class="uk-display-inline-block ltr ss02"><?php echo $mobile; ?></a>
                            </li>
                            <li class="uk-flex uk-flex-middle">
                                <i class="far fa-envelope fa-fw uk-text-primary"></i>
                                <span><?php echo JText::_('EMAIL'); ?>&ensp;:&ensp;</span>
                                <a href="mailto:<?php echo $params->get('email'); ?>" title=""><?php echo $params->get('email'); ?></a>
                            </li>
                            <li class="uk-flex uk-flex-middle">
                                <i class="far fa-map-signs fa-fw uk-text-primary"></i>
                                <span><?php echo JText::_('ADDRESS'); ?>&ensp;:&ensp;</span>
                                <a href="#"><?php echo $params->get('address'); ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div>
                <div class="uk-padding-small copyrightsWrapper">
                    <div class="uk-flex-between uk-grid-divider uk-grid-small" data-uk-grid>
                        <div class="uk-width-1-1 uk-width-expand@s copyright uk-flex-last uk-flex-first@s">
                            <div class="uk-height-1-1 uk-flex uk-flex-middle uk-flex-center uk-flex-right@s">
                                <div>
                                    <div class="uk-grid-small" data-uk-grid>
                                        <div class="uk-width-expand uk-flex-uk-flex-middle">
                                            <div class="uk-text-center uk-text-right@s">
                                                <span class="uk-display-block uk-text-muted"><?php echo JText::_('COPYRIGHT'); ?></span>
                                                <a href="<?php echo JUri::base(); ?>" class="" title=""><i class="far fa-copyright uk-text-muted"></i><?php echo $sitename; ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-1 uk-width-expand@s copyright uk-flex-last uk-flex-first@s">
                            <div class="uk-height-1-1 uk-flex uk-flex-middle uk-flex-center uk-flex-right@s">
                                <div>
                                    <div class="uk-grid-small" data-uk-grid>
                                        <div class="uk-width-expand uk-flex-uk-flex-middle">
                                            <div class="uk-text-center uk-text-right@s">
                                                <span class="uk-display-block uk-text-muted"><?php echo JText::_('DESIGNED_BY'); ?></span>
                                                <a href="<?php echo JUri::base(); ?>" class="" title=""><i class="far fa-code uk-text-muted"></i><?php echo $netparsi; ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-1 uk-width-1-4@s uk-flex uk-flex-center support uk-visible@s">
                            <div class="uk-height-1-1 uk-flex uk-flex-middle">
                                <div>
                                    <div class="uk-grid-small" data-uk-grid>
                                        <div class="uk-width-auto uk-flex uk-flex-middle">
                                            <i class="far fa-headset fa-3x supportIcon uk-text-primary"></i>
                                        </div>
                                        <div class="uk-width-expand uk-flex uk-flex-middle">
                                            <div>
                                                <span class="uk-display-block uk-text-muted"><?php echo JText::_('ANY_QUESTIONS'); ?></span>
                                                <a href="tel:<?php echo $params->get('phone'); ?>" class="" title=""><?php echo JText::sprintf('OUR_PHONE', '<b class="uk-display-inline-block ltr ss02">'.$phone.'</b>'); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-1 uk-width-1-3@s"><jdoc:include type="modules" name="newsletter" style="html5" /></div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div id="hamMenu" data-uk-offcanvas="overlay: true">
        <div class="uk-offcanvas-bar uk-card uk-card-default uk-padding-remove bgWhite">
            <div class="uk-flex uk-flex-column uk-height-1-1">
                <div class="uk-width-expand">
                    <div class="offcanvasTop uk-box-shadow-small uk-position-relative uk-flex-stretch uk-background-primary">
                        <div class="uk-grid-collapse uk-height-1-1" data-uk-grid>
                            <div class="uk-flex uk-width-1-4 uk-flex uk-flex-center uk-flex-middle"><a onclick="UIkit.offcanvas('#hamMenu').hide();" class="uk-flex uk-flex-center uk-flex-middle uk-height-1-1 uk-width-1-1 uk-margin-remove"><i class="far fa-chevron-right"></i></a></div>
                            <div class="uk-flex uk-width-expand uk-flex uk-flex-right uk-flex-middle uk-text-white">
                                <span class="font uk-flex uk-flex-middle uk-text-white uk-text-bold uk-h5 uk-margin-remove"><?php echo $sitename; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="uk-padding-small"><jdoc:include type="modules" name="offcanvas" style="xhtml" /></div>
                </div>
            </div>
        </div>
    </div>
    <?php if ($user->id) { ?>
        <div id="userMenu" data-uk-offcanvas="overlay: true">
            <div class="uk-offcanvas-bar uk-card uk-card-default uk-padding-remove bgWhite">
                <div class="uk-flex uk-flex-column uk-height-1-1">
                    <div class="uk-width-expand">
                        <div class="offcanvasTop uk-box-shadow-small uk-position-relative uk-flex-stretch uk-background-primary">
                            <div class="uk-grid-collapse uk-height-1-1" data-uk-grid>
                                <div class="uk-flex uk-width-1-4 uk-flex uk-flex-center uk-flex-middle"><a onclick="UIkit.offcanvas('#userMenu').hide();" class="uk-flex uk-flex-center uk-flex-middle uk-height-1-1 uk-width-1-1 uk-margin-remove"><i class="far fa-chevron-right"></i></a></div>
                                <div class="uk-flex uk-width-expand uk-flex uk-flex-right uk-flex-middle uk-text-white">
                                    <span class="font uk-flex uk-flex-middle uk-text-white uk-text-bold uk-h5 uk-margin-remove"><?php echo $user->name; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="uk-padding-small"><jdoc:include type="modules" name="offcanvasuser" style="xhtml" /></div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
	<jdoc:include type="modules" name="debug" style="none" />
</body>
</html>