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
 * @package theme_essential_fel
 * @category theme
 * @author Valery Fremaux (valery@club-internet.fr)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL
 */
defined('MOODLE_INTERNAL') || die();

$essential_fel_settingscolour->add(new admin_setting_heading('theme_essential_fel5_colour',
    get_string('colorheadingsub', 'theme_essential_fel'),
    format_text(get_string('colordesc', 'theme_essential_fel'), FORMAT_MARKDOWN)));

// Main theme colour setting.
$name = 'theme_essential_fel'.$themeix.'/themecolor';
$title = get_string('themecolor', 'theme_essential_fel');
$description = get_string('themecolordesc', 'theme_essential_fel');
$default = '#30add1';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);

// Main theme text colour setting.
$name = 'theme_essential_fel'.$themeix.'/themetextcolor';
$title = get_string('themetextcolor', 'theme_essential_fel');
$description = get_string('themetextcolordesc', 'theme_essential_fel');
$default = '#217a94';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);

// Main theme link colour setting.
$name = 'theme_essential_fel'.$themeix.'/themeurlcolor';
$title = get_string('themeurlcolor', 'theme_essential_fel');
$description = get_string('themeurlcolordesc', 'theme_essential_fel');
$default = '#943b21';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);

// Main theme hover colour setting.
$name = 'theme_essential_fel'.$themeix.'/themehovercolor';
$title = get_string('themehovercolor', 'theme_essential_fel');
$description = get_string('themehovercolordesc', 'theme_essential_fel');
$default = '#6a2a18';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);

// Icon colour setting.
$name = 'theme_essential_fel'.$themeix.'/themeiconcolor';
$title = get_string('themeiconcolor', 'theme_essential_fel');
$description = get_string('themeiconcolordesc', 'theme_essential_fel');
$default = '#30add1';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);

// Default button text colour setting.
$name = 'theme_essential_fel'.$themeix.'/themedefaultbuttontextcolour';
$title = get_string('themedefaultbuttontextcolour', 'theme_essential_fel');
$description = get_string('themedefaultbuttontextcolourdesc', 'theme_essential_fel');
$default = '#ffffff';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);

// Default button text hover colour setting.
$name = 'theme_essential_fel'.$themeix.'/themedefaultbuttontexthovercolour';
$title = get_string('themedefaultbuttontexthovercolour', 'theme_essential_fel');
$description = get_string('themedefaultbuttontexthovercolourdesc', 'theme_essential_fel');
$default = '#ffffff';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);

// Default button background colour setting.
$name = 'theme_essential_fel'.$themeix.'/themedefaultbuttonbackgroundcolour';
$title = get_string('themedefaultbuttonbackgroundcolour', 'theme_essential_fel');
$description = get_string('themedefaultbuttonbackgroundcolourdesc', 'theme_essential_fel');
$default = '#30add1';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);

// Default button background hover colour setting.
$name = 'theme_essential_fel'.$themeix.'/themedefaultbuttonbackgroundhovercolour';
$title = get_string('themedefaultbuttonbackgroundhovercolour', 'theme_essential_fel');
$description = get_string('themedefaultbuttonbackgroundhovercolourdesc', 'theme_essential_fel');
$default = '#3ad4ff';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);

// Navigation colour setting.
$name = 'theme_essential_fel'.$themeix.'/themenavcolor';
$title = get_string('themenavcolor', 'theme_essential_fel');
$description = get_string('themenavcolordesc', 'theme_essential_fel');
$default = '#ffffff';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);

// Theme stripe text colour setting.
$name = 'theme_essential_fel'.$themeix.'/themestripetextcolour';
$title = get_string('themestripetextcolour', 'theme_essential_fel');
$description = get_string('themestripetextcolourdesc', 'theme_essential_fel');
$default = '#ffffff';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);

// Theme stripe background colour setting.
$name = 'theme_essential_fel'.$themeix.'/themestripebackgroundcolour';
$title = get_string('themestripebackgroundcolour', 'theme_essential_fel');
$description = get_string('themestripebackgroundcolourdesc', 'theme_essential_fel');
$default = '#ff9a34';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);

// Theme stripe url colour setting.
$name = 'theme_essential_fel'.$themeix.'/themestripeurlcolour';
$title = get_string('themestripeurlcolour', 'theme_essential_fel');
$description = get_string('themestripeurlcolourdesc', 'theme_essential_fel');
$default = '#25849f';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);
