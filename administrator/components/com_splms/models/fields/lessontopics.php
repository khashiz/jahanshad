<?php
/**
 * @package     SP LMS
 *
 * @copyright   Copyright (C) 2010 - 2021 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No Direct Access
defined ('_JEXEC') or die('Resticted Aceess');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;

class JFormFieldLessontopics extends FormField{

	protected $type = 'Lessontopics';

	private function getLessonTopicsByCourseId( $courseid = '' ) {
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from($db->quoteName('#__splms_lessiontopics'));
		$query->where($db->quoteName('published')." = 1");
		
		if( $courseid ) {
			$query->where($db->quoteName('course_id')." = " . $courseid);
		} elseif ( $courseid == '' ) {
			$query->where($db->quoteName('course_id')." = " . 0);
		}

		$query->where('published = 1');
		$query->order('ordering DESC');
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	public function getInput() {
		
		// Load Lessons model
		jimport('joomla.application.component.model');
		BaseDatabaseModel::addIncludePath( JPATH_SITE . '/administrator/components/com_splms/models' );
		$lessons_model = BaseDatabaseModel::getInstance( 'Lessons', 'SplmsModel' );

		$input 		   		= Factory::getApplication()->input;
		$selected_courseid	= $input->get('courseid', NULL, 'INT');		
		$item_id			= $input->get('id', NULL, 'INT');

		// Loaded course id
		if( $item_id ) {
			$loaded_courseid = $lessons_model->getLessons($item_id)->course_id;	
		} else {
			$loaded_courseid = 0;
		}

		// Generate course ID
		$courseid = 0;
		if( $selected_courseid ) {
			$courseid = $selected_courseid;
		} elseif( $loaded_courseid ) {
			$courseid = $loaded_courseid;
		}
		
		// Get topics by course id
		$topics = $this->getLessonTopicsByCourseId( $courseid );

		$topic_id = '';
		if ( !empty($this->value) && $this->value ) {
			$topic_id = $this->value;
		}

		$selected = ($topic_id == '') ? 'selected' : '' ;
		$output = '';
		$output .= '<select id="' . $this->id . '" name="' . $this->name . '" class="custom-select">';
		$output .= '<option value="" ' . $selected . '>'. Text::_('COM_SPSPLMS_FILTER_LESSON_TOPICS') .'</option>';
		foreach ($topics as $key => $topic) {
			$selected = ($topic->id == $topic_id) ? 'selected' : '' ;
			$output .= '<option value="'. $topic->id .'" ' . $selected . '>'. $topic->title .'</option>';
		}
		$output .= '</select>';

		return $output;
	}

}
