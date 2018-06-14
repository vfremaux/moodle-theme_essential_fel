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

require_once($CFG->dirroot.'/theme/essential_fel/classes/toolbox.php');

class theme_essential_fel_core_course_renderer extends core_course_renderer {

    protected $enablecategoryicon;

    protected $thumbfiles;

    public function __construct(moodle_page $page, $target) {
        static $theme;

        parent::__construct($page, $target);

        if (empty($theme)) {
            $theme = theme_config::load('essential_fel');
        }

        $this->enablecategoryicon = $this->local_get_setting('enablecategoryicon');
    }

    protected function local_get_setting($setting, $format = '') {
        return \theme_essential_fel\toolbox::get_setting($setting, $format);
    }

    /**
     * Returns HTML to display a course category as a part of a tree
     *
     * This is an internal function, to display a particular category and all its contents
     * use {@link core_course_renderer::course_category()}
     *
     * @param coursecat_helper $chelper various display options
     * @param coursecat $coursecat
     * @param int $depth depth of this category in the current tree
     * @return string
     */
    protected function coursecat_category(coursecat_helper $chelper, $coursecat, $depth) {
        if (!$this->enablecategoryicon) {
            return parent::coursecat_category($chelper, $coursecat, $depth);
        }
        global $CFG;
        // Open category tag.
        $classes = array('category');
        if (empty($coursecat->visible)) {
            $classes[] = 'dimmed_category';
        }
        if ($chelper->get_subcat_depth() > 0 && $depth >= $chelper->get_subcat_depth()) {
            // Do not load content.
            $categorycontent = '';
            $classes[] = 'notloaded';
            if ($coursecat->get_children_count() ||
                ($chelper->get_show_courses() >= self::COURSECAT_SHOW_COURSES_COLLAPSED && $coursecat->get_courses_count())
            ) {
                $classes[] = 'with_children';
                $classes[] = 'collapsed';
            }
        } else {
            // Load category content.
            $categorycontent = $this->coursecat_category_content($chelper, $coursecat, $depth);
            $classes[] = 'loaded';
            if (!empty($categorycontent)) {
                $classes[] = 'with_children';
            }
        }
        $classes[] = 'essential_felcats';

        if (intval($CFG->version) >= 2013111800) {
            // Make sure JS file to expand category content is included.
            $this->coursecat_include_js();
        }

        $content = html_writer::start_tag('div', array(
            'class' => join(' ', $classes),
            'data-categoryid' => $coursecat->id,
            'data-depth' => $depth,
            'data-showcourses' => $chelper->get_show_courses(),
            'data-type' => self::COURSECAT_TYPE_CATEGORY,
        ));

        $coursescount = $coursecat->get_courses_count();
        if ($coursecat->get_children_count()) {
            $childcoursescount = $this->get_children_courses_count($coursecat);
            $coursescount = $coursescount.' - '.$childcoursescount;
            $coursecounttitle = get_string('numberofcoursesandsubcatcourses', 'theme_essential_fel');
        } else {
            $coursecounttitle = get_string('numberofcourses');
        }
        $content .= html_writer::tag('span', $coursescount,
            array('title' => $coursecounttitle, 'class' => 'numberofcourse'));

        // Category name.
        $categoryname = html_writer::tag('span', $coursecat->get_formatted_name());

        // Do a settings check to output our icon for the category.
        if ($this->local_get_setting('enablecategoryicon')) {
            $customcategoryicon = $this->local_get_setting('categoryicon'.$coursecat->id);
            if ($customcategoryicon &&
                $this->local_get_setting('enablecustomcategoryicon')) {
                // User has set a value for the category.
                $val = $customcategoryicon;
            } else {
                // User hasn't set a value for the category, get the default.
                $val = $this->local_get_setting('defaultcategoryicon');
            }
        }
        if (!empty($val)) {
            $icon = html_writer::tag('span', '', array('aria-hidden' => 'true', 'class' => 'fa fa-'.$val));
        } else {
            $icon = '';
        }

        $categoryname = html_writer::link(new moodle_url('/course/index.php',
                array('categoryid' => $coursecat->id)),
            $icon . $categoryname);
        $content .= html_writer::start_tag('div', array('class' => 'info'));

        $content .= html_writer::tag(($depth > 1) ? 'h4' : 'h3', $categoryname, array('class' => 'categoryname'));
        $content .= html_writer::end_tag('div'); // Class .info.

        // Add category content to the output.
        $content .= html_writer::tag('div', $categorycontent, array('class' => 'content'));

        $content .= html_writer::end_tag('div'); // Class .category.
        return $content;
    }

