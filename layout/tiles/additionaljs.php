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
 * Essential is a clean and customizable theme.
 *
 * @package     theme_essential_fel
 * @copyright   2016 Gareth J Barnard
 * @copyright   2015 Gareth J Barnard in respect to modifications of the Bootstrap theme.
 * @author      G J Barnard - gjbarnard at gmail dot com and {@link http://moodle.org/user/profile.php?id=442195}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$PAGE->requires->js_call_amd('theme_essential_fel/header', 'init');
$PAGE->requires->js_call_amd('theme_essential_fel/footer', 'init');
if (\theme_essential_fel\toolbox::not_lte_ie9()) {
    $oldnavbar = \theme_essential_fel\toolbox::get_setting('oldnavbar');
    $PAGE->requires->js_call_amd('theme_essential_fel/navbar', 'init', array('data' => array('oldnavbar' => $oldnavbar)));
    if ($oldnavbar) {
        // Only need this to change the classes when scrolling when the navbar is in the old position.
        $PAGE->requires->js_call_amd('theme_essential_fel/affix', 'init');
    }
    $breadcrumbstyle = \theme_essential_fel\toolbox::get_setting('breadcrumbstyle');
    if ($PAGE->pagelayout == 'course') {
        $PAGE->requires->js_call_amd('theme_essential_fel/course_navigation', 'init');
    }
    if ($breadcrumbstyle == '1') {
        $PAGE->requires->js_call_amd('theme_essential_fel/jBreadCrumb', 'init');
    }
    if (\theme_essential_fel\toolbox::get_setting('fitvids')) {
        $PAGE->requires->js_call_amd('theme_essential_fel/fitvids', 'init');
    }
}
if ($PAGE->pagelayout == 'mydashboard') {
    if (\theme_essential_fel\toolbox::course_content_search()) {
        $essential_felsearch = new moodle_url('/theme/essential_fel/inspector.ajax.php');
        $essential_felsearch->param('sesskey', sesskey());
        $inspectorscourerdata = array('data' => array('theme' => $essential_felsearch->out(false)));
        $PAGE->requires->js_call_amd('theme_essential_fel/inspector_scourer', 'init', $inspectorscourerdata);
    }
}