<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_logreg
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die;

$comParams = JComponentHelper::getParams('com_logregsms');
$session = JFactory::getSession();
$app = JFactory::getApplication();

$module_id = $module->id;
?>
<div class="uk-width-auto uk-flex uk-flex-middle">
    <div class="uk-width-auto uk-flex uk-flex-middle uk-hidden@s">
        <span href="#authModal" data-uk-toggle class="uk-button uk-button-default uk-button-large uk-border-rounded uk-button-icon uk-box-shadow-small"><i class="fas fa-user"></i></span>
    </div>
    <a href="#authModal" data-uk-toggle class="uk-button uk-button-primary uk-button-large uk-border-rounded uk-box-shadow-small uk-visible@s">
        <i class="far fa-user-plus"></i>
        <span><?php echo JText::_('AUTH_TITLE'); ?></span>
    </a>
    <div id="authModal" class="uk-flex-top" data-uk-modal>
        <div class="uk-modal-dialog uk-margin-auto-vertical uk-modal-body uk-border-rounded uk-overflow-hidden uk-box-shadow-medium authWrapper">
            <h4 class="uk-text-center uk-text-secondary font f700"><?php echo JText::_('AUTH_TITLE'); ?></h4>
            <div id="mod_logreg<?php echo $module->id; ?>" class="mod_logreg"><?php require "step1.php"; ?></div>
            <input type="hidden" id="delayMiliSecond<?php echo $module->id; ?>" value="<?php echo $params->get('delayMiliSecond', 2000); ?>">
            <div class="uk-position-cover uk-flex uk-flex-center uk-flex-middle uk-animation-fade authLoader" id="modLogRegLoading<?php echo $module->id; ?>" hidden>
                <span data-uk-spinner></span>
            </div>
        </div>
    </div>
</div>