    /**
     * Returns the number of courses in the category and sub-categories.
     *
     * @param coursecat $coursecat
     * @return int Count of courses
     */
    protected function get_children_courses_count($coursecat) {
        $childcoursescount = 0;
        $coursecatchildren = $coursecat->get_children();
        foreach ($coursecatchildren as $coursecatchild) {
            $childcoursescount += $coursecatchild->get_courses_count();
            if ($coursecatchild->get_children_count()) {
                $childcoursescount += $this->get_children_courses_count($coursecatchild);
            }
        }
        return $childcoursescount;
    }

    /**
     * Returns HTML to display course content (summary, course contacts and optionally category name)
     *
     * This method is called from coursecat_coursebox() and may be re-used in AJAX
     *
     * @param coursecat_helper $chelper various display options
     * @param stdClass|course_in_list $course
     * @return string
     */
    protected function coursecat_coursebox_content(coursecat_helper $chelper, $course) {
        if (!$this->enablecategoryicon) {
            return parent::coursecat_coursebox_content($chelper, $course);
        }
        global $CFG;
        if ($chelper->get_show_courses() < self::COURSECAT_SHOW_COURSES_EXPANDED) {
            return '';
        }
        if ($course instanceof stdClass) {
            require_once($CFG->libdir. '/coursecatlib.php');
            $course = new course_in_list($course);
        }
        $content = '';

        $coursehassummary = $course->has_summary();
        $coursehascontacts = $course->has_course_contacts();
        $courseoverviewfiles = $course->get_course_overviewfiles();
        // Display course summary.
        if ($coursehassummary) {
            $summaryclass = 'summary';
            if (($coursehascontacts == false) && (empty($courseoverviewfiles))) {
                $summaryclass .= ' fullsummarywidth';
            }
            if (!$course->visible) {
                $summaryclass .= ' dimmed';
            }
            $content .= html_writer::start_tag('div', array('class' => $summaryclass));
            $content .= $chelper->get_course_formatted_summary($course,
                    array('overflowdiv' => true, 'noclean' => true, 'para' => false));
            $content .= html_writer::end_tag('div'); // Class .summary.
        }

        // Display course overview files.
        $contentimages = $contentfiles = '';
        foreach ($courseoverviewfiles as $file) {
            $isimage = $file->is_valid_image();
            $url = file_encode_url("$CFG->wwwroot/pluginfile.php",
                    '/'. $file->get_contextid(). '/'. $file->get_component(). '/'.
                    $file->get_filearea(). $file->get_filepath(). $file->get_filename(), !$isimage);
            if ($isimage) {
                $contentimages .= html_writer::tag('div',
                        html_writer::empty_tag('img', array('src' => $url)),
                        array('class' => 'courseimage'));
            } else {
                $image = $this->output->pix_icon(file_file_icon($file, 24), $file->get_filename(), 'moodle');
                $filename = html_writer::tag('span', $image, array('class' => 'fp-icon')).
                        html_writer::tag('span', $file->get_filename(), array('class' => 'fp-filename'));
                $contentfiles .= html_writer::tag('span',
                        html_writer::link($url, $filename),
                        array('class' => 'coursefile fp-filename-icon'));
            }
        }
        $content .= $contentimages. $contentfiles;

        // Display course contacts.  See course_in_list::get_course_contacts().
        if ($coursehascontacts) {
            $teacherclass = 'teachers';
            if (!$course->visible) {
                $teacherclass .= ' dimmed';
            }
            if ((!empty($courseoverviewfiles)) && (!$coursehassummary)) {
                $teacherclass .= ' courseboxright';
            } else if ((empty($courseoverviewfiles)) && (!$coursehassummary)) {
                $teacherclass .= ' fullsummarywidth';
            } else if ((!empty($courseoverviewfiles)) && ($coursehassummary)) {
                $teacherclass .= ' fullsummarywidth';
            }
            $content .= html_writer::start_tag('ul', array('class' => $teacherclass));
            $teacherlinkattributes = array();
            if (!$course->visible) {
                $teacherlinkattributes['class'] = 'dimmed';
            }
            foreach ($course->get_course_contacts() as $userid => $coursecontact) {
                $faiconsetting = $this->local_get_setting('courselistteachericon');
                $faiconsettinghtml = (empty($faiconsetting)) ? '' : '<span aria-hidden="true" class="fa fa-'.
                    $faiconsetting.'"></span> ';
                $name = $faiconsettinghtml.$coursecontact['rolename'].': '.
                        html_writer::link(new moodle_url('/user/view.php',
                                array('id' => $userid, 'course' => SITEID)),
                            $coursecontact['username'], $teacherlinkattributes);
                $content .= html_writer::tag('li', $name);
            }
            $content .= html_writer::end_tag('ul'); // Class .teachers.
        }

        // Display course category if necessary (for example in search results).
        if ($chelper->get_show_courses() == self::COURSECAT_SHOW_COURSES_EXPANDED_WITH_CAT) {
            require_once($CFG->libdir. '/coursecatlib.php');
            if ($cat = coursecat::get($course->category, IGNORE_MISSING)) {
                $content .= html_writer::start_tag('div', array('class' => 'coursecat'));
                $content .= get_string('category').': '.
                        html_writer::link(new moodle_url('/course/index.php', array('categoryid' => $cat->id)),
                                $cat->get_formatted_name(), array('class' => $cat->visible ? '' : 'dimmed'));
                $content .= html_writer::end_tag('div'); // Class .coursecat.
            }
        }

        return $content;
    }

