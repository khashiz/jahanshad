
jQuery(document).ready(function () {

});

function ModuleLogRegStep1(module_id) {
  var mobileNum = jQuery('#mobilenum_m' + module_id);
  mobileNum.val(CleanString(mobileNum.val()));
  var mobileNumVal = mobileNum.val();
  if (mobileNumVal.length !== 11) {
    UIkit.notification({ message: 'تعداد ارقام شماره موبایل صحیح نیست', status: 'danger', pos: 'top-center' });
    jQuery('.authWrapper').addClass('uk-animation-shake');
    setTimeout(() => {
      jQuery('.authWrapper').removeClass('uk-animation-shake');
    }, 1000);
    return false;
  }
  else if (((mobileNumVal.charAt(0) + mobileNumVal.charAt(1)) !== "09") && ((mobileNumVal.charAt(0) + mobileNumVal.charAt(1)) !== "۰۹")) {
    UIkit.notification({ message: 'شماره شما باید با ۰۹ شروع شود', status: 'danger', pos: 'top-center' });
    jQuery('.authWrapper').addClass('uk-animation-shake');
    setTimeout(() => {
      jQuery('.authWrapper').removeClass('uk-animation-shake');
    }, 1000);
    return false;
  }

  // loading
  // jQuery('#modLogRegLoading' + module_id).addClass('show');
  jQuery('.authLoader').removeAttr('hidden');

  jQuery.ajax('index.php?option=com_logregsms&task=validation_mobile.step1', {
    type: 'POST',
    dataType: 'json',
    data: {
      mobilenum: mobileNumVal,
      mid: module_id,
    },
    success: function (data, status, xhr) {
      if (data.status == 0) {
        UIkit.notification({ message: data.message, status: 'danger', pos: 'top-center' });
        jQuery('.authWrapper').addClass('uk-animation-shake');
        setTimeout(() => {
          jQuery('.authWrapper').removeClass('uk-animation-shake');
        }, 1000);
        return false;
      } else {
        UIkit.notification({ message: data.message, status: 'success', pos: 'top-center' });
      }

      jQuery('#mod_logreg' + module_id).fadeOut(1, function () {
        jQuery('#mod_logreg' + module_id).html(data.html);
        jQuery('#mod_logreg' + module_id).fadeIn();
      });

      setTimeout(() => {
        var elemM = document.getElementById('module_timer_div' + module_id);
        var moduletimeleft = data.additional.timer;
        var timerId = setInterval(function () {
          if (moduletimeleft == -1) {
            clearTimeout(timerId);

            jQuery('#resendButton' + module_id).removeAttr('disabled');
            jQuery('#resendButton' + module_id).attr('onclick', 'ModuleLogRegResend(' + module_id + ')');
          } else {
            elemM.innerHTML = moduletimeleft + ' ثانیه تا امکان ارسال کد جدید';
            moduletimeleft--;
          }
        }, 1000);
      }, 200);
    },
    error: function (jqXhr, textStatus, errorMessage) {
      console.log(errorMessage);
    }
  }).done(function (data, textStatus, jqXHR) {
    // loading
    // jQuery('#modLogRegLoading' + module_id).removeClass('show');
    jQuery('.authLoader').attr('hidden','');
  });
}

function ModuleLogRegStep2(module_id) {
  var delayMiliSecond = parseFloat(jQuery('#delayMiliSecond' + module_id).val());

  var authcode = jQuery('#authcode_m' + module_id);
  authcode.val(CleanString(authcode.val()));
  var authcodeVal = authcode.val();
  if (!authcodeVal) {
    UIkit.notification({ message: 'کد تایید خالی می باشد', status: 'danger', pos: 'top-center' });
    jQuery('.authWrapper').addClass('uk-animation-shake');
    setTimeout(() => {
      jQuery('.authWrapper').removeClass('uk-animation-shake');
    }, 1000);
    return false;
  }

  // loading
  // jQuery('#modLogRegLoading' + module_id).addClass('show');
  jQuery('.authLoader').removeAttr('hidden');

  jQuery.ajax('index.php?option=com_logregsms&task=validation_code.step2', {
    type: 'POST',
    dataType: 'json',
    data: {
      codenum: authcodeVal,
      mid: module_id
    },
    success: function (data, status, xhr) {
      if (data.status == 0) {
        UIkit.notification({ message: data.message, status: 'danger', pos: 'top-center' });
        jQuery('.authWrapper').addClass('uk-animation-shake');
        setTimeout(() => {
          jQuery('.authWrapper').removeClass('uk-animation-shake');
        }, 1000);
        jQuery('.authLoader').attr('hidden','');
        return false;
      } else {
        UIkit.notification({ message: data.message, status: 'success', pos: 'top-center' });
      }

      if (data.additional.isregisteration == "1") {
        jQuery('#mod_logreg' + module_id).fadeOut(150, function () {
          jQuery('#mod_logreg' + module_id).html(data.html);
          jQuery('#mod_logreg' + module_id).fadeIn();
        });
      }

      if (data.additional.isregisteration == "0" && data.additional.refreshpage == "1") {
        setTimeout(() => {
          window.location.reload();
        }, delayMiliSecond);
      }
    },
    error: function (jqXhr, textStatus, errorMessage) {

    }
  }).done(function (data, textStatus, jqXHR) {
    // loading
    if (data.additional.isregisteration == "1" && data.additional.refreshpage == "0") {
      // jQuery('#modLogRegLoading' + module_id).removeClass('show');
      jQuery('.authLoader').attr('hidden','');
    }
  });;
}

