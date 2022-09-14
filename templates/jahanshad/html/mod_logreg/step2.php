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
            <div class="form-group">
                <label for="authcode_m<?php echo $module_id; ?>">کد تاییدیه</label>
                <div>
                    <input type="text" class="form-control" id="authcode_m<?php echo $module_id; ?>" onKeyPress="numberValidate(event)" placeholder="" autocomplete="off" maxlength="11">
                </div>
            </div>
            <div>
                <button type="button" onclick="ModuleLogRegStep2(<?php echo $module_id; ?>);" class="uk-box-shadow-small uk-box-shadow-hover-medium uk-border-rounded uk-width-1-1 uk-button-large uk-flex-center rsform-submit-button  uk-button uk-button-primary">
                    <i class="far fa-search"></i>
                    <span><?php echo JText::_('AUTH_CHECK_CODE') ?></span>
                </button>
            </div>
        </div>

        <div id="re_send_btn">
            <a class="btn btn-warning" id="resendButton<?php echo $module_id; ?>" disabled>ارسال مجدد کد</a>
            <div id="module_timer_div<?php echo $module_id; ?>"></div>
        </div>

        <button type="button" onclick="ModuleLogRegReturnFirst(<?php echo $module_id; ?>);" class="btn btn-link">ورود با شماره موبایل جدید</button>
    </form>
</div>