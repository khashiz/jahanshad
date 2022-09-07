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
class JFormFieldCourselist extends FormField{

	protected $type = 'Courselist';

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

		$doc = Factory::getDocument();
		$doc->addScriptDeclaration('
            jQuery(function($){
				$("#jform_course_id").on("change", function(e) {
					e.preventDefault();
					let closestFieldset = $(this).closest("fieldset");

					let topicInputFieldId = "#jform_'. (string)$this->element['topicid'] .'";
					let topicInputField = $("#jform_'. (string)$this->element['topicid'] .'");
					let SelectedCourseId = $(this).val();

					// Set courseId to topicInput
					topicInputField.attr("data-courseid", SelectedCourseId);					
					
					$.get(location.href + "&courseid=" + SelectedCourseId)
					.then(function(page) {
						topicInputField.html($(page).find(topicInputFieldId).html());

						let data = [];
						topicInputField.find("option:selected").each(function(){
							data.push($(this).val());
						});
						
						if (data.length) {
							for (var i = 0; i < data.length; i++) {
								data[i] = data[i].replace(/^\s*/, "").replace(/\s*$/, "");
							}
							topicInputField.val(data).trigger("liszt:updated");
						} else {
							topicInputField.trigger("liszt:updated");
						}
					})
				});
            });
		');
		
		$courses 	   		= $this->getCourses();
		$selected_course_id = $this->value;

		$courseid = '';
		if ( !empty($this->value) && $this->value ) {
			$courseid = $this->value;
		}

		$selected = ( $courseid == '' ) ? 'selected' : '' ;
		$output = '';
		$output .= '<select id="' . $this->id . '" name="' . $this->name . '" class="custom-select">';
		$output .= '<option value="" ' . $selected . '>'. Text::_('COM_SPSPLMS_FILTER_COURSES') .'</option>';
		foreach ($courses as $key => $course) {
			$selected = ($course->id == $courseid) ? 'selected' : '' ;
			$output .= '<option value="'. $course->id .'" ' . $selected . '>'. $course->title .'</option>';
		}
		$output .= '</select>';

		return $output;
	}

}
