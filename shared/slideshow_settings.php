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

$essential_fel_settingsslideshow->add(new admin_setting_heading('theme_essential_fel5_slideshow',
    get_string('slideshowheadingsub', 'theme_essential_fel'),
    format_text(get_string('slideshowdesc', 'theme_essential_fel'), FORMAT_MARKDOWN)));

// Toggle slideshow.
$name = 'theme_essential_fel'.$themeix.'/toggleslideshow';
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
$essential_fel_settingsslideshow->add($setting);

// Number of slides.
$name = 'theme_essential_fel'.$themeix.'/numberofslides';
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
$essential_fel_settingsslideshow->add(new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices));

// Hide slideshow on phones.
$name = 'theme_essential_fel'.$themeix.'/hideontablet';
$title = get_string('hideontablet', 'theme_essential_fel');
$description = get_string('hideontabletdesc', 'theme_essential_fel');
$default = false;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsslideshow->add($setting);

// Hide slideshow on tablet.
$name = 'theme_essential_fel'.$themeix.'/hideonphone';
$title = get_string('hideonphone', 'theme_essential_fel');
$description = get_string('hideonphonedesc', 'theme_essential_fel');
$default = true;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsslideshow->add($setting);

// Slide interval.
$name = 'theme_essential_fel'.$themeix.'/slideinterval';
$title = get_string('slideinterval', 'theme_essential_fel');
$description = get_string('slideintervaldesc', 'theme_essential_fel');
$default = '5000';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsslideshow->add($setting);

// Slide caption text colour setting.
$name = 'theme_essential_fel'.$themeix.'/slidecaptiontextcolor';
$title = get_string('slidecaptiontextcolor', 'theme_essential_fel');
$description = get_string('slidecaptiontextcolordesc', 'theme_essential_fel');
$default = '#ffffff';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsslideshow->add($setting);

// Slide caption background colour setting.
$name = 'theme_essential_fel'.$themeix.'/slidecaptionbackgroundcolor';
$title = get_string('slidecaptionbackgroundcolor', 'theme_essential_fel');
$description = get_string('slidecaptionbackgroundcolordesc', 'theme_essential_fel');
$default = '#30add1';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsslideshow->add($setting);

// Show caption options.
$name = 'theme_essential_fel'.$themeix.'/slidecaptionoptions';
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
$essential_fel_settingsslideshow->add($setting);

// Show caption centred.
$name = 'theme_essential_fel'.$themeix.'/slidecaptioncentred';
$title = get_string('slidecaptioncentred', 'theme_essential_fel');
$description = get_string('slidecaptioncentreddesc', 'theme_essential_fel');
$default = false;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsslideshow->add($setting);

// Slide button colour setting.
$name = 'theme_essential_fel'.$themeix.'/slidebuttoncolor';
$title = get_string('slidebuttoncolor', 'theme_essential_fel');
$description = get_string('slidebuttoncolordesc', 'theme_essential_fel');
$default = '#30add1';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsslideshow->add($setting);

// Slide button hover colour setting.
$name = 'theme_essential_fel'.$themeix.'/slidebuttonhovercolor';
$title = get_string('slidebuttonhovercolor', 'theme_essential_fel');
$description = get_string('slidebuttonhovercolordesc', 'theme_essential_fel');
$default = '#217a94';
$previewconfig = null;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsslideshow->add($setting);

// This is the descriptor for the user theme slide colours.
$name = 'theme_essential_fel'.$themeix.'/alternativethemeslidecolorsinfo';
$heading = get_string('alternativethemeslidecolors', 'theme_essential_fel');
$information = get_string('alternativethemeslidecolorsdesc', 'theme_essential_fel');
$setting = new admin_setting_heading($name, $heading, $information);
$essential_fel_settingsslideshow->add($setting);

