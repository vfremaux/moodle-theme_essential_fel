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

$essential_fel_settingsfeature->add(new admin_setting_heading('theme_essential_fel5_feature',
    get_string('featureheadingsub', 'theme_essential_fel'),
    format_text(get_string('featuredesc', 'theme_essential_fel'), FORMAT_MARKDOWN)));

// Course content search.
$name = 'theme_essential_fel'.$themeix.'/coursecontentsearch';
$title = get_string('coursecontentsearch', 'theme_essential_fel');
$description = get_string('coursecontentsearchdesc', 'theme_essential_fel');
$default = true;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsfeature->add($setting);

// Custom scrollbars.
$name = 'theme_essential_fel'.$themeix.'/customscrollbars';
$title = get_string('customscrollbars', 'theme_essential_fel');
$description = get_string('customscrollbarsdesc', 'theme_essential_fel');
$default = true;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsfeature->add($setting);

// Fitvids.
$name = 'theme_essential_fel'.$themeix.'/fitvids';
$title = get_string('fitvids', 'theme_essential_fel');
$description = get_string('fitvidsdesc', 'theme_essential_fel');
$default = true;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsfeature->add($setting);

// Floating submit buttons.
$name = 'theme_essential_fel'.$themeix.'/floatingsubmitbuttons';
$title = get_string('floatingsubmitbuttons', 'theme_essential_fel');
$description = get_string('floatingsubmitbuttonsdesc', 'theme_essential_fel');
$default = true;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
$essential_fel_settingsfeature->add($setting);

// Custom or standard layout.
$name = 'theme_essential_fel'.$themeix.'/layout';
$title = get_string('layout', 'theme_essential_fel');
$description = get_string('layoutdesc', 'theme_essential_fel');
$default = false;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsfeature->add($setting);

// Categories in the course breadcrumb.
$name = 'theme_essential_fel'.$themeix.'/categoryincoursebreadcrumbfeature';
$title = get_string('categoryincoursebreadcrumbfeature', 'theme_essential_fel5');
$description = get_string('categoryincoursebreadcrumbfeaturedesc', 'theme_essential_fel5');
$default = true;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
$essential_fel_settingsfeature->add($setting);

// Return to section.
$name = 'theme_essential_fel'.$themeix.'/returntosectionfeature';
$title = get_string('returntosectionfeature', 'theme_essential_fel5');
$description = get_string('returntosectionfeaturedesc', 'theme_essential_fel5');
$default = true;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
$essential_fel_settingsfeature->add($setting);

// Return to section name text limit.
$name = 'theme_essential_fel'.$themeix.'/returntosectiontextlimitfeature';
$title = get_string('returntosectiontextlimitfeature', 'theme_essential_fel5');
$default = 15;
$lower = 5;
$upper = 40;
$description = get_string('returntosectiontextlimitfeaturedesc', 'theme_essential_fel5',
    array('lower' => $lower, 'upper' => $upper));
$setting = new essential_fel_admin_setting_configinteger($name, $title, $description, $default, $lower, $upper);
$essential_fel_settingsfeature->add($setting);

// Login background image.
$name = 'theme_essential_fel'.$themeix.'/loginbackground';
$title = get_string('loginbackground', 'theme_essential_fel');
$description = get_string('loginbackgrounddesc', 'theme_essential_fel');
$setting = new admin_setting_configstoredfile($name, $title, $description, 'loginbackground');
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsfeature->add($setting);

// Login background style.
$name = 'theme_essential_fel'.$themeix.'/loginbackgroundstyle';
$title = get_string('loginbackgroundstyle', 'theme_essential_fel');
$description = get_string('loginbackgroundstyledesc', 'theme_essential_fel');
$default = 'cover';
$setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default,
    array(
        'cover' => get_string('stylecover', 'theme_essential_fel'),
        'stretch' => get_string('stylestretch', 'theme_essential_fel')
    )
);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsfeature->add($setting);

    $opactitychoices = array(
        '0.0' => '0.0',
        '0.1' => '0.1',
        '0.2' => '0.2',
        '0.3' => '0.3',
        '0.4' => '0.4',
        '0.5' => '0.5',
        '0.6' => '0.6',
        '0.7' => '0.7',
        '0.8' => '0.8',
        '0.9' => '0.9',
        '1.0' => '1.0'
    );

    // Overridden course title text background opacity setting.
    $name = 'theme_essential_fel'.$themeix.'/loginbackgroundopacity';
    $title = get_string('loginbackgroundopacity', 'theme_essential_fel');
    $description = get_string('loginbackgroundopacitydesc', 'theme_essential_fel');
    $default = '0.8';
    $setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $opactitychoices);
    $essential_fel_settingsfeature->add($setting);

    $essential_fel_settingsfeature->add(new admin_setting_heading('theme_essential_fel5_featurereadme',
    get_string('readme_title', 'theme_essential_fel5'), get_string('readme_desc', 'theme_essential_fel5', array('url' => $readme))));