function ModuleLogRegStep3(module_id) {
  var formEl = jQuery('form[name=step3form]')
  var data = formEl.serialize();

  var username_m = formEl.find('#username').val();
  if (!username_m) {
    UIkit.notification({ message: 'نام کاربری خالی می باشد', status: 'danger', pos: 'top-center' });
    jQuery('.authWrapper').addClass('uk-animation-shake');
    setTimeout(() => {
      jQuery('.authWrapper').removeClass('uk-animation-shake');
    }, 1000);
    return false;
  }

  var name_m = formEl.find('#name').val();
  if (!name_m) {
    UIkit.notification({ message: 'نام خالی می باشد', status: 'danger', pos: 'top-center' });
    jQuery('.authWrapper').addClass('uk-animation-shake');
    setTimeout(() => {
      jQuery('.authWrapper').removeClass('uk-animation-shake');
    }, 1000);
    return false;
  }

  // loading
  // jQuery('#modLogRegLoading' + module_id).addClass('show');
  jQuery('.authLoader').removeAttr('hidden');

  jQuery.ajax('index.php?option=com_logregsms&task=registration.step3', {
    type: 'POST',
    dataType: 'json',
    data: data,
    success: function (data, status, xhr) {
      if (data.status == 0) {
        UIkit.notification({ message: data.message, status: 'danger', pos: 'top-center' });
        jQuery('.authWrapper').addClass('uk-animation-shake');
        setTimeout(() => {
          jQuery('.authWrapper').removeClass('uk-animation-shake');
        }, 1000);
        // alert(data.message);
        return false;
      } else {
        UIkit.notification({ message: data.message, status: 'success', pos: 'top-center' });
        // alert(data.message);
      }

      UIkit.notification({ message: data.message, status: 'warning', pos: 'top-center' });
      // alert(data.message);
      ModuleLogRegLoginProccess(data.additional.url, module_id);
    },
    error: function (jqXhr, textStatus, errorMessage) {

    }
  }).done(function (data, textStatus, jqXHR) {
    // loading
    // jQuery('#modLogRegLoading' + module_id).removeClass('show');
    jQuery('.authLoader').attr('hidden','');
  });;
}

function ModuleLogRegLoginProccess(url, module_id) {
  var delayMiliSecond = parseFloat(jQuery('#delayMiliSecond' + module_id).val());

  // loading
  // jQuery('#modLogRegLoading' + module_id).addClass('show');
  jQuery('.authLoader').removeAttr('hidden');

  jQuery.ajax(url, {
    type: 'Get',
    dataType: 'json',
    data: {},
    success: function (data, status, xhr) {
      if (data.status == 0) {
        UIkit.notification({ message: data.message, status: 'danger', pos: 'top-center' });
        // alert(data.message);
      }

      if (data.additional.refreshpage == "1") {
        setTimeout(() => {
          window.location.reload();
        }, delayMiliSecond);
      }
    },
    error: function (jqXhr, textStatus, errorMessage) {

    }
  }).done(function (data, textStatus, jqXHR) {
    // loading
    //jQuery('#modLogRegLoading'+module_id).removeClass('show');
  });;
}

function ModuleLogRegResend(module_id) {
  jQuery('#resendButton' + module_id).attr('disabled', 'disabled');
  jQuery('#resendButton' + module_id).removeAttr('onclick');

  // loading
  // jQuery('#modLogRegLoading' + module_id).addClass('show');
  jQuery('.authLoader').removeAttr('hidden');

  jQuery.ajax('index.php?option=com_logregsms&view=validation_code&task=validation_code.sendCode', {
    type: 'Get',
    dataType: 'json',
    data: {},
    success: function (data, status, xhr) {
      if (data.status == 0) {
        UIkit.notification({ message: data.message, status: 'danger', pos: 'top-center' });
        // alert(data.message);
        return false;
      } else {
        UIkit.notification({ message: data.message, status: 'success', pos: 'top-center' });
        // alert(data.message);
      }

      setTimeout(() => {
        var elemM = document.getElementById('module_timer_div' + module_id);
        var moduletimeleft = data.additional.timer;
        var timerId = setInterval(function () {
          if (moduletimeleft == -1) {
            clearTimeout(timerId);

            jQuery('#resendButton' + module_id).removeAttr('disabled');
            jQuery('#resendButton' + module_id).attr('onclick', 'ModuleLogRegResend(' + module_id + ')');
          } else {
            elemM.innerHTML = moduletimeleft + ' ثانیه تا امکان ارسال کد جدید';
            moduletimeleft--;
          }
        }, 1000);
      }, 200);
    },
    error: function (jqXhr, textStatus, errorMessage) {

    }
  }).done(function (data, textStatus, jqXHR) {
    // loading
    // jQuery('#modLogRegLoading' + module_id).removeClass('show');
    jQuery('.authLoader').attr('hidden','');
  });;
}

function ModuleLogRegReturnFirst(module_id) {
  // loading
  // jQuery('#modLogRegLoading' + module_id).addClass('show');
  jQuery('.authLoader').removeAttr('hidden');

  jQuery.ajax('index.php?option=com_logregsms&view=validation_mobile&task=validation_mobile.renderStep1', {
    type: 'Get',
    dataType: 'json',
    data: {
      mid: module_id
    },
    success: function (data, status, xhr) {
      jQuery('#mod_logreg' + module_id).fadeOut(150, function () {
        jQuery('#mod_logreg' + module_id).html(data.html);
        jQuery('#mod_logreg' + module_id).fadeIn();
      });
    },
    error: function (jqXhr, textStatus, errorMessage) {

    }
  }).done(function (data, textStatus, jqXHR) {
    // loading
    // jQuery('#modLogRegLoading' + module_id).removeClass('show');
    jQuery('.authLoader').attr('hidden','');
  });;
}