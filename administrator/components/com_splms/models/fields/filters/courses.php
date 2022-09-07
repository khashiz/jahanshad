<?php
/**
 * @package     SP LMS
 *
 * @copyright   Copyright (C) 2010 - 2021 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access!');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Form\FormField;

jimport('joomla.filesystem.file');

class JFormFieldCourses extends FormField{

	protected $type = 'Courses';

	public function getCourses() {

		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from($db->quoteName('#__splms_courses'));
		$query->where($db->quoteName('published')." = 1");
		$query->where('published = 1');
		$query->order('ordering DESC');
		$db->setQuery($query);

		return $db->loadObjectList();

	}

	public function getInput() {
		$courses = $this->getCourses();
		$courseid = '';
		if ($this->value) {
			$courseid = $this->value;
		}

		$selected = ($courseid == '') ? 'selected' : '' ;

		$output = '';
		$output .= '<select id="'.$this->id.'" name="'.$this->name.'" onchange="this.form.submit();" class="custom-select">';
		$output .= '<option value="" ' . $selected . '>'. Text::_('COM_SPSPLMS_FILTER_COURSES') .'</option>';
		foreach ($courses as $key => $course) {
			$selected = ($course->id == $courseid) ? 'selected' : '' ;
			$output .= '<option value="'. $course->id .'" ' . $selected . '>'. $course->title .'</option>';
		}
		$output .= '</select>';

		return $output;
	}

}
