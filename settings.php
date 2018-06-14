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
 * @copyright   2015 Gareth J Barnard
 * @copyright   2014 Gareth J Barnard, David Bezemer
 * @copyright   2013 Julian Ridden
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;
$settings = null; // Unsets the default $settings object initialised by Moodle.

// Create own category and define pages.
$ADMIN->add('themes', new admin_category('theme_essential_fel', 'Essential FEL'));

// Generic settings.
$essential_felsettingsgeneric = new admin_settingpage('theme_essential_fel_generic', get_string('genericsettings', 'theme_essential_fel'));
// Initialise individual settings only if admin pages require them.
if ($ADMIN->fulltree) {
    global $CFG;
    if (file_exists("{$CFG->dirroot}/theme/essential_fel/admin_setting_configselect.php")) {
        require_once($CFG->dirroot . '/theme/essential_fel/admin_setting_configtext.php');
        require_once($CFG->dirroot . '/theme/essential_fel/admin_setting_configselect.php');
        require_once($CFG->dirroot . '/theme/essential_fel/admin_setting_configinteger.php');
        require_once($CFG->dirroot . '/theme/essential_fel/admin_setting_configradio.php');
    } else if (!empty($CFG->themedir) && file_exists("{$CFG->themedir}/essential_fel/admin_setting_configselect.php")) {
        require_once($CFG->dirroot . '/theme/essential_fel/admin_setting_configtext.php');
        require_once($CFG->themedir . '/essential_fel/admin_setting_configselect.php');
        require_once($CFG->themedir . '/essential_fel/admin_setting_configinteger.php');
        require_once($CFG->themedir . '/essential_fel/admin_setting_configradio.php');
    }

    $sponsor = new moodle_url('http://moodle.org/user/profile.php?id=442195');
    $sponsor = html_writer::link($sponsor, get_string('paypal_click', 'theme_essential_fel'), array('target' => '_blank'));

    $flattr = new moodle_url('https://flattr.com/profile/gjb2048');
    $flattr = html_writer::link($flattr, get_string('flattr_click', 'theme_essential_fel'), array('target' => '_blank'));

    $essential_felsettingsgeneric->add(new admin_setting_heading('theme_essential_fel_generalsponsor',
        get_string('sponsor_title', 'theme_essential_fel'),
        get_string('sponsor_desc', 'theme_essential_fel') . get_string('paypal_desc', 'theme_essential_fel',
            array('url' => $sponsor)).get_string('flattr_desc', 'theme_essential_fel',
            array('url' => $flattr)).get_string('sponsor_desc2', 'theme_essential_fel')));

    $key = 'theme_essential_fel_variantsheading';
    $label = get_string('variantsheadingsub', 'theme_essential_fel');
    $desc = format_text(get_string('variantsheading_desc', 'theme_essential_fel'), FORMAT_MARKDOWN);
    $headersetting = new admin_setting_heading($key, $label, $desc);
    $essential_felsettingsgeneric->add($headersetting);

    // Theme variant tag.
    $name = 'theme_essential_fel/themetitle';
    $title = get_string('themetitle', 'theme_essential_fel');
    $description = get_string('themetitledesc', 'theme_essential_fel');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $essential_felsettingsgeneric->add($setting);

    $key = 'theme_essential_fel_generalheading';
    $label = get_string('generalheadingsub', 'theme_essential_fel');
    $desc = format_text(get_string('generalheadingdesc', 'theme_essential_fel'), FORMAT_MARKDOWN);
    $headersetting = new admin_setting_heading($key, $label, $desc);
    $essential_felsettingsgeneric->add($headersetting);

    // Page background image.
    $name = 'theme_essential_fel/pagebackground';
    $title = get_string('pagebackground', 'theme_essential_fel');
    $description = get_string('pagebackgrounddesc', 'theme_essential_fel');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'pagebackground');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsgeneric->add($setting);

    // Background style.
    $name = 'theme_essential_fel/pagebackgroundstyle';
    $title = get_string('pagebackgroundstyle', 'theme_essential_fel');
    $description = get_string('pagebackgroundstyledesc', 'theme_essential_fel');
    $default = 'fixed';
    $setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default,
        array(
            'fixed' => get_string('stylefixed', 'theme_essential_fel'),
            'tiled' => get_string('styletiled', 'theme_essential_fel'),
            'stretch' => get_string('stylestretch', 'theme_essential_fel')
        )
    );
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsgeneric->add($setting);

    // Fixed or variable width.
    $name = 'theme_essential_fel/pagewidth';
    $title = get_string('pagewidth', 'theme_essential_fel');
    $description = get_string('pagewidthdesc', 'theme_essential_fel');
    $default = 1200;
    $choices = array(
        960 => get_string('fixedwidthnarrow', 'theme_essential_fel'),
        1200 => get_string('fixedwidthnormal', 'theme_essential_fel'),
        1400 => get_string('fixedwidthwide', 'theme_essential_fel'),
        100 => get_string('variablewidth', 'theme_essential_fel'));
    $setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsgeneric->add($setting);

    // Page top blocks per row.
    $name = 'theme_essential_fel/pagetopblocksperrow';
    $title = get_string('pagetopblocksperrow', 'theme_essential_fel');
    $default = 1;
    $lower = 1;
    $upper = 4;
    $description = get_string('pagetopblocksperrowdesc', 'theme_essential_fel',
        array('lower' => $lower, 'upper' => $upper));
    $setting = new essential_fel_admin_setting_configinteger($name, $title, $description, $default, $lower, $upper);
    $essential_felsettingsgeneric->add($setting);

    // Page bottom blocks per row.
    $name = 'theme_essential_fel/pagebottomblocksperrow';
    $title = get_string('pagebottomblocksperrow', 'theme_essential_fel');
    $default = 4;
    $lower = 1;
    $upper = 4;
    $description = get_string('pagebottomblocksperrowdesc', 'theme_essential_fel',
        array('lower' => $lower, 'upper' => $upper));
    $setting = new essential_fel_admin_setting_configinteger($name, $title, $description, $default, $lower, $upper);
    $essential_felsettingsgeneric->add($setting);

    // Custom favicon.
    $name = 'theme_essential_fel/favicon';
    $title = get_string('favicon', 'theme_essential_fel');
    $description = get_string('favicondesc', 'theme_essential_fel');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'favicon');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsgeneric->add($setting);

    // Custom CSS file.
    $name = 'theme_essential_fel/customcss';
    $title = get_string('customcss', 'theme_essential_fel');
    $description = get_string('customcssdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsgeneric->add($setting);

    // Custom CSS file.
    $name = 'theme_essential_fel/additionalcsssheets';
    $title = get_string('additionalcsssheets', 'theme_essential_fel');
    $description = get_string('additionalcsssheetsdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsgeneric->add($setting);

    $readme = new moodle_url('/theme/essential_fel/README.txt');
    $readme = html_writer::link($readme, get_string('readme_click', 'theme_essential_fel'), array('target' => '_blank'));

    $essential_felsettingsgeneric->add(new admin_setting_heading('theme_essential_fel_generalreadme',
        get_string('readme_title', 'theme_essential_fel'), get_string('readme_desc', 'theme_essential_fel', array('url' => $readme))));
}
$ADMIN->add('theme_essential_fel', $essential_felsettingsgeneric);

// Feature settings.
$essential_felsettingsfeature = new admin_settingpage('theme_essential_fel_feature', get_string('featureheading', 'theme_essential_fel'));
if ($ADMIN->fulltree) {
    global $CFG;
    if (file_exists("{$CFG->dirroot}/theme/essential_fel/admin_setting_configinteger.php")) {
        require_once($CFG->dirroot . '/theme/essential_fel/admin_setting_configinteger.php');
    } else if (!empty($CFG->themedir) && file_exists("{$CFG->themedir}/essential_fel/admin_setting_configinteger.php")) {
        require_once($CFG->themedir . '/essential_fel/essential_fel_admin_setting_configinteger.php');
    }

    $essential_felsettingsfeature->add(new admin_setting_heading('theme_essential_fel_feature',
        get_string('featureheadingsub', 'theme_essential_fel'),
        format_text(get_string('featuredesc', 'theme_essential_fel'), FORMAT_MARKDOWN)));

    // Course content search.
    $name = 'theme_essential_fel/coursecontentsearch';
    $title = get_string('coursecontentsearch', 'theme_essential_fel');
    $description = get_string('coursecontentsearchdesc', 'theme_essential_fel');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfeature->add($setting);

    // Custom scrollbars.
    $name = 'theme_essential_fel/customscrollbars';
    $title = get_string('customscrollbars', 'theme_essential_fel');
    $description = get_string('customscrollbarsdesc', 'theme_essential_fel');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfeature->add($setting);

    // Fitvids.
    $name = 'theme_essential_fel/fitvids';
    $title = get_string('fitvids', 'theme_essential_fel');
    $description = get_string('fitvidsdesc', 'theme_essential_fel');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfeature->add($setting);

    // Floating submit buttons.
    $name = 'theme_essential_fel/floatingsubmitbuttons';
    $title = get_string('floatingsubmitbuttons', 'theme_essential_fel');
    $description = get_string('floatingsubmitbuttonsdesc', 'theme_essential_fel');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $essential_felsettingsfeature->add($setting);

    // Custom or standard layout.
    $name = 'theme_essential_fel/layout';
    $title = get_string('layout', 'theme_essential_fel');
    $description = get_string('layoutdesc', 'theme_essential_fel');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfeature->add($setting);

    // Categories in the course breadcrumb.
    $name = 'theme_essential_fel/categoryincoursebreadcrumbfeature';
    $title = get_string('categoryincoursebreadcrumbfeature', 'theme_essential_fel');
    $description = get_string('categoryincoursebreadcrumbfeaturedesc', 'theme_essential_fel');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $essential_felsettingsfeature->add($setting);

    // Return to section.
    $name = 'theme_essential_fel/returntosectionfeature';
    $title = get_string('returntosectionfeature', 'theme_essential_fel');
    $description = get_string('returntosectionfeaturedesc', 'theme_essential_fel');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $essential_felsettingsfeature->add($setting);

    // Return to section name text limit.
    $name = 'theme_essential_fel/returntosectiontextlimitfeature';
    $title = get_string('returntosectiontextlimitfeature', 'theme_essential_fel');
    $default = 15;
    $lower = 5;
    $upper = 40;
    $description = get_string('returntosectiontextlimitfeaturedesc', 'theme_essential_fel',
        array('lower' => $lower, 'upper' => $upper));
    $setting = new essential_fel_admin_setting_configinteger($name, $title, $description, $default, $lower, $upper);
    $essential_felsettingsfeature->add($setting);

    // Login background image.
    $name = 'theme_essential_fel/loginbackground';
    $title = get_string('loginbackground', 'theme_essential_fel');
    $description = get_string('loginbackgrounddesc', 'theme_essential_fel');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'loginbackground');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfeature->add($setting);

    // Login background style.
    $name = 'theme_essential_fel/loginbackgroundstyle';
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
    $essential_felsettingsfeature->add($setting);

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
        $name = 'theme_essential_fel/loginbackgroundopacity';
        $title = get_string('loginbackgroundopacity', 'theme_essential_fel');
        $description = get_string('loginbackgroundopacitydesc', 'theme_essential_fel');
        $default = '0.8';
        $setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $opactitychoices);
        $essential_felsettingsfeature->add($setting);

        // Hide logout links for sync users
        $name = 'theme_essential_fel/hide_logout_links';
        $title = get_string('hidelogoutlinks', 'theme_essential_fel');
        $description = get_string('hidelogoutlinksdesc', 'theme_essential_fel');
        $default = false;
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
        $essential_felsettingsfeature->add($setting);

        $essential_felsettingsfeature->add(new admin_setting_heading('theme_essential_fel_featurereadme',
        get_string('readme_title', 'theme_essential_fel'), get_string('readme_desc', 'theme_essential_fel', array('url' => $readme))));
}
$ADMIN->add('theme_essential_fel', $essential_felsettingsfeature);

