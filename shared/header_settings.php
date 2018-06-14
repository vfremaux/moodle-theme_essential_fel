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

// New or old navbar.
$name = 'theme_essential_fel'.$themeix.'/oldnavbar';
$title = get_string('oldnavbar', 'theme_essential_fel');
$description = get_string('oldnavbardesc', 'theme_essential_fel');
$default = 0;
$choices = array(
    0 => get_string('navbarabove', 'theme_essential_fel'),
    1 => get_string('navbarbelow', 'theme_essential_fel')
);
$images = array(
    0 => 'navbarabove',
    1 => 'navbarbelow'
);
$setting = new essential_fel_admin_setting_configradio($name, $title, $description, $default, $choices, false, $images);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsheader->add($setting);

// Use the site icon if there is no logo.
$name = 'theme_essential_fel'.$themeix.'/usesiteicon';
$title = get_string('usesiteicon', 'theme_essential_fel');
$description = get_string('usesiteicondesc', 'theme_essential_fel');
$default = true;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsheader->add($setting);

// Default Site icon setting.
$name = 'theme_essential_fel'.$themeix.'/siteicon';
$title = get_string('siteicon', 'theme_essential_fel');
$description = get_string('siteicondesc', 'theme_essential_fel');
$default = 'laptop';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$essential_fel_settingsheader->add($setting);

// Header title setting.
$name = 'theme_essential_fel'.$themeix.'/headertitle';
$title = get_string('headertitle', 'theme_essential_fel');
$description = get_string('headertitledesc', 'theme_essential_fel');
$default = '1';
$choices = array(
    0 => get_string('notitle', 'theme_essential_fel'),
    1 => get_string('fullname', 'theme_essential_fel'),
    2 => get_string('shortname', 'theme_essential_fel'),
    3 => get_string('fullnamesummary', 'theme_essential_fel'),
    4 => get_string('shortnamesummary', 'theme_essential_fel')
);
$setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsheader->add($setting);

// Logo file setting.
$name = 'theme_essential_fel'.$themeix.'/logo';
$title = get_string('logo', 'theme_essential_fel');
$description = get_string('logodesc', 'theme_essential_fel');
$setting = new admin_setting_configstoredfile($name, $title, $description, 'logo');
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsheader->add($setting);

// Logo width setting.
$name = 'theme_essential_fel'.$themeix.'/logowidth';
$title = get_string('logowidth', 'theme_essential_fel');
$description = get_string('logowidthdesc', 'theme_essential_fel');
$default = '65px';
$regex = '/\b(\d)(\d*)(px|em)\b/';
$logodimerror = get_string('logodimerror', 'theme_essential_fel');
$setting = new essential_fel_admin_setting_configtext($name, $title, $description, $default, $regex, $logodimerror);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsheader->add($setting);

// Logo height setting.
$name = 'theme_essential_fel'.$themeix.'/logoheight';
$title = get_string('logoheight', 'theme_essential_fel');
$description = get_string('logoheightdesc', 'theme_essential_fel');
$default = '65px';
$setting = new essential_fel_admin_setting_configtext($name, $title, $description, $default, $regex, $logodimerror);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsheader->add($setting);

// Navbar title setting.
$name = 'theme_essential_fel'.$themeix.'/navbartitle';
$title = get_string('navbartitle', 'theme_essential_fel');
$description = get_string('navbartitledesc', 'theme_essential_fel');
$default = '2';
$choices = array(
    0 => get_string('notitle', 'theme_essential_fel'),
    1 => get_string('fullname', 'theme_essential_fel'),
    2 => get_string('shortname', 'theme_essential_fel')
);
$setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsheader->add($setting);

// Header text colour setting.
$name = 'theme_essential_fel'.$themeix.'/headertextcolor';
$title = get_string('headertextcolor', 'theme_essential_fel');
$description = get_string('headertextcolordesc', 'theme_essential_fel');
$default = '#217a94';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsheader->add($setting);

// Header background image.
$name = 'theme_essential_fel'.$themeix.'/headerbackground';
$title = get_string('headerbackground', 'theme_essential_fel');
$description = get_string('headerbackgrounddesc', 'theme_essential_fel');
$setting = new admin_setting_configstoredfile($name, $title, $description, 'headerbackground');
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsheader->add($setting);

// Background style.
$name = 'theme_essential_fel'.$themeix.'/headerbackgroundstyle';
$title = get_string('headerbackgroundstyle', 'theme_essential_fel');
$description = get_string('headerbackgroundstyledesc', 'theme_essential_fel');
$default = 'tiled';
$setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default,
    array(
        'fixed' => get_string('stylefixed', 'theme_essential_fel'),
        'tiled' => get_string('styletiled', 'theme_essential_fel')
    )
);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsheader->add($setting);

// Choose breadcrumbstyle.
$name = 'theme_essential_fel'.$themeix.'/breadcrumbstyle';
$title = get_string('breadcrumbstyle', 'theme_essential_fel');
$description = get_string('breadcrumbstyledesc', 'theme_essential_fel');
$default = 1;
$choices = array(
    1 => get_string('breadcrumbstyled', 'theme_essential_fel'),
    4 => get_string('breadcrumbstylednocollapse', 'theme_essential_fel'),
    2 => get_string('breadcrumbsimple', 'theme_essential_fel'),
    3 => get_string('breadcrumbthin', 'theme_essential_fel'),
    0 => get_string('nobreadcrumb', 'theme_essential_fel')
);
$images = array(
    1 => 'breadcrumbstyled',
    4 => 'breadcrumbstylednocollapse',
    2 => 'breadcrumbsimple',
    3 => 'breadcrumbthin'
);
$setting = new essential_fel_admin_setting_configradio($name, $title, $description, $default, $choices, false, $images);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsheader->add($setting);

// Header block.
$name = 'theme_essential_fel'.$themeix.'/haveheaderblock';
$title = get_string('haveheaderblock', 'theme_essential_fel');
$description = get_string('haveheaderblockdesc', 'theme_essential_fel');
$default = true;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$essential_fel_settingsheader->add($setting);

$name = 'theme_essential_fel'.$themeix.'/headerblocksperrow';
$title = get_string('headerblocksperrow', 'theme_essential_fel');
$default = 4;
$lower = 1;
$upper = 4;
$description = get_string('headerblocksperrowdesc', 'theme_essential_fel',
    array('lower' => $lower, 'upper' => $upper));
$setting = new essential_fel_admin_setting_configinteger($name, $title, $description, $default, $lower, $upper);
$essential_fel_settingsheader->add($setting);