    /**
     * Serves requests to /theme/essential_fel/inspector.ajax.php
     *
     * @param string $term search term.
     * @return array of results.
     * @throws coding_exception
     */
    public function inspector_ajax($term) {
        global $USER;

        $data = array();

        $courses = enrol_get_my_courses();
        $site = get_site();

        if (array_key_exists($site->id, $courses)) {
            unset($courses[$site->id]);
        }

        foreach ($courses as $c) {
            if (isset($USER->lastcourseaccess[$c->id])) {
                $courses[$c->id]->lastaccess = $USER->lastcourseaccess[$c->id];
            } else {
                $courses[$c->id]->lastaccess = 0;
            }
        }

        // Get remote courses.
        $remotecourses = array();
        if (is_enabled_auth('mnet')) {
            $remotecourses = get_my_remotecourses();
        }
        // Remote courses will have -ve remoteid as key, so it can be differentiated from normal courses.
        foreach ($remotecourses as $id => $val) {
            $remoteid = $val->remoteid * -1;
            $val->id = $remoteid;
            $courses[$remoteid] = $val;
        }

        foreach ($courses as $course) {
            $modinfo = get_fast_modinfo($course);
            $courseformat = course_get_format($course->id);
            $course = $courseformat->get_course();
            $courseformatsettings = $courseformat->get_format_options();
            $sesskey = sesskey();

            foreach ($modinfo->get_section_info_all() as $section => $thissection) {
                if (!$thissection->uservisible) {
                    continue;
                }
                if (is_object($thissection)) {
                    $thissection = $modinfo->get_section_info($thissection->section);
                } else {
                    $thissection = $modinfo->get_section_info($thissection);
                }
                if ((string) $thissection->name !== '') {
                    $sectionname = format_string($thissection->name, true,
                        array('context' => context_course::instance($course->id)));
                } else {
                    $sectionname = $courseformat->get_section_name($thissection->section);
                }
                if ($thissection->section <= $course->numsections) {
                    // Do not link 'orphaned' sections.
                    $courseurl = new moodle_url('/course/view.php');
                    $courseurl->param('id', $course->id);
                    $courseurl->param('sesskey', $sesskey);
                    if ((!empty($courseformatsettings['coursedisplay'])) &&
                        ($courseformatsettings['coursedisplay'] == COURSE_DISPLAY_MULTIPAGE)) {
                        $courseurl->param('section', $thissection->section);
                        $coursehref = $courseurl->out(false);
                    } else {
                        $coursehref = $courseurl->out(false).'#section-'.$thissection->section;
                    }
                    $label = $course->fullname.' - '.$sectionname;
                    if (stristr($label, $term)) {
                        $data[] = array('id' => $coursehref, 'label' => $label, 'value' => $label);
                    }
                }
                if (!empty($modinfo->sections[$thissection->section])) {
                    foreach ($modinfo->sections[$thissection->section] as $modnumber) {
                        $mod = $modinfo->cms[$modnumber];
                        if (!empty($mod->url)) {
                            $instancename = $mod->get_formatted_name();
                            $label = $course->fullname.' - '.$sectionname.' - '.$instancename;
                            if (stristr($label, $term)) {
                                $data[] = array('id' => $mod->url->out(false), 'label' => $label, 'value' => $label);
                            }
                        }
                    }
                }
            }
        }

        return $data;
    }