// Colour settings.
$essential_felsettingscolour = new admin_settingpage('theme_essential_fel_colour', get_string('colorheading', 'theme_essential_fel'));
if ($ADMIN->fulltree) {
    $essential_felsettingscolour->add(new admin_setting_heading('theme_essential_fel_colour',
        get_string('colorheadingsub', 'theme_essential_fel'),
        format_text(get_string('colordesc', 'theme_essential_fel'), FORMAT_MARKDOWN)));

    // Main theme colour setting.
    $name = 'theme_essential_fel/themecolor';
    $title = get_string('themecolor', 'theme_essential_fel');
    $description = get_string('themecolordesc', 'theme_essential_fel');
    $default = '#30add1';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingscolour->add($setting);

    // Main theme text colour setting.
    $name = 'theme_essential_fel/themetextcolor';
    $title = get_string('themetextcolor', 'theme_essential_fel');
    $description = get_string('themetextcolordesc', 'theme_essential_fel');
    $default = '#217a94';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingscolour->add($setting);

    // Main theme link colour setting.
    $name = 'theme_essential_fel/themeurlcolor';
    $title = get_string('themeurlcolor', 'theme_essential_fel');
    $description = get_string('themeurlcolordesc', 'theme_essential_fel');
    $default = '#943b21';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingscolour->add($setting);

    // Main theme hover colour setting.
    $name = 'theme_essential_fel/themehovercolor';
    $title = get_string('themehovercolor', 'theme_essential_fel');
    $description = get_string('themehovercolordesc', 'theme_essential_fel');
    $default = '#6a2a18';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingscolour->add($setting);

    // Icon colour setting.
    $name = 'theme_essential_fel/themeiconcolor';
    $title = get_string('themeiconcolor', 'theme_essential_fel');
    $description = get_string('themeiconcolordesc', 'theme_essential_fel');
    $default = '#30add1';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingscolour->add($setting);

    // Default button text colour setting.
    $name = 'theme_essential_fel/themedefaultbuttontextcolour';
    $title = get_string('themedefaultbuttontextcolour', 'theme_essential_fel');
    $description = get_string('themedefaultbuttontextcolourdesc', 'theme_essential_fel');
    $default = '#ffffff';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingscolour->add($setting);

    // Default button text hover colour setting.
    $name = 'theme_essential_fel/themedefaultbuttontexthovercolour';
    $title = get_string('themedefaultbuttontexthovercolour', 'theme_essential_fel');
    $description = get_string('themedefaultbuttontexthovercolourdesc', 'theme_essential_fel');
    $default = '#ffffff';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingscolour->add($setting);

    // Default button background colour setting.
    $name = 'theme_essential_fel/themedefaultbuttonbackgroundcolour';
    $title = get_string('themedefaultbuttonbackgroundcolour', 'theme_essential_fel');
    $description = get_string('themedefaultbuttonbackgroundcolourdesc', 'theme_essential_fel');
    $default = '#30add1';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingscolour->add($setting);

    // Default button background hover colour setting.
    $name = 'theme_essential_fel/themedefaultbuttonbackgroundhovercolour';
    $title = get_string('themedefaultbuttonbackgroundhovercolour', 'theme_essential_fel');
    $description = get_string('themedefaultbuttonbackgroundhovercolourdesc', 'theme_essential_fel');
    $default = '#3ad4ff';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingscolour->add($setting);

    // Navigation colour setting.
    $name = 'theme_essential_fel/themenavcolor';
    $title = get_string('themenavcolor', 'theme_essential_fel');
    $description = get_string('themenavcolordesc', 'theme_essential_fel');
    $default = '#ffffff';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingscolour->add($setting);

    // Theme stripe text colour setting.
    $name = 'theme_essential_fel/themestripetextcolour';
    $title = get_string('themestripetextcolour', 'theme_essential_fel');
    $description = get_string('themestripetextcolourdesc', 'theme_essential_fel');
    $default = '#ffffff';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingscolour->add($setting);

    // Theme stripe background colour setting.
    $name = 'theme_essential_fel/themestripebackgroundcolour';
    $title = get_string('themestripebackgroundcolour', 'theme_essential_fel');
    $description = get_string('themestripebackgroundcolourdesc', 'theme_essential_fel');
    $default = '#ff9a34';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingscolour->add($setting);

    // Theme stripe url colour setting.
    $name = 'theme_essential_fel/themestripeurlcolour';
    $title = get_string('themestripeurlcolour', 'theme_essential_fel');
    $description = get_string('themestripeurlcolourdesc', 'theme_essential_fel');
    $default = '#25849f';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingscolour->add($setting);

    // This is the descriptor for the footer.
    $name = 'theme_essential_fel/footercolorinfo';
    $heading = get_string('footercolors', 'theme_essential_fel');
    $information = get_string('footercolorsdesc', 'theme_essential_fel');
    $setting = new admin_setting_heading($name, $heading, $information);
    $essential_felsettingscolour->add($setting);

    // Footer background colour setting.
    $name = 'theme_essential_fel/footercolor';
    $title = get_string('footercolor', 'theme_essential_fel');
    $description = get_string('footercolordesc', 'theme_essential_fel');
    $default = '#30add1';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingscolour->add($setting);

    // Footer text colour setting.
    $name = 'theme_essential_fel/footertextcolor';
    $title = get_string('footertextcolor', 'theme_essential_fel');
    $description = get_string('footertextcolordesc', 'theme_essential_fel');
    $default = '#ffffff';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingscolour->add($setting);

    // Footer heading colour setting.
    $name = 'theme_essential_fel/footerheadingcolor';
    $title = get_string('footerheadingcolor', 'theme_essential_fel');
    $description = get_string('footerheadingcolordesc', 'theme_essential_fel');
    $default = '#cccccc';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingscolour->add($setting);

    // Footer block background colour setting.
    $name = 'theme_essential_fel/footerblockbackgroundcolour';
    $title = get_string('footerblockbackgroundcolour', 'theme_essential_fel');
    $description = get_string('footerblockbackgroundcolourdesc', 'theme_essential_fel');
    $default = '#cccccc';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingscolour->add($setting);

    // Footer block text colour setting.
    $name = 'theme_essential_fel/footerblocktextcolour';
    $title = get_string('footerblocktextcolour', 'theme_essential_fel');
    $description = get_string('footerblocktextcolourdesc', 'theme_essential_fel');
    $default = '#000000';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingscolour->add($setting);

    // Footer block URL colour setting.
    $name = 'theme_essential_fel/footerblockurlcolour';
    $title = get_string('footerblockurlcolour', 'theme_essential_fel');
    $description = get_string('footerblockurlcolourdesc', 'theme_essential_fel');
    $default = '#000000';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingscolour->add($setting);

    // Footer block URL hover colour setting.
    $name = 'theme_essential_fel/footerblockhovercolour';
    $title = get_string('footerblockhovercolour', 'theme_essential_fel');
    $description = get_string('footerblockhovercolourdesc', 'theme_essential_fel');
    $default = '#555555';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingscolour->add($setting);

    // Footer seperator colour setting.
    $name = 'theme_essential_fel/footersepcolor';
    $title = get_string('footersepcolor', 'theme_essential_fel');
    $description = get_string('footersepcolordesc', 'theme_essential_fel');
    $default = '#313131';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingscolour->add($setting);

    // Footer URL colour setting.
    $name = 'theme_essential_fel/footerurlcolor';
    $title = get_string('footerurlcolor', 'theme_essential_fel');
    $description = get_string('footerurlcolordesc', 'theme_essential_fel');
    $default = '#cccccc';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingscolour->add($setting);

    // Footer URL hover colour setting.
    $name = 'theme_essential_fel/footerhovercolor';
    $title = get_string('footerhovercolor', 'theme_essential_fel');
    $description = get_string('footerhovercolordesc', 'theme_essential_fel');
    $default = '#bbbbbb';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingscolour->add($setting);

    // This is the descriptor for the user theme colours.
    $name = 'theme_essential_fel/alternativethemecolorsinfo';
    $heading = get_string('alternativethemecolors', 'theme_essential_fel');
    $information = get_string('alternativethemecolorsdesc', 'theme_essential_fel');
    $setting = new admin_setting_heading($name, $heading, $information);
    $essential_felsettingscolour->add($setting);

    $defaultalternativethemecolors = array('#a430d1', '#d15430', '#5dd130', '#006b94');
    $defaultalternativethemehovercolors = array('#9929c4', '#c44c29', '#53c429', '#4090af');
    $defaultalternativethemestripetextcolors = array('#bdfdb7', '#c3fdd0', '#9f5bfb', '#ff1ebd');
    $defaultalternativethemestripebackgroundcolors = array('#c1009f', '#bc2800', '#b4b2fd', '#0336b4');
    $defaultalternativethemestripeurlcolors = array('#bef500', '#30af67', '#ffe9a6', '#ffab00');

    foreach (range(1, 4) as $alternativethemenumber) {
        // Enables the user to select an alternative colours choice.
        $name = 'theme_essential_fel/enablealternativethemecolors' . $alternativethemenumber;
        $title = get_string('enablealternativethemecolors', 'theme_essential_fel', $alternativethemenumber);
        $description = get_string('enablealternativethemecolorsdesc', 'theme_essential_fel', $alternativethemenumber);
        $default = false;
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingscolour->add($setting);

        // User theme colour name.
        $name = 'theme_essential_fel/alternativethemename' . $alternativethemenumber;
        $title = get_string('alternativethemename', 'theme_essential_fel', $alternativethemenumber);
        $description = get_string('alternativethemenamedesc', 'theme_essential_fel', $alternativethemenumber);
        $default = get_string('alternativecolors', 'theme_essential_fel', $alternativethemenumber);
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingscolour->add($setting);

        // User theme colour setting.
        $name = 'theme_essential_fel/alternativethemecolor' . $alternativethemenumber;
        $title = get_string('alternativethemecolor', 'theme_essential_fel', $alternativethemenumber);
        $description = get_string('alternativethemecolordesc', 'theme_essential_fel', $alternativethemenumber);
        $default = $defaultalternativethemecolors[$alternativethemenumber - 1];
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingscolour->add($setting);

        // Alternative theme text colour setting.
        $name = 'theme_essential_fel/alternativethemetextcolor' . $alternativethemenumber;
        $title = get_string('alternativethemetextcolor', 'theme_essential_fel', $alternativethemenumber);
        $description = get_string('alternativethemetextcolordesc', 'theme_essential_fel', $alternativethemenumber);
        $default = $defaultalternativethemecolors[$alternativethemenumber - 1];
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingscolour->add($setting);

        // Alternative theme link colour setting.
        $name = 'theme_essential_fel/alternativethemeurlcolor' . $alternativethemenumber;
        $title = get_string('alternativethemeurlcolor', 'theme_essential_fel', $alternativethemenumber);
        $description = get_string('alternativethemeurlcolordesc', 'theme_essential_fel', $alternativethemenumber);
        $default = $defaultalternativethemecolors[$alternativethemenumber - 1];
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingscolour->add($setting);

        // Alternative theme link hover colour setting.
        $name = 'theme_essential_fel/alternativethemehovercolor' . $alternativethemenumber;
        $title = get_string('alternativethemehovercolor', 'theme_essential_fel', $alternativethemenumber);
        $description = get_string('alternativethemehovercolordesc', 'theme_essential_fel', $alternativethemenumber);
        $default = $defaultalternativethemehovercolors[$alternativethemenumber - 1];
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingscolour->add($setting);

        // Alternative theme default button text colour setting.
        $name = 'theme_essential_fel/alternativethemedefaultbuttontextcolour' . $alternativethemenumber;
        $title = get_string('alternativethemedefaultbuttontextcolour', 'theme_essential_fel', $alternativethemenumber);
        $description = get_string('alternativethemedefaultbuttontextcolourdesc', 'theme_essential_fel', $alternativethemenumber);
        $default = '#ffffff';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingscolour->add($setting);

        // Alternative theme default button text hover colour setting.
        $name = 'theme_essential_fel/alternativethemedefaultbuttontexthovercolour' . $alternativethemenumber;
        $title = get_string('alternativethemedefaultbuttontexthovercolour', 'theme_essential_fel', $alternativethemenumber);
        $description = get_string('alternativethemedefaultbuttontexthovercolourdesc', 'theme_essential_fel',
            $alternativethemenumber);
        $default = '#ffffff';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingscolour->add($setting);

        // Alternative theme default button background colour setting.
        $name = 'theme_essential_fel/alternativethemedefaultbuttonbackgroundcolour' . $alternativethemenumber;
        $title = get_string('alternativethemedefaultbuttonbackgroundcolour', 'theme_essential_fel', $alternativethemenumber);
        $description = get_string('alternativethemedefaultbuttonbackgroundcolourdesc', 'theme_essential_fel', $alternativethemenumber);
        $default = '#30add1';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingscolour->add($setting);

        // Alternative theme default button background hover colour setting.
        $name = 'theme_essential_fel/alternativethemedefbuttonbackgroundhvrcolour' . $alternativethemenumber;
        $title = get_string('alternativethemedefaultbuttonbackgroundhovercolour', 'theme_essential_fel', $alternativethemenumber);
        $description = get_string('alternativethemedefaultbuttonbackgroundhovercolourdesc', 'theme_essential_fel',
            $alternativethemenumber);
        $default = '#3ad4ff';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingscolour->add($setting);

        // Alternative theme icon colour setting.
        $name = 'theme_essential_fel/alternativethemeiconcolor' . $alternativethemenumber;
        $title = get_string('alternativethemeiconcolor', 'theme_essential_fel', $alternativethemenumber);
        $description = get_string('alternativethemeiconcolordesc', 'theme_essential_fel', $alternativethemenumber);
        $default = $defaultalternativethemecolors[$alternativethemenumber - 1];
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingscolour->add($setting);

        // Alternative theme nav colour setting.
        $name = 'theme_essential_fel/alternativethemenavcolor' . $alternativethemenumber;
        $title = get_string('alternativethemenavcolor', 'theme_essential_fel', $alternativethemenumber);
        $description = get_string('alternativethemenavcolordesc', 'theme_essential_fel', $alternativethemenumber);
        $default = '#ffffff';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingscolour->add($setting);

        // Alternative theme stripe text colour setting.
        $name = 'theme_essential_fel/alternativethemestripetextcolour' . $alternativethemenumber;
        $title = get_string('alternativethemestripetextcolour', 'theme_essential_fel', $alternativethemenumber);
        $description = get_string('alternativethemestripetextcolourdesc', 'theme_essential_fel', $alternativethemenumber);
        $default = $defaultalternativethemestripetextcolors[$alternativethemenumber - 1];
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingscolour->add($setting);

        // Alternative theme stripe background colour setting.
        $name = 'theme_essential_fel/alternativethemestripebackgroundcolour' . $alternativethemenumber;
        $title = get_string('alternativethemestripebackgroundcolour', 'theme_essential_fel', $alternativethemenumber);
        $description = get_string('alternativethemestripebackgroundcolourdesc', 'theme_essential_fel', $alternativethemenumber);
        $default = $defaultalternativethemestripebackgroundcolors[$alternativethemenumber - 1];
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingscolour->add($setting);

        // Theme stripe url colour setting.
        $name = 'theme_essential_fel/alternativethemestripeurlcolour' . $alternativethemenumber;
        $title = get_string('alternativethemestripeurlcolour', 'theme_essential_fel', $alternativethemenumber);
        $description = get_string('alternativethemestripeurlcolourdesc', 'theme_essential_fel', $alternativethemenumber);
        $default = $defaultalternativethemestripeurlcolors[$alternativethemenumber - 1];
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingscolour->add($setting);

        // Enrolled and not accessed course background colour.
        $name = 'theme_essential_fel/alternativethememycoursesorderenrolbackcolour'.$alternativethemenumber;
        $title = get_string('alternativethememycoursesorderenrolbackcolour', 'theme_essential_fel', $alternativethemenumber);
        $description = get_string('alternativethememycoursesorderenrolbackcolourdesc', 'theme_essential_fel', $alternativethemenumber);
        $default = '#a3ebff';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingscolour->add($setting);

        // Footer background colour setting.
        $name = 'theme_essential_fel/alternativethemefootercolor' . $alternativethemenumber;
        $title = get_string('alternativethemefootercolor', 'theme_essential_fel', $alternativethemenumber);
        $description = get_string('alternativethemefootercolordesc', 'theme_essential_fel', $alternativethemenumber);
        $default = '#30add1';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingscolour->add($setting);

        // Footer text colour setting.
        $name = 'theme_essential_fel/alternativethemefootertextcolor' . $alternativethemenumber;
        $title = get_string('alternativethemefootertextcolor', 'theme_essential_fel', $alternativethemenumber);
        $description = get_string('alternativethemefootertextcolordesc', 'theme_essential_fel', $alternativethemenumber);
        $default = '#ffffff';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingscolour->add($setting);

        // Footer heading colour setting.
        $name = 'theme_essential_fel/alternativethemefooterheadingcolor' . $alternativethemenumber;
        $title = get_string('alternativethemefooterheadingcolor', 'theme_essential_fel', $alternativethemenumber);
        $description = get_string('alternativethemefooterheadingcolordesc', 'theme_essential_fel', $alternativethemenumber);
        $default = '#cccccc';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingscolour->add($setting);

        // Footer block background colour setting.
        $name = 'theme_essential_fel/alternativethemefooterblockbackgroundcolour' . $alternativethemenumber;
        $title = get_string('alternativethemefooterblockbackgroundcolour', 'theme_essential_fel', $alternativethemenumber);
        $description = get_string('alternativethemefooterblockbackgroundcolourdesc', 'theme_essential_fel',
                $alternativethemenumber);
        $default = '#cccccc';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingscolour->add($setting);

        // Footer block text colour setting.
        $name = 'theme_essential_fel/alternativethemefooterblocktextcolour' . $alternativethemenumber;
        $title = get_string('alternativethemefooterblocktextcolour', 'theme_essential_fel', $alternativethemenumber);
        $description = get_string('alternativethemefooterblocktextcolourdesc', 'theme_essential_fel',
                $alternativethemenumber);
        $default = '#000000';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingscolour->add($setting);

        // Footer block URL colour setting.
        $name = 'theme_essential_fel/alternativethemefooterblockurlcolour' . $alternativethemenumber;
        $title = get_string('alternativethemefooterblockurlcolour', 'theme_essential_fel', $alternativethemenumber);
        $description = get_string('alternativethemefooterblockurlcolourdesc', 'theme_essential_fel', $alternativethemenumber);
        $default = '#000000';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingscolour->add($setting);

        // Footer block URL hover colour setting.
        $name = 'theme_essential_fel/alternativethemefooterblockhovercolour' . $alternativethemenumber;
        $title = get_string('alternativethemefooterblockhovercolour', 'theme_essential_fel', $alternativethemenumber);
        $description = get_string('alternativethemefooterblockhovercolourdesc', 'theme_essential_fel',
                $alternativethemenumber);
        $default = '#555555';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingscolour->add($setting);

        // Footer seperator colour setting.
        $name = 'theme_essential_fel/alternativethemefootersepcolor' . $alternativethemenumber;
        $title = get_string('alternativethemefootersepcolor', 'theme_essential_fel', $alternativethemenumber);
        $description = get_string('alternativethemefootersepcolordesc', 'theme_essential_fel', $alternativethemenumber);
        $default = '#313131';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingscolour->add($setting);

        // Footer URL colour setting.
        $name = 'theme_essential_fel/alternativethemefooterurlcolor' . $alternativethemenumber;
        $title = get_string('alternativethemefooterurlcolor', 'theme_essential_fel', $alternativethemenumber);
        $description = get_string('alternativethemefooterurlcolordesc', 'theme_essential_fel', $alternativethemenumber);
        $default = '#cccccc';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingscolour->add($setting);

        // Footer URL hover colour setting.
        $name = 'theme_essential_fel/alternativethemefooterhovercolor' . $alternativethemenumber;
        $title = get_string('alternativethemefooterhovercolor', 'theme_essential_fel', $alternativethemenumber);
        $description = get_string('alternativethemefooterhovercolordesc', 'theme_essential_fel', $alternativethemenumber);
        $default = '#bbbbbb';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingscolour->add($setting);
    }

    $essential_felsettingscolour->add(new admin_setting_heading('theme_essential_fel_colourreadme',
        get_string('readme_title', 'theme_essential_fel'), get_string('readme_desc', 'theme_essential_fel', array('url' => $readme))));
}
$ADMIN->add('theme_essential_fel', $essential_felsettingscolour);

