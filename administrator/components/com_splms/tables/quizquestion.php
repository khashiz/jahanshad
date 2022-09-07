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
use Joomla\CMS\Table\Table;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Application\ApplicationHelper;

class SplmsTableQuizquestion extends Table {

	public function __construct(&$db) {
		parent::__construct('#__splms_quizquestions', 'id', $db);
	}
	
	public function bind($src, $ignore = array())
	{
		if(isset($src["list_answers"]) && is_array($src["list_answers"]) && !empty($src["list_answers"]))
		{
			$src["list_answers"] = json_encode($src["list_answers"]);
		}
		return parent::bind($src, $ignore);
	}

	public function store($updateNulls = false) {
		$date = Factory::getDate()->toSql();
		$user = Factory::getUser();

		if ($this->id) {
			$this->modified		= $date;
			$this->modified_by		= $user->get('id');
		} else {
			if (!(int) $this->created) {
				$this->created = $date;
			}
			if (empty($this->created_by)) {
				$this->created_by = $user->get('id');
			}
			if (!(int) $this->modified) {
				$this->modified = $date;
			}
			if (empty($this->modified_by)) {
				$this->modified_by = $user->get('id');
			}
		}

		// Verify that the alias is unique
		$table = Table::getInstance('Quizquestion', 'SplmsTable');
		if ($table->load(array('alias' => $this->alias)) && ($table->id != $this->id || $this->id == 0)) {
			$this->setError(Text::_('COM_SPLMS_ERROR_UNIQUE_ALIAS'));
			return false;
		}

		return parent::store($updateNulls);
	}

	public function check() {
		// Check for valid name.
		if (trim($this->title) == '') {
			throw new UnexpectedValueException(sprintf('The title is empty'));
		}
		if (empty($this->alias)) {
			$this->alias = $this->title;
		}
		$this->alias = ApplicationHelper::stringURLSafe($this->alias, $this->language);
		if (trim(str_replace('-', '', $this->alias)) == '') {
			$this->alias = Factory::getDate()->format('Y-m-d-H-i-s');
		}
		return true;
	}

}
