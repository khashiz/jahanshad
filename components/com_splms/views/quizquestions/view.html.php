<?php
/**
* @package com_splms
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2022 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Resticted Aceess');

use Joomla\CMS\Factory;
use Joomla\CMS\Log\Log;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

class SplmsViewQuizquestions extends HtmlView{

	protected $items;
	protected $params;
	protected $layout_type;
	function display($tpl = null) {
		// Assign data to the view
		$model = $this->getModel();
		$this->items = $this->get('items');
		$this->pagination	= $this->get('Pagination');

		// Load Lessons model
		jimport('joomla.application.component.model');
		BaseDatabaseModel::addIncludePath(JPATH_SITE.'/components/com_splms/models');

		$app = Factory::getApplication();
		$this->params = $app->getParams();
		$menus = Factory::getApplication()->getMenu();
		$menu = $menus->getActive();
		
		$this->layout_type = str_replace('_', '-', $this->params->get('layout_type', 'default'));
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			Log::add(implode('<br />', $errors), Log::WARNING, 'jerror');
			return false;
		}
		
		//Loan Courses model
		$courses_model = BaseDatabaseModel::getInstance( 'Courses', 'SplmsModel' );
		foreach ($this->items as &$this->item) {
			$this->item->url 	= new Uri(Route::_('index.php?option=com_splms&view=quizquestion&id=' . $this->item->id . ':' . $this->item->alias . '&Itemid=' . $menu->id, false));
			$this->item->cat_name = $courses_model->getCourse($this->item->course_id)->title;
		}
		//Generate Item Meta
        SplmsHelper::itemMeta();
		parent::display($tpl);
	}

}