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
?>
<div class="validation-code">
    <form method="post" name="step2form" id="LogRegModuleForm<?php echo $module_id; ?>" onSubmit="return false;">
        <div class="uk-child-width-1-1 uk-grid-small" data-uk-grid>
            <div>
                <input type="tel" class="uk-form-large uk-text-center ltr uk-input form-control" id="authcode_m<?php echo $module_id; ?>" onKeyPress="numberValidate(event)" placeholder="<?php echo JText::_('ENTER_CODE'); ?>" autocomplete="off" maxlength="5">
            </div>
            <div>
                <button type="button" onclick="ModuleLogRegStep2(<?php echo $module_id; ?>);" class="uk-button uk-button-primary uk-button-large uk-box-shadow-small uk-box-shadow-hover-medium uk-border-rounded uk-width-1-1 uk-flex-center">
                    <i class="far fa-search"></i>
                    <span><?php echo JText::_('AUTH_CHECK_CODE') ?></span>
                </button>
            </div>
            <div>
                <hr class="uk-margin-top uk-margin-bottom">
            </div>
            <div class="uk-width-expand" id="re_send_btn">
                <a class="uk-flex uk-flex-middle uk-text-tiny font f500 uk-text-muted resendLink" id="resendButton<?php echo $module_id; ?>" disabled>
                    <i class="far fa-redo-alt uk-margin-small-left"></i>
                    <span><?php echo JText::_('AUTH_RESEND_CODE') ?></span>
                </a>
                <div class="uk-text-muted uk-text-tiny font f700 ss02" id="module_timer_div<?php echo $module_id; ?>"></div>
            </div>
            <div class="uk-width-auto">
                <a href="javascript:void(0);" class="uk-flex uk-flex-middle uk-text-tiny font f500 uk-text-muted" onclick="ModuleLogRegReturnFirst(<?php echo $module_id; ?>);">
                    <i class="far fa-mobile uk-margin-small-left icon16"></i>
                    <span><?php echo JText::_('AUTH_CHANGE_NUMBER') ?></span>
                </a>
            </div>
        </div>
    </form>
</div>