
<?php
/**
 * @package    logregsms
 * @subpackage C:
 * @author     Mohammad Hosein Mir {@link https://joomina.ir}
 * @author     Created on 22-Feb-2019
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');

/**
 * logregsms Model.
 *
 * @package    logregsms
 * @subpackage Models
 */
class LogregsmsControllerValidation_Code extends JControllerForm
{
	/**
	 * Gets the Data.
	 *
	 * @return string The greeting to be displayed to the user
	 */
	public function step2()
	{
		$isajax = false;
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			$isajax = true;
		}

		$helper = new LRSHelper();
		$params = $helper::getParams();
		$code_input = $helper::$_app->input->get('codenum', '');
		$code_input = trim($helper::CleanUTF8_ToEn($code_input));
		$session = JFactory::getSession();
		$code_session = $session->get('smsregCode', '');
		$mobile = $session->get('smsregMobile', '');
		$return = $session->get('smsregReturn', '');
		$valmob_Itemid = $helper::getOneMenu('validation_mobile');
		$valcd_Itemid = $helper::getOneMenu('validation_code');
		$reg_Itemid = $helper::getOneMenu('registration');
		$userProf_Itemid = $helper::getOneMenu('profile', 'com_users');

		$user = $helper::User();
		if ($user->guest == false) {
			if ($isajax) {
				$this->doneAjax(0, 'شما قبلا به سایت وارد شده اید.');
			} else {
				$helper::$_app->enqueueMessage('شما قبلا به سایت وارد شده اید.', 'message');
				$helper::$_app->redirect(JRoute::_('index.php?option=com_users&view=profile&Itemid=' . $userProf_Itemid));
				exit;
			}
		}

		if ($code_session !== $code_input) {
			if ($isajax) {
				$session->clear('smsregAllowReg');
				$this->doneAjax(0, JText::_('AUTH_WRONG_CODE'));
			} else {
				$session->clear('smsregAllowReg');
				$helper::$_app->enqueueMessage(JText::_('AUTH_WRONG_CODE'), 'error');
				$helper::$_app->redirect(JRoute::_('index.php?option=com_logregsms&view=validation_code&Itemid=' . $valcd_Itemid));
				exit;
			}
		}

		$session->clear('smsregCode');

		// check 0
		//$mobile = ltrim($mobile, '0');

