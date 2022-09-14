<div class="registration-form">
  <form method="post" name="step3form" id="LogRegModuleForm{MODULE_ID}" onSubmit="return false;">
    <div class="form-group">
      <label for="username">نام کاربری * </label>
      <input type="text" class="form-control" name="username" id="username" value="<?php echo $mobile; ?>" readonly disabled />
    </div>

    <div class="form-group">
      <label for="name">نام * </label>
      <input type="text" class="form-control" name="name" id="name" placeholder="به فارسی وارد کنید" />
    </div>

    <?php if ($email_required == "1" || $email_required == "2") : ?>
      <div class="form-group">
        <label for="email_m"> نشانی ایمیل <?php echo $email_required == "1" ? "*" : ""; ?> </label>
        <input type="text" id="email" name="email" class="form-control" value="" />
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

    <button type="button" onclick="ModuleLogRegStep3(<?php echo $module_id; ?>);" class="btn btn-primary">ثبت نام</button>

    <button type="button" onclick="ModuleLogRegReturnFirst(<?php echo $module_id; ?>);" class="btn btn-link">ورود با شماره موبایل جدید</button>

  </form>
</div>