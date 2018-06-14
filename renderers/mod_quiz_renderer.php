<?php

require_once($CFG->dirroot.'/mod/quiz/renderer.php');

class theme_essential_fel_mod_quiz_renderer extends mod_quiz_renderer {

    function footer() {
        global $COURSE;
        if ($COURSE->format == 'page') {
            require_once $CFG->dirroot.'/course/format/page/xlib.php';
            page_print_page_format_navigation($cm, true);
        }
    }
}
