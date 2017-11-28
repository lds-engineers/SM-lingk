<?php
// This file is part of the Local lingk plugin for Moodle
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
 * lingk
 *
 * This module provides extensive lingk on a platform of choice
 * Currently support Google lingk and Piwik
 *
 * @package    local_lingk
 * @copyright  Bas Brands, Sonsbeekmedia 2017
 * @author     Bas Brands <bas@sonsbeekmedia.nl>, David Bezemer <info@davidbezemer.nl>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;
global $DB,$PAGE;


if ($hassiteconfig) { // needs this condition or there is error on login page
    $ADMIN->add('localplugins', new admin_externalpage('local_lingk',
            get_string('pluginname', 'local_lingk'),
            new moodle_url('/local/lingk/swagger_index.php')));
}


