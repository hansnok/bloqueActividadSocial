<?php
/**
 * Clase que define los links a funcionalidades propias del bloque actividad_social
 * @author 2015 Hans Jeria (hansjeria@gmail.com)
 *
 */

class block_simplehtml extends block_base {
	
	public $blockname = null;
	
	public function init() {
		$this->title = "Actividad Social";
		$this->version = 2015050601;
	}
	
	public function html_attributes() {
		$attributes = parent::html_attributes();
		if (!empty($this->config->enablehoverexpansion) && $this->config->enablehoverexpansion == 'yes') {
			$attributes['class'] .= ' block_js_expansion';
		}
		$attributes['class'] .= ' block_navigation';
		return $attributes;
	}
	
	function applicable_formats() {
		return array('all' => true);
	}
	
	public function get_aria_role() {
		return 'navigation';
	}
	
	function has_config() {
		return true;
	}
	
	function specialization() {
		$this->title = $this->config->title;
	}
	
	function actividad_social(){
		global $COURSE, $CFG, $PAGE, $USER;
		

	}
	
	public function get_content() {
		global $DB, $USER, $CFG, $COURSE, $PAGE;
			
		if ($this->content !== NULL) {
        	return $this->content;
    	}

    	$this->content = new stdClass;
    	$this->content->text = $this->config->text;
    	$this->content->footer = ;

    	return $this->content;
	}
}