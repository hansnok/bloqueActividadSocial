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
		global $OUTPUT;
		if ($this->content !== NULL) {
			return $this->content;
		}
	
		$this->content = new stdClass;
		$redirecturl = new moodle_url('local/actividadSocial/index.php', array('action'=>'agregar'));
		//$this->content->text = $this->config->text;
		$this->content->text = $OUTPUT->single_button($redirecturl,"Ver más");
		$this->content->footer = '';
	
		return $this->content;
	}
	
	// Agrega icono para editar el bloque
	function instance_allow_config() {
		return true;
	}
	
	// Carga la configuración al bloque
	function specialization() {
		$this->title = $this->config->title;
	}
	
	// Posibilidad de configuración global
	function has_config() {
		return true;
	}
	
	// Guarda la configuración
	function config_save($data) {
		// Comportamiento por defecto: graba todas las variables como propiedades $CFG
		foreach ($data as $name => $value) {
			set_config($name, $value);
		}
		return true;
	}
	
	function instance_config_save($data) {
		$data = stripslashes_recursive($data);
		$this->config = $data;
		return set_field('block_instance', 'configdata', base64_encode(serialize($data)),
				'id', $this->instance->id);
	}
	

	
	function preferred_width() {
		// El valor preferido está en pixeles
		return 200;
	}
	
	

}