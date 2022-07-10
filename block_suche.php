<?php

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