		// check if user register before or not
		$check = $helper::FindUserName($mobile);
		if (!$check) {
			if ($isajax) {
				JForm::addFormPath(JPATH_SITE . '/components/com_users/forms');
				$form = JForm::getInstance('com_users.registration', 'registration');

				$data = null;
				JFactory::getApplication()->triggerEvent('onContentPrepareForm', array($form, $data));
				$all_groups = $form->getFieldsets();
				$field_groups = array();

				foreach (array_reverse($all_groups) as $key => $value) {
					if((strrpos($key, 'fields')) === false) continue;
	
					$fields = $form->getFieldset($value->name);
					$field_groups = array_merge($field_groups, array_reverse($fields));
				}
	
				$fields = !empty($field_groups) ? array_reverse($field_groups) : null;

				$email_required = $params->get('is_email_required', "1");
				$displayData = array(
					'module_id' => $helper::$_app->input->getInt('mid', 0), 
					'email_required' => $email_required,
					'fields' => $fields,
					'mobile' => $mobile
				);
				$path = JPATH_ROOT . '/modules/mod_logreg/tmpl/step3.php';

				$loader = static function (array $displayData, $path) {
					extract($displayData);

					ob_start();
					include($path);
					$html = ob_get_contents();
					ob_end_clean();

					return $html;
				};

				$html = $loader($displayData, $path);

				$session->set('smsregAllowReg', '1');
				$this->doneAjax(1, 'جهت ادامه فرایند ثبت نام، لطفا فرم مربوط به اطلاعات شخصی را تکمیل کنید', $html, array('isregisteration' => 1, 'refreshpage' => 0));
			} else {
				$session->set('smsregAllowReg', '1');
				$helper::$_app->enqueueMessage('لطفا فرم زیر را جهت ثبت نام پر کنید', 'message');
				$helper::$_app->redirect(JRoute::_('index.php?option=com_logregsms&view=registration&Itemid=' . $reg_Itemid));
				exit;
			}
		} else {
			$session->clear('smsregMobile');
			// login
			$newpass = rand(111111, 999999);

			$data = new stdClass();
			$data->username = $mobile;
			$data->password = JUserHelper::hashPassword($newpass);
			$up = $helper::Update($data, '#__users', 'username');
			
			$menuitem = $params->get('after_login', '');

			$login = $helper::Login($mobile, $newpass, true);
			if ($login['result'] == true) {
				$msg = 'با نام کاربری ' . $mobile . ' با موفقیت وارد حساب کاربری خود شده اید.';
				if ($isajax) {
					$this->doneAjax(1, $msg, '', array('isregisteration' => 0, 'refreshpage' => 1));
				} else {
					if (!empty($return)) {
						$helper::$_app->enqueueMessage($msg, 'message');

						$return = base64_decode($return);
						$helper::$_app->redirect($return);
					} elseif (is_numeric($menuitem)) {
						$helper::$_app->enqueueMessage($msg, 'message');
						$helper::$_app->redirect(JRoute::_('index.php?Itemid=' . $menuitem));
					} else {
						$helper::$_app->enqueueMessage($msg, 'message');
						$helper::$_app->redirect(JRoute::_('index.php?option=com_users&view=profile&Itemid=' . $userProf_Itemid));
					}
					exit;
				}
			}

			if ($isajax) {
				$this->doneAjax(0, $login['msg']);
			} else {
				$helper::$_app->enqueueMessage($login['msg'], 'error');
				$helper::$_app->redirect('index.php');
			}
		}
	}
	public function sendCode()
	{
		$isajax = false;
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			$isajax = true;
		}

		date_default_timezone_set('Iran');
		$helper = new LRSHelper();
		$params = $helper::getParams();
		$shareservice = intval($params->get('shareservice', 0));
		$app = JFactory::getApplication();
		$valmob_Itemid = $helper::getOneMenu('validation_mobile');
		$valcd_Itemid = $helper::getOneMenu('validation_code');

		$session = JFactory::getSession();
		$sms_code =  $session->get('smsregCode');
		$mobile =  $session->get('smsregMobile');

		$username = $params->get('username', '');
		$text = $params->get('smstext', 'کد تاییدیه شما: {code}');
		$password = $params->get('password', '');
		$line = $params->get('line', '');
		$reseller = $params->get('reseller', '');

		if (empty($sms_code)) {
			if ($isajax) {
				$this->doneAjax(0, 'همه session ها منقضی شده اند');
			} else {
				$helper::$_app->enqueueMessage('همه session ها منقضی شده اند', 'error');
				$app->redirect(JRoute::_('index.php?option=com_logregsms&view=validation_mobile&Itemid=' . $valmob_Itemid));
			}
		}

		$confirm = LRSHelper::getConfirm('', $sms_code, -1);

		$resend = (int)$params->get('resend', '');
		$resend_second = $resend * 60;


		$time = $confirm->time;
		$current = time();
		$resend_time = strtotime($time) + $resend_second;

		if ($current > $resend_time) {

			// make code and send message
			$code = LRSHelper::rndNums(5);
			// prepare text
			$data = array('code' => $code);
			$data = LRSHelper::Prepare($text, $data);

			// send sms
			$result = LRSSendSms::SendSms($username, $password, $line, $reseller, $data, $mobile, $code);
			if ($shareservice == 0) {
				$sms_result = isset($result['SendSimpleSMS2Result']) ? $result['SendSimpleSMS2Result'] : -1;
			} else {
				if (constant("SHARECONS") === "1") {
					$sms_result = isset($result->SendByBaseNumberResult) ? $result->SendByBaseNumberResult : -1;
				}
			}

			$session = JFactory::getSession();
			$session->set('smsregCode', $code);
			$session->set('smsregMobile', $mobile);


			LRSHelper::Insert(
				array(
					'created_on' => date('Y-m-d'),
					'time' => date('H:i:s'),
					'to' => $mobile,
					'from' => $line,
					'message' => $data,
					'text' => '',
					'result' => $sms_result
				),
				'#__logregsms_smsarchives'
			);

			// update confirm
			$confirm_table = new stdClass();
			$confirm_table->id = $confirm->id;
			$confirm_table->code = $code;
			$confirm_table->time = date("Y-m-d H:i:s");
			$confirm_table->is_confirmed = -1;
			$result_confirm = JFactory::getDbo()->updateObject('#__logregsms_confirm', $confirm_table, 'id');

			if (!$result || !$result_confirm) {
				if ($isajax) {
					$this->doneAjax(0, 'ثبت و ارسال کد با خطا مواجه شد.');
				} else {
					$helper::$_app->enqueueMessage('ثبت و ارسال کد با خطا مواجه شد.', 'error');
					$app->redirect(JRoute::_('index.php?option=com_logregsms&view=validation_mobile&Itemid=' . $valmob_Itemid));
				}
			} else {
				if ($isajax) {
					$resend = (int)$params->get('resend', 1);
					$resend_second = $resend * 60;

					$this->doneAjax(1, 'کد جدیدی برای شما ارسال شد.', '', array('timer' => $resend_second));
				} else {
					$helper::$_app->enqueueMessage('کد جدیدی برای شما ارسال شد.', 'message');
					$app->redirect(JRoute::_('index.php?option=com_logregsms&view=validation_code&Itemid=' . $valcd_Itemid));
				}
			}
		} else {
			if ($isajax) {
				$this->doneAjax(0, 'لطفا کمی صبر کنید!');
			} else {
				$helper::$_app->enqueueMessage('صبر کن !', 'error');
				$app->redirect(JRoute::_('index.php?option=com_logregsms&view=validation_code&Itemid=' . $valcd_Itemid));
			}
		}
	}

	public function doneAjax($status = 0, $msg = '', $html = '', $additional = array())
	{
		$ajax = new \stdClass();
		$ajax->status = $status;
		$ajax->message = $msg;
		$ajax->html = $html;
		$ajax->additional = $additional;

		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($ajax);
		die;
	}
}
