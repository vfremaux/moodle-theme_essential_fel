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

// This is the descriptor for the font settings.
$name = 'theme_essential_fel'.$themeix.'/fontheading';
$heading = get_string('fontheadingsub', 'theme_essential_fel');
$information = get_string('fontheadingdesc', 'theme_essential_fel');
$setting = new admin_setting_heading($name, $heading, $information);
$essential_fel_settingsfont->add($setting);

// Font selector.
$gws = html_writer::link('//www.google.com/fonts', get_string('fonttypegoogle', 'theme_essential_fel'), array('target' => '_blank'));
$name = 'theme_essential_fel'.$themeix.'/fontselect';
$title = get_string('fontselect', 'theme_essential_fel');
$description = get_string('fontselectdesc', 'theme_essential_fel', array('googlewebfonts' => $gws));
$default = 1;
$choices = array(
    1 => get_string('fonttypeuser', 'theme_essential_fel'),
    2 => get_string('fonttypegoogle', 'theme_essential_fel'),
    3 => get_string('fonttypecustom', 'theme_essential_fel')
);
$setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsfont->add($setting);

// Heading font name.
$name = 'theme_essential_fel'.$themeix.'/fontnameheading';
$title = get_string('fontnameheading', 'theme_essential_fel');
$description = get_string('fontnameheadingdesc', 'theme_essential_fel');
$default = 'Verdana';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsfont->add($setting);

// Text font name.
$name = 'theme_essential_fel'.$themeix.'/fontnamebody';
$title = get_string('fontnamebody', 'theme_essential_fel');
$description = get_string('fontnamebodydesc', 'theme_essential_fel');
$default = 'Verdana';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsfont->add($setting);

if ($config->fontselect === "2") {
    // Google font character sets.
    $name = 'theme_essential_fel'.$themeix.'/fontcharacterset';
    $title = get_string('fontcharacterset', 'theme_essential_fel');
    $description = get_string('fontcharactersetdesc', 'theme_essential_fel');
    $default = 'latin-ext';
    $setting = new admin_setting_configmulticheckbox($name, $title, $description, $default,
        array(
            'latin-ext' => get_string('fontcharactersetlatinext', 'theme_essential_fel'),
            'cyrillic' => get_string('fontcharactersetcyrillic', 'theme_essential_fel'),
            'cyrillic-ext' => get_string('fontcharactersetcyrillicext', 'theme_essential_fel'),
            'greek' => get_string('fontcharactersetgreek', 'theme_essential_fel'),
            'greek-ext' => get_string('fontcharactersetgreekext', 'theme_essential_fel'),
            'vietnamese' => get_string('fontcharactersetvietnamese', 'theme_essential_fel')
        )
    );
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_fel_settingsfont->add($setting);
} else if ($config->fontselect === "3") {
    // This is the descriptor for the font files.
    $name = 'theme_essential_fel'.$themeix.'/fontfiles';
    $heading = get_string('fontfiles', 'theme_essential_fel');
    $information = get_string('fontfilesdesc', 'theme_essential_fel');
    $setting = new admin_setting_heading($name, $heading, $information);
    $essential_fel_settingsfont->add($setting);

    // Heading fonts.
    // TTF font.
    $name = 'theme_essential_fel'.$themeix.'/fontfilettfheading';
    $title = get_string('fontfilettfheading', 'theme_essential_fel');
    $description = '';
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilettfheading');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_fel_settingsfont->add($setting);

    // OTF font.
    $name = 'theme_essential_fel'.$themeix.'/fontfileotfheading';
    $title = get_string('fontfileotfheading', 'theme_essential_fel');
    $description = '';
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfileotfheading');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_fel_settingsfont->add($setting);

    // WOFF font.
    $name = 'theme_essential_fel'.$themeix.'/fontfilewoffheading';
    $title = get_string('fontfilewoffheading', 'theme_essential_fel');
    $description = '';
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilewoffheading');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_fel_settingsfont->add($setting);

    // WOFF2 font.
    $name = 'theme_essential_fel'.$themeix.'/fontfilewofftwoheading';
    $title = get_string('fontfilewofftwoheading', 'theme_essential_fel');
    $description = '';
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilewofftwoheading');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_fel_settingsfont->add($setting);

    // EOT font.
    $name = 'theme_essential_fel'.$themeix.'/fontfileeotheading';
    $title = get_string('fontfileeotheading', 'theme_essential_fel');
    $description = '';
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfileeotheading');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_fel_settingsfont->add($setting);

    // SVG font.
    $name = 'theme_essential_fel'.$themeix.'/fontfilesvgheading';
    $title = get_string('fontfilesvgheading', 'theme_essential_fel');
    $description = '';
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilesvgheading');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_fel_settingsfont->add($setting);

    // Body fonts.
    // TTF font.
    $name = 'theme_essential_fel'.$themeix.'/fontfilettfbody';
    $title = get_string('fontfilettfbody', 'theme_essential_fel');
    $description = '';
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilettfbody');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_fel_settingsfont->add($setting);

    // OTF font.
    $name = 'theme_essential_fel'.$themeix.'/fontfileotfbody';
    $title = get_string('fontfileotfbody', 'theme_essential_fel');
    $description = '';
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfileotfbody');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_fel_settingsfont->add($setting);

    // WOFF font.
    $name = 'theme_essential_fel'.$themeix.'/fontfilewoffbody';
    $title = get_string('fontfilewoffbody', 'theme_essential_fel');
    $description = '';
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilewoffbody');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_fel_settingsfont->add($setting);

    // WOFF2 font.
    $name = 'theme_essential_fel'.$themeix.'/fontfilewofftwobody';
    $title = get_string('fontfilewofftwobody', 'theme_essential_fel');
    $description = '';
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilewofftwobody');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_fel_settingsfont->add($setting);

    // EOT font.
    $name = 'theme_essential_fel'.$themeix.'/fontfileeotbody';
    $title = get_string('fontfileeotbody', 'theme_essential_fel');
    $description = '';
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfileeotbody');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_fel_settingsfont->add($setting);

    // SVG font.
    $name = 'theme_essential_fel'.$themeix.'/fontfilesvgbody';
    $title = get_string('fontfilesvgbody', 'theme_essential_fel');
    $description = '';
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilesvgbody');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_fel_settingsfont->add($setting);
}

$essential_fel_settingsfont->add(new admin_setting_heading('theme_essential_fel5_fontreadme',
    get_string('readme_title', 'theme_essential_fel'), get_string('readme_desc', 'theme_essential_fel', array('url' => $readme))));