    /**
     * Renders html to display a name with the link to the course module on a course page
     *
     * If module is unavailable for user but still needs to be displayed
     * in the list, just the name is returned without a link
     *
     * Note, that for course modules that never have separate pages (i.e. labels)
     * this function return an empty string
     *
     * @param cm_info $mod
     * @param array $displayoptions
     * @return string
     */
    public function course_section_cm_name(cm_info $mod, $displayoptions = array()) {
        if ((!$mod->uservisible && empty($mod->availableinfo)) || !$mod->url) {
            // Nothing to be displayed to the user.
            return '';
        }

        // Render element that allows to edit activity name inline. It calls {@link course_section_cm_name_title()}
        // to get the display title of the activity.
        $tmpl = new \core_course\output\course_module_name($mod, $this->page->user_is_editing(), $displayoptions);
        $cmname = $this->output->render_from_template('core/inplace_editable', $tmpl->export_for_template($this->output));

        return $cmname;
    }

    public function course_section_cm_name_for_thumb($mod) {

        // Accessibility: for files get description via icon, this is very ugly hack!

        $instancename = $mod->get_formatted_name();
        $altname = $mod->modfullname;
        /*
         * Avoid unnecessary duplication: if e.g. a forum name already
         * includes the word forum (or Forum, etc) then it is unhelpful
         * to include that in the accessible description that is added.
         */
        if (false !== strpos(core_text::strtolower($instancename),
                core_text::strtolower($altname))) {
            $altname = '';
        }
        // File type after name, for alphabetic lists (screen reader).
        if ($altname) {
            $altname = get_accesshide(' '.$altname);
        }

        $linkclasses = '';
        $accesstext = '';
        $textclasses = '';
        if ($mod->uservisible) {
            $conditionalhidden = $this->is_cm_conditionally_hidden($mod);
            $accessiblebutdim = (!$mod->visible || $conditionalhidden) &&
                has_capability('moodle/course:viewhiddenactivities', $mod->context);
            if ($accessiblebutdim) {
                $linkclasses .= ' dimmed';
                $textclasses .= ' dimmed_text';
                if ($conditionalhidden) {
                    $linkclasses .= ' conditionalhidden';
                    $textclasses .= ' conditionalhidden';
                }
                // Show accessibility note only if user can access the module himself.
                $accesstext = get_accesshide(get_string('hiddenfromstudents').':'. $mod->modfullname);
            }
        } else {
            $linkclasses .= ' dimmed';
            $textclasses .= ' dimmed_text';
        }

        // Get on-click attribute value if specified and decode the onclick - it
        // has already been encoded for display (puke).
        $onclick = htmlspecialchars_decode($mod->onclick, ENT_QUOTES);

        $groupinglabel = $mod->get_grouping_label($textclasses);

        // Display link itself.
        $cmname = $accesstext.html_writer::tag('span', $instancename . $altname, array('class' => 'instancename'));
        if ($mod->uservisible) {
            $cmoutput = html_writer::link($mod->url, $cmname, array('class' => $linkclasses, 'onclick' => $onclick)).$groupinglabel;
        } else {
            // We may be displaying this just in order to show information
            // about visibility, without the actual link ($mod->uservisible)
            $cmoutput = html_writer::tag('div', $cmname, array('class' => $textclasses)).$groupinglabel;
        }
        return $cmoutput;
    }

