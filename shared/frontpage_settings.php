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

$name = 'theme_essential_fel'.$themeix.'/courselistteachericon';
$title = get_string('courselistteachericon', 'theme_essential_fel');
$description = get_string('courselistteachericondesc', 'theme_essential_fel');
$default = 'graduation-cap';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsfrontpage->add($setting);

$essential_fel_settingsfrontpage->add(new admin_setting_heading('theme_essential_fel5_frontcontent',
    get_string('frontcontentheading', 'theme_essential_fel'), ''));

// Toggle frontpage content.
$name = 'theme_essential_fel'.$themeix.'/togglefrontcontent';
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
$essential_fel_settingsfrontpage->add($setting);

// Frontpage content.
$name = 'theme_essential_fel'.$themeix.'/frontcontentarea';
$title = get_string('frontcontentarea', 'theme_essential_fel');
$description = get_string('frontcontentareadesc', 'theme_essential_fel');
$default = '';
$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsfrontpage->add($setting);

$name = 'theme_essential_fel5_frontpageblocksheading';
$heading = get_string('frontpageblocksheading', 'theme_essential_fel');
$information = '';
$setting = new admin_setting_heading($name, $heading, $information);
$essential_fel_settingsfrontpage->add($setting);

// Frontpage block alignment.
$name = 'theme_essential_fel'.$themeix.'/frontpageblocks';
$title = get_string('frontpageblocks', 'theme_essential_fel');
$description = get_string('frontpageblocksdesc', 'theme_essential_fel');
$before = get_string('beforecontent', 'theme_essential_fel');
$after = get_string('aftercontent', 'theme_essential_fel');
$default = 1;
$choices = array(1 => $before, 0 => $after);
$setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsfrontpage->add($setting);

// Toggle frontpage home (was middle) blocks.
$name = 'theme_essential_fel'.$themeix.'/frontpagemiddleblocks';
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
$essential_fel_settingsfrontpage->add($setting);

// Home blocks per row.
$name = 'theme_essential_fel'.$themeix.'/frontpagehomeblocksperrow';
$title = get_string('frontpagehomeblocksperrow', 'theme_essential_fel');
$default = 3;
$lower = 1;
$upper = 4;
$description = get_string('frontpagehomeblocksperrowdesc', 'theme_essential_fel',
    array('lower' => $lower, 'upper' => $upper));
$setting = new essential_fel_admin_setting_configinteger($name, $title, $description, $default, $lower, $upper);
$essential_fel_settingsfrontpage->add($setting);

// Toggle frontpage page top blocks.
$name = 'theme_essential_fel'.$themeix.'/fppagetopblocks';
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
$essential_fel_settingsfrontpage->add($setting);

// Marketing spot settings.
$essential_fel_settingsfrontpage->add(new admin_setting_heading('theme_essential_fel5_marketing',
    get_string('marketingheading', 'theme_essential_fel'),
    format_text(get_string('marketingdesc', 'theme_essential_fel'), FORMAT_MARKDOWN)));

// Toggle marketing spots.
$name = 'theme_essential_fel'.$themeix.'/togglemarketing';
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
$essential_fel_settingsfrontpage->add($setting);

// Marketing spot height.
$name = 'theme_essential_fel'.$themeix.'/marketingheight';
$title = get_string('marketingheight', 'theme_essential_fel');
$description = get_string('marketingheightdesc', 'theme_essential_fel');
$default = 100;
$choices = array();
for ($mhit = 50; $mhit <= 500; $mhit = $mhit + 2) {
    $choices[$mhit] = $mhit;
}
$setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
$essential_fel_settingsfrontpage->add($setting);

// Marketing spot image height.
$name = 'theme_essential_fel'.$themeix.'/marketingimageheight';
$title = get_string('marketingimageheight', 'theme_essential_fel');
$description = get_string('marketingimageheightdesc', 'theme_essential_fel');
$default = 100;
$choices = array(50 => '50', 100 => '100', 150 => '150', 200 => '200', 250 => '250', 300 => '300');
$setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
$essential_fel_settingsfrontpage->add($setting);