foreach (range(1, 4) as $alternativethemenumber) {
    // Alternative theme slide caption text colour setting.
    $name = 'theme_essential_fel'.$themeix.'/alternativethemeslidecaptiontextcolor' . $alternativethemenumber;
    $title = get_string('alternativethemeslidecaptiontextcolor', 'theme_essential_fel', $alternativethemenumber);
    $description = get_string('alternativethemeslidecaptiontextcolordesc', 'theme_essential_fel',
            $alternativethemenumber);
    $default = '#ffffff';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_fel_settingsslideshow->add($setting);

    // Alternative theme slide caption background colour setting.
    $name = 'theme_essential_fel'.$themeix.'/alternativethemeslidecaptionbackgroundcolor' . $alternativethemenumber;
    $title = get_string('alternativethemeslidecaptionbackgroundcolor', 'theme_essential_fel', $alternativethemenumber);
    $description = get_string('alternativethemeslidecaptionbackgroundcolordesc', 'theme_essential_fel',
            $alternativethemenumber);
    $default = $defaultalternativethemecolors[$alternativethemenumber - 1];
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_fel_settingsslideshow->add($setting);

    // Alternative theme slide button colour setting.
    $name = 'theme_essential_fel'.$themeix.'/alternativethemeslidebuttoncolor' . $alternativethemenumber;
    $title = get_string('alternativethemeslidebuttoncolor', 'theme_essential_fel', $alternativethemenumber);
    $description = get_string('alternativethemeslidebuttoncolordesc', 'theme_essential_fel', $alternativethemenumber);
    $default = $defaultalternativethemecolors[$alternativethemenumber - 1];
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_fel_settingsslideshow->add($setting);

    // Alternative theme slide button hover colour setting.
    $name = 'theme_essential_fel'.$themeix.'/alternativethemeslidebuttonhovercolor' . $alternativethemenumber;
    $title = get_string('alternativethemeslidebuttonhovercolor', 'theme_essential_fel', $alternativethemenumber);
    $description = get_string('alternativethemeslidebuttonhovercolordesc', 'theme_essential_fel',
            $alternativethemenumber);
    $default = $defaultalternativethemehovercolors[$alternativethemenumber - 1];
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_fel_settingsslideshow->add($setting);
}

$numberofslides = get_config('theme_essential_fel', 'numberofslides');
for ($i = 1; $i <= $numberofslides; $i++) {
    // This is the descriptor for the slide.
    $name = 'theme_essential_fel'.$themeix.'/slide'.$i.'info';
    $heading = get_string('slideno', 'theme_essential_fel', array('slide' => $i));
    $information = get_string('slidenodesc', 'theme_essential_fel', array('slide' => $i));
    $setting = new admin_setting_heading($name, $heading, $information);
    $essential_fel_settingsslideshow->add($setting);

    // Title.
    $name = 'theme_essential_fel'.$themeix.'/slide'.$i;
    $title = get_string('slidetitle', 'theme_essential_fel');
    $description = get_string('slidetitledesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_fel_settingsslideshow->add($setting);

    // Image.
    $name = 'theme_essential_fel'.$themeix.'/slide'.$i.'image';
    $title = get_string('slideimage', 'theme_essential_fel');
    $description = get_string('slideimagedesc', 'theme_essential_fel');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'slide'.$i.'image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_fel_settingsslideshow->add($setting);

    // Caption text.
    $name = 'theme_essential_fel'.$themeix.'/slide'.$i.'caption';
    $title = get_string('slidecaption', 'theme_essential_fel');
    $description = get_string('slidecaptiondesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_fel_settingsslideshow->add($setting);

    // URL.
    $name = 'theme_essential_fel'.$themeix.'/slide'.$i.'url';
    $title = get_string('slideurl', 'theme_essential_fel');
    $description = get_string('slideurldesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_fel_settingsslideshow->add($setting);

    // URL target.
    $name = 'theme_essential_fel'.$themeix.'/slide'.$i.'target';
    $title = get_string('slideurltarget', 'theme_essential_fel');
    $description = get_string('slideurltargetdesc', 'theme_essential_fel');
    $target1 = get_string('slideurltargetself', 'theme_essential_fel');
    $target2 = get_string('slideurltargetnew', 'theme_essential_fel');
    $target3 = get_string('slideurltargetparent', 'theme_essential_fel');
    $default = '_blank';
    $choices = array('_self' => $target1, '_blank' => $target2, '_parent' => $target3);
    $setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_fel_settingsslideshow->add($setting);
}

$essential_fel_settingsslideshow->add(new admin_setting_heading('theme_essential_fel5_slideshowreadme',
    get_string('readme_title', 'theme_essential_fel'), get_string('readme_desc', 'theme_essential_fel', array('url' => $readme))));
