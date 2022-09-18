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
<div class="validation-mobile">
    <form method="post" name="step1form" id="LogRegModuleForm<?php echo $module_id; ?>" onSubmit="return false;">
        <div class="uk-child-width-1-1 uk-grid-small" data-uk-grid>
            <div>
                <label for="mobilenum" class="uk-form-label uk-text-center"></label>
                <div>
                    <input type="tel" class="uk-form-large uk-text-center ltr uk-input form-control" id="mobilenum_m<?php echo $module_id; ?>" onKeyPress="numberValidate(event)" placeholder="لطفاً شماره موبایل خود را وارد کنید" autocomplete="off" maxlength="11">
                </div>
            </div>
            <div>
                <button type="button" onclick="ModuleLogRegStep1(<?php echo $module_id; ?>);" class="uk-box-shadow-small uk-box-shadow-hover-medium uk-border-rounded uk-width-1-1 uk-button-large uk-flex-center rsform-submit-button  uk-button uk-button-primary">
                    <i class="far fa-mobile"></i>
                    <span><?php echo JText::_('AUTH_SEND_CODE') ?></span>
                </button>
            </div>
        </div>
    </form>
</div>