foreach (range(1, 3) as $marketingspotnumber) {
    // This is the descriptor for Marketing Spot in $marketingspotnumber.
    $name = 'theme_essential_fel'.$themeix.'/marketing' . $marketingspotnumber . 'info';
    $heading = get_string('marketing' . $marketingspotnumber, 'theme_essential_fel');
    $information = get_string('marketinginfodesc', 'theme_essential_fel');
    $setting = new admin_setting_heading($name, $heading, $information);
    $essential_fel_settingsfrontpage->add($setting);

    // Marketing spot.
    $name = 'theme_essential_fel'.$themeix.'/marketing' . $marketingspotnumber;
    $title = get_string('marketingtitle', 'theme_essential_fel');
    $description = get_string('marketingtitledesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_fel_settingsfrontpage->add($setting);

    $name = 'theme_essential_fel'.$themeix.'/marketing' . $marketingspotnumber . 'icon';
    $title = get_string('marketingicon', 'theme_essential_fel');
    $description = get_string('marketingicondesc', 'theme_essential_fel');
    $default = 'star';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_fel_settingsfrontpage->add($setting);

    $name = 'theme_essential_fel'.$themeix.'/marketing' . $marketingspotnumber . 'image';
    $title = get_string('marketingimage', 'theme_essential_fel');
    $description = get_string('marketingimagedesc', 'theme_essential_fel');
    $setting = new admin_setting_configstoredfile($name, $title, $description,
            'marketing' . $marketingspotnumber . 'image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_fel_settingsfrontpage->add($setting);

    $name = 'theme_essential_fel'.$themeix.'/marketing' . $marketingspotnumber . 'content';
    $title = get_string('marketingcontent', 'theme_essential_fel');
    $description = get_string('marketingcontentdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_fel_settingsfrontpage->add($setting);

    $name = 'theme_essential_fel'.$themeix.'/marketing' . $marketingspotnumber . 'buttontext';
    $title = get_string('marketingbuttontext', 'theme_essential_fel');
    $description = get_string('marketingbuttontextdesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_fel_settingsfrontpage->add($setting);

    $name = 'theme_essential_fel'.$themeix.'/marketing' . $marketingspotnumber . 'buttonurl';
    $title = get_string('marketingbuttonurl', 'theme_essential_fel');
    $description = get_string('marketingbuttonurldesc', 'theme_essential_fel');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_fel_settingsfrontpage->add($setting);

    $name = 'theme_essential_fel'.$themeix.'/marketing' . $marketingspotnumber . 'target';
    $title = get_string('marketingurltarget', 'theme_essential_fel');
    $description = get_string('marketingurltargetdesc', 'theme_essential_fel');
    $target1 = get_string('marketingurltargetself', 'theme_essential_fel');
    $target2 = get_string('marketingurltargetnew', 'theme_essential_fel');
    $target3 = get_string('marketingurltargetparent', 'theme_essential_fel');
    $default = '_blank';
    $choices = array('_self' => $target1, '_blank' => $target2, '_parent' => $target3);
    $setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essential_fel_settingsfrontpage->add($setting);
}

// User alerts.
$essential_fel_settingsfrontpage->add(new admin_setting_heading('theme_essential_fel5_alerts',
    get_string('alertsheadingsub', 'theme_essential_fel'),
    format_text(get_string('alertsdesc', 'theme_essential_fel'), FORMAT_MARKDOWN)));

$information = get_string('alertinfodesc', 'theme_essential_fel');

// This is the descriptor for alert one.
$name = 'theme_essential_fel'.$themeix.'/alert1info';
$heading = get_string('alert1', 'theme_essential_fel');
$setting = new admin_setting_heading($name, $heading, $information);
$essential_fel_settingsfrontpage->add($setting);

// Enable alert.
$name = 'theme_essential_fel'.$themeix.'/enable1alert';
$title = get_string('enablealert', 'theme_essential_fel');
$description = get_string('enablealertdesc', 'theme_essential_fel');
$default = false;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsfrontpage->add($setting);

// Alert type.
$name = 'theme_essential_fel'.$themeix.'/alert1type';
$title = get_string('alerttype', 'theme_essential_fel');
$description = get_string('alerttypedesc', 'theme_essential_fel');
$alertinfo = get_string('alert_info', 'theme_essential_fel');
$alertwarning = get_string('alert_warning', 'theme_essential_fel');
$alertgeneral = get_string('alert_general', 'theme_essential_fel');
$default = 'info';
$choices = array('info' => $alertinfo, 'error' => $alertwarning, 'success' => $alertgeneral);
$setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsfrontpage->add($setting);

// Alert title.
$name = 'theme_essential_fel'.$themeix.'/alert1title';
$title = get_string('alerttitle', 'theme_essential_fel');
$description = get_string('alerttitledesc', 'theme_essential_fel');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsfrontpage->add($setting);

// Alert text.
$name = 'theme_essential_fel'.$themeix.'/alert1text';
$title = get_string('alerttext', 'theme_essential_fel');
$description = get_string('alerttextdesc', 'theme_essential_fel');
$default = '';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsfrontpage->add($setting);

// This is the descriptor for alert two.
$name = 'theme_essential_fel'.$themeix.'/alert2info';
$heading = get_string('alert2', 'theme_essential_fel');
$setting = new admin_setting_heading($name, $heading, $information);
$essential_fel_settingsfrontpage->add($setting);

// Enable alert.
$name = 'theme_essential_fel'.$themeix.'/enable2alert';
$title = get_string('enablealert', 'theme_essential_fel');
$description = get_string('enablealertdesc', 'theme_essential_fel');
$default = false;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsfrontpage->add($setting);

// Alert type.
$name = 'theme_essential_fel'.$themeix.'/alert2type';
$title = get_string('alerttype', 'theme_essential_fel');
$description = get_string('alerttypedesc', 'theme_essential_fel');
$alertinfo = get_string('alert_info', 'theme_essential_fel');
$alertwarning = get_string('alert_warning', 'theme_essential_fel');
$alertgeneral = get_string('alert_general', 'theme_essential_fel');
$default = 'info';
$choices = array('info' => $alertinfo, 'error' => $alertwarning, 'success' => $alertgeneral);
$setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsfrontpage->add($setting);

// Alert title.
$name = 'theme_essential_fel'.$themeix.'/alert2title';
$title = get_string('alerttitle', 'theme_essential_fel');
$description = get_string('alerttitledesc', 'theme_essential_fel');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsfrontpage->add($setting);

// Alert text.
$name = 'theme_essential_fel'.$themeix.'/alert2text';
$title = get_string('alerttext', 'theme_essential_fel');
$description = get_string('alerttextdesc', 'theme_essential_fel');
$default = '';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsfrontpage->add($setting);

// This is the descriptor for alert three.
$name = 'theme_essential_fel'.$themeix.'/alert3info';
$heading = get_string('alert3', 'theme_essential_fel');
$setting = new admin_setting_heading($name, $heading, $information);
$essential_fel_settingsfrontpage->add($setting);

// Enable alert.
$name = 'theme_essential_fel'.$themeix.'/enable3alert';
$title = get_string('enablealert', 'theme_essential_fel');
$description = get_string('enablealertdesc', 'theme_essential_fel');
$default = false;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsfrontpage->add($setting);

// Alert type.
$name = 'theme_essential_fel'.$themeix.'/alert3type';
$title = get_string('alerttype', 'theme_essential_fel');
$description = get_string('alerttypedesc', 'theme_essential_fel');
$alertinfo = get_string('alert_info', 'theme_essential_fel');
$alertwarning = get_string('alert_warning', 'theme_essential_fel');
$alertgeneral = get_string('alert_general', 'theme_essential_fel');
$default = 'info';
$choices = array('info' => $alertinfo, 'error' => $alertwarning, 'success' => $alertgeneral);
$setting = new essential_fel_admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsfrontpage->add($setting);

// Alert title.
$name = 'theme_essential_fel'.$themeix.'/alert3title';
$title = get_string('alerttitle', 'theme_essential_fel');
$description = get_string('alerttitledesc', 'theme_essential_fel');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsfrontpage->add($setting);

// Alert text.
$name = 'theme_essential_fel'.$themeix.'/alert3text';
$title = get_string('alerttext', 'theme_essential_fel');
$description = get_string('alerttextdesc', 'theme_essential_fel');
$default = '';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$essential_fel_settingsfrontpage->add($setting);

$essential_fel_settingsfrontpage->add(new admin_setting_heading('theme_essential_fel5_frontpagereadme',
    get_string('readme_title', 'theme_essential_fel'), get_string('readme_desc', 'theme_essential_fel', array('url' => $readme))));
