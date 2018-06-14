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

// Footer background colour setting.
$name = 'theme_essential_fel'.$themeix.'/alternativethemefootercolor' . $alternativethemenumber;
$title = get_string('alternativethemefootercolor', 'theme_essential_fel', $alternativethemenumber);
$description = get_string('alternativethemefootercolordesc', 'theme_essential_fel', $alternativethemenumber);
$default = '#30add1';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);

// Footer text colour setting.
$name = 'theme_essential_fel'.$themeix.'/alternativethemefootertextcolor' . $alternativethemenumber;
$title = get_string('alternativethemefootertextcolor', 'theme_essential_fel', $alternativethemenumber);
$description = get_string('alternativethemefootertextcolordesc', 'theme_essential_fel', $alternativethemenumber);
$default = '#ffffff';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);

// Footer heading colour setting.
$name = 'theme_essential_fel'.$themeix.'/alternativethemefooterheadingcolor' . $alternativethemenumber;
$title = get_string('alternativethemefooterheadingcolor', 'theme_essential_fel', $alternativethemenumber);
$description = get_string('alternativethemefooterheadingcolordesc', 'theme_essential_fel', $alternativethemenumber);
$default = '#cccccc';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);

// Footer block background colour setting.
$name = 'theme_essential_fel'.$themeix.'/alternativethemefooterblockbackgroundcolour' . $alternativethemenumber;
$title = get_string('alternativethemefooterblockbackgroundcolour', 'theme_essential_fel', $alternativethemenumber);
$description = get_string('alternativethemefooterblockbackgroundcolourdesc', 'theme_essential_fel', $alternativethemenumber);
$default = '#cccccc';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);

// Footer block text colour setting.
$name = 'theme_essential_fel'.$themeix.'/alternativethemefooterblocktextcolour' . $alternativethemenumber;
$title = get_string('alternativethemefooterblocktextcolour', 'theme_essential_fel', $alternativethemenumber);
$description = get_string('alternativethemefooterblocktextcolourdesc', 'theme_essential_fel',
        $alternativethemenumber);
$default = '#000000';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);

// Footer block URL colour setting.
$name = 'theme_essential_fel'.$themeix.'/alternativethemefooterblockurlcolour' . $alternativethemenumber;
$title = get_string('alternativethemefooterblockurlcolour', 'theme_essential_fel', $alternativethemenumber);
$description = get_string('alternativethemefooterblockurlcolourdesc', 'theme_essential_fel', $alternativethemenumber);
$default = '#000000';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);

// Footer block URL hover colour setting.
$name = 'theme_essential_fel'.$themeix.'/alternativethemefooterblockhovercolour' . $alternativethemenumber;
$title = get_string('alternativethemefooterblockhovercolour', 'theme_essential_fel', $alternativethemenumber);
$description = get_string('alternativethemefooterblockhovercolourdesc', 'theme_essential_fel', $alternativethemenumber);
$default = '#555555';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);

// Footer seperator colour setting.
$name = 'theme_essential_fel'.$themeix.'/alternativethemefootersepcolor' . $alternativethemenumber;
$title = get_string('alternativethemefootersepcolor', 'theme_essential_fel', $alternativethemenumber);
$description = get_string('alternativethemefootersepcolordesc', 'theme_essential_fel', $alternativethemenumber);
$default = '#313131';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);

// Footer URL colour setting.
$name = 'theme_essential_fel'.$themeix.'/alternativethemefooterurlcolor' . $alternativethemenumber;
$title = get_string('alternativethemefooterurlcolor', 'theme_essential_fel', $alternativethemenumber);
$description = get_string('alternativethemefooterurlcolordesc', 'theme_essential_fel', $alternativethemenumber);
$default = '#cccccc';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);

// Footer URL hover colour setting.
$name = 'theme_essential_fel'.$themeix.'/alternativethemefooterhovercolor' . $alternativethemenumber;
$title = get_string('alternativethemefooterhovercolor', 'theme_essential_fel', $alternativethemenumber);
$description = get_string('alternativethemefooterhovercolordesc', 'theme_essential_fel', $alternativethemenumber);
$default = '#bbbbbb';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);
