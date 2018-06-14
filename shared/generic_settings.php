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
 * @package block_dashboard
 * @category blocks
 * @author Valery Fremaux (valery@club-internet.fr)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL
 */
defined('MOODLE_INTERNAL') || die();

$essential_fel_settingsgeneric->add(new admin_setting_heading('theme_essential_fel5_generalheading',
    get_string('generalheadingsub', 'theme_essential_fel5'),
    format_text(get_string('generalheadingdesc', 'theme_essential_fel5'), FORMAT_MARKDOWN)));

// Page background image.
$name = 'theme_essential_fel5/pagebackground';
$title = get_string('pagebackground', 'theme_essential_fel5');
$description = get_string('pagebackgrounddesc', 'theme_essential_fel5');
$setting = new admin_setting_configstoredfile($name, $title, $description, 'pagebackground');
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsgeneric->add($setting);

// Background style.
$name = 'theme_essential_fel5/pagebackgroundstyle';
$title = get_string('pagebackgroundstyle', 'theme_essential_fel5');
$description = get_string('pagebackgroundstyledesc', 'theme_essential_fel5');
$default = 'fixed';
$setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default,
    array(
        'fixed' => get_string('stylefixed', 'theme_essential_fel5'),
        'tiled' => get_string('styletiled', 'theme_essential_fel5'),
        'stretch' => get_string('stylestretch', 'theme_essential_fel5')
    )
);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsgeneric->add($setting);

// Fixed or variable width.
$name = 'theme_essential_fel5/pagewidth';
$title = get_string('pagewidth', 'theme_essential_fel5');
$description = get_string('pagewidthdesc', 'theme_essential_fel5');
$default = 1200;
$choices = array(
    960 => get_string('fixedwidthnarrow', 'theme_essential_fel5'),
    1200 => get_string('fixedwidthnormal', 'theme_essential_fel5'),
    1400 => get_string('fixedwidthwide', 'theme_essential_fel5'),
    100 => get_string('variablewidth', 'theme_essential_fel5'));
$setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsgeneric->add($setting);

// Page top blocks per row.
$name = 'theme_essential_fel5/pagetopblocksperrow';
$title = get_string('pagetopblocksperrow', 'theme_essential_fel5');
$default = 1;
$lower = 1;
$upper = 4;
$description = get_string('pagetopblocksperrowdesc', 'theme_essential_fel',
    array('lower' => $lower, 'upper' => $upper));
$setting = new essential_fel_admin_setting_configinteger($name, $title, $description, $default, $lower, $upper);
$essential_fel_settingsgeneric->add($setting);

// Page bottom blocks per row.
$name = 'theme_essential_fel5/pagebottomblocksperrow';
$title = get_string('pagebottomblocksperrow', 'theme_essential_fel');
$default = 4;
$lower = 1;
$upper = 4;
$description = get_string('pagebottomblocksperrowdesc', 'theme_essential_fel',
    array('lower' => $lower, 'upper' => $upper));
$setting = new essential_fel_admin_setting_configinteger($name, $title, $description, $default, $lower, $upper);
$essential_fel_settingsgeneric->add($setting);

// Custom favicon.
$name = 'theme_essential_fel5/favicon';
$title = get_string('favicon', 'theme_essential_fel5');
$description = get_string('favicondesc', 'theme_essential_fel');
$setting = new admin_setting_configstoredfile($name, $title, $description, 'favicon');
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsgeneric->add($setting);

// Custom CSS file.
$name = 'theme_essential_fel5/customcss';
$title = get_string('customcss', 'theme_essential_fel5');
$description = get_string('customcssdesc', 'theme_essential_fel');
$default = '';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsgeneric->add($setting);

$readme = new moodle_url('/theme/essential_fel5/README.txt');
$readme = html_writer::link($readme, get_string('readme_click', 'theme_essential_fel'), array('target' => '_blank'));

$essential_fel_settingsgeneric->add(new admin_setting_heading('theme_essential_fel5_generalreadme',
    get_string('readme_title', 'theme_essential_fel5'), get_string('readme_desc', 'theme_essential_fel5', array('url' => $readme))));
