<?php
/**
 * Page Theme
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see http://opensource.org/licenses/gpl-3.0.html.
 *
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @package theme_page
 * @reauthor Valery Fremaux
 * @author Mark Nielsen
 */

require_once $CFG->dirroot.'/course/format/page/renderers.php';

/**
 * Page Layout File
 *
 * @author Valery Fremaux
 * @package theme_page
 */

/// SPECIAL PAGE LAYOUT INITIALISATION

/**
 * page local library
 * @see format_page_default_width_styles
 */
 
?>
<!-- STANDARD THEME HEADER PART 
The following part should be removed and replaced by the header section of the actual theme
-->

<?php
$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));
$hasheader = (empty($PAGE->layout_options['noheader']));

$hassidepre = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-pre', $OUTPUT));
$hassidepost = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-post', $OUTPUT));

$hasfooterleft = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('footer-left', $OUTPUT));
$hasfootermiddle = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('footer-middle', $OUTPUT));
$hasfooterright = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('footer-right', $OUTPUT));

$showsidepre = ($hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT));
$showsidepost = ($hassidepost && !$PAGE->blocks->region_completely_docked('side-post', $OUTPUT));

$showfooterleft = ($hasfooterleft && !$PAGE->blocks->region_completely_docked('footer-left', $OUTPUT));
$showfootermiddle = ($hasfootermiddle && !$PAGE->blocks->region_completely_docked('footer-middle', $OUTPUT));
$showfooterright = ($hasfooterright && !$PAGE->blocks->region_completely_docked('footer-right', $OUTPUT));
$hasboringlayout = (empty($PAGE->theme->settings->layout)) ? false : $PAGE->theme->settings->layout;

// If there can be a sidepost region on this page and we are editing, always
// show it so blocks can be dragged into it.
if ($PAGE->user_is_editing()) {
    if ($PAGE->blocks->is_known_region('side-pre')) {
        $showsidepre = true;
    }
    if ($PAGE->blocks->is_known_region('side-post')) {
        $showsidepost = true;
    }
}

$haslogo = (!empty($PAGE->theme->settings->logo));

$hasfootnote = (!empty($PAGE->theme->settings->footnote));
$custommenu = $OUTPUT->custom_menu();
$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));

$courseheader = $coursecontentheader = $coursecontentfooter = $coursefooter = '';

if (empty($PAGE->layout_options['nocourseheaderfooter'])) {
    $courseheader = $OUTPUT->course_header();
    $coursecontentheader = $OUTPUT->course_content_header();
    if (empty($PAGE->layout_options['nocoursefooter'])) {
        $coursecontentfooter = $OUTPUT->course_content_footer();
        $coursefooter = $OUTPUT->course_footer();
    }
}

$layout = 'pre-and-post';
if ($showsidepre && !$showsidepost) {
    if (!right_to_left()) {
        $layout = 'side-pre-only';
    } else {
        $layout = 'side-post-only';
    }
} else if ($showsidepost && !$showsidepre) {
    if (!right_to_left()) {
        $layout = 'side-post-only';
    } else {
        $layout = 'side-pre-only';
    }
} else if (!$showsidepost && !$showsidepre) {
    $layout = 'content-only';
}
$bodyclasses[] = $layout;

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $PAGE->title ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google web fonts -->
    <link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic' rel='stylesheet' type='text/css'>

    <?php
    require_once($CFG->dirroot.'/auth/scormbridge/lib.php');
    echo scormbridge_hook_theme_scorm_score_passing();
    ?>

</head>

<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses)) ?>">

<?php 
local_print_administrator_message();
echo $OUTPUT->standard_top_of_body_html(); 
?>

<div id="page-wrapper">
<div id="page-wrapper-2">

<?php 
if ($hasheader) {
    include('header.php');
}
?>

<?php 
if ($hasnavbar) {
?>
<header role="banner" class="navbar">
    <nav role="navigation" class="navbar-inner">
        <div class="container-fluid">
            <a class="brand" href="<?php echo $CFG->wwwroot;?>"><i class="icon-home"></i>&nbsp;<?php print_string('home'); ?></a>
            <a class="btn btn-navbar" data-toggle="workaround-collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="nav-collapse collapse">
            <?php if ($hascustommenu) {
                echo $custommenu;
            } ?>
            <ul class="nav pull-right">
            <li><?php echo $PAGE->headingmenu ?></li>
            <li class="navbar-text"><?php echo $OUTPUT->login_info() ?></li>
            <li class="navbutton"><?php echo $PAGE->button ?></li>
            </ul>
            </div>
        </div>
    </nav>
</header>
<?php 
}
?>
<!-- END OF HEADER -->
<!-- START CUSTOMMENU AND NAVBAR -->
<!-- END OF CUSTOMMENU AND NAVBAR -->
<!-- page content -->
    <div id="format-page-content" class="format-page-content container-fluid">
        <!-- EVERYTHING HERE IS DEFERRED TO format.php OF THE COURSE FORMAT -->
        <?php echo $OUTPUT->main_content(); ?>
    </div>
<!-- START OF FOOTER -->
<?php 
if ($hasfooter) {
?>
<footer id="page-footer" class="container-fluid">
            <?php require('footer.php'); ?>
</footer>
<?php
}
?>

</div>
</div>

<?php echo $OUTPUT->standard_footer_html(); ?>

<?php echo $OUTPUT->standard_end_of_body_html() ?>

</body>
</html>
