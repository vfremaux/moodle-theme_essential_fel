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
 * Defines renderer for course format flexsections
 *
 * @package    format_flexsections
 * @copyright  2012 Marina Glancy
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot.'/course/format/flexsections/renderer.php');

/**
 * Renderer for flexsections format.
 *
 * @copyright 2012 Marina Glancy
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class theme_essential_fel_format_flexsections_renderer extends format_flexsections_renderer {
    /** @var core_course_renderer Stores instances of core_course_renderer */
    protected $courserenderer = null;

    public $availablestyles;

    /**
     * Current theme config.
     */
    protected $config;

    public function __construct(moodle_page $page, $target) {
        global $PAGE, $COURSE;

        parent::__construct($page, $target);
        static $initialized = false;

        $this->config = get_config('theme_essential_fel');
        $this->availablestyles = $this->parse_styleconfig();

        if (!$initialized) {
            if ($PAGE->user_is_editing()) {
                $PAGE->requires->js_call_amd('theme_essential_fel/flex_section_control', 'init_editing', array($COURSE->id));
            } else {
                $PAGE->requires->js_call_amd('theme_essential_fel/flex_section_control', 'init', array($COURSE->id));
            }
            $initialized = true;
        }
    }

    /**
     * Display section and all its activities and subsections (called recursively)
     *
     * @param int|stdClass $course
     * @param int|section_info $section
     * @param int $sr section to return to (for building links)
     * @param int $level nested level on the page (in case of 0 also displays additional start/end html code)
     */
    public function display_section($course, $section, $sr, $level = 0) {
        global $PAGE, $USER, $DB, $CFG;
        static $userstates;

        if (!isset($userstates)) {
            // Fills the cache of user states at first section called.

            /*
             * If user's preferences never initialized, then hide final leaves and show 
             * everything else
             */
            $params = array('userid' => $USER->id, 'name' => 'flexsection_initialized_'.$course->id);
            if (!$DB->record_exists('user_preferences', $params)) {
                require_once($CFG->dirroot.'/theme/'.$PAGE->theme->name.'/flexsections/flexlib.php');

                $select = " name LIKE 'flexsection%' AND userid = ? AND value = ? ";
                $DB->delete_records_select('user_preferences', $select, array($USER->id, $course->id));

                $leaves = flexsection_get_leaves($course->id);
                if ($leaves) {
                    foreach ($leaves as $leaf) {
                        $hidekey = 'flexsection_'.$leaf->id.'_hidden';
                        $newrec = new StdClass;
                        $newrec->userid = $USER->id;
                        $newrec->name = $hidekey;
                        $newrec->value = $course->id;
                        $DB->insert_record('user_preferences', $newrec);
                    }
                }

                // Mark the course as initialized for the user.
                $newrec = new StdClass;
                $newrec->userid = $USER->id;
                $newrec->name = 'flexsection_initialized_'.$course->id;
                $newrec->value = 1;
                $DB->insert_record('user_preferences', $newrec);
            }

            // Request is optimised to the current course scope, using preference value.
            $select = ' userid = :userid AND '.$DB->sql_like('name', ':prefname').' AND value = :value ';
            $params = array('userid' => $USER->id, 'prefname' => 'flexsection\\_%\\_hidden', 'value' => $course->id);
            $flexprefs = $DB->get_records_select('user_preferences', $select, $params);
            if ($flexprefs) {
                foreach ($flexprefs as $prf) {
                    $name = str_replace('flexsection_', '', $prf->name);
                    $name = str_replace('_hidden', '', $name);
                    $userstates[$name] = $prf->value;
                }
            }
        }

        // Get available section style overrides from config.
        $availablestyles = $this->parse_styleconfig();

        $course = course_get_format($course)->get_course();
        $section = course_get_format($course)->get_section($section); // This converts $section from int to object.
        $context = context_course::instance($course->id);
        $contentvisible = true;

        $highlight = false;
        $tosection = $tosection = optional_param('tosection', false, PARAM_INT);
        if ($tosection) {
            // When specifying a 'tosection' argument, we will open the path down to this section.
             if ($section->section == $tosection) {
                $highlight = 'highlight';
                // We are the happy candidate.
                $sectiontoopen = clone($section);
                while ($sectiontoopen->parent) {
                    $userstates[$sectiontoopen->id] = FORMAT_FLEXSECTIONS_EXPANDED;
                    $hidekey = 'flexsection_'.$sectiontoopen->id.'_hidden';
                    $DB->delete_records('user_preferences', array('userid' => $USER->id, 'name' => $hidekey));
                    $sectiontoopen = course_get_format($course)->get_section($sectiontoopen->parent);
                }
                // Open top level.
                $userstates[$sectiontoopen->id] = FORMAT_FLEXSECTIONS_EXPANDED;
                $hidekey = 'flexsection_'.$sectiontoopen->id.'_hidden';
                $DB->delete_records('user_preferences', array('userid' => $USER->id, 'name' => $hidekey));
             }
        }

        if (!$section->uservisible || !course_get_format($course)->is_section_real_available($section)) {
            if ($section->visible && !$section->available && $section->availableinfo) {
                // Still display section but without content.
                $contentvisible = false;
            } else {
                return '';
            }
        }

        if ($section->section == 0) {
            // General section is always visible.
            $contentvisible = true;
        }

        $sectionnum = $section->section;
        $movingsection = course_get_format($course)->is_moving_section();

        if ($level === 0) {
            $cancelmovingcontrols = course_get_format($course)->get_edit_controls_cancelmoving();

            foreach ($cancelmovingcontrols as $control) {
                echo $this->render($control);
            }

            echo html_writer::start_tag('ul', array('class' => 'flexsections flexsections-level-0'));

            if ($section->section) {
                $this->display_insert_section_here($course, $section->parent, $section->section, $sr);
            }
        }

        $children = course_get_format($course)->get_subsections($sectionnum);
        $isleafclass = (!empty($children)) ? 'isleaf' : '';

        echo html_writer::start_tag('li',
                array('class' => "section main $isleafclass".
                    ($movingsection === $sectionnum ? ' ismoving' : '').
                    (course_get_format($course)->is_section_current($section) ? ' current' : '').
                    (($section->visible && $contentvisible) ? '' : ' hidden'),
                    'id' => 'section-'.$sectionnum));

        // Display controls except for expanded/collapsed.
        $controls = course_get_format($course)->get_section_edit_controls($section, $sr);

        // Theme adds style related additional attribute in format.
        if (!empty($this->availablestyles) && ($section->section > 0) && $PAGE->user_is_editing()) {
            if (has_capability('moodle/course:update', $context)) {
                $contentclassurl = new moodle_url('/theme/'.$PAGE->theme->name.'/flexsections/flexsectionclass.php', array('id' => $section->id, 'sr' => $sr));
                $text = new lang_string('chooseclass', 'theme_'.$PAGE->theme->name);
                $controls[] = new format_flexsections_edit_control('contentclass', $contentclassurl, $text);
            }
        }

        // Theme adds activitynames hiding control.
        if (has_capability('moodle/course:update', $context)) {
            if (!empty($section->hideactivitynames)) {
                $params = array('id' => $section->id, 'sr' => $sr, 'what' => 'showactivitynames');
                $switchurl = new moodle_url('/theme/'.$PAGE->theme->name.'/flexsections/switchactivitynames.php', $params);
                $text = new lang_string('showactivitynames', 'theme_'.$PAGE->theme->name);
                $controls[] = new format_flexsections_edit_control('hideactivitynames', $switchurl, $text);
            } else {
                $params = array('id' => $section->id, 'sr' => $sr, 'what' => 'hideactivitynames');
                $switchurl = new moodle_url('/theme/'.$PAGE->theme->name.'/flexsections/switchactivitynames.php', $params);
                $text = new lang_string('hideactivitynames', 'theme_'.$PAGE->theme->name);
                $controls[] = new format_flexsections_edit_control('hideactivitynames', $switchurl, $text);
            }
        }

        $collapsedcontrol = null;
        // Override add expand// collapse control for all users.
        if (@$userstates[$section->id] == FORMAT_FLEXSECTIONS_EXPANDED) {
            $text = new lang_string('showcollapsed', 'format_flexsections');
            $class = 'expanded flexcontrol level-'.$level;
            $src = $this->output->pix_url('t/expanded');
        } else {
            $text = new lang_string('showexpanded', 'format_flexsections');
            $class = 'collapsed flexcontrol level-'.$level;
            $src = $this->output->pix_url('t/collapsed');
        }
        $attrs = array('src' => $src,
                       'class' => $class,
                       'title' => $text,
                       'id' => 'control-'.$section->id.'-section-'.$section->section);
        $collapsedcontrol = html_writer::tag('img', '', $attrs);
        $hiddenvar = @$userstates[$section->id];

        $controlsstr = '';
        foreach ($controls as $idxcontrol => $control) {
            if ($control->class === 'expanded' || $control->class === 'collapsed') {
                // Ignore old collapse control mode.
                // $collapsedcontrol = $control;
            } else {
                $controlsstr .= $this->render($control);
            }
        }

        if (!empty($controlsstr)) {
            echo html_writer::tag('div', $controlsstr, array('class' => 'controls'));
        }

        // Display section content.
        echo html_writer::start_tag('div', array('class' => 'content '.$highlight));

        // Display section name and expanded/collapsed control.
        if ($sectionnum && ($title = $this->section_title($sectionnum, $course, true))) {
            if (is_object($collapsedcontrol)) {
                $title = $this->render($collapsedcontrol). $title;
            } else {
                $title = $collapsedcontrol.$title;
            }

            $attrs = array('class' => 'sectionname');

            // Check section style overrides.
            if ($this->availablestyles) {
                $this->add_custom_style($attrs, $section);
            }

            echo html_writer::tag('h3', $title, $attrs);
        }

        // Display section availability.
        echo $this->section_availability_message($section,
            has_capability('moodle/course:viewhiddensections', $context));

        // Display section description (if needed).
        if ($contentvisible && ($summary = $this->format_summary_text($section))) {
            echo html_writer::tag('div', $summary, array('class' => 'summary'));
        } else {
            echo html_writer::tag('div', '', array('class' => 'summary nosummary'));
        }

        // Display section contents (activities and subsections).
        if ($contentvisible) {

            // Display resources and activities.
            $attrs = array('class' => 'section-content');
            if ($hiddenvar) {
                $attrs['style'] = 'display:none';
            }
            echo html_writer::start_tag('div', $attrs);
            echo $this->courserenderer->course_section_cm_list($course, $section, $sr);

            if ($PAGE->user_is_editing()) {
                // a little hack to allow use drag&drop for moving activities if the section is empty
                if (empty(get_fast_modinfo($course)->sections[$sectionnum])) {
                    echo "<ul class=\"section img-text\">\n</ul>\n";
                }
                echo $this->courserenderer->course_section_add_cm_control($course, $sectionnum, $sr);
            }
            echo html_writer::end_tag('div');

            // Display subsections.
            if (!empty($children) || $movingsection) {

                if ($level == 0) {
                    // Display collapse/expand/init buttons.
                    echo $this->globalcontrols();
                }

                $attrs = array('class' => 'flexsections flexsections-level-'.($level+1));
                if ($hiddenvar && $section->section) {
                    $attrs['style'] = 'display:none';
                }

                echo html_writer::start_tag('ul', $attrs);

                foreach ($children as $num) {
                    $this->display_insert_section_here($course, $section, $num, $sr);
                    $this->display_section($course, $num, $sr, $level+1);
                }
                $this->display_insert_section_here($course, $section, null, $sr);
                echo html_writer::end_tag('ul'); // .flexsections
            }
            if ($addsectioncontrol = course_get_format($course)->get_add_section_control($sectionnum)) {
                echo $this->render($addsectioncontrol);
            }

        }
        echo html_writer::end_tag('div'); // .content
        echo html_writer::end_tag('li'); // .section
        if ($level === 0) {
            if (!$section->section) {
                // This is when moving.
                $this->display_insert_section_here($course, $section->parent, null, $sr);
            }
            echo html_writer::end_tag('ul'); // .flexsections
        }
    }

    public function add_custom_style(&$attrs, &$section) {
        global $DB;

        $availableconfigs = $this->availablestyles['configs'];
        $styleoverride = $DB->get_field('course_format_options', 'value', array('sectionid' => $section->id, 'name' => 'styleoverride'));
        if ($styleoverride) {
            if (array_key_exists($styleoverride, $availableconfigs)) {
                $styletoapply = $availableconfigs[$styleoverride];
                if (preg_match('/^\\{(.*)\\}/', $styletoapply, $matches)) {
                    // If is a real style rule, apply as style attrribute.
                    $attrs['style'] = $matches[1];
                } else {
                    $attrs['class'] .= ' '.$styletoapply;
                }
            }
        }
    }

    protected function globalcontrols() {

        $str = '';

        $params = array('type' => 'button',
                        'class' => 'btn flexsection-global-control',
                        'id' => 'flexsections-control-collapseall',
                        'value' => get_string('collapseall', 'theme_essential_fel'));
        $str .= html_writer::tag('input', '', $params);

        $params = array('type' => 'button',
                        'class' => 'btn flexsection-global-control',
                        'id' => 'flexsections-control-expandall',
                        'value' => get_string('expandall', 'theme_essential_fel'));
        $str .= html_writer::tag('input', '', $params);

        $params = array('type' => 'button',
                        'class' => 'btn flexsection-global-control',
                        'id' => 'flexsections-control-reset',
                        'value' => get_string('reset', 'theme_essential_fel'));
        $str .= html_writer::tag('input', '', $params);

        return $str;
    }

    /**
     * renders HTML for format_flexsections_edit_control
     *
     * @param format_flexsections_edit_control $control
     * @return string
     */
    protected function render_format_flexsections_edit_control(format_flexsections_edit_control $control) {
        if (!$control) {
            return '';
        }

        if ($control->class === 'contentclass') {
            $icon = new pix_icon('contentclass', $control->text, 'format_flexsections', array('class' => 'iconsmall', 'title' => $control->text));
            $action = new action_link($control->url, $icon, null, array('class' => $control->class));
            return $this->render($action);
        }

        return parent::render_format_flexsections_edit_control($control);
    }

    /**
     * Parses the theme configuration flexsectionstyles setting and
     * extracts usable style information for section headings.
     *
     * admitted syntax are : 
     * <stylename>:<stylelabel>:<stylerule>
     * 
     * stylerule can be a class name, or a {<cssrulelist>} real css fragment.
     */
    public function parse_styleconfig() {
        if (!empty($this->config->flexsectionsstyles)) {
            $rules = explode("\n", $this->config->flexsectionsstyles);
            foreach ($rules as $r) {
                if (preg_match('/^(#|\\/)/', $r)) {
                    // Ignore commented line.
                    continue;
                }
                if (preg_match('/^[\\s]*$/', $r)) {
                    // Ignore empty or only space lines.
                    continue;
                }
                if (preg_match('/^(.*?):(.*?):(.*)$/', $r, $matches)) {
                    $styleconfigs[$matches[1]] = $matches[3];
                    $stylelabels[$matches[1]] = $matches[2];
                }
            }
            return array('configs' => $styleconfigs, 'labels' => $stylelabels);
        }

        return array('configs' => array(), 'labels' => array());
    }

}