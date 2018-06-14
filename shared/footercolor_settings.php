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

// This is the descriptor for the footer.
$name = 'theme_essential_fel'.$themeix.'/footercolorinfo';
$heading = get_string('footercolors', 'theme_essential_fel');
$information = get_string('footercolorsdesc', 'theme_essential_fel');
$setting = new admin_setting_heading($name, $heading, $information);
$essential_fel_settingscolour->add($setting);

// Footer background colour setting.
$name = 'theme_essential_fel'.$themeix.'/footercolor';
$title = get_string('footercolor', 'theme_essential_fel');
$description = get_string('footercolordesc', 'theme_essential_fel');
$default = '#30add1';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);

// Footer text colour setting.
$name = 'theme_essential_fel'.$themeix.'/footertextcolor';
$title = get_string('footertextcolor', 'theme_essential_fel');
$description = get_string('footertextcolordesc', 'theme_essential_fel');
$default = '#ffffff';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);

// Footer heading colour setting.
$name = 'theme_essential_fel'.$themeix.'/footerheadingcolor';
$title = get_string('footerheadingcolor', 'theme_essential_fel');
$description = get_string('footerheadingcolordesc', 'theme_essential_fel');
$default = '#cccccc';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);

// Footer block background colour setting.
$name = 'theme_essential_fel'.$themeix.'/footerblockbackgroundcolour';
$title = get_string('footerblockbackgroundcolour', 'theme_essential_fel');
$description = get_string('footerblockbackgroundcolourdesc', 'theme_essential_fel');
$default = '#cccccc';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);

// Footer block text colour setting.
$name = 'theme_essential_fel'.$themeix.'/footerblocktextcolour';
$title = get_string('footerblocktextcolour', 'theme_essential_fel');
$description = get_string('footerblocktextcolourdesc', 'theme_essential_fel');
$default = '#000000';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);

// Footer block URL colour setting.
$name = 'theme_essential_fel'.$themeix.'/footerblockurlcolour';
$title = get_string('footerblockurlcolour', 'theme_essential_fel');
$description = get_string('footerblockurlcolourdesc', 'theme_essential_fel');
$default = '#000000';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);

// Footer block URL hover colour setting.
$name = 'theme_essential_fel'.$themeix.'/footerblockhovercolour';
$title = get_string('footerblockhovercolour', 'theme_essential_fel');
$description = get_string('footerblockhovercolourdesc', 'theme_essential_fel');
$default = '#555555';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);

// Footer seperator colour setting.
$name = 'theme_essential_fel'.$themeix.'/footersepcolor';
$title = get_string('footersepcolor', 'theme_essential_fel');
$description = get_string('footersepcolordesc', 'theme_essential_fel');
$default = '#313131';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);

// Footer URL colour setting.
$name = 'theme_essential_fel'.$themeix.'/footerurlcolor';
$title = get_string('footerurlcolor', 'theme_essential_fel');
$description = get_string('footerurlcolordesc', 'theme_essential_fel');
$default = '#cccccc';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);

// Footer URL hover colour setting.
$name = 'theme_essential_fel'.$themeix.'/footerhovercolor';
$title = get_string('footerhovercolor', 'theme_essential_fel');
$description = get_string('footerhovercolordesc', 'theme_essential_fel');
$default = '#bbbbbb';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingscolour->add($setting);


