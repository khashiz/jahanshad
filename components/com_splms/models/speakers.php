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
use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Model\ListModel;

class SplmsModelSpeakers extends ListModel {

	protected function getListQuery() {
		$app = Factory::getApplication();
		$user = Factory::getUser();
		// Get Params
		$params   = $app->getMenu()->getActive()->getParams();
		$ordering 		= $params->get('ordering', ' DESC');

		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select('a.*');
		$query->from($db->quoteName('#__splms_speakers', 'a'));

		//Authorised
		$groups = implode(',', $user->getAuthorisedViewLevels());
		$query->where('a.access IN (' . $groups . ')');

		// Filter by language
		$query->where('a.language in (' . $db->quote(Factory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
		$query->where($db->qn('a.published')." = ".$db->quote('1'));
		$query->order($db->quoteName('a.ordering') . $ordering);

		return $query;
	}

	protected function populateState($ordering = null, $direction = null) {
		$app = Factory::getApplication('site');
		$params = $app->getParams();
		$this->setState('list.start', $app->input->get('limitstart', 0, 'uint'));
		$limit = $params->get('limit');
		$this->setState('list.limit', $limit);
	}

	//if item not found
	public function &getItem($id = null) {
		$item = parent::getItem($id);
		if(Factory::getApplication()->isSite()) {
			if($item->id) {
				return $item;
			} else {
				throw new \Exception(Text::_('COM_SPLMS_NO_ITEMS_FOUND'), 404);
			}
		} else {
			return $item;
		}
	}

	//Get Speaker Events
	public static function getSpeakerEvents($speaker_id) {
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('id', 'title', 'alias', 'event_start_date', 'price')));
		$query->from($db->quoteName('#__splms_events'));
		$query->where($db->quoteName('published')." = 1");
		$query->where($db->quoteName('speaker_id')." LIKE ".$db->quote($speaker_id));
		$query->order('ordering DESC');
		$db->setQuery($query);
		$results = $db->loadObjectList();

		foreach ($results as &$result) {
			$result->url = Route::_('index.php?option=com_splms&view=event&id='.$result->id.':'.$result->alias . SplmsHelper::getItemid('events'));
		}

		return $results;
	}

	// Get Event Speakers by event
	public static function getSpeakerById($id) {

		$db = Factory::getDbo();
		$query = $db->getQuery(true);

		if (!empty($id)) {
			$query->select($db->quoteName(array('id', 'title', 'alias', 'designation', 'image')));
			$query->from($db->quoteName('#__splms_speakers'));
			$query->where($db->quoteName('published')." = 1");
			$query->where($db->quoteName('id')." = (". $id . ")");
			$query->order('ordering DESC');
			$db->setQuery($query);
			$item = $db->loadObject();
			$item->url = Route::_('index.php?option=com_splms&view=speaker&id='.$item->id.':'.$item->alias . SplmsHelper::getItemid('speakers'));
		}else{
			$item='';
		}
		return $item;
	}

}
