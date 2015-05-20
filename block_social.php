<?php
/**
 * Clase que define los links a funcionalidades propias del bloque actividad_social
 * @author 2015 Hans Jeria (hansjeria@gmail.com)
 *
 */

class block_social extends block_base {

	// Inicializa el bloque
	function init() {
		$this->title = "Actividad Social";
		$this->version = 2015050601;
	}

	// Función que genera el contenido del bloque
	function get_content() {
		global $OUTPUT, $USER, $CFG, $DB, $PAGE, $COURSE;
		
		if ($this->content !== NULL) {
			return $this->content;
		}
		
		$course = $PAGE->course;
		if(!$course || $course->id <= 1)
			return false;
		else{
			$this->content = new stdClass;
			$redirecturl = new moodle_url('local/actividadSocial/index.php', array('action'=>'agregar'));
			//$this->content->text = $this->config->text;
			$this->content->text = $OUTPUT->single_button($redirecturl,"Ver más");
			$this->content->footer = '';
			
			return $this->content;
		}
		

	}

	
	function preferred_width() {
		// El valor preferido está en pixeles
		return 200;
	}
	
	

}