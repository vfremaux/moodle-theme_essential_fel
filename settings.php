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
 * This is built using the bootstrapbase template to allow for new theme's using
 * Moodle's new Bootstrap theme engine
 *
 * @package     theme_essential_fel
 * @copyright   2013 Julian Ridden
 * @copyright   2014 Gareth J Barnard, David Bezemer
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$settings = null;

defined('MOODLE_INTERNAL') || die;
// if (is_siteadmin()) {

    $ADMIN->add('themes', new admin_category('theme_essential_fel', 'Essential FEL'));

    /* Generic Settings */
    $temp = new admin_settingpage('theme_essential_fel_generic', get_string('genericsettings', 'theme_essential_fel'), 'theme/essential_fel:configure');

    $donate = new moodle_url('https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=themmai%40gmail%2ecom&lc=GB&item_name=Essential%20Theme%20Fund&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donate_LG%2egif%3aNonHosted');
    $donate = html_writer::link($donate, get_string('donate_click', 'theme_essential_fel'), array('target' => '_blank'));

    $temp->add(new admin_setting_heading('theme_essential_fel_generaldonate', get_string('donate_title', 'theme_essential_fel'),
        get_string('donate_desc', 'theme_essential_fel', array('url' => $donate))));

    $temp->add(new admin_setting_heading('theme_essential_fel_generalheading', get_string('generalheadingsub', 'theme_essential_fel'),
        format_text(get_string('generalheadingdesc', 'theme_essential_fel'), FORMAT_MARKDOWN)));

    // This is the descriptor for the font settings
    $name = 'theme_essential_fel/fontheading';
    $heading = get_string('fontheading', 'theme_essential_fel');
    $information = get_string('fontheadingdesc', 'theme_essential_fel');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Font Selector.
    $name = 'theme_essential_fel/fontselect';
    $title = get_string('fontselect', 'theme_essential_fel');
    $description = get_string('fontselectdesc', 'theme_essential_fel');
    $default = 1;
    $choices = array(
        1 => get_string('fonttypestandard', 'theme_essential_fel'),
        2 => get_string('fonttypegoogle', 'theme_essential_fel'),
        3 => get_string('fonttypecustom', 'theme_essential_fel'),
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Heading font name
    $name = 'theme_essential_fel/fontnameheading';
    $title = get_string('fontnameheading', 'theme_essential_fel');
    $description = get_string('fontnameheadingdesc', 'theme_essential_fel');
    $default = 'Verdana';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Text font name
    $name = 'theme_essential_fel/fontnamebody';
    $title = get_string('fontnamebody', 'theme_essential_fel');
    $description = get_string('fontnamebodydesc', 'theme_essential_fel');
    $default = 'Verdana';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    if(get_config('theme_essential_fel', 'fontselect') === "2") {
        // Google Font Character Sets
        $name = 'theme_essential_fel/fontcharacterset';
        $title = get_string('fontcharacterset', 'theme_essential_fel');
        $description = get_string('fontcharactersetdesc', 'theme_essential_fel');
        $default = 'latin-ext';
        $setting = new admin_setting_configmulticheckbox($name, $title, $description, $default, array(
            'latin-ext' => get_string('fontcharactersetlatinext', 'theme_essential_fel'),
            'cyrillic' => get_string('fontcharactersetcyrillic', 'theme_essential_fel'),
            'cyrillic-ext' => get_string('fontcharactersetcyrillicext', 'theme_essential_fel'),
            'greek' => get_string('fontcharactersetgreek', 'theme_essential_fel'),
            'greek-ext' => get_string('fontcharactersetgreekext', 'theme_essential_fel'),
            'vietnamese' => get_string('fontcharactersetvietnamese', 'theme_essential_fel'),
        ));
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

    } else if(get_config('theme_essential_fel', 'fontselect') === "3") {

        // This is the descriptor for the font files
        $name = 'theme_essential_fel/fontfiles';
        $heading = get_string('fontfiles', 'theme_essential_fel');
        $information = get_string('fontfilesdesc', 'theme_essential_fel');
        $setting = new admin_setting_heading($name, $heading, $information);
        $temp->add($setting);

        // TTF Font
        $name = 'theme_essential_fel/fontfilettfheading';
        $title = get_string('fontfilettfheading', 'theme_essential_fel');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilettfheading');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // TTF Font
        $name = 'theme_essential_fel/fontfilettfbody';
        $title = get_string('fontfilettfbody', 'theme_essential_fel');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilettfbody');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);
    }

    // Include Awesome Font from Bootstrapcdn
    $name = 'theme_essential_fel/bootstrapcdn';
    $title = get_string('bootstrapcdn', 'theme_essential_fel');
    $description = get_string('bootstrapcdndesc', 'theme_essential_fel');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 0);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Background Image.
    $name = 'theme_essential_fel/pagebackground';
    $title = get_string('pagebackground', 'theme_essential_fel');
    $description = get_string('pagebackgrounddesc', 'theme_essential_fel');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'pagebackground');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Background Image.
    $name = 'theme_essential_fel/pagebackgroundstyle';
    $title = get_string('pagebackgroundstyle', 'theme_essential_fel');
    $description = get_string('pagebackgroundstyledesc', 'theme_essential_fel');
    $default = 'fixed';
    $setting = new admin_setting_configselect($name, $title, $description, $default, array(
        'fixed' => get_string('backgroundstylefixed', 'theme_essential_fel'),
        'tiled' => get_string('backgroundstyletiled', 'theme_essential_fel'),
        'stretch' => get_string('backgroundstylestretch', 'theme_essential_fel'),
    ));
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Fixed or Variable Width.
    $name = 'theme_essential_fel/pagewidth';
    $title = get_string('pagewidth', 'theme_essential_fel');
    $description = get_string('pagewidthdesc', 'theme_essential_fel');
    $default = 1200;
    $choices = array(960 => get_string('fixedwidthnarrow', 'theme_essential_fel'),
        1200 => get_string('fixedwidthnormal', 'theme_essential_fel'),
        1400 => get_string('fixedwidthwide', 'theme_essential_fel'),
        100 => get_string('variablewidth', 'theme_essential_fel'));
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Custom or standard layout.
    $name = 'theme_essential_fel/layout';
    $title = get_string('layout', 'theme_essential_fel');
    $description = get_string('layoutdesc', 'theme_essential_fel');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // New or old navbar.
    $name = 'theme_essential_fel/oldnavbar';
    $title = get_string('oldnavbar', 'theme_essential_fel');
    $description = get_string('oldnavbardesc', 'theme_essential_fel');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Choose breadcrumbstyle
    $name = 'theme_essential_fel/breadcrumbstyle';
    $title = get_string('breadcrumbstyle', 'theme_essential_fel');
    $description = get_string('breadcrumbstyledesc', 'theme_essential_fel');
    $default = 1;
    $choices = array(1 => get_string('breadcrumbstyled', 'theme_essential_fel'),
        2 => get_string('breadcrumbsimple', 'theme_essential_fel'),
        3 => get_string('breadcrumbthin', 'theme_essential_fel'),
        0 => get_string('nobreadcrumb', 'theme_essential_fel')
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);


    // Custom CSS file.
    $name = 'theme_essential_fel/customcss';
    $title = get_string('customcss', 'theme_essential_fel');
    $description = get_string('customcssdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $readme = new moodle_url('/theme/essential_fel/README.txt');
    $readme = html_writer::link($readme, get_string('readme_click', 'theme_essential_fel'), array('target' => '_blank'));

    $temp->add(new admin_setting_heading('theme_essential_fel_generalreadme', get_string('readme_title', 'theme_essential_fel'),
        get_string('readme_desc', 'theme_essential_fel', array('url' => $readme))));

    $ADMIN->add('theme_essential_fel', $temp);


    /* Colour Settings */
    $temp = new admin_settingpage('theme_essential_fel_color', get_string('colorheading', 'theme_essential_fel'), 'theme/essential_fel:configure');
    $temp->add(new admin_setting_heading('theme_essential_fel_color', get_string('colorheadingsub', 'theme_essential_fel'),
        format_text(get_string('colordesc', 'theme_essential_fel'), FORMAT_MARKDOWN)));

    // Main theme colour setting.
    $name = 'theme_essential_fel/themecolor';
    $title = get_string('themecolor', 'theme_essential_fel');
    $description = get_string('themecolordesc', 'theme_essential_fel');
    $default = '#30add1';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Main theme colour setting.
    $name = 'theme_essential_fel/backgroundcolor';
    $title = get_string('backgroundcolor', 'theme_essential_fel');
    $description = get_string('backgroundcolordesc', 'theme_essential_fel');
    $default = '#ffffff';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Main theme colour setting.
    $name = 'theme_essential_fel/themecolorlight';
    $title = get_string('themecolorlight', 'theme_essential_fel');
    $description = get_string('themecolorlightdesc', 'theme_essential_fel');
    $default = '#30add1';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Main theme colour setting.
    $name = 'theme_essential_fel/themecolordark';
    $title = get_string('themecolordark', 'theme_essential_fel');
    $description = get_string('themecolordarkdesc', 'theme_essential_fel');
    $default = '#0038a8';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Main theme text colour setting.
    $name = 'theme_essential_fel/themetextcolor';
    $title = get_string('themetextcolor', 'theme_essential_fel');
    $description = get_string('themetextcolordesc', 'theme_essential_fel');
    $default = '#217a94';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Main theme text colour setting.
    $name = 'theme_essential_fel/themeinfobgcolor';
    $title = get_string('themeinfobgcolor', 'theme_essential_fel');
    $description = get_string('themeinfobgcolordesc', 'theme_essential_fel');
    $default = '#217a94';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Tree Leaf colour setting.
    $name = 'theme_essential_fel/treeleafcolor';
    $title = get_string('treeleafcolor', 'theme_essential_fel');
    $description = get_string('treeleafcolordesc', 'theme_essential_fel');
    $default = '#909090';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Main theme link colour setting.
    $name = 'theme_essential_fel/themeurlcolor';
    $title = get_string('themeurlcolor', 'theme_essential_fel');
    $description = get_string('themeurlcolordesc', 'theme_essential_fel');
    $default = '#943b21';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Main theme Hover colour setting.
    $name = 'theme_essential_fel/themehovercolor';
    $title = get_string('themehovercolor', 'theme_essential_fel');
    $description = get_string('themehovercolordesc', 'theme_essential_fel');
    $default = '#6a2a18';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Icon colour setting.
    $name = 'theme_essential_fel/themeiconcolor';
    $title = get_string('themeiconcolor', 'theme_essential_fel');
    $description = get_string('themeiconcolordesc', 'theme_essential_fel');
    $default = '#30add1';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Navigation colour setting.
    $name = 'theme_essential_fel/themenavcolor';
    $title = get_string('themenavcolor', 'theme_essential_fel');
    $description = get_string('themenavcolordesc', 'theme_essential_fel');
    $default = '#ffffff';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // This is the descriptor for the Footer
    $name = 'theme_essential_fel/footercolorinfo';
    $heading = get_string('footercolors', 'theme_essential_fel');
    $information = get_string('footercolorsdesc', 'theme_essential_fel');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Footer background colour setting.
    $name = 'theme_essential_fel/footercolor';
    $title = get_string('footercolor', 'theme_essential_fel');
    $description = get_string('footercolordesc', 'theme_essential_fel');
    $default = '#555555';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Footer text colour setting.
    $name = 'theme_essential_fel/footertextcolor';
    $title = get_string('footertextcolor', 'theme_essential_fel');
    $description = get_string('footertextcolordesc', 'theme_essential_fel');
    $default = '#bbbbbb';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Footer Block Heading colour setting.
    $name = 'theme_essential_fel/footerheadingcolor';
    $title = get_string('footerheadingcolor', 'theme_essential_fel');
    $description = get_string('footerheadingcolordesc', 'theme_essential_fel');
    $default = '#cccccc';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Footer Seperator colour setting.
    $name = 'theme_essential_fel/footersepcolor';
    $title = get_string('footersepcolor', 'theme_essential_fel');
    $description = get_string('footersepcolordesc', 'theme_essential_fel');
    $default = '#313131';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Footer URL colour setting.
    $name = 'theme_essential_fel/footerurlcolor';
    $title = get_string('footerurlcolor', 'theme_essential_fel');
    $description = get_string('footerurlcolordesc', 'theme_essential_fel');
    $default = '#217a94';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Footer URL hover colour setting.
    $name = 'theme_essential_fel/footerhovercolor';
    $title = get_string('footerhovercolor', 'theme_essential_fel');
    $description = get_string('footerhovercolordesc', 'theme_essential_fel');
    $default = '#30add1';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $ADMIN->add('theme_essential_fel', $temp);

    /* Header Settings */
    $temp = new admin_settingpage('theme_essential_fel_header', get_string('headerheading', 'theme_essential_fel'), 'theme/essential_fel:configure');

    // Default Site icon setting.
    $name = 'theme_essential_fel/siteicon';
    $title = get_string('siteicon', 'theme_essential_fel');
    $description = get_string('siteicondesc', 'theme_essential_fel');
    $default = 'laptop';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $temp->add($setting);

    // Logo file setting.
    $name = 'theme_essential_fel/logo';
    $title = get_string('logo', 'theme_essential_fel');
    $description = get_string('logodesc', 'theme_essential_fel');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

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
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Navbar title setting.
    $name = 'theme_essential_fel/navbartitle';
    $title = get_string('navbartitle', 'theme_essential_fel');
    $description = get_string('navbartitledesc', 'theme_essential_fel');
    $default = '2';
    $choices = array(
        0 => get_string('notitle', 'theme_essential_fel'),
        1 => get_string('fullname', 'theme_essential_fel'),
        2 => get_string('shortname', 'theme_essential_fel'),
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    /* Course Menu Settings */
    $name = 'theme_essential_fel/mycoursesinfo';
    $heading = get_string('mycoursesinfo', 'theme_essential_fel');
    $information = get_string('mycoursesinfodesc', 'theme_essential_fel');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Toggle courses display in custommenu.
    $name = 'theme_essential_fel/displaymycourses';
    $title = get_string('displaymycourses', 'theme_essential_fel');
    $description = get_string('displaymycoursesdesc', 'theme_essential_fel');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Set terminology for dropdown course list
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
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Helplink type
    $name = 'theme_essential_fel/helplinktype';
    $title = get_string('helplinktype', 'theme_essential_fel');
    $description = get_string('helplinktypedesc', 'theme_essential_fel');
    $default = 1;
    $choices = array(1 => get_string('email'),
        2 => get_string('url'),
        0 => get_string('none')
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Helplink
    $name = 'theme_essential_fel/helplink';
    $title = get_string('helplink', 'theme_essential_fel');
    $description = get_string('helplinkdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    /* Social Network Settings */
    $temp->add(new admin_setting_heading('theme_essential_fel_social', get_string('socialheadingsub', 'theme_essential_fel'),
        format_text(get_string('socialdesc', 'theme_essential_fel'), FORMAT_MARKDOWN)));

    // Website url setting.
    $name = 'theme_essential_fel/website';
    $title = get_string('website', 'theme_essential_fel');
    $description = get_string('websitedesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Facebook url setting.
    $name = 'theme_essential_fel/facebook';
    $title = get_string('facebook', 'theme_essential_fel');
    $description = get_string('facebookdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Flickr url setting.
    $name = 'theme_essential_fel/flickr';
    $title = get_string('flickr', 'theme_essential_fel');
    $description = get_string('flickrdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Twitter url setting.
    $name = 'theme_essential_fel/twitter';
    $title = get_string('twitter', 'theme_essential_fel');
    $description = get_string('twitterdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Google+ url setting.
    $name = 'theme_essential_fel/googleplus';
    $title = get_string('googleplus', 'theme_essential_fel');
    $description = get_string('googleplusdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // LinkedIn url setting.
    $name = 'theme_essential_fel/linkedin';
    $title = get_string('linkedin', 'theme_essential_fel');
    $description = get_string('linkedindesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Pinterest url setting.
    $name = 'theme_essential_fel/pinterest';
    $title = get_string('pinterest', 'theme_essential_fel');
    $description = get_string('pinterestdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Instagram url setting.
    $name = 'theme_essential_fel/instagram';
    $title = get_string('instagram', 'theme_essential_fel');
    $description = get_string('instagramdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // YouTube url setting.
    $name = 'theme_essential_fel/youtube';
    $title = get_string('youtube', 'theme_essential_fel');
    $description = get_string('youtubedesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Skype url setting.
    $name = 'theme_essential_fel/skype';
    $title = get_string('skype', 'theme_essential_fel');
    $description = get_string('skypedesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // VKontakte url setting.
    $name = 'theme_essential_fel/vk';
    $title = get_string('vk', 'theme_essential_fel');
    $description = get_string('vkdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    /* Apps Settings */
    $temp->add(new admin_setting_heading('theme_essential_fel_mobileapps', get_string('mobileappsheadingsub', 'theme_essential_fel'),
        format_text(get_string('mobileappsdesc', 'theme_essential_fel'), FORMAT_MARKDOWN)));

    // Android App url setting.
    $name = 'theme_essential_fel/android';
    $title = get_string('android', 'theme_essential_fel');
    $description = get_string('androiddesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Windows App url setting.
    $name = 'theme_essential_fel/windows';
    $title = get_string('windows', 'theme_essential_fel');
    $description = get_string('windowsdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Windows PhoneApp url setting.
    $name = 'theme_essential_fel/winphone';
    $title = get_string('winphone', 'theme_essential_fel');
    $description = get_string('winphonedesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);


// iOS App url setting.
    $name = 'theme_essential_fel/ios';
    $title = get_string('ios', 'theme_essential_fel');
    $description = get_string('iosdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // This is the descriptor for iOS Icons
    $name = 'theme_essential_fel/iosiconinfo';
    $heading = get_string('iosicon', 'theme_essential_fel');
    $information = get_string('iosicondesc', 'theme_essential_fel');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // iPhone Icon.
    $name = 'theme_essential_fel/iphoneicon';
    $title = get_string('iphoneicon', 'theme_essential_fel');
    $description = get_string('iphoneicondesc', 'theme_essential_fel');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'iphoneicon');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // iPhone Retina Icon.
    $name = 'theme_essential_fel/iphoneretinaicon';
    $title = get_string('iphoneretinaicon', 'theme_essential_fel');
    $description = get_string('iphoneretinaicondesc', 'theme_essential_fel');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'iphoneretinaicon');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // iPad Icon.
    $name = 'theme_essential_fel/ipadicon';
    $title = get_string('ipadicon', 'theme_essential_fel');
    $description = get_string('ipadicondesc', 'theme_essential_fel');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'ipadicon');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // iPad Retina Icon.
    $name = 'theme_essential_fel/ipadretinaicon';
    $title = get_string('ipadretinaicon', 'theme_essential_fel');
    $description = get_string('ipadretinaicondesc', 'theme_essential_fel');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'ipadretinaicon');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $ADMIN->add('theme_essential_fel', $temp);

    /* Footer Settings */
    $temp = new admin_settingpage('theme_essential_fel_footer', get_string('footerheading', 'theme_essential_fel'), 'theme/essential_fel:configure');

    // Copyright setting.
    $name = 'theme_essential_fel/copyright';
    $title = get_string('copyright', 'theme_essential_fel');
    $description = get_string('copyrightdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $temp->add($setting);

    // Footnote setting.
    $name = 'theme_essential_fel/footnote';
    $title = get_string('footnote', 'theme_essential_fel');
    $description = get_string('footnotedesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Performance Information Display.
    $name = 'theme_essential_fel/perfinfo';
    $title = get_string('perfinfo', 'theme_essential_fel');
    $description = get_string('perfinfodesc', 'theme_essential_fel');
    $perf_max = get_string('perf_max', 'theme_essential_fel');
    $perf_min = get_string('perf_min', 'theme_essential_fel');
    $default = 'min';
    $choices = array('min' => $perf_min, 'max' => $perf_max);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $ADMIN->add('theme_essential_fel', $temp);

    $temp = new admin_settingpage('theme_essential_fel_frontpage', get_string('frontpageheading', 'theme_essential_fel'), 'theme/essential_fel:configure');

    $temp->add(new admin_setting_heading('theme_essential_fel_frontcontent', get_string('frontcontentheading', 'theme_essential_fel'),
        ''));

    // Toggle Frontpage Content.
    $name = 'theme_essential_fel/togglefrontcontent';
    $title = get_string('frontcontent', 'theme_essential_fel');
    $description = get_string('frontcontentdesc', 'theme_essential_fel');
    $alwaysdisplay = get_string('alwaysdisplay', 'theme_essential_fel');
    $displaybeforelogin = get_string('displaybeforelogin', 'theme_essential_fel');
    $displayafterlogin = get_string('displayafterlogin', 'theme_essential_fel');
    $dontdisplay = get_string('dontdisplay', 'theme_essential_fel');
    $default = 0;
    $choices = array(1 => $alwaysdisplay, 2 => $displaybeforelogin, 3 => $displayafterlogin, 0 => $dontdisplay);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Frontpage Content
    $name = 'theme_essential_fel/frontcontentarea';
    $title = get_string('frontcontentarea', 'theme_essential_fel');
    $description = get_string('frontcontentareadesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel_frontpageblocksheading';
    $heading = get_string('frontpageblocksheading', 'theme_essential_fel');
    $information = '';
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Frontpage Block alignment.
    $name = 'theme_essential_fel/frontpageblocks';
    $title = get_string('frontpageblocks', 'theme_essential_fel');
    $description = get_string('frontpageblocksdesc', 'theme_essential_fel');
    $left = get_string('left', 'theme_essential_fel');
    $right = get_string('right', 'theme_essential_fel');
    $default = 1;
    $choices = array(1 => $left, 0 => $right);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Toggle Frontpage Middle Blocks
    $name = 'theme_essential_fel/frontpagemiddleblocks';
    $title = get_string('frontpagemiddleblocks', 'theme_essential_fel');
    $description = get_string('frontpagemiddleblocksdesc', 'theme_essential_fel');
    $alwaysdisplay = get_string('alwaysdisplay', 'theme_essential_fel');
    $displaybeforelogin = get_string('displaybeforelogin', 'theme_essential_fel');
    $displayafterlogin = get_string('displayafterlogin', 'theme_essential_fel');
    $dontdisplay = get_string('dontdisplay', 'theme_essential_fel');
    $default = 0;
    $choices = array(1 => $alwaysdisplay, 2 => $displaybeforelogin, 3 => $displayafterlogin, 0 => $dontdisplay);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);


    /* Marketing Spot Settings */
    $temp->add(new admin_setting_heading('theme_essential_fel_marketing', get_string('marketingheadingsub', 'theme_essential_fel'),
        format_text(get_string('marketingdesc', 'theme_essential_fel'), FORMAT_MARKDOWN)));

    // Toggle Marketing Spots.
    $name = 'theme_essential_fel/togglemarketing';
    $title = get_string('togglemarketing', 'theme_essential_fel');
    $description = get_string('togglemarketingdesc', 'theme_essential_fel');
    $alwaysdisplay = get_string('alwaysdisplay', 'theme_essential_fel');
    $displaybeforelogin = get_string('displaybeforelogin', 'theme_essential_fel');
    $displayafterlogin = get_string('displayafterlogin', 'theme_essential_fel');
    $dontdisplay = get_string('dontdisplay', 'theme_essential_fel');
    $default = 1;
    $choices = array(1 => $alwaysdisplay, 2 => $displaybeforelogin, 3 => $displayafterlogin, 0 => $dontdisplay);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Marketing Spot Image Height.
    $name = 'theme_essential_fel/marketingheight';
    $title = get_string('marketingheight', 'theme_essential_fel');
    $description = get_string('marketingheightdesc', 'theme_essential_fel');
    $default = 100;
    $choices = array(50 => '50', 100 => '100', 150 => '150', 200 => '200', 250 => '250', 300 => '300');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $temp->add($setting);

    // This is the descriptor for Marketing Spot One.
    $name = 'theme_essential_fel/marketing1info';
    $heading = get_string('marketing1', 'theme_essential_fel');
    $information = get_string('marketinginfodesc', 'theme_essential_fel');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Marketing Spot One.
    $name = 'theme_essential_fel/marketing1';
    $title = get_string('marketingtitle', 'theme_essential_fel');
    $description = get_string('marketingtitledesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing1icon';
    $title = get_string('marketingicon', 'theme_essential_fel');
    $description = get_string('marketingicondesc', 'theme_essential_fel');
    $default = 'star';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing1image';
    $title = get_string('marketingimage', 'theme_essential_fel');
    $description = get_string('marketingimagedesc', 'theme_essential_fel');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing1image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing1content';
    $title = get_string('marketingcontent', 'theme_essential_fel');
    $description = get_string('marketingcontentdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing1buttontext';
    $title = get_string('marketingbuttontext', 'theme_essential_fel');
    $description = get_string('marketingbuttontextdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing1buttonurl';
    $title = get_string('marketingbuttonurl', 'theme_essential_fel');
    $description = get_string('marketingbuttonurldesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing1target';
    $title = get_string('marketingurltarget', 'theme_essential_fel');
    $description = get_string('marketingurltargetdesc', 'theme_essential_fel');
    $target1 = get_string('marketingurltargetself', 'theme_essential_fel');
    $target2 = get_string('marketingurltargetnew', 'theme_essential_fel');
    $target3 = get_string('marketingurltargetparent', 'theme_essential_fel');
    $default = '_blank';
    $choices = array('_self' => $target1, '_blank' => $target2, '_parent' => $target3);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // This is the descriptor for Marketing Spot Two.
    $name = 'theme_essential_fel/marketing2info';
    $heading = get_string('marketing2', 'theme_essential_fel');
    $information = get_string('marketinginfodesc', 'theme_essential_fel');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Marketing Spot Two.
    $name = 'theme_essential_fel/marketing2';
    $title = get_string('marketingtitle', 'theme_essential_fel');
    $description = get_string('marketingtitledesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing2icon';
    $title = get_string('marketingicon', 'theme_essential_fel');
    $description = get_string('marketingicondesc', 'theme_essential_fel');
    $default = 'star';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing2image';
    $title = get_string('marketingimage', 'theme_essential_fel');
    $description = get_string('marketingimagedesc', 'theme_essential_fel');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing2image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing2content';
    $title = get_string('marketingcontent', 'theme_essential_fel');
    $description = get_string('marketingcontentdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing2buttontext';
    $title = get_string('marketingbuttontext', 'theme_essential_fel');
    $description = get_string('marketingbuttontextdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing2buttonurl';
    $title = get_string('marketingbuttonurl', 'theme_essential_fel');
    $description = get_string('marketingbuttonurldesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing2target';
    $title = get_string('marketingurltarget', 'theme_essential_fel');
    $description = get_string('marketingurltargetdesc', 'theme_essential_fel');
    $target1 = get_string('marketingurltargetself', 'theme_essential_fel');
    $target2 = get_string('marketingurltargetnew', 'theme_essential_fel');
    $target3 = get_string('marketingurltargetparent', 'theme_essential_fel');
    $default = '_blank';
    $choices = array('_self' => $target1, '_blank' => $target2, '_parent' => $target3);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // This is the descriptor for Marketing Spot Three
    $name = 'theme_essential_fel/marketing3info';
    $heading = get_string('marketing3', 'theme_essential_fel');
    $information = get_string('marketinginfodesc', 'theme_essential_fel');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Marketing Spot Three.
    $name = 'theme_essential_fel/marketing3';
    $title = get_string('marketingtitle', 'theme_essential_fel');
    $description = get_string('marketingtitledesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing3icon';
    $title = get_string('marketingicon', 'theme_essential_fel');
    $description = get_string('marketingicondesc', 'theme_essential_fel');
    $default = 'star';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing3image';
    $title = get_string('marketingimage', 'theme_essential_fel');
    $description = get_string('marketingimagedesc', 'theme_essential_fel');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing3image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing3content';
    $title = get_string('marketingcontent', 'theme_essential_fel');
    $description = get_string('marketingcontentdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing3buttontext';
    $title = get_string('marketingbuttontext', 'theme_essential_fel');
    $description = get_string('marketingbuttontextdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing3buttonurl';
    $title = get_string('marketingbuttonurl', 'theme_essential_fel');
    $description = get_string('marketingbuttonurldesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing3target';
    $title = get_string('marketingurltarget', 'theme_essential_fel');
    $description = get_string('marketingurltargetdesc', 'theme_essential_fel');
    $target1 = get_string('marketingurltargetself', 'theme_essential_fel');
    $target2 = get_string('marketingurltargetnew', 'theme_essential_fel');
    $target3 = get_string('marketingurltargetparent', 'theme_essential_fel');
    $default = '_blank';
    $choices = array('_self' => $target1, '_blank' => $target2, '_parent' => $target3);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Add second marketing row
    $name = 'theme_essential_fel/marketingsecondrowhead';
    $heading = get_string('marketingsecondrow', 'theme_essential_fel');
    $setting = new admin_setting_heading($name, $heading, '');
    $temp->add($setting);

    $name = 'theme_essential_fel/enablemarketingsecondrow';
    $title = get_string('enablemarketingsecondrow', 'theme_essential_fel');
    $description = get_string('enablemarketingsecondrowdesc', 'theme_essential_fel');
    $default = 0;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $temp->add($setting);


    // This is the descriptor for Marketing Spot Four
    $name = 'theme_essential_fel/marketing4info';
    $heading = get_string('marketing4', 'theme_essential_fel');
    $information = get_string('marketinginfodesc', 'theme_essential_fel');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Marketing Spot Four.
    $name = 'theme_essential_fel/marketing4';
    $title = get_string('marketingtitle', 'theme_essential_fel');
    $description = get_string('marketingtitledesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing4icon';
    $title = get_string('marketingicon', 'theme_essential_fel');
    $description = get_string('marketingicondesc', 'theme_essential_fel');
    $default = 'star';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing4image';
    $title = get_string('marketingimage', 'theme_essential_fel');
    $description = get_string('marketingimagedesc', 'theme_essential_fel');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing3image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing4content';
    $title = get_string('marketingcontent', 'theme_essential_fel');
    $description = get_string('marketingcontentdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing4buttontext';
    $title = get_string('marketingbuttontext', 'theme_essential_fel');
    $description = get_string('marketingbuttontextdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing4buttonurl';
    $title = get_string('marketingbuttonurl', 'theme_essential_fel');
    $description = get_string('marketingbuttonurldesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing4target';
    $title = get_string('marketingurltarget', 'theme_essential_fel');
    $description = get_string('marketingurltargetdesc', 'theme_essential_fel');
    $target1 = get_string('marketingurltargetself', 'theme_essential_fel');
    $target2 = get_string('marketingurltargetnew', 'theme_essential_fel');
    $target3 = get_string('marketingurltargetparent', 'theme_essential_fel');
    $default = '_blank';
    $choices = array('_self' => $target1, '_blank' => $target2, '_parent' => $target3);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // This is the descriptor for Marketing Spot Five
    $name = 'theme_essential_fel/marketing5info';
    $heading = get_string('marketing5', 'theme_essential_fel');
    $information = get_string('marketinginfodesc', 'theme_essential_fel');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Marketing Spot Five.
    $name = 'theme_essential_fel/marketing5';
    $title = get_string('marketingtitle', 'theme_essential_fel');
    $description = get_string('marketingtitledesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing5icon';
    $title = get_string('marketingicon', 'theme_essential_fel');
    $description = get_string('marketingicondesc', 'theme_essential_fel');
    $default = 'star';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing5image';
    $title = get_string('marketingimage', 'theme_essential_fel');
    $description = get_string('marketingimagedesc', 'theme_essential_fel');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing3image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing5content';
    $title = get_string('marketingcontent', 'theme_essential_fel');
    $description = get_string('marketingcontentdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing5buttontext';
    $title = get_string('marketingbuttontext', 'theme_essential_fel');
    $description = get_string('marketingbuttontextdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing5buttonurl';
    $title = get_string('marketingbuttonurl', 'theme_essential_fel');
    $description = get_string('marketingbuttonurldesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing5target';
    $title = get_string('marketingurltarget', 'theme_essential_fel');
    $description = get_string('marketingurltargetdesc', 'theme_essential_fel');
    $target1 = get_string('marketingurltargetself', 'theme_essential_fel');
    $target2 = get_string('marketingurltargetnew', 'theme_essential_fel');
    $target3 = get_string('marketingurltargetparent', 'theme_essential_fel');
    $default = '_blank';
    $choices = array('_self' => $target1, '_blank' => $target2, '_parent' => $target3);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // This is the descriptor for Marketing Spot Six
    $name = 'theme_essential_fel/marketing6info';
    $heading = get_string('marketing6', 'theme_essential_fel');
    $information = get_string('marketinginfodesc', 'theme_essential_fel');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Marketing Spot Six.
    $name = 'theme_essential_fel/marketing6';
    $title = get_string('marketingtitle', 'theme_essential_fel');
    $description = get_string('marketingtitledesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing6icon';
    $title = get_string('marketingicon', 'theme_essential_fel');
    $description = get_string('marketingicondesc', 'theme_essential_fel');
    $default = 'star';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing6image';
    $title = get_string('marketingimage', 'theme_essential_fel');
    $description = get_string('marketingimagedesc', 'theme_essential_fel');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing3image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing6content';
    $title = get_string('marketingcontent', 'theme_essential_fel');
    $description = get_string('marketingcontentdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing6buttontext';
    $title = get_string('marketingbuttontext', 'theme_essential_fel');
    $description = get_string('marketingbuttontextdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing6buttonurl';
    $title = get_string('marketingbuttonurl', 'theme_essential_fel');
    $description = get_string('marketingbuttonurldesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essential_fel/marketing6target';
    $title = get_string('marketingurltarget', 'theme_essential_fel');
    $description = get_string('marketingurltargetdesc', 'theme_essential_fel');
    $target1 = get_string('marketingurltargetself', 'theme_essential_fel');
    $target2 = get_string('marketingurltargetnew', 'theme_essential_fel');
    $target3 = get_string('marketingurltargetparent', 'theme_essential_fel');
    $default = '_blank';
    $choices = array('_self' => $target1, '_blank' => $target2, '_parent' => $target3);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);


    /* User Alerts */
    $temp->add(new admin_setting_heading('theme_essential_fel_alerts', get_string('alertsheadingsub', 'theme_essential_fel'),
        format_text(get_string('alertsdesc', 'theme_essential_fel'), FORMAT_MARKDOWN)));

    // This is the descriptor for Alert One
    $name = 'theme_essential_fel/alert1info';
    $heading = get_string('alert1', 'theme_essential_fel');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Enable Alert
    $name = 'theme_essential_fel/enable1alert';
    $title = get_string('enablealert', 'theme_essential_fel');
    $description = get_string('enablealertdesc', 'theme_essential_fel');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Alert Type.
    $name = 'theme_essential_fel/alert1type';
    $title = get_string('alerttype', 'theme_essential_fel');
    $description = get_string('alerttypedesc', 'theme_essential_fel');
    $alert_info = get_string('alert_info', 'theme_essential_fel');
    $alert_warning = get_string('alert_warning', 'theme_essential_fel');
    $alert_general = get_string('alert_general', 'theme_essential_fel');
    $default = 'info';
    $choices = array('info' => $alert_info, 'error' => $alert_warning, 'success' => $alert_general);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Alert Title.
    $name = 'theme_essential_fel/alert1title';
    $title = get_string('alerttitle', 'theme_essential_fel');
    $description = get_string('alerttitledesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Alert Text.
    $name = 'theme_essential_fel/alert1text';
    $title = get_string('alerttext', 'theme_essential_fel');
    $description = get_string('alerttextdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // This is the descriptor for Alert Two
    $name = 'theme_essential_fel/alert2info';
    $heading = get_string('alert2', 'theme_essential_fel');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Enable Alert
    $name = 'theme_essential_fel/enable2alert';
    $title = get_string('enablealert', 'theme_essential_fel');
    $description = get_string('enablealertdesc', 'theme_essential_fel');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Alert Type.
    $name = 'theme_essential_fel/alert2type';
    $title = get_string('alerttype', 'theme_essential_fel');
    $description = get_string('alerttypedesc', 'theme_essential_fel');
    $alert_info = get_string('alert_info', 'theme_essential_fel');
    $alert_warning = get_string('alert_warning', 'theme_essential_fel');
    $alert_general = get_string('alert_general', 'theme_essential_fel');
    $default = 'info';
    $choices = array('info' => $alert_info, 'error' => $alert_warning, 'success' => $alert_general);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Alert Title.
    $name = 'theme_essential_fel/alert2title';
    $title = get_string('alerttitle', 'theme_essential_fel');
    $description = get_string('alerttitledesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Alert Text.
    $name = 'theme_essential_fel/alert2text';
    $title = get_string('alerttext', 'theme_essential_fel');
    $description = get_string('alerttextdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // This is the descriptor for Alert Three
    $name = 'theme_essential_fel/alert3info';
    $heading = get_string('alert3', 'theme_essential_fel');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Enable Alert
    $name = 'theme_essential_fel/enable3alert';
    $title = get_string('enablealert', 'theme_essential_fel');
    $description = get_string('enablealertdesc', 'theme_essential_fel');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Alert Type.
    $name = 'theme_essential_fel/alert3type';
    $title = get_string('alerttype', 'theme_essential_fel');
    $description = get_string('alerttypedesc', 'theme_essential_fel');
    $alert_info = get_string('alert_info', 'theme_essential_fel');
    $alert_warning = get_string('alert_warning', 'theme_essential_fel');
    $alert_general = get_string('alert_general', 'theme_essential_fel');
    $default = 'info';
    $choices = array('info' => $alert_info, 'error' => $alert_warning, 'success' => $alert_general);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Alert Title.
    $name = 'theme_essential_fel/alert3title';
    $title = get_string('alerttitle', 'theme_essential_fel');
    $description = get_string('alerttitledesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Alert Text.
    $name = 'theme_essential_fel/alert3text';
    $title = get_string('alerttext', 'theme_essential_fel');
    $description = get_string('alerttextdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $ADMIN->add('theme_essential_fel', $temp);

    /* Slideshow Widget Settings */
    $temp = new admin_settingpage('theme_essential_fel_slideshow', get_string('slideshowheading', 'theme_essential_fel'), 'theme/essential_fel:configure');
    $temp->add(new admin_setting_heading('theme_essential_fel_slideshow', get_string('slideshowheadingsub', 'theme_essential_fel'),
        format_text(get_string('slideshowdesc', 'theme_essential_fel'), FORMAT_MARKDOWN)));

    // Toggle Slideshow.
    $name = 'theme_essential_fel/toggleslideshow';
    $title = get_string('toggleslideshow', 'theme_essential_fel');
    $description = get_string('toggleslideshowdesc', 'theme_essential_fel');
    $alwaysdisplay = get_string('alwaysdisplay', 'theme_essential_fel');
    $displaybeforelogin = get_string('displaybeforelogin', 'theme_essential_fel');
    $displayafterlogin = get_string('displayafterlogin', 'theme_essential_fel');
    $dontdisplay = get_string('dontdisplay', 'theme_essential_fel');
    $default = 1;
    $choices = array(1 => $alwaysdisplay, 2 => $displaybeforelogin, 3 => $displayafterlogin, 0 => $dontdisplay);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

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
    $temp->add(new admin_setting_configselect($name, $title, $description, $default, $choices));

    // Hide slideshow on phones.
    $name = 'theme_essential_fel/hideontablet';
    $title = get_string('hideontablet', 'theme_essential_fel');
    $description = get_string('hideontabletdesc', 'theme_essential_fel');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Hide slideshow on tablet.
    $name = 'theme_essential_fel/hideonphone';
    $title = get_string('hideonphone', 'theme_essential_fel');
    $description = get_string('hideonphonedesc', 'theme_essential_fel');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Slide interval.
    $name = 'theme_essential_fel/slideinterval';
    $title = get_string('slideinterval', 'theme_essential_fel');
    $description = get_string('slideintervaldesc', 'theme_essential_fel');
    $default = '5000';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Slide Text colour setting.
    $name = 'theme_essential_fel/slidecolor';
    $title = get_string('slidecolor', 'theme_essential_fel');
    $description = get_string('slidecolordesc', 'theme_essential_fel');
    $default = '#ffffff';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Show caption below the image.
    $name = 'theme_essential_fel/slidecaptionbelow';
    $title = get_string('slidecaptionbelow', 'theme_essential_fel');
    $description = get_string('slidecaptionbelowdesc', 'theme_essential_fel');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Show caption centred.
    $name = 'theme_essential_fel/slidecaptioncentred';
    $title = get_string('slidecaptioncentred', 'theme_essential_fel');
    $description = get_string('slidecaptioncentreddesc', 'theme_essential_fel');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Slide button colour setting.
    $name = 'theme_essential_fel/slidebuttoncolor';
    $title = get_string('slidebuttoncolor', 'theme_essential_fel');
    $description = get_string('slidebuttoncolordesc', 'theme_essential_fel');
    $default = '#30add1';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Slide button hover colour setting.
    $name = 'theme_essential_fel/slidebuttonhovercolor';
    $title = get_string('slidebuttonhovercolor', 'theme_essential_fel');
    $description = get_string('slidebuttonhovercolordesc', 'theme_essential_fel');
    $default = '#217a94';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $numberofslides = get_config('theme_essential_fel', 'numberofslides');
    for ($i = 1; $i <= $numberofslides; $i++) {
        // This is the descriptor for Slide One
        $name = 'theme_essential_fel/slide' . $i . 'info';
        $heading = get_string('slideno', 'theme_essential_fel', array('slide' => $i));
        $information = get_string('slidenodesc', 'theme_essential_fel', array('slide' => $i));
        $setting = new admin_setting_heading($name, $heading, $information);
        $temp->add($setting);

        // Title.
        $name = 'theme_essential_fel/slide' . $i;
        $title = get_string('slidetitle', 'theme_essential_fel');
        $description = get_string('slidetitledesc', 'theme_essential_fel');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // Image.
        $name = 'theme_essential_fel/slide' . $i . 'image';
        $title = get_string('slideimage', 'theme_essential_fel');
        $description = get_string('slideimagedesc', 'theme_essential_fel');
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'slide' . $i . 'image');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // Caption text.
        $name = 'theme_essential_fel/slide' . $i . 'caption';
        $title = get_string('slidecaption', 'theme_essential_fel');
        $description = get_string('slidecaptiondesc', 'theme_essential_fel');
        $default = '';
        $setting = new admin_setting_configtextarea($name, $title, $description, $default, PARAM_TEXT);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // URL.
        $name = 'theme_essential_fel/slide' . $i . 'url';
        $title = get_string('slideurl', 'theme_essential_fel');
        $description = get_string('slideurldesc', 'theme_essential_fel');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // URL target.
        $name = 'theme_essential_fel/slide' . $i . 'target';
        $title = get_string('slideurltarget', 'theme_essential_fel');
        $description = get_string('slideurltargetdesc', 'theme_essential_fel');
        $target1 = get_string('slideurltargetself', 'theme_essential_fel');
        $target2 = get_string('slideurltargetnew', 'theme_essential_fel');
        $target3 = get_string('slideurltargetparent', 'theme_essential_fel');
        $default = '_blank';
        $choices = array('_self' => $target1, '_blank' => $target2, '_parent' => $target3);
        $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);
    }

    $ADMIN->add('theme_essential_fel', $temp);

    /* Category Settings */
    $temp = new admin_settingpage('theme_essential_fel_categoryicon', get_string('categoryiconheading', 'theme_essential_fel'), 'theme/essential_fel:configure');
    $temp->add(new admin_setting_heading('theme_essential_fel_categoryicon', get_string('categoryiconheadingsub', 'theme_essential_fel'),
        format_text(get_string('categoryicondesc', 'theme_essential_fel'), FORMAT_MARKDOWN)));

    // Category Icons.
    $name = 'theme_essential_fel/enablecategoryicon';
    $title = get_string('enablecategoryicon', 'theme_essential_fel');
    $description = get_string('enablecategoryicondesc', 'theme_essential_fel');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // We only want to output category icon options if the parent setting is enabled
    if (get_config('theme_essential_fel', 'enablecategoryicon')) {

        // Default Icon Selector.
        $name = 'theme_essential_fel/defaultcategoryicon';
        $title = get_string('defaultcategoryicon', 'theme_essential_fel');
        $description = get_string('defaultcategoryicondesc', 'theme_essential_fel');
        $default = 'folder-open';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // Category Icons.
        $name = 'theme_essential_fel/enablecustomcategoryicon';
        $title = get_string('enablecustomcategoryicon', 'theme_essential_fel');
        $description = get_string('enablecustomcategoryicondesc', 'theme_essential_fel');
        $setting = new admin_setting_configcheckbox($name, $title, $description, 0);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        if (get_config('theme_essential_fel', 'enablecustomcategoryicon')) {

            // This is the descriptor for Custom Category Icons
            $name = 'theme_essential_fel/categoryiconinfo';
            $heading = get_string('categoryiconinfo', 'theme_essential_fel');
            $information = get_string('categoryiconinfodesc', 'theme_essential_fel');
            $setting = new admin_setting_heading($name, $heading, $information);
            $temp->add($setting);

            // Get the default category icon.
            $defaultcategoryicon = get_config('theme_essential_fel', 'defaultcategoryicon');
            if (empty($defaultcategoryicon)) {
                $defaultcategoryicon = 'folder-open';
            }

            // Get all category IDs and their pretty names
            require_once($CFG->libdir . '/coursecatlib.php');
            $coursecats = coursecat::make_categories_list();

            // Go through all categories and create the necessary settings
            foreach ($coursecats as $key => $value) {

                // Category Icons for each category.
                $name = 'theme_essential_fel/categoryicon';
                $title = $value;
                $description = get_string('categoryiconcategory', 'theme_essential_fel', array('category' => $value));
                $default = $defaultcategoryicon;
                $setting = new admin_setting_configtext($name . $key, $title, $description, $default);
                $setting->set_updatedcallback('theme_reset_all_caches');
                $temp->add($setting);
            }
            unset($coursecats);
        }
    }

    $ADMIN->add('theme_essential_fel', $temp);

    /* Analytics Settings */
    $temp = new admin_settingpage('theme_essential_fel_analytics', get_string('analytics', 'theme_essential_fel'), 'theme/essential_fel:configure');
    $temp->add(new admin_setting_heading('theme_essential_fel_analytics', get_string('analyticsheadingsub', 'theme_essential_fel'),
        format_text(get_string('analyticsdesc', 'theme_essential_fel'), FORMAT_MARKDOWN)));

    $name = 'theme_essential_fel/analyticsenabled';
    $title = get_string('analyticsenabled', 'theme_essential_fel');
    $description = get_string('analyticsenableddesc', 'theme_essential_fel');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $temp->add($setting);

    $name = 'theme_essential_fel/analytics';
    $title = get_string('analytics', 'theme_essential_fel');
    $description = get_string('analyticsdesc', 'theme_essential_fel');
    $guniversal = get_string('analyticsguniversal', 'theme_essential_fel');
    $piwik = get_string('analyticspiwik', 'theme_essential_fel');
    $default = 'piwik';
    $choices = array(
        'piwik' => $piwik,
        'guniversal' => $guniversal,
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $temp->add($setting);

    if (get_config('theme_essential_fel', 'analytics') === 'piwik') {
        $name = 'theme_essential_fel/analyticssiteid';
        $title = get_string('analyticssiteid', 'theme_essential_fel');
        $description = get_string('analyticssiteiddesc', 'theme_essential_fel');
        $default = '1';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $temp->add($setting);

        $name = 'theme_essential_fel/analyticsimagetrack';
        $title = get_string('analyticsimagetrack', 'theme_essential_fel');
        $description = get_string('analyticsimagetrackdesc', 'theme_essential_fel');
        $default = true;
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
        $temp->add($setting);

        $name = 'theme_essential_fel/analyticssiteurl';
        $title = get_string('analyticssiteurl', 'theme_essential_fel');
        $description = get_string('analyticssiteurldesc', 'theme_essential_fel');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $temp->add($setting);
    } else if (get_config('theme_essential_fel', 'analytics') === 'guniversal') {
        $name = 'theme_essential_fel/analyticstrackingid';
        $title = get_string('analyticstrackingid', 'theme_essential_fel');
        $description = get_string('analyticstrackingiddesc', 'theme_essential_fel');
        $default = 'UA-XXXXXXXX-X';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $temp->add($setting);
    }

    $name = 'theme_essential_fel/analyticstrackadmin';
    $title = get_string('analyticstrackadmin', 'theme_essential_fel');
    $description = get_string('analyticstrackadmindesc', 'theme_essential_fel');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $temp->add($setting);

    $name = 'theme_essential_fel/analyticscleanurl';
    $title = get_string('analyticscleanurl', 'theme_essential_fel');
    $description = get_string('analyticscleanurldesc', 'theme_essential_fel');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $temp->add($setting);

    $ADMIN->add('theme_essential_fel', $temp);
// }