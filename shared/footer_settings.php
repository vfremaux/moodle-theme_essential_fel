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

// Copyright setting.
$name = 'theme_essential_fel'.$themeix.'/copyright';
$title = get_string('copyright', 'theme_essential_fel');
$description = get_string('copyrightdesc', 'theme_essential_fel');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$essential_fel_settingsfooter->add($setting);

// Footnote setting.
$name = 'theme_essential_fel'.$themeix.'/footnote';
$title = get_string('footnote', 'theme_essential_fel');
$description = get_string('footnotedesc', 'theme_essential_fel');
$default = '';
$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsfooter->add($setting);

// Performance information display.
$name = 'theme_essential_fel'.$themeix.'/perfinfo';
$title = get_string('perfinfo', 'theme_essential_fel');
$description = get_string('perfinfodesc', 'theme_essential_fel');
$perfmax = get_string('perf_max', 'theme_essential_fel');
$perfmin = get_string('perf_min', 'theme_essential_fel');
$default = 'min';
$choices = array('min' => $perfmin, 'max' => $perfmax);
$setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsfooter->add($setting);

$essential_fel5settingsfooter->add(new admin_setting_heading('theme_essential_fel5_footerreadme',
    get_string('readme_title', 'theme_essential_fel'), get_string('readme_desc', 'theme_essential_fel', array('url' => $readme))));

$name = 'theme_essential_fel'.$themeix.'/footerlogo1';
$title = get_string('footerlogo', 'theme_essential_fel').' 1';
$description = get_string('footerlogodesc', 'theme_essential_fel');
$default = '';
$setting = new admin_setting_configstoredfile($name, $title, $description, 'footerlogo1');
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsfooter->add($setting);

$name = 'theme_essential_fel'.$themeix.'/footerlogo2';
$title = get_string('footerlogo', 'theme_essential_fel').' 2';
$description = get_string('footerlogodesc', 'theme_essential_fel');
$default = '';
$setting = new admin_setting_configstoredfile($name, $title, $description, 'footerlogo2');
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsfooter->add($setting);

$name = 'theme_essential_fel'.$themeix.'/footerlogo3';
$title = get_string('footerlogo', 'theme_essential_fel').' 3';
$description = get_string('footerlogodesc', 'theme_essential_fel');
$default = '';
$setting = new admin_setting_configstoredfile($name, $title, $description, 'footerlogo3');
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsfooter->add($setting);