    public function course_section_cm_thumb($mod) {
        global $DB, $COURSE, $PAGE;

        $cmoutput = '';

        // Check existance of module thumb image in the description.
        $fs = get_file_storage();

        $files = $fs->get_area_files($mod->context->id, 'mod_'.$mod->modname, 'modthumb', $mod->id, 'filepath,filename', true);
        if (!empty($files)) {
            $file = array_pop($files);
        }

        if (!empty($file)) {

            $this->thumbfiles[$mod->id] = $file;
            $url = $mod->url;

            if ($COURSE->format == 'page') {
                /*
                 * Divert the resource call to the special page format file wrapper.
                 * Do not change any other thing. The special file wrapper will know how
                 * to get the origin component identity back.
                 */
                $imgurl = moodle_url::make_pluginfile_url($file->get_contextid(), 'format_page',
                                                          $file->get_filearea(), $file->get_itemid(),
                                                          '/', $file->get_filename());
            } else {
                $imgurl = moodle_url::make_pluginfile_url($file->get_contextid(), 'theme_'.$PAGE->theme->name,
                                                          $file->get_filearea(), $file->get_itemid(),
                                                          '/', $file->get_filename());
            }

            // For items which are hidden but available to current user
            // ($mod->uservisible), we show those as dimmed only if the user has
            // viewhiddenactivities, so that teachers see 'items which might not
            // be available to some students' dimmed but students do not see 'item
            // which is actually available to current student' dimmed.
            $linkclasses = '';
            $accesstext = '';
            $textclasses = '';
            if ($mod->uservisible) {
                $conditionalhidden = $this->is_cm_conditionally_hidden($mod);
                $accessiblebutdim = (!$mod->visible || $conditionalhidden) &&
                    has_capability('moodle/course:viewhiddenactivities', $mod->context);
                if ($accessiblebutdim) {
                    $linkclasses .= ' dimmed';
                    $textclasses .= ' dimmed_text';
                    if ($conditionalhidden) {
                        $linkclasses .= ' conditionalhidden';
                        $textclasses .= ' conditionalhidden';
                    }
                    // Show accessibility note only if user can access the module himself.
                    $accesstext = get_accesshide(get_string('hiddenfromstudents').':'. $mod->modfullname);
                }
            } else {
                $linkclasses .= ' dimmed';
                $textclasses .= ' dimmed_text';
            }

            // Get on-click attribute value if specified and decode the onclick - it
            // has already been encoded for display (puke).
            $onclick = htmlspecialchars_decode($mod->onclick, ENT_QUOTES);

            $img = '<img src="'.$imgurl.'">';
            // $modurl = new moodle_url('/mod/'.$mod->modname.'/view.php', array('id' => $mod->id));
            $cmoutput = '<div class="cm-picture"><a href="'.$mod->url.'">'.$img.'</a></div>';

            $imglink = html_writer::link($mod->url, $img, array('class' => $linkclasses, 'onclick' => $onclick));

            $cmoutput = html_writer::tag('div', $imglink, array('class' => 'cm-picture'));
        }

        return $cmoutput;
    }

