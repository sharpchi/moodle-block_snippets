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

namespace block_snippets\output;

use renderable;
use templatable;

defined('MOODLE_INTERNAL') || die();

class enrolments implements renderable, templatable {

    private $userid;

    private $courses = [];

    public function __construct($userid) {
        global $DB;
        $this->userid = $userid;
        $sql = "SELECT c.id, c.fullname, c.shortname
        FROM mootest_user_enrolments AS ue
        JOIN mootest_enrol AS e ON e.id = ue.enrolid
        JOIN mootest_course AS c ON c.id = e.courseid
        WHERE ue.userid = :userid";
        $this->courses = $DB->get_records_sql($sql, ['userid' => $this->userid]);
    }

    public function export_for_template(\renderer_base $output) {
        $data = new \stdClass();
        $data->count = count($this->courses);
        $data->courses = array_values($this->courses);
        return $data;
    }
}

