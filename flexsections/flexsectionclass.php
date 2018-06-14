<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Defines renderer for course format flexsections
 *
 * @package    format_flexsections
 * @copyright  2012 Marina Glancy
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require('../../../config.php');

$sectionid = required_param('id', PARAM_INT);

if (!$section = $DB->get_record('course_sections', array('id' => $sectionid))) {
    print_error('badsectionid');
}

if (!$course = $DB->get_record('course', array('id' => $section->course))) {
    print_error('coursemisconf');
}

// Security.

$context = context_course::instance($course->id);
$PAGE->set_context($context);
$PAGE->requires->js('/theme/essential_fel/flexsections/js/changesectionclass.js');
$PAGE->requires->css('/theme/essential_fel/flexsections/styles.css');

require_login($course);
require_capability('moodle/course:manageactivities', $context);

$PAGE->set_heading(get_string('sectionclass', 'theme_'.$PAGE->theme->name));
$url = new moodle_url('/theme/'.$PAGE->theme->name.'/flexsections/flexsectionclass.php', array('id' => $sectionid));
$PAGE->set_url($url);

$renderer = $PAGE->get_renderer('format_flexsections');
$availablestyles = $renderer->parse_styleconfig();

require_once($CFG->dirroot.'/theme/'.$PAGE->theme->name.'/flexsections/flexsectionclass_form.php');

$params = array('courseid' => $course->id, 'sectionid' => $sectionid, 'name' => 'styleoverride');
$styleoverride = $DB->get_field('course_format_options', 'value', $params);

$mform = new flexsectionclass_form($url, array('styles' => $availablestyles, 'current' => $styleoverride));

if ($mform->is_cancelled()) {
    $courseurl = new moodle_url('/course/view.php', array('id' => $course->id, 'tosection' => $section->section), 'section-'.$section->section);
    redirect($courseurl);
}

if ($data = $mform->get_data()) {
    // Records in course_format_options for this section.

    if (!empty($data->overridestyle)) {
        $params = array('courseid' => $course->id, 'sectionid' => $sectionid, 'name' => 'styleoverride');
        if (!$oldrec = $DB->get_record('course_format_options', $params)) {
            $option = new StdClass;
            $option->courseid = $course->id;
            $option->sectionid = $section->id;
            $option->format = 'flexsections';
            $option->name = 'styleoverride';
            $option->value = $data->overridestyle;
            $DB->insert_record('course_format_options', $option);
        } else {
            $oldrec->value = $data->overridestyle;
            $DB->update_record('course_format_options', $oldrec);
        }
    } else {
        $params = array('courseid' => $course->id, 'sectionid' => $sectionid, 'name' => 'styleoverride');
        $DB->delete_records('course_format_options', $params);
    }

    $courseurl = new moodle_url('/course/view.php', array('id' => $course->id, 'tosection' => $section->section), 'section-'.$section->section);
    redirect($courseurl);
}

echo $OUTPUT->header();

$formdata = new Stdclass;
$formdata->styleoverride = $styleoverride;
$formdata->id = $sectionid;
$mform->set_data($formdata);
$mform->display();

echo $OUTPUT->footer();