    /**
     * Renders HTML to display one course module in a course section
     *
     * This includes link, content, availability, completion info and additional information
     * that module type wants to display (i.e. number of unread forum posts)
     *
     * This function calls:
     * {@link core_course_renderer::course_section_cm_name()}
     * {@link core_course_renderer::course_section_cm_text()}
     * {@link core_course_renderer::course_section_cm_availability()}
     * {@link core_course_renderer::course_section_cm_completion()}
     * {@link course_get_cm_edit_actions()}
     * {@link core_course_renderer::course_section_cm_edit_actions()}
     *
     * @param stdClass $course
     * @param completion_info $completioninfo
     * @param cm_info $mod
     * @param int|null $sectionreturn
     * @param array $displayoptions
     * @return string
     */
    public function course_section_cm($course, &$completioninfo, cm_info $mod, $sectionreturn, $displayoptions = array()) {
        $output = '';
        // We return empty string (because course module will not be displayed at all)
        // if:
        // 1) The activity is not visible to users
        // and
        // 2) The 'availableinfo' is empty, i.e. the activity was
        //     hidden in a way that leaves no info, such as using the
        //     eye icon.
        if (!$mod->uservisible && empty($mod->availableinfo)) {
            return $output;
        }

        $output .= html_writer::start_tag('div');

        if ($this->page->user_is_editing()) {
            $output .= course_get_cm_move($mod, $sectionreturn);
        }

        $output .= html_writer::start_tag('div', array('class' => 'mod-indent-outer', 'style' => 'width:100%'));

        // This div is used to indent the content.
        $indentclasses = 'mod-indent';
        if (!empty($mod->indent)) {
            $indentclasses .= ' mod-indent-'.$mod->indent;
            if ($mod->indent > 15) {
                $indentclasses .= ' mod-indent-huge';
            }
        }
        $output .= html_writer::div('', $indentclasses);

        // Start a wrapper for the actual content to keep the indentation consistent.
        $output .= html_writer::start_tag('div', array('style' => 'width:100%'));

        $thumb = $this->course_section_cm_thumb($mod);

        if ($thumb) {
            $output .= html_writer::start_tag('div', array('class' => 'cm-name'));
            $output .= $thumb;
            $output .= html_writer::start_tag('div', array('class' => 'cm-label'));
            $cmname = $this->course_section_cm_name_for_thumb($mod, $displayoptions);
        } else {
            // Display the link to the module (or do nothing if module has no url)
            $cmname = $this->course_section_cm_name($mod, $displayoptions);
        }

        if (!empty($cmname)) {
            // Start the div for the activity title, excluding the edit icons.
            $output .= html_writer::start_tag('div', array('class' => 'activityinstance'));
            $output .= $cmname;


            // Module can put text after the link (e.g. forum unread)
            $output .= $mod->afterlink;

            // Closing the tag which contains everything but edit icons. Content part of the module should not be part of this.
            $output .= html_writer::end_tag('div'); // .activityinstance
        }

        // If there is content but NO link (eg label), then display the
        // content here (BEFORE any icons). In this case cons must be
        // displayed after the content so that it makes more sense visually
        // and for accessibility reasons, e.g. if you have a one-line label
        // it should work similarly (at least in terms of ordering) to an
        // activity.
        $contentpart = $this->course_section_cm_text($mod, $displayoptions);
        if (!empty($this->thumbfiles[$mod->id])) {
            // Remove the thumb that has already been displayed.
            $pattern = '/<img.*?'.$this->thumbfiles[$mod->id]->get_filename().'".*?>/';
            $contentpart = preg_replace($pattern, '', $contentpart);
        }

        $url = $mod->url;
        if (empty($url)) {
            $output .= $contentpart;
        }

        $modicons = '';
        if ($this->page->user_is_editing()) {
            $editactions = course_get_cm_edit_actions($mod, $mod->indent, $sectionreturn);
            $modicons .= ' '. $this->course_section_cm_edit_actions($editactions, $mod, $displayoptions);
            $modicons .= $mod->afterediticons;
        }

        $modicons .= $this->course_section_cm_completion($course, $completioninfo, $mod, $displayoptions);

        if (!empty($modicons)) {
            $output .= html_writer::span($modicons, 'actions');
        }

        // If there is content AND a link, then display the content here
        // (AFTER any icons). Otherwise it was displayed before
        if (!empty($url)) {
            $output .= $contentpart;
        }

        // Show availability info (if module is not available).
        $output .= $this->course_section_cm_availability($mod, $displayoptions);

        if ($thumb) {
            $output .= html_writer::end_tag('div'); // Close cm-label.
            $output .= html_writer::end_tag('div'); // Close cm-name.
        }

        $output .= html_writer::end_tag('div'); // Indentclasses.

        // End of indentation div.
        $output .= html_writer::end_tag('div');

        $output .= html_writer::end_tag('div');
        return $output;
    }

    public function get_thumbfiles() {
        return $this->thumbfiles;
    }

    /**
     * Renders HTML for displaying the sequence of course module editing buttons
     *
     * @see course_get_cm_edit_actions()
     *
     * @param action_link[] $actions Array of action_link objects
     * @param cm_info $mod The module we are displaying actions for.
     * @param array $displayoptions additional display options:
     *     ownerselector => A JS/CSS selector that can be used to find an cm node.
     *         If specified the owning node will be given the class 'action-menu-shown' when the action
     *         menu is being displayed.
     *     constraintselector => A JS/CSS selector that can be used to find the parent node for which to constrain
     *         the action menu to when it is being displayed.
     *     donotenhance => If set to true the action menu that gets displayed won't be enhanced by JS.
     * @return string
     */
    public function course_section_cm_edit_actions($actions, cm_info $mod = null, $displayoptions = array()) {
        global $CFG, $PAGE;

        if (empty($actions)) {
            return '';
        }

        $baseurl = '/theme/'.$PAGE->theme->name.'/mod_thumb.php';
        $actions['thumb'] = new action_menu_link_primary(
            new moodle_url($baseurl, array('id' => $mod->id)),
            new pix_icon('editthumb', null, 'theme', array('class' => 'iconsmall')),
            '',
            array('class' => 'editing_thumb', 'data-action' => 'thumb', 'aria-live' => 'assertive')
        );

        return parent::course_section_cm_edit_actions($actions, $mod, $displayoptions);
    }
}