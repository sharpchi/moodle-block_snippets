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
 * @package   block_snippets
 * @author    Mark Sharp <m.sharp@chi.ac.uk
 * @copyright 2020 University of Chichester {@link www.chi.ac.uk}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/
require_once($CFG->dirroot . '/blocks/snippets/classes/output/enrolments.php');
use \block_snippets\output\enrolments;

defined('MOODLE_INTERNAL') || die();

class block_snippets extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_snippets');
    }

    public function get_content() {
        global $OUTPUT, $USER;
        $this->content = new stdClass();
        $data = new stdClass();
        $data->title = 'Snippet title';
        $data->text = 'Hello world!';
        $data->items = [];
        for ($x = 0; $x < rand(3,8); $x++) {
            $item = new stdClass();
            $item->item = 'Item ' . ($x + 1);
            $item->badge = rand(5, 15 + $x);
            $data->items[] = $item;
        }
        $this->content->text = $OUTPUT->render_from_template('block_snippets/text', $data);
        $erenderer = new enrolments($USER->id);
        $this->content->text .= $OUTPUT->render_from_template('block_snippets/enrolments', $erenderer->export_for_template($OUTPUT));
        $this->content->text .= $OUTPUT->render($erenderer);
        $this->content->footer = '';
        return $this->content;
    }

    function specialization() {
        
    }
}