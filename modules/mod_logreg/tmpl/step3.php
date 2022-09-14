<div class="registration-form">
    <form method="post" name="step3form" id="LogRegModuleForm{MODULE_ID}" onSubmit="return false;">
        <div class="uk-child-width-1-1 uk-grid-small" data-uk-grid>
            <div>
                <div class="uk-alert uk-alert-success uk-text-center uk-text-small font f700 uk-border-rounded"><?php echo JText::sprintf('REGISTER_WITH_NUMBER', $mobile) ?></div>
                <div class="uk-hidden">
                    <input type="text" class="uk-form-large uk-input form-control" name="username" id="username" value="<?php echo $mobile; ?>" readonly disabled />
                </div>
            </div>
            <div class="uk-width-1-1 uk-width-1-2@s">
                <label for="name" class="uk-form-label"><?php echo JText::_('NAME').'<span class="uk-text-danger">&ensp;*&ensp;</span>'; ?></label>
                <div>
                    <input type="text" class="uk-form-large uk-input form-control" name="name" id="name" placeholder="به فارسی وارد کنید" />
                </div>
            </div>
	        <?php if ($email_required == "1" || $email_required == "2") : ?>
                <div class="uk-width-1-1 uk-width-1-2@s">
                    <label for="email_m" class="uk-form-label"><?php echo JText::_('EMAIL'); echo $email_required == "1" ? '<span class="uk-text-danger">&ensp;*&ensp;</span>' : ''; ?> </label>
                    <div>
                        <input type="email" id="email" name="email" class="uk-form-large uk-input uk-text-left ltr form-control" value="" />
                    </div>
                </div>
	        <?php endif; ?>
	        <?php if (!empty($fields)) { ?>
		        <?php $js = ""; ?>
		        <?php foreach ($fields as $key => $value) { ?>
			        <?php if ($value->fieldname == "mobile" || $value->fieldname == "cellphone") { ?>
				        <?php $value->setValue($mobile); ?>
				        <?php $value->readonly = true; ?>
				        <?php $value->hidden = true; ?>
			        <?php } ?>
			        <?php if ($value->hidden) { ?>
                        <div class="form-group" style="display: none;">
					        <?php echo $value->input; ?>
                        </div>
			        <?php } else { ?>
                        <div class="form-group">
					        <?php echo $value->label; ?>
					        <?php echo $value->input; ?>
                        </div>
			        <?php } ?>
		        <?php } ?>
	        <?php } ?>
            <div>
                <button type="button" onclick="ModuleLogRegStep3(<?php echo $module_id; ?>);" class="uk-box-shadow-small uk-box-shadow-hover-medium uk-border-rounded uk-width-1-1 uk-button-large uk-flex-center rsform-submit-button  uk-button uk-button-primary">
                    <i class="far fa-check"></i>
                    <span><?php echo JText::_('AUTH_COMPLETE_SIGN_UP') ?></span>
                </button>
            </div>
            <div>
                <hr class="uk-margin-top uk-margin-bottom">
            </div>
            <div class="uk-width-auto">
                <a href="javascript:void(0);" class="uk-flex uk-flex-middle uk-text-tiny font f500 uk-text-muted" onclick="ModuleLogRegReturnFirst(<?php echo $module_id; ?>);">
                    <i class="far fa-redo uk-margin-small-left icon16"></i>
                    <span><?php echo JText::_('AUTH_CHANGE_NUMBER') ?></span>
                </a>
            </div>
        </div>
    </form>
</div>