// Header settings.
$essential_felsettingsheader = new admin_settingpage('theme_essential_fel_header', get_string('headerheading', 'theme_essential_fel'));
if ($ADMIN->fulltree) {
    global $CFG;
    if (file_exists("{$CFG->dirroot}/theme/essential_fel/admin_setting_configtext.php")) {
        require_once($CFG->dirroot . '/theme/essential_fel/admin_setting_configinteger.php');
        require_once($CFG->dirroot . '/theme/essential_fel/admin_setting_configtext.php');
        require_once($CFG->dirroot . '/theme/essential_fel/admin_setting_configradio.php');
    } else if (!empty($CFG->themedir) && file_exists("{$CFG->themedir}/essential_fel/admin_setting_configtext.php")) {
        require_once($CFG->themedir . '/essential_fel/admin_setting_configinteger.php');
        require_once($CFG->themedir . '/essential_fel/admin_setting_configtext.php');
        require_once($CFG->themedir . '/essential_fel/admin_setting_configradio.php');
    }

    // New or old navbar.
    $name = 'theme_essential_fel/oldnavbar';
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
    $essential_felsettingsheader->add($setting);

    // Use the site icon if there is no logo.
    $name = 'theme_essential_fel/usesiteicon';
    $title = get_string('usesiteicon', 'theme_essential_fel');
    $description = get_string('usesiteicondesc', 'theme_essential_fel');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsheader->add($setting);

    // Default Site icon setting.
    $name = 'theme_essential_fel/siteicon';
    $title = get_string('siteicon', 'theme_essential_fel');
    $description = get_string('siteicondesc', 'theme_essential_fel');
    $default = 'laptop';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $essential_felsettingsheader->add($setting);

    // Header title setting.
    $name = 'theme_essential_fel/headertitle';
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
    $essential_felsettingsheader->add($setting);

    // Logo file setting.
    $name = 'theme_essential_fel/logo';
    $title = get_string('logo', 'theme_essential_fel');
    $description = get_string('logodesc', 'theme_essential_fel');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsheader->add($setting);

    // Logo width setting.
    $name = 'theme_essential_fel/logowidth';
    $title = get_string('logowidth', 'theme_essential_fel');
    $description = get_string('logowidthdesc', 'theme_essential_fel');
    $default = '65px';
    $regex = '/\b(\d)(\d*)(px|em)\b/';
    $logodimerror = get_string('logodimerror', 'theme_essential_fel');
    $setting = new essential_fel_admin_setting_configtext($name, $title, $description, $default, $regex, $logodimerror);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsheader->add($setting);

    // Logo height setting.
    $name = 'theme_essential_fel/logoheight';
    $title = get_string('logoheight', 'theme_essential_fel');
    $description = get_string('logoheightdesc', 'theme_essential_fel');
    $default = '65px';
    $setting = new essential_fel_admin_setting_configtext($name, $title, $description, $default, $regex, $logodimerror);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsheader->add($setting);

    // Navbar title setting.
    $name = 'theme_essential_fel/navbartitle';
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
    $essential_felsettingsheader->add($setting);

    // Header text colour setting.
    $name = 'theme_essential_fel/headertextcolor';
    $title = get_string('headertextcolor', 'theme_essential_fel');
    $description = get_string('headertextcolordesc', 'theme_essential_fel');
    $default = '#217a94';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsheader->add($setting);

    // Header background image.
    $name = 'theme_essential_fel/headerbackground';
    $title = get_string('headerbackground', 'theme_essential_fel');
    $description = get_string('headerbackgrounddesc', 'theme_essential_fel');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'headerbackground');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsheader->add($setting);

    // Background style.
    $name = 'theme_essential_fel/headerbackgroundstyle';
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
    $essential_felsettingsheader->add($setting);

    // Choose breadcrumbstyle.
    $name = 'theme_essential_fel/breadcrumbstyle';
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
    $essential_felsettingsheader->add($setting);

    // Header block.
    $name = 'theme_essential_fel/haveheaderblock';
    $title = get_string('haveheaderblock', 'theme_essential_fel');
    $description = get_string('haveheaderblockdesc', 'theme_essential_fel');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $essential_felsettingsheader->add($setting);

    $name = 'theme_essential_fel/headerblocksperrow';
    $title = get_string('headerblocksperrow', 'theme_essential_fel');
    $default = 4;
    $lower = 1;
    $upper = 4;
    $description = get_string('headerblocksperrowdesc', 'theme_essential_fel',
        array('lower' => $lower, 'upper' => $upper));
    $setting = new essential_fel_admin_setting_configinteger($name, $title, $description, $default, $lower, $upper);
    $essential_felsettingsheader->add($setting);

    // Course menu settings.
    $name = 'theme_essential_fel/mycoursesinfo';
    $heading = get_string('mycoursesinfo', 'theme_essential_fel');
    $information = get_string('mycoursesinfodesc', 'theme_essential_fel');
    $setting = new admin_setting_heading($name, $heading, $information);
    $essential_felsettingsheader->add($setting);

    // Toggle courses display in custommenu.
    $name = 'theme_essential_fel/displaymycourses';
    $title = get_string('displaymycourses', 'theme_essential_fel');
    $description = get_string('displaymycoursesdesc', 'theme_essential_fel');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsheader->add($setting);

    // Toggle hidden courses display in custommenu.
    $name = 'theme_essential_fel/displayhiddenmycourses';
    $title = get_string('displayhiddenmycourses', 'theme_essential_fel');
    $description = get_string('displayhiddenmycoursesdesc', 'theme_essential_fel');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    // No need for callback as CSS not changed.
    $essential_felsettingsheader->add($setting);

    // My courses order.
    $name = 'theme_essential_fel/mycoursesorder';
    $title = get_string('mycoursesorder', 'theme_essential_fel');
    $description = get_string('mycoursesorderdesc', 'theme_essential_fel');
    $default = 1;
    $choices = array(
        1 => get_string('mycoursesordersort', 'theme_essential_fel'),
        2 => get_string('mycoursesorderid', 'theme_essential_fel'),
        3 => get_string('mycoursesorderlast', 'theme_essential_fel')
    );
    $setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
    // No need for callback as CSS not changed.
    $essential_felsettingsheader->add($setting);

    // Course ID order.
    $name = 'theme_essential_fel/mycoursesorderidorder';
    $title = get_string('mycoursesorderidorder', 'theme_essential_fel');
    $description = get_string('mycoursesorderidorderdesc', 'theme_essential_fel');
    $default = 1;
    $choices = array(
        1 => get_string('mycoursesorderidasc', 'theme_essential_fel'),
        2 => get_string('mycoursesorderiddes', 'theme_essential_fel')
    );
    $setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
    // No need for callback as CSS not changed.
    $essential_felsettingsheader->add($setting);

    // Max courses.
    $name = 'theme_essential_fel/mycoursesmax';
    $title = get_string('mycoursesmax', 'theme_essential_fel');
    $default = 0;
    $lower = 0;
    $upper = 20;
    $description = get_string('mycoursesmaxdesc', 'theme_essential_fel',
        array('lower' => $lower, 'upper' => $upper));
    $setting = new essential_fel_admin_setting_configinteger($name, $title, $description, $default, $lower, $upper);
    // No need for callback as CSS not changed.
    $essential_felsettingsheader->add($setting);

    // Set terminology for dropdown course list.
    $name = 'theme_essential_fel/mycoursetitle';
    $title = get_string('mycoursetitle', 'theme_essential_fel');
    $description = get_string('mycoursetitledesc', 'theme_essential_fel');
    $default = 'course';
    $choices = array(
        'course' => get_string('mycourses', 'theme_essential_fel'),
        'unit' => get_string('myunits', 'theme_essential_fel'),
        'class' => get_string('myclasses', 'theme_essential_fel'),
        'module' => get_string('mymodules', 'theme_essential_fel')
    );
    $setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsheader->add($setting);

    // Enrolled and not accessed course background colour.
    $name = 'theme_essential_fel/mycoursesorderenrolbackcolour';
    $title = get_string('mycoursesorderenrolbackcolour', 'theme_essential_fel');
    $description = get_string('mycoursesorderenrolbackcolourdesc', 'theme_essential_fel');
    $default = '#a3ebff';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsheader->add($setting);

    // User menu settings.
    $name = 'theme_essential_fel/usermenu';
    $heading = get_string('usermenu', 'theme_essential_fel');
    $information = get_string('usermenudesc', 'theme_essential_fel');
    $setting = new admin_setting_heading($name, $heading, $information);
    $essential_felsettingsheader->add($setting);

    // Helplink type.
    $name = 'theme_essential_fel/helplinktype';
    $title = get_string('helplinktype', 'theme_essential_fel');
    $description = get_string('helplinktypedesc', 'theme_essential_fel');
    $default = 1;
    $choices = array(1 => get_string('email'),
        2 => get_string('url'),
        0 => get_string('none')
    );
    $setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsheader->add($setting);

    // Helplink.
    $name = 'theme_essential_fel/helplink';
    $title = get_string('helplink', 'theme_essential_fel');
    $description = get_string('helplinkdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsheader->add($setting);

    // Editing menu settings.
    $name = 'theme_essential_fel/editingmenu';
    $heading = get_string('editingmenu', 'theme_essential_fel');
    $information = get_string('editingmenudesc', 'theme_essential_fel');
    $setting = new admin_setting_heading($name, $heading, $information);
    $essential_felsettingsheader->add($setting);

    $name = 'theme_essential_fel/displayeditingmenu';
    $title = get_string('displayeditingmenu', 'theme_essential_fel');
    $description = get_string('displayeditingmenudesc', 'theme_essential_fel');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $essential_felsettingsheader->add($setting);

    $name = 'theme_essential_fel/hidedefaulteditingbutton';
    $title = get_string('hidedefaulteditingbutton', 'theme_essential_fel');
    $description = get_string('hidedefaulteditingbuttondesc', 'theme_essential_fel');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $essential_felsettingsheader->add($setting);

    // Social network settings.
    $essential_felsettingsheader->add(new admin_setting_heading('theme_essential_fel_social',
        get_string('socialheadingsub', 'theme_essential_fel'),
        format_text(get_string('socialdesc', 'theme_essential_fel'), FORMAT_MARKDOWN)));

    // Website URL setting.
    $name = 'theme_essential_fel/website';
    $title = get_string('websiteurl', 'theme_essential_fel');
    $description = get_string('websitedesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsheader->add($setting);

    // Facebook URL setting.
    $name = 'theme_essential_fel/facebook';
    $title = get_string('facebookurl', 'theme_essential_fel');
    $description = get_string('facebookdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsheader->add($setting);

    // Flickr URL setting.
    $name = 'theme_essential_fel/flickr';
    $title = get_string('flickrurl', 'theme_essential_fel');
    $description = get_string('flickrdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsheader->add($setting);

    // Twitter URL setting.
    $name = 'theme_essential_fel/twitter';
    $title = get_string('twitterurl', 'theme_essential_fel');
    $description = get_string('twitterdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsheader->add($setting);

    // Google+ URL setting.
    $name = 'theme_essential_fel/googleplus';
    $title = get_string('googleplusurl', 'theme_essential_fel');
    $description = get_string('googleplusdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsheader->add($setting);

    // LinkedIn URL setting.
    $name = 'theme_essential_fel/linkedin';
    $title = get_string('linkedinurl', 'theme_essential_fel');
    $description = get_string('linkedindesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsheader->add($setting);

    // Pinterest URL setting.
    $name = 'theme_essential_fel/pinterest';
    $title = get_string('pinteresturl', 'theme_essential_fel');
    $description = get_string('pinterestdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsheader->add($setting);

    // Instagram URL setting.
    $name = 'theme_essential_fel/instagram';
    $title = get_string('instagramurl', 'theme_essential_fel');
    $description = get_string('instagramdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsheader->add($setting);

    // YouTube URL setting.
    $name = 'theme_essential_fel/youtube';
    $title = get_string('youtubeurl', 'theme_essential_fel');
    $description = get_string('youtubedesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsheader->add($setting);

    // Skype URL setting.
    $name = 'theme_essential_fel/skype';
    $title = get_string('skypeuri', 'theme_essential_fel');
    $description = get_string('skypedesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsheader->add($setting);

    // VKontakte URL setting.
    $name = 'theme_essential_fel/vk';
    $title = get_string('vkurl', 'theme_essential_fel');
    $description = get_string('vkdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsheader->add($setting);

    // Apps settings.
    $essential_felsettingsheader->add(new admin_setting_heading('theme_essential_fel_mobileapps',
        get_string('mobileappsheadingsub', 'theme_essential_fel'),
        format_text(get_string('mobileappsdesc', 'theme_essential_fel'), FORMAT_MARKDOWN)));

    // Android App URL setting.
    $name = 'theme_essential_fel/android';
    $title = get_string('androidurl', 'theme_essential_fel');
    $description = get_string('androiddesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsheader->add($setting);

    // Windows App URL setting.
    $name = 'theme_essential_fel/windows';
    $title = get_string('windowsurl', 'theme_essential_fel');
    $description = get_string('windowsdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsheader->add($setting);

    // Windows PhoneApp URL setting.
    $name = 'theme_essential_fel/winphone';
    $title = get_string('winphoneurl', 'theme_essential_fel');
    $description = get_string('winphonedesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsheader->add($setting);

    // The iOS App URL setting.
    $name = 'theme_essential_fel/ios';
    $title = get_string('iosurl', 'theme_essential_fel');
    $description = get_string('iosdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsheader->add($setting);

    // This is the descriptor for iOS icons.
    $name = 'theme_essential_fel/iosiconinfo';
    $heading = get_string('iosicon', 'theme_essential_fel');
    $information = get_string('iosicondesc', 'theme_essential_fel');
    $setting = new admin_setting_heading($name, $heading, $information);
    $essential_felsettingsheader->add($setting);

    // The iPhone icon.
    $name = 'theme_essential_fel/iphoneicon';
    $title = get_string('iphoneicon', 'theme_essential_fel');
    $description = get_string('iphoneicondesc', 'theme_essential_fel');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'iphoneicon');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsheader->add($setting);

    // The iPhone retina icon.
    $name = 'theme_essential_fel/iphoneretinaicon';
    $title = get_string('iphoneretinaicon', 'theme_essential_fel');
    $description = get_string('iphoneretinaicondesc', 'theme_essential_fel');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'iphoneretinaicon');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsheader->add($setting);

    // The iPad icon.
    $name = 'theme_essential_fel/ipadicon';
    $title = get_string('ipadicon', 'theme_essential_fel');
    $description = get_string('ipadicondesc', 'theme_essential_fel');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'ipadicon');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsheader->add($setting);

    // The iPad retina icon.
    $name = 'theme_essential_fel/ipadretinaicon';
    $title = get_string('ipadretinaicon', 'theme_essential_fel');
    $description = get_string('ipadretinaicondesc', 'theme_essential_fel');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'ipadretinaicon');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsheader->add($setting);

    $essential_felsettingsheader->add(new admin_setting_heading('theme_essential_fel_headerreadme',
        get_string('readme_title', 'theme_essential_fel'), get_string('readme_desc', 'theme_essential_fel', array('url' => $readme))));
}
$ADMIN->add('theme_essential_fel', $essential_felsettingsheader);

// Font settings.
$essential_felsettingsfont = new admin_settingpage('theme_essential_fel_font', get_string('fontsettings', 'theme_essential_fel'));
if ($ADMIN->fulltree) {
    // This is the descriptor for the font settings.
    $name = 'theme_essential_fel/fontheading';
    $heading = get_string('fontheadingsub', 'theme_essential_fel');
    $information = get_string('fontheadingdesc', 'theme_essential_fel');
    $setting = new admin_setting_heading($name, $heading, $information);
    $essential_felsettingsfont->add($setting);

    // Font selector.
    $gws = html_writer::link('//www.google.com/fonts', get_string('fonttypegoogle', 'theme_essential_fel'), array('target' => '_blank'));
    $name = 'theme_essential_fel/fontselect';
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
    $essential_felsettingsfont->add($setting);

    // Heading font name.
    $name = 'theme_essential_fel/fontnameheading';
    $title = get_string('fontnameheading', 'theme_essential_fel');
    $description = get_string('fontnameheadingdesc', 'theme_essential_fel');
    $default = 'Verdana';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfont->add($setting);

    // Text font name.
    $name = 'theme_essential_fel/fontnamebody';
    $title = get_string('fontnamebody', 'theme_essential_fel');
    $description = get_string('fontnamebodydesc', 'theme_essential_fel');
    $default = 'Verdana';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfont->add($setting);

    if (get_config('theme_essential_fel', 'fontselect') === "2") {
        // Google font character sets.
        $name = 'theme_essential_fel/fontcharacterset';
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
        $essential_felsettingsfont->add($setting);
    } else if (get_config('theme_essential_fel', 'fontselect') === "3") {
        // This is the descriptor for the font files.
        $name = 'theme_essential_fel/fontfiles';
        $heading = get_string('fontfiles', 'theme_essential_fel');
        $information = get_string('fontfilesdesc', 'theme_essential_fel');
        $setting = new admin_setting_heading($name, $heading, $information);
        $essential_felsettingsfont->add($setting);

        // Heading fonts.
        // TTF font.
        $name = 'theme_essential_fel/fontfilettfheading';
        $title = get_string('fontfilettfheading', 'theme_essential_fel');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilettfheading');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingsfont->add($setting);

        // OTF font.
        $name = 'theme_essential_fel/fontfileotfheading';
        $title = get_string('fontfileotfheading', 'theme_essential_fel');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfileotfheading');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingsfont->add($setting);

        // WOFF font.
        $name = 'theme_essential_fel/fontfilewoffheading';
        $title = get_string('fontfilewoffheading', 'theme_essential_fel');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilewoffheading');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingsfont->add($setting);

        // WOFF2 font.
        $name = 'theme_essential_fel/fontfilewofftwoheading';
        $title = get_string('fontfilewofftwoheading', 'theme_essential_fel');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilewofftwoheading');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingsfont->add($setting);

        // EOT font.
        $name = 'theme_essential_fel/fontfileeotheading';
        $title = get_string('fontfileeotheading', 'theme_essential_fel');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfileeotheading');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingsfont->add($setting);

        // SVG font.
        $name = 'theme_essential_fel/fontfilesvgheading';
        $title = get_string('fontfilesvgheading', 'theme_essential_fel');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilesvgheading');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingsfont->add($setting);

        // Body fonts.
        // TTF font.
        $name = 'theme_essential_fel/fontfilettfbody';
        $title = get_string('fontfilettfbody', 'theme_essential_fel');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilettfbody');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingsfont->add($setting);

        // OTF font.
        $name = 'theme_essential_fel/fontfileotfbody';
        $title = get_string('fontfileotfbody', 'theme_essential_fel');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfileotfbody');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingsfont->add($setting);

        // WOFF font.
        $name = 'theme_essential_fel/fontfilewoffbody';
        $title = get_string('fontfilewoffbody', 'theme_essential_fel');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilewoffbody');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingsfont->add($setting);

        // WOFF2 font.
        $name = 'theme_essential_fel/fontfilewofftwobody';
        $title = get_string('fontfilewofftwobody', 'theme_essential_fel');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilewofftwobody');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingsfont->add($setting);

        // EOT font.
        $name = 'theme_essential_fel/fontfileeotbody';
        $title = get_string('fontfileeotbody', 'theme_essential_fel');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfileeotbody');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingsfont->add($setting);

        // SVG font.
        $name = 'theme_essential_fel/fontfilesvgbody';
        $title = get_string('fontfilesvgbody', 'theme_essential_fel');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilesvgbody');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingsfont->add($setting);
    }

    $essential_felsettingsfont->add(new admin_setting_heading('theme_essential_fel_fontreadme',
        get_string('readme_title', 'theme_essential_fel'), get_string('readme_desc', 'theme_essential_fel', array('url' => $readme))));
}
$ADMIN->add('theme_essential_fel', $essential_felsettingsfont);

// Footer settings.
$essential_felsettingsfooter = new admin_settingpage('theme_essential_fel_footer', get_string('footerheading', 'theme_essential_fel'));
if ($ADMIN->fulltree) {
    // Copyright setting.
    $name = 'theme_essential_fel/copyright';
    $title = get_string('copyright', 'theme_essential_fel');
    $description = get_string('copyrightdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $essential_felsettingsfooter->add($setting);

    // Footnote setting.
    $name = 'theme_essential_fel/footnote';
    $title = get_string('footnote', 'theme_essential_fel');
    $description = get_string('footnotedesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfooter->add($setting);

    // Performance information display.
    $name = 'theme_essential_fel/perfinfo';
    $title = get_string('perfinfo', 'theme_essential_fel');
    $description = get_string('perfinfodesc', 'theme_essential_fel');
    $perfmax = get_string('perf_max', 'theme_essential_fel');
    $perfmin = get_string('perf_min', 'theme_essential_fel');
    $default = 'min';
    $choices = array('min' => $perfmin, 'max' => $perfmax);
    $setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfooter->add($setting);

    $name = 'theme_essential_fel/footerlogo1';
    $title = get_string('footerlogo', 'theme_essential_fel').' 1';
    $description = get_string('footerlogodesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'footerlogo1');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfooter->add($setting);

    $name = 'theme_essential_fel/footerlogo2';
    $title = get_string('footerlogo', 'theme_essential_fel').' 2';
    $description = get_string('footerlogodesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'footerlogo2');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfooter->add($setting);

    $name = 'theme_essential_fel/footerlogo3';
    $title = get_string('footerlogo', 'theme_essential_fel').' 3';
    $description = get_string('footerlogodesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'footerlogo3');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfooter->add($setting);

    $essential_felsettingsfooter->add(new admin_setting_heading('theme_essential_fel_footerreadme',
        get_string('readme_title', 'theme_essential_fel'), get_string('readme_desc', 'theme_essential_fel', array('url' => $readme))));
}
$ADMIN->add('theme_essential_fel', $essential_felsettingsfooter);

// Frontpage settings.
$essential_felsettingsfrontpage = new admin_settingpage('theme_essential_fel_frontpage', get_string('frontpageheading', 'theme_essential_fel'));
if ($ADMIN->fulltree) {

    $name = 'theme_essential_fel/courselistteachericon';
    $title = get_string('courselistteachericon', 'theme_essential_fel');
    $description = get_string('courselistteachericondesc', 'theme_essential_fel');
    $default = 'graduation-cap';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfrontpage->add($setting);

    $essential_felsettingsfrontpage->add(new admin_setting_heading('theme_essential_fel_frontcontent',
        get_string('frontcontentheading', 'theme_essential_fel'), ''));

    // Toggle frontpage content.
    $name = 'theme_essential_fel/togglefrontcontent';
    $title = get_string('frontcontent', 'theme_essential_fel');
    $description = get_string('frontcontentdesc', 'theme_essential_fel');
    $alwaysdisplay = get_string('alwaysdisplay', 'theme_essential_fel');
    $displaybeforelogin = get_string('displaybeforelogin', 'theme_essential_fel');
    $displayafterlogin = get_string('displayafterlogin', 'theme_essential_fel');
    $dontdisplay = get_string('dontdisplay', 'theme_essential_fel');
    $default = 0;
    $choices = array(1 => $alwaysdisplay, 2 => $displaybeforelogin, 3 => $displayafterlogin, 0 => $dontdisplay);
    $setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfrontpage->add($setting);

    // Frontpage content.
    $name = 'theme_essential_fel/frontcontentarea';
    $title = get_string('frontcontentarea', 'theme_essential_fel');
    $description = get_string('frontcontentareadesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfrontpage->add($setting);

    $name = 'theme_essential_fel_frontpageblocksheading';
    $heading = get_string('frontpageblocksheading', 'theme_essential_fel');
    $information = '';
    $setting = new admin_setting_heading($name, $heading, $information);
    $essential_felsettingsfrontpage->add($setting);

    // Frontpage block alignment.
    $name = 'theme_essential_fel/frontpageblocks';
    $title = get_string('frontpageblocks', 'theme_essential_fel');
    $description = get_string('frontpageblocksdesc', 'theme_essential_fel');
    $before = get_string('beforecontent', 'theme_essential_fel');
    $after = get_string('aftercontent', 'theme_essential_fel');
    $default = 1;
    $choices = array(1 => $before, 0 => $after);
    $setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfrontpage->add($setting);

    // Toggle frontpage home (was middle) blocks.
    $name = 'theme_essential_fel/frontpagemiddleblocks';
    $title = get_string('frontpagemiddleblocks', 'theme_essential_fel');
    $description = get_string('frontpagemiddleblocksdesc', 'theme_essential_fel');
    $alwaysdisplay = get_string('alwaysdisplay', 'theme_essential_fel');
    $displaybeforelogin = get_string('displaybeforelogin', 'theme_essential_fel');
    $displayafterlogin = get_string('displayafterlogin', 'theme_essential_fel');
    $dontdisplay = get_string('dontdisplay', 'theme_essential_fel');
    $default = 0;
    $choices = array(1 => $alwaysdisplay, 2 => $displaybeforelogin, 3 => $displayafterlogin, 0 => $dontdisplay);
    $setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfrontpage->add($setting);

    // Home blocks per row.
    $name = 'theme_essential_fel/frontpagehomeblocksperrow';
    $title = get_string('frontpagehomeblocksperrow', 'theme_essential_fel');
    $default = 3;
    $lower = 1;
    $upper = 4;
    $description = get_string('frontpagehomeblocksperrowdesc', 'theme_essential_fel',
        array('lower' => $lower, 'upper' => $upper));
    $setting = new essential_fel_admin_setting_configinteger($name, $title, $description, $default, $lower, $upper);
    $essential_felsettingsfrontpage->add($setting);

    // Toggle frontpage page top blocks.
    $name = 'theme_essential_fel/fppagetopblocks';
    $title = get_string('fppagetopblocks', 'theme_essential_fel');
    $description = get_string('fppagetopblocksdesc', 'theme_essential_fel');
    $alwaysdisplay = get_string('alwaysdisplay', 'theme_essential_fel');
    $displaybeforelogin = get_string('displaybeforelogin', 'theme_essential_fel');
    $displayafterlogin = get_string('displayafterlogin', 'theme_essential_fel');
    $dontdisplay = get_string('dontdisplay', 'theme_essential_fel');
    $default = 3;
    $choices = array(1 => $alwaysdisplay, 2 => $displaybeforelogin, 3 => $displayafterlogin, 0 => $dontdisplay);
    $setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfrontpage->add($setting);

    // Marketing spot settings.
    $essential_felsettingsfrontpage->add(new admin_setting_heading('theme_essential_fel_marketing',
        get_string('marketingheading', 'theme_essential_fel'),
        format_text(get_string('marketingdesc', 'theme_essential_fel'), FORMAT_MARKDOWN)));

    // Toggle marketing spots.
    $name = 'theme_essential_fel/togglemarketing';
    $title = get_string('togglemarketing', 'theme_essential_fel');
    $description = get_string('togglemarketingdesc', 'theme_essential_fel');
    $alwaysdisplay = get_string('alwaysdisplay', 'theme_essential_fel');
    $displaybeforelogin = get_string('displaybeforelogin', 'theme_essential_fel');
    $displayafterlogin = get_string('displayafterlogin', 'theme_essential_fel');
    $dontdisplay = get_string('dontdisplay', 'theme_essential_fel');
    $default = 1;
    $choices = array(1 => $alwaysdisplay, 2 => $displaybeforelogin, 3 => $displayafterlogin, 0 => $dontdisplay);
    $setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfrontpage->add($setting);

    // Marketing spot height.
    $name = 'theme_essential_fel/marketingheight';
    $title = get_string('marketingheight', 'theme_essential_fel');
    $description = get_string('marketingheightdesc', 'theme_essential_fel');
    $default = 100;
    $choices = array();
    for ($mhit = 50; $mhit <= 500; $mhit = $mhit + 2) {
        $choices[$mhit] = $mhit;
    }
    $setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
    $essential_felsettingsfrontpage->add($setting);

    // Marketing spot image height.
    $name = 'theme_essential_fel/marketingimageheight';
    $title = get_string('marketingimageheight', 'theme_essential_fel');
    $description = get_string('marketingimageheightdesc', 'theme_essential_fel');
    $default = 100;
    $choices = array(50 => '50', 100 => '100', 150 => '150', 200 => '200', 250 => '250', 300 => '300');
    $setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
    $essential_felsettingsfrontpage->add($setting);

    foreach (range(1, 3) as $marketingspotnumber) {
        // This is the descriptor for Marketing Spot in $marketingspotnumber.
        $name = 'theme_essential_fel/marketing' . $marketingspotnumber . 'info';
        $heading = get_string('marketing' . $marketingspotnumber, 'theme_essential_fel');
        $information = get_string('marketinginfodesc', 'theme_essential_fel');
        $setting = new admin_setting_heading($name, $heading, $information);
        $essential_felsettingsfrontpage->add($setting);

        // Marketing spot.
        $name = 'theme_essential_fel/marketing' . $marketingspotnumber;
        $title = get_string('marketingtitle', 'theme_essential_fel');
        $description = get_string('marketingtitledesc', 'theme_essential_fel');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingsfrontpage->add($setting);

        $name = 'theme_essential_fel/marketing' . $marketingspotnumber . 'icon';
        $title = get_string('marketingicon', 'theme_essential_fel');
        $description = get_string('marketingicondesc', 'theme_essential_fel');
        $default = 'star';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingsfrontpage->add($setting);

        $name = 'theme_essential_fel/marketing' . $marketingspotnumber . 'image';
        $title = get_string('marketingimage', 'theme_essential_fel');
        $description = get_string('marketingimagedesc', 'theme_essential_fel');
        $setting = new admin_setting_configstoredfile($name, $title, $description,
                'marketing' . $marketingspotnumber . 'image');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingsfrontpage->add($setting);

        $name = 'theme_essential_fel/marketing' . $marketingspotnumber . 'content';
        $title = get_string('marketingcontent', 'theme_essential_fel');
        $description = get_string('marketingcontentdesc', 'theme_essential_fel');
        $default = '';
        $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingsfrontpage->add($setting);

        $name = 'theme_essential_fel/marketing' . $marketingspotnumber . 'buttontext';
        $title = get_string('marketingbuttontext', 'theme_essential_fel');
        $description = get_string('marketingbuttontextdesc', 'theme_essential_fel');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingsfrontpage->add($setting);

        $name = 'theme_essential_fel/marketing' . $marketingspotnumber . 'buttonurl';
        $title = get_string('marketingbuttonurl', 'theme_essential_fel');
        $description = get_string('marketingbuttonurldesc', 'theme_essential_fel');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingsfrontpage->add($setting);

        $name = 'theme_essential_fel/marketing' . $marketingspotnumber . 'target';
        $title = get_string('marketingurltarget', 'theme_essential_fel');
        $description = get_string('marketingurltargetdesc', 'theme_essential_fel');
        $target1 = get_string('marketingurltargetself', 'theme_essential_fel');
        $target2 = get_string('marketingurltargetnew', 'theme_essential_fel');
        $target3 = get_string('marketingurltargetparent', 'theme_essential_fel');
        $default = '_blank';
        $choices = array('_self' => $target1, '_blank' => $target2, '_parent' => $target3);
        $setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingsfrontpage->add($setting);
    }

    // User alerts.
    $essential_felsettingsfrontpage->add(new admin_setting_heading('theme_essential_fel_alerts',
        get_string('alertsheadingsub', 'theme_essential_fel'),
        format_text(get_string('alertsdesc', 'theme_essential_fel'), FORMAT_MARKDOWN)));

    $information = get_string('alertinfodesc', 'theme_essential_fel');

    // This is the descriptor for alert one.
    $name = 'theme_essential_fel/alert1info';
    $heading = get_string('alert1', 'theme_essential_fel');
    $setting = new admin_setting_heading($name, $heading, $information);
    $essential_felsettingsfrontpage->add($setting);

    // Enable alert.
    $name = 'theme_essential_fel/enable1alert';
    $title = get_string('enablealert', 'theme_essential_fel');
    $description = get_string('enablealertdesc', 'theme_essential_fel');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfrontpage->add($setting);

    // Alert type.
    $name = 'theme_essential_fel/alert1type';
    $title = get_string('alerttype', 'theme_essential_fel');
    $description = get_string('alerttypedesc', 'theme_essential_fel');
    $alertinfo = get_string('alert_info', 'theme_essential_fel');
    $alertwarning = get_string('alert_warning', 'theme_essential_fel');
    $alertgeneral = get_string('alert_general', 'theme_essential_fel');
    $default = 'info';
    $choices = array('info' => $alertinfo, 'error' => $alertwarning, 'success' => $alertgeneral);
    $setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfrontpage->add($setting);

    // Alert title.
    $name = 'theme_essential_fel/alert1title';
    $title = get_string('alerttitle', 'theme_essential_fel');
    $description = get_string('alerttitledesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfrontpage->add($setting);

    // Alert text.
    $name = 'theme_essential_fel/alert1text';
    $title = get_string('alerttext', 'theme_essential_fel');
    $description = get_string('alerttextdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfrontpage->add($setting);

    // This is the descriptor for alert two.
    $name = 'theme_essential_fel/alert2info';
    $heading = get_string('alert2', 'theme_essential_fel');
    $setting = new admin_setting_heading($name, $heading, $information);
    $essential_felsettingsfrontpage->add($setting);

    // Enable alert.
    $name = 'theme_essential_fel/enable2alert';
    $title = get_string('enablealert', 'theme_essential_fel');
    $description = get_string('enablealertdesc', 'theme_essential_fel');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfrontpage->add($setting);

    // Alert type.
    $name = 'theme_essential_fel/alert2type';
    $title = get_string('alerttype', 'theme_essential_fel');
    $description = get_string('alerttypedesc', 'theme_essential_fel');
    $alertinfo = get_string('alert_info', 'theme_essential_fel');
    $alertwarning = get_string('alert_warning', 'theme_essential_fel');
    $alertgeneral = get_string('alert_general', 'theme_essential_fel');
    $default = 'info';
    $choices = array('info' => $alertinfo, 'error' => $alertwarning, 'success' => $alertgeneral);
    $setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfrontpage->add($setting);

    // Alert title.
    $name = 'theme_essential_fel/alert2title';
    $title = get_string('alerttitle', 'theme_essential_fel');
    $description = get_string('alerttitledesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfrontpage->add($setting);

    // Alert text.
    $name = 'theme_essential_fel/alert2text';
    $title = get_string('alerttext', 'theme_essential_fel');
    $description = get_string('alerttextdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfrontpage->add($setting);

    // This is the descriptor for alert three.
    $name = 'theme_essential_fel/alert3info';
    $heading = get_string('alert3', 'theme_essential_fel');
    $setting = new admin_setting_heading($name, $heading, $information);
    $essential_felsettingsfrontpage->add($setting);

    // Enable alert.
    $name = 'theme_essential_fel/enable3alert';
    $title = get_string('enablealert', 'theme_essential_fel');
    $description = get_string('enablealertdesc', 'theme_essential_fel');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfrontpage->add($setting);

    // Alert type.
    $name = 'theme_essential_fel/alert3type';
    $title = get_string('alerttype', 'theme_essential_fel');
    $description = get_string('alerttypedesc', 'theme_essential_fel');
    $alertinfo = get_string('alert_info', 'theme_essential_fel');
    $alertwarning = get_string('alert_warning', 'theme_essential_fel');
    $alertgeneral = get_string('alert_general', 'theme_essential_fel');
    $default = 'info';
    $choices = array('info' => $alertinfo, 'error' => $alertwarning, 'success' => $alertgeneral);
    $setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfrontpage->add($setting);

    // Alert title.
    $name = 'theme_essential_fel/alert3title';
    $title = get_string('alerttitle', 'theme_essential_fel');
    $description = get_string('alerttitledesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfrontpage->add($setting);

    // Alert text.
    $name = 'theme_essential_fel/alert3text';
    $title = get_string('alerttext', 'theme_essential_fel');
    $description = get_string('alerttextdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsfrontpage->add($setting);

    $essential_felsettingsfrontpage->add(new admin_setting_heading('theme_essential_fel_frontpagereadme',
        get_string('readme_title', 'theme_essential_fel'), get_string('readme_desc', 'theme_essential_fel', array('url' => $readme))));
}
$ADMIN->add('theme_essential_fel', $essential_felsettingsfrontpage);

// Slideshow settings.
$essential_felsettingsslideshow = new admin_settingpage('theme_essential_fel_slideshow', get_string('slideshowheading', 'theme_essential_fel'));
if ($ADMIN->fulltree) {
    $essential_felsettingsslideshow->add(new admin_setting_heading('theme_essential_fel_slideshow',
        get_string('slideshowheadingsub', 'theme_essential_fel'),
        format_text(get_string('slideshowdesc', 'theme_essential_fel'), FORMAT_MARKDOWN)));

    // Toggle slideshow.
    $name = 'theme_essential_fel/toggleslideshow';
    $title = get_string('toggleslideshow', 'theme_essential_fel');
    $description = get_string('toggleslideshowdesc', 'theme_essential_fel');
    $alwaysdisplay = get_string('alwaysdisplay', 'theme_essential_fel');
    $displaybeforelogin = get_string('displaybeforelogin', 'theme_essential_fel');
    $displayafterlogin = get_string('displayafterlogin', 'theme_essential_fel');
    $dontdisplay = get_string('dontdisplay', 'theme_essential_fel');
    $default = 1;
    $choices = array(1 => $alwaysdisplay, 2 => $displaybeforelogin, 3 => $displayafterlogin, 0 => $dontdisplay);
    $setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsslideshow->add($setting);

    // Number of slides.
    $name = 'theme_essential_fel/numberofslides';
    $title = get_string('numberofslides', 'theme_essential_fel');
    $description = get_string('numberofslides_desc', 'theme_essential_fel');
    $default = 4;
    $choices = array(
        1 => '1',
        2 => '2',
        3 => '3',
        4 => '4',
        5 => '5',
        6 => '6',
        7 => '7',
        8 => '8',
        9 => '9',
        10 => '10',
        11 => '11',
        12 => '12',
        13 => '13',
        14 => '14',
        15 => '15',
        16 => '16'
    );
    $essential_felsettingsslideshow->add(new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices));

    // Hide slideshow on phones.
    $name = 'theme_essential_fel/hideontablet';
    $title = get_string('hideontablet', 'theme_essential_fel');
    $description = get_string('hideontabletdesc', 'theme_essential_fel');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsslideshow->add($setting);

    // Hide slideshow on tablet.
    $name = 'theme_essential_fel/hideonphone';
    $title = get_string('hideonphone', 'theme_essential_fel');
    $description = get_string('hideonphonedesc', 'theme_essential_fel');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsslideshow->add($setting);

    // Slide interval.
    $name = 'theme_essential_fel/slideinterval';
    $title = get_string('slideinterval', 'theme_essential_fel');
    $description = get_string('slideintervaldesc', 'theme_essential_fel');
    $default = '5000';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsslideshow->add($setting);

    // Slide caption text colour setting.
    $name = 'theme_essential_fel/slidecaptiontextcolor';
    $title = get_string('slidecaptiontextcolor', 'theme_essential_fel');
    $description = get_string('slidecaptiontextcolordesc', 'theme_essential_fel');
    $default = '#ffffff';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsslideshow->add($setting);

    // Slide caption background colour setting.
    $name = 'theme_essential_fel/slidecaptionbackgroundcolor';
    $title = get_string('slidecaptionbackgroundcolor', 'theme_essential_fel');
    $description = get_string('slidecaptionbackgroundcolordesc', 'theme_essential_fel');
    $default = '#30add1';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsslideshow->add($setting);

    // Show caption options.
    $name = 'theme_essential_fel/slidecaptionoptions';
    $title = get_string('slidecaptionoptions', 'theme_essential_fel');
    $description = get_string('slidecaptionoptionsdesc', 'theme_essential_fel');
    $default = 0;
    $choices = array(
        0 => get_string('slidecaptionbeside', 'theme_essential_fel'),
        1 => get_string('slidecaptionontop', 'theme_essential_fel'),
        2 => get_string('slidecaptionunderneath', 'theme_essential_fel')
    );
    $images = array(
        0 => 'beside',
        1 => 'on_top',
        2 => 'underneath'
    );
    $setting = new essential_fel_admin_setting_configradio($name, $title, $description, $default, $choices, false, $images);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsslideshow->add($setting);

    // Show caption centred.
    $name = 'theme_essential_fel/slidecaptioncentred';
    $title = get_string('slidecaptioncentred', 'theme_essential_fel');
    $description = get_string('slidecaptioncentreddesc', 'theme_essential_fel');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsslideshow->add($setting);

    // Slide button colour setting.
    $name = 'theme_essential_fel/slidebuttoncolor';
    $title = get_string('slidebuttoncolor', 'theme_essential_fel');
    $description = get_string('slidebuttoncolordesc', 'theme_essential_fel');
    $default = '#30add1';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsslideshow->add($setting);

    // Slide button hover colour setting.
    $name = 'theme_essential_fel/slidebuttonhovercolor';
    $title = get_string('slidebuttonhovercolor', 'theme_essential_fel');
    $description = get_string('slidebuttonhovercolordesc', 'theme_essential_fel');
    $default = '#217a94';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingsslideshow->add($setting);

    // This is the descriptor for the user theme slide colours.
    $name = 'theme_essential_fel/alternativethemeslidecolorsinfo';
    $heading = get_string('alternativethemeslidecolors', 'theme_essential_fel');
    $information = get_string('alternativethemeslidecolorsdesc', 'theme_essential_fel');
    $setting = new admin_setting_heading($name, $heading, $information);
    $essential_felsettingsslideshow->add($setting);

    foreach (range(1, 4) as $alternativethemenumber) {
        // Alternative theme slide caption text colour setting.
        $name = 'theme_essential_fel/alternativethemeslidecaptiontextcolor' . $alternativethemenumber;
        $title = get_string('alternativethemeslidecaptiontextcolor', 'theme_essential_fel', $alternativethemenumber);
        $description = get_string('alternativethemeslidecaptiontextcolordesc', 'theme_essential_fel',
                $alternativethemenumber);
        $default = '#ffffff';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingsslideshow->add($setting);

        // Alternative theme slide caption background colour setting.
        $name = 'theme_essential_fel/alternativethemeslidecaptionbackgroundcolor' . $alternativethemenumber;
        $title = get_string('alternativethemeslidecaptionbackgroundcolor', 'theme_essential_fel', $alternativethemenumber);
        $description = get_string('alternativethemeslidecaptionbackgroundcolordesc', 'theme_essential_fel',
                $alternativethemenumber);
        $default = $defaultalternativethemecolors[$alternativethemenumber - 1];
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingsslideshow->add($setting);

        // Alternative theme slide button colour setting.
        $name = 'theme_essential_fel/alternativethemeslidebuttoncolor' . $alternativethemenumber;
        $title = get_string('alternativethemeslidebuttoncolor', 'theme_essential_fel', $alternativethemenumber);
        $description = get_string('alternativethemeslidebuttoncolordesc', 'theme_essential_fel', $alternativethemenumber);
        $default = $defaultalternativethemecolors[$alternativethemenumber - 1];
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingsslideshow->add($setting);

        // Alternative theme slide button hover colour setting.
        $name = 'theme_essential_fel/alternativethemeslidebuttonhovercolor' . $alternativethemenumber;
        $title = get_string('alternativethemeslidebuttonhovercolor', 'theme_essential_fel', $alternativethemenumber);
        $description = get_string('alternativethemeslidebuttonhovercolordesc', 'theme_essential_fel',
                $alternativethemenumber);
        $default = $defaultalternativethemehovercolors[$alternativethemenumber - 1];
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingsslideshow->add($setting);
    }

    $numberofslides = get_config('theme_essential_fel', 'numberofslides');
    for ($i = 1; $i <= $numberofslides; $i++) {
        // This is the descriptor for the slide.
        $name = 'theme_essential_fel/slide'.$i.'info';
        $heading = get_string('slideno', 'theme_essential_fel', array('slide' => $i));
        $information = get_string('slidenodesc', 'theme_essential_fel', array('slide' => $i));
        $setting = new admin_setting_heading($name, $heading, $information);
        $essential_felsettingsslideshow->add($setting);

        // Title.
        $name = 'theme_essential_fel/slide'.$i;
        $title = get_string('slidetitle', 'theme_essential_fel');
        $description = get_string('slidetitledesc', 'theme_essential_fel');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingsslideshow->add($setting);

        // Image.
        $name = 'theme_essential_fel/slide'.$i.'image';
        $title = get_string('slideimage', 'theme_essential_fel');
        $description = get_string('slideimagedesc', 'theme_essential_fel');
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'slide'.$i.'image');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingsslideshow->add($setting);

        // Caption text.
        $name = 'theme_essential_fel/slide'.$i.'caption';
        $title = get_string('slidecaption', 'theme_essential_fel');
        $description = get_string('slidecaptiondesc', 'theme_essential_fel');
        $default = '';
        $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingsslideshow->add($setting);

        // URL.
        $name = 'theme_essential_fel/slide'.$i.'url';
        $title = get_string('slideurl', 'theme_essential_fel');
        $description = get_string('slideurldesc', 'theme_essential_fel');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingsslideshow->add($setting);

        // URL target.
        $name = 'theme_essential_fel/slide'.$i.'target';
        $title = get_string('slideurltarget', 'theme_essential_fel');
        $description = get_string('slideurltargetdesc', 'theme_essential_fel');
        $target1 = get_string('slideurltargetself', 'theme_essential_fel');
        $target2 = get_string('slideurltargetnew', 'theme_essential_fel');
        $target3 = get_string('slideurltargetparent', 'theme_essential_fel');
        $default = '_blank';
        $choices = array('_self' => $target1, '_blank' => $target2, '_parent' => $target3);
        $setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingsslideshow->add($setting);
    }

    $essential_felsettingsslideshow->add(new admin_setting_heading('theme_essential_fel_slideshowreadme',
        get_string('readme_title', 'theme_essential_fel'), get_string('readme_desc', 'theme_essential_fel', array('url' => $readme))));
}
$ADMIN->add('theme_essential_fel', $essential_felsettingsslideshow);

// Category course title image settings.
$enablecategoryctics = get_config('theme_essential_fel', 'enablecategoryctics');
if ($enablecategoryctics) {
    $essential_felsettingscategoryctititle = get_string('categoryctiheadingcs', 'theme_essential_fel');
} else {
    $essential_felsettingscategoryctititle = get_string('categoryctiheading', 'theme_essential_fel');
}
$essential_felsettingscategorycti = new admin_settingpage('theme_essential_fel_categorycti', $essential_felsettingscategoryctititle);
if ($ADMIN->fulltree) {
    global $CFG;
    if (file_exists("{$CFG->dirroot}/theme/essential_fel/admin_setting_configinteger.php")) {
        require_once($CFG->dirroot . '/theme/essential_fel/admin_setting_configinteger.php');
    } else if (!empty($CFG->themedir) && file_exists("{$CFG->themedir}/essential_fel/admin_setting_configinteger.php")) {
        require_once($CFG->themedir . '/essential_fel/admin_setting_configinteger.php');
    }

    $essential_felsettingscategorycti->add(new admin_setting_heading('theme_essential_fel_categorycti',
        get_string('categoryctiheadingsub', 'theme_essential_fel'),
        format_text(get_string('categoryctidesc', 'theme_essential_fel'), FORMAT_MARKDOWN)));

    // Category icons.
    $name = 'theme_essential_fel/enablecategorycti';
    $title = get_string('enablecategorycti', 'theme_essential_fel');
    $description = get_string('enablecategoryctidesc', 'theme_essential_fel');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingscategorycti->add($setting);

    // Category icons category setting pages.
    $name = 'theme_essential_fel/enablecategoryctics';
    $title = get_string('enablecategoryctics', 'theme_essential_fel');
    $description = get_string('enablecategorycticsdesc', 'theme_essential_fel');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingscategorycti->add($setting);

    // We only want to output category course title image options if the parent setting is enabled.
    if (get_config('theme_essential_fel', 'enablecategorycti')) {
        $essential_felsettingscategorycti->add(new admin_setting_heading('theme_essential_fel_categorycticourses',
            get_string('ctioverride', 'theme_essential_fel'), get_string('ctioverridedesc', 'theme_essential_fel')));

        // Overridden image height.
        $name = 'theme_essential_fel/ctioverrideheight';
        $title = get_string('ctioverrideheight', 'theme_essential_fel');
        $default = 200;
        $lower = 40;
        $upper = 400;
        $description = get_string('ctioverrideheightdesc', 'theme_essential_fel',
            array('lower' => $lower, 'upper' => $upper));
        $setting = new essential_fel_admin_setting_configinteger($name, $title, $description, $default, $lower, $upper);
        $essential_felsettingscategorycti->add($setting);

        // Overridden course title text colour setting.
        $name = 'theme_essential_fel/ctioverridetextcolour';
        $title = get_string('ctioverridetextcolour', 'theme_essential_fel');
        $description = get_string('ctioverridetextcolourdesc', 'theme_essential_fel');
        $default = '#ffffff';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $essential_felsettingscategorycti->add($setting);

        // Overridden course title text background colour setting.
        $name = 'theme_essential_fel/ctioverridetextbackgroundcolour';
        $title = get_string('ctioverridetextbackgroundcolour', 'theme_essential_fel');
        $description = get_string('ctioverridetextbackgroundcolourdesc', 'theme_essential_fel');
        $default = '#c51230';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $essential_felsettingscategorycti->add($setting);

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
        $name = 'theme_essential_fel/ctioverridetextbackgroundopacity';
        $title = get_string('ctioverridetextbackgroundopacity', 'theme_essential_fel');
        $description = get_string('ctioverridetextbackgroundopacitydesc', 'theme_essential_fel');
        $default = '0.8';
        $setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $opactitychoices);
        $essential_felsettingscategorycti->add($setting);
    }
}
$ADMIN->add('theme_essential_fel', $essential_felsettingscategorycti);

// We only want to output category course title image options if the parent setting is enabled.
if (get_config('theme_essential_fel', 'enablecategorycti')) {
    // Get all category IDs and their names.
    $coursecats = \theme_essential_fel\toolbox::get_categories_list();

    if (!$enablecategoryctics) {
        $essential_felsettingscategoryctimenu = $essential_felsettingscategorycti;
    }

    // Go through all categories and create the necessary settings.
    foreach ($coursecats as $key => $value) {
        if (($value->depth == 1) && ($enablecategoryctics)) {
            $essential_felsettingscategoryctimenu = new admin_settingpage('theme_essential_fel_categorycti_'.$value->id,
                get_string('categoryctiheadingcategory', 'theme_essential_fel', array('category' => $value->namechunks[0])));
        }

        if ($ADMIN->fulltree) {
            $namepath = join(' / ', $value->namechunks);
            // This is the descriptor for category course title image.
            $name = 'theme_essential_fel/categoryctiinfo'.$key;
            $heading = get_string('categoryctiinfo', 'theme_essential_fel', array('category' => $namepath));
            $information = get_string('categoryctiinfodesc', 'theme_essential_fel', array('category' => $namepath));
            $setting = new admin_setting_heading($name, $heading, $information);
            $essential_felsettingscategoryctimenu->add($setting);

            // Image.
            $name = 'theme_essential_fel/categoryct'.$key.'image';
            $title = get_string('categoryctimage', 'theme_essential_fel', array('category' => $namepath));
            $description = get_string('categoryctimagedesc', 'theme_essential_fel', array('category' => $namepath));
            $setting = new admin_setting_configstoredfile($name, $title, $description, 'categoryct'.$key.'image');
            $setting->set_updatedcallback('theme_reset_all_caches');
            $essential_felsettingscategoryctimenu->add($setting);

            // Image URL.
            $name = 'theme_essential_fel/categoryctimageurl'.$key;
            $title = get_string('categoryctimageurl', 'theme_essential_fel', array('category' => $namepath));
            $description = get_string('categoryctimageurldesc', 'theme_essential_fel', array('category' => $namepath));
            $default = '';
            $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
            $setting->set_updatedcallback('theme_reset_all_caches');
            $essential_felsettingscategoryctimenu->add($setting);

            // Image height.
            $name = 'theme_essential_fel/categorycti'.$key.'height';
            $title = get_string('categoryctiheight', 'theme_essential_fel', array('category' => $namepath));
            $default = 200;
            $lower = 40;
            $upper = 400;
            $description = get_string('categoryctiheightdesc', 'theme_essential_fel',
                array('category' => $namepath, 'lower' => $lower, 'upper' => $upper));
            $setting = new essential_fel_admin_setting_configinteger($name, $title, $description, $default, $lower, $upper);
            $setting->set_updatedcallback('theme_reset_all_caches');
            $essential_felsettingscategoryctimenu->add($setting);

            // Category course title text colour setting.
            $name = 'theme_essential_fel/categorycti'.$key.'textcolour';
            $title = get_string('categoryctitextcolour', 'theme_essential_fel', array('category' => $namepath));
            $description = get_string('categoryctitextcolourdesc', 'theme_essential_fel', array('category' => $namepath));
            $default = '#000000';
            $previewconfig = null;
            $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
            $setting->set_updatedcallback('theme_reset_all_caches');
            $essential_felsettingscategoryctimenu->add($setting);

            // Category course title text background colour setting.
            $name = 'theme_essential_fel/categorycti'.$key.'textbackgroundcolour';
            $title = get_string('categoryctitextbackgroundcolour', 'theme_essential_fel', array('category' => $namepath));
            $description = get_string('categoryctitextbackgroundcolourdesc', 'theme_essential_fel', array('category' => $namepath));
            $default = '#ffffff';
            $previewconfig = null;
            $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
            $setting->set_updatedcallback('theme_reset_all_caches');
            $essential_felsettingscategoryctimenu->add($setting);

            // Category course title text background opacity setting.
            $name = 'theme_essential_fel/categorycti'.$key.'textbackgroundopactity';
            $title = get_string('categoryctitextbackgroundopacity', 'theme_essential_fel', array('category' => $namepath));
            $description = get_string('categoryctitextbackgroundopacitydesc', 'theme_essential_fel', array('category' => $namepath));
            $default = '0.8';
            $setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $opactitychoices);
            $setting->set_updatedcallback('theme_reset_all_caches');
            $essential_felsettingscategoryctimenu->add($setting);
        }
        if (($value->depth == 1) && ($enablecategoryctics)) {
            $ADMIN->add('theme_essential_fel', $essential_felsettingscategoryctimenu);
        }
    }
}

// Category icon settings.
$essential_felsettingscategoryicon = new admin_settingpage('theme_essential_fel_categoryicon',
    get_string('categoryiconheading', 'theme_essential_fel'));
if ($ADMIN->fulltree) {
    $essential_felsettingscategoryicon->add(new admin_setting_heading('theme_essential_fel_categoryicon',
        get_string('categoryiconheadingsub', 'theme_essential_fel'),
        format_text(get_string('categoryicondesc', 'theme_essential_fel'), FORMAT_MARKDOWN)));

    // Category icons.
    $name = 'theme_essential_fel/enablecategoryicon';
    $title = get_string('enablecategoryicon', 'theme_essential_fel');
    $description = get_string('enablecategoryicondesc', 'theme_essential_fel');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_felsettingscategoryicon->add($setting);

    // We only want to output category icon options if the parent setting is enabled.
    if (get_config('theme_essential_fel', 'enablecategoryicon')) {

        // Default icon selector.
        $name = 'theme_essential_fel/defaultcategoryicon';
        $title = get_string('defaultcategoryicon', 'theme_essential_fel');
        $description = get_string('defaultcategoryicondesc', 'theme_essential_fel');
        $default = 'folder-open';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingscategoryicon->add($setting);

        // Category icons.
        $name = 'theme_essential_fel/enablecustomcategoryicon';
        $title = get_string('enablecustomcategoryicon', 'theme_essential_fel');
        $description = get_string('enablecustomcategoryicondesc', 'theme_essential_fel');
        $setting = new admin_setting_configcheckbox($name, $title, $description, 0);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essential_felsettingscategoryicon->add($setting);

        if (get_config('theme_essential_fel', 'enablecustomcategoryicon')) {

            // This is the descriptor for custom category icons.
            $name = 'theme_essential_fel/categoryiconinfo';
            $heading = get_string('categoryiconinfo', 'theme_essential_fel');
            $information = get_string('categoryiconinfodesc', 'theme_essential_fel');
            $setting = new admin_setting_heading($name, $heading, $information);
            $essential_felsettingscategoryicon->add($setting);

            // Get the default category icon.
            $defaultcategoryicon = get_config('theme_essential_fel', 'defaultcategoryicon');
            if (empty($defaultcategoryicon)) {
                $defaultcategoryicon = 'folder-open';
            }

            // Get all category IDs and their names.
            $coursecats = \theme_essential_fel\toolbox::get_categories_list();

            // Go through all categories and create the necessary settings.
            foreach ($coursecats as $key => $value) {
                $namepath = join(' / ', $value->namechunks);
                // Category icons for each category.
                $name = 'theme_essential_fel/categoryicon';
                $title = $namepath;
                $description = get_string('categoryiconcategory', 'theme_essential_fel', array('category' => $namepath));
                $default = $defaultcategoryicon;
                $setting = new admin_setting_configtext($name . $key, $title, $description, $default);
                $setting->set_updatedcallback('theme_reset_all_caches');
                $essential_felsettingscategoryicon->add($setting);
            }
            unset($coursecats);
        }
    }

    $essential_felsettingscategoryicon->add(new admin_setting_heading('theme_essential_fel_categoryiconreadme',
        get_string('readme_title', 'theme_essential_fel'), get_string('readme_desc', 'theme_essential_fel', array('url' => $readme))));
}
$ADMIN->add('theme_essential_fel', $essential_felsettingscategoryicon);

// Analytics settings.
$essential_felsettingsanalytics = new admin_settingpage('theme_essential_fel_analytics', get_string('analytics', 'theme_essential_fel'));
if ($ADMIN->fulltree) {
    $essential_felsettingsanalytics->add(new admin_setting_heading('theme_essential_fel_analytics',
        get_string('analyticsheadingsub', 'theme_essential_fel'),
        format_text(get_string('analyticsdesc', 'theme_essential_fel'), FORMAT_MARKDOWN)));

    $name = 'theme_essential_fel/analyticsenabled';
    $title = get_string('analyticsenabled', 'theme_essential_fel');
    $description = get_string('analyticsenableddesc', 'theme_essential_fel');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $essential_felsettingsanalytics->add($setting);

    $name = 'theme_essential_fel/analytics';
    $title = get_string('analytics', 'theme_essential_fel');
    $description = get_string('analyticsdesc', 'theme_essential_fel');
    $guniversal = get_string('analyticsguniversal', 'theme_essential_fel');
    $piwik = get_string('analyticspiwik', 'theme_essential_fel');
    $default = 'piwik';
    $choices = array(
        'piwik' => $piwik,
        'guniversal' => $guniversal
    );
    $setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
    $essential_felsettingsanalytics->add($setting);

    if (get_config('theme_essential_fel', 'analytics') === 'piwik') {
        $name = 'theme_essential_fel/analyticssiteid';
        $title = get_string('analyticssiteid', 'theme_essential_fel');
        $description = get_string('analyticssiteiddesc', 'theme_essential_fel');
        $default = '1';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $essential_felsettingsanalytics->add($setting);

        $name = 'theme_essential_fel/analyticsimagetrack';
        $title = get_string('analyticsimagetrack', 'theme_essential_fel');
        $description = get_string('analyticsimagetrackdesc', 'theme_essential_fel');
        $default = true;
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
        $essential_felsettingsanalytics->add($setting);

        $name = 'theme_essential_fel/analyticssiteurl';
        $title = get_string('analyticssiteurl', 'theme_essential_fel');
        $description = get_string('analyticssiteurldesc', 'theme_essential_fel');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $essential_felsettingsanalytics->add($setting);

        $name = 'theme_essential_fel/analyticsuseuserid';
        $title = get_string('analyticsuseuserid', 'theme_essential_fel');
        $description = get_string('analyticsuseuseriddesc', 'theme_essential_fel');
        $default = false;
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
        $essential_felsettingsanalytics->add($setting);
    } else if (get_config('theme_essential_fel', 'analytics') === 'guniversal') {
        $name = 'theme_essential_fel/analyticstrackingid';
        $title = get_string('analyticstrackingid', 'theme_essential_fel');
        $description = get_string('analyticstrackingiddesc', 'theme_essential_fel');
        $default = 'UA-XXXXXXXX-X';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $essential_felsettingsanalytics->add($setting);
    }

    $name = 'theme_essential_fel/analyticstrackadmin';
    $title = get_string('analyticstrackadmin', 'theme_essential_fel');
    $description = get_string('analyticstrackadmindesc', 'theme_essential_fel');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $essential_felsettingsanalytics->add($setting);

    $name = 'theme_essential_fel/analyticscleanurl';
    $title = get_string('analyticscleanurl', 'theme_essential_fel');
    $description = get_string('analyticscleanurldesc', 'theme_essential_fel');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $essential_felsettingsanalytics->add($setting);

    $essential_felsettingsanalytics->add(new admin_setting_heading('theme_essential_fel_analyticsreadme',
        get_string('readme_title', 'theme_essential_fel'), get_string('readme_desc', 'theme_essential_fel', array('url' => $readme))));
}
$ADMIN->add('theme_essential_fel', $essential_felsettingsanalytics);

// Extra settings.
$essential_felsettingsextras = new admin_settingpage('theme_essential_fel_extras', get_string('extras', 'theme_essential_fel'));
if ($ADMIN->fulltree) {

    // Drives the addition of customized thumbs for activities.
    // @see <themedir>/classes/core_course_renderer.php § func section_cm_name(), section_cm_thumb(), etc.
    $key = 'theme_essential_fel/modfixedthumbwidth';
    $label = get_string('modfixedthumbwidth', 'theme_essential_fel');
    $desc = get_string('modfixedthumbwidthdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($key, $label, $desc, $default, PARAM_TEXT);
    $essential_felsettingsextras->add($setting);

    // Flex section style list.
    $key = 'theme_essential_fel/flexsectionsstyles';
    $label = get_string('flexsectionsstyles', 'theme_essential_fel');
    $desc = get_string('flexsectionsstylesdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtextarea($key, $label, $desc, $default, PARAM_TEXT, 64, 10);
    $essential_felsettingsextras->add($setting);
}
$ADMIN->add('theme_essential_fel', $essential_felsettingsextras);

// Style guide.
$essential_felsettingsstyleguide = new admin_settingpage('theme_essential_fel_styleguide', get_string('styleguide', 'theme_essential_fel'));
if ($ADMIN->fulltree) {
    if (file_exists("{$CFG->dirroot}/theme/essential_fel/admin_setting_styleguide.php")) {
        require_once($CFG->dirroot . '/theme/essential_fel/admin_setting_styleguide.php');
    } else if (!empty($CFG->themedir) && file_exists("{$CFG->themedir}/essential_fel/admin_setting_styleguide.php")) {
        require_once($CFG->themedir . '/essential_fel/admin_setting_styleguide.php');
    }
    $essential_felsettingsstyleguide->add(new essential_fel_admin_setting_styleguide('theme_essential_fel_styleguide',
        get_string('styleguidesub', 'theme_essential_fel'),
        get_string('styleguidedesc', 'theme_essential_fel',
            array(
                'origcodelicenseurl' => html_writer::link('http://www.apache.org/licenses/LICENSE-2.0', 'Apache License v2.0',
                    array('target' => '_blank')),
                'holderlicenseurl' => html_writer::link('https://github.com/imsky/holder#license', 'MIT',
                    array('target' => '_blank')),
                'thiscodelicenseurl' => html_writer::link('http://www.gnu.org/copyleft/gpl.html', 'GPLv3',
                    array('target' => '_blank')),
                'compatible' => html_writer::link('http://www.gnu.org/licenses/license-list.en.html#apache2', 'compatible',
                    array('target' => '_blank')),
                'contentlicenseurl' => html_writer::link('http://creativecommons.org/licenses/by/3.0/', 'CC BY 3.0',
                    array('target' => '_blank')),
                'globalsettings' => html_writer::link('http://getbootstrap.com/2.3.2/scaffolding.html#global', 'Global settings',
                    array('target' => '_blank'))
            )
        )
    ));
}
$ADMIN->add('theme_essential_fel', $essential_felsettingsstyleguide);
