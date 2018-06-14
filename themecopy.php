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
 * Allows cpying settings between theme variants
 * @package theme_essential_fel
 * @category theme
 * @author valery fremaux (valery.fremaux@gmail.com)
 * @copyright 2008 Valery Fremaux (Edunao.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * Page reorganisation service
 */
require('../../config.php');

// Security.

$context = context_system::instance();

require_login();
// TODO : Should be refined with theme own manage capabilities.
require_capability('moodle/site:config', $context);

$PAGE->set_context($context);
$url = new moodle_url('/theme/'.$PAGE->theme->name.'/themecopy.php');
$PAGE->set_url($url); // Defined here to avoid notices on errors etc.
$PAGE->set_heading(get_string('copytheme', 'theme_'.$PAGE->theme->name));

// Starts page content.

require_once($CFG->dirroot.'/theme/'.$PAGE->theme->name.'/themecopy_form.php');

$variantpaths = glob($CFG->dirroot.'/theme/'.$PAGE->theme->name.'*');
foreach ($variantpaths as $path) {
    $path = basename($path);
    $variants[$path] = get_string('pluginname', 'theme_'.$path);
}

$mform = new theme_copy_form($url, array('variants' => $variants));

$returnurl = new moodle_url('/admin/settings.php', array('section' => 'theme_'.$PAGE->theme->name.'_generic'));

if ($mform->is_cancelled()) {
    redirect($returnurl);
}

if ($data = $mform->get_data()) {

    $params = array('plugin' => 'theme_'.$data->themefrom);
    $fromsettings = $DB->get_records('config_plugins', $params);

    $fs = get_file_storage();

    foreach ($fromsettings as $setting) {
        if ($setting->name == 'themetitle') {
            // Theme variant title should NOT be changed.
            continue;
        }
        $params = array('plugin' => 'theme_'.$data->themeto, 'name' => $setting->name);
        if ($oldsetting = $DB->get_record('config_plugins', $params)) {
            $oldsetting->value = $setting->value;
            $DB->update_record('config_plugins', $oldsetting);
        } else {
            unset($setting->id);
            $setting->plugin = 'theme_'.$data->themeto;
            $DB->insert_record('config_plugins', $setting);
        }
    }

    if (!empty($data->withfiles)) {

        // Get all areas used.
        $sql = "
            SELECT
                DISTINCT filearea,filearea
            FROM
                {files}
            WHERE
                contextid = :contextid AND
                component = :component
        ";
        $params = array('contextid' => $context->id, 'component' => 'theme_'.$data->themefrom);
        $areas = $DB->get_records_sql_menu($sql, $params);
        if ($areas) {
            // Process files copy on configfiles settings.
            foreach (array_keys($areas) as $farea) {
                $themefiles = $fs->get_area_files($context->id, 'theme_'.$data->themefrom, $farea, 0, 'filepath,filename', false);
                // Purge to area at this location
                $fs->delete_area_files($context->id, 'theme_'.$data->themeto, $farea, 0);

                foreach ($themefiles as $themefile) {
                    $newfile = new StdClass;
                    $newfile->contextid = $themefile->get_contextid();
                    $newfile->component = 'theme_'.$data->themeto;
                    $newfile->filearea = $themefile->get_filearea();
                    $newfile->itemid = $themefile->get_itemid();
                    $newfile->filepath = $themefile->get_filepath();
                    $newfile->filename = $themefile->get_filename();
                    $fs->create_file_from_storedfile($newfile, $themefile->get_id());
                }
            }
        }
    }

    cache_helper::invalidate_by_definition('core', 'config', array(), 'theme_'.$data->themeto);

    echo $OUTPUT->header();
    echo $OUTPUT->notification(get_string('themecopied', 'theme_essential_fel'), 'notifysuccess');
    echo $OUTPUT->continue_button($returnurl);
    echo $OUTPUT->footer();
    die;
}

echo $OUTPUT->header();

$mform->display();

echo $OUTPUT->footer();