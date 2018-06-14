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
defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');

class flexsectionclass_form extends moodleform {

    public function definition() {

        $mform = $this->_form;

        $mform->addElement('hidden', 'overridestyle');
        $mform->setType('overridestyle', PARAM_TEXT);

        $attrs = array();
        if (empty($this->_customdata['current'])) {
            $attrs['class'] = 'btn currentchoice';
        } else {
            $attrs['class'] = 'btn';
            $attrs['onclick'] = 'submitclasschange(this, \'\')';
        }
        $btnlabel = get_string('nostyleoverride', 'theme_essential_fel', '');
        $mform->addElement('button', 'styleoverride_none', $btnlabel, $attrs);

        if (!empty($this->_customdata['styles']['labels'])) {
            foreach ($this->_customdata['styles']['labels'] as $name => $label) {

                $btncurrentclass = ($name == $this->_customdata['current']) ? 'btn currentchoice' : 'btn';
                $currentclass = ($name == $this->_customdata['current']) ? 'currentchoice' : '';

                $attrs = array('onclick' => 'submitclasschange(this, \''.$name.'\');return true;', 'class' => $btncurrentclass);
                $btnlabel = get_string('activatestyle', 'theme_essential_fel').' > '.$label;
                $mform->addElement('button', 'styleoverride_'.$name, $btnlabel, $attrs);

                $attrs = array('class' => 'sectionname');

                if (preg_match('/^\\{(.*)\\}/', $this->_customdata['styles']['configs'][$name], $matches)) {
                    // True style.
                    $attrs['style'] = $matches[1];
                } else {
                    $attrs['class'] .= ' '.$this->_customdata['styles']['configs'][$name].' '.$currentclass;
                }
                $sectionsample = '<span class="sample-label">'.get_string('sample', 'theme_essential_fel').'</span><br/>';
                $sectionsample .= html_writer::tag('h3', get_string('section'), $attrs);
                $html = '<div class="flexsectionstyle-sample-wrapper">
                    <div class="flexsectionstyle-sample '.$currentclass.'">'.$sectionsample.'</div>
                </div>';
                $mform->addElement('static', 'stylesample', '', $html);

            }
        }

        $mform->addElement('cancel', get_string('cancel'));
    }

}