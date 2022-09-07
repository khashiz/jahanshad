<?php
/**
* @package com_splms
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2022 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/


// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;

class SplmsViewEvents extends HtmlView{

	protected $items;
	protected $pagination;
	protected $state;
	public $filterForm;
	public $activeFilters;
	protected $sidebar;

	function display($tpl = null){

		// Get application
		$app = Factory::getApplication();
		$context = "com_splms.events";

		// Get data from the model
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');
		$this->filter_order = $this->state->get('list.ordering');
		$this->filter_order_Dir = $this->state->get('list.direction');
		$this->filterForm = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		$this->canDo = SplmsHelper::getActions();

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}

		// has access visite this view
		SplmsHelper::hasVisitAccess();

		// Set the submenu
		SplmsHelper::addSubmenu('events');
		$this->addToolBar();
		$this->sidebar = JHtmlSidebar::render();

		return parent::display($tpl);

	}

	protected function addToolBar() {
		ToolbarHelper::title(Text::_('COM_SPLMS_PAGE_HEADING') .  Text::_('COM_SPLMS_EVENTS'));

		if ($this->canDo->get('core.create')) {
			ToolbarHelper::addNew('event.add', 'JTOOLBAR_NEW');
		}

		if ($this->canDo->get('core.edit')) {
			ToolbarHelper::editList('event.edit', 'JTOOLBAR_EDIT');
		}

		if ($this->canDo->get('core.edit.state')) {
			ToolbarHelper::publish('events.publish', 'JTOOLBAR_PUBLISH', true);
			ToolbarHelper::unpublish('events.unpublish', 'JTOOLBAR_UNPUBLISH', true);
			ToolbarHelper::archiveList('events.archive');
			ToolbarHelper::checkin('events.checkin');
		}

		if ($this->state->get('filter.published') == -2 && $this->canDo->get('core.delete')) {
			ToolbarHelper::deleteList('', 'events.delete', 'JTOOLBAR_EMPTY_TRASH');
		} elseif ($this->canDo->get('core.edit.state') && $this->canDo->get('core.delete')) {
			ToolbarHelper::trash('events.trash');
		}

		if ($this->canDo->get('core.admin')) {
			ToolbarHelper::divider();
			ToolbarHelper::preferences('com_splms');
		}
		
	}
}
