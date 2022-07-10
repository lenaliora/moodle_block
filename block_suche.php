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

class block_suche extends block_base {

    /**
     * Initialisiert die Klassen-Variablen.
     */
    public function init() {
        $this->title = get_string('suche', 'block_suche');
    }


    /**
     * Gibt den Block-Inhalt zurück.
     *
     * @return stdClass Der Block-Inhalt
     */
    public function get_content() {

        if ($this->content !== null) {
            return $this->content;
        }
        $this->content = new stdClass();
        $this->content->text = '<script async src="https://cse.google.com/cse.js?cx=xxx"></script>
<div class="gcse-search"></div>';
        return $this->content;
    }
}
