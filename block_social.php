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
			
			$params = array(1,1,$course->id);
			
			//Traer las tareas
			$sql_assing = "SELECT asub.id, a.name, us.firstname, us.lastname, asub.timecreated, asub.timemodified
						 	FROM {course_modules} as cm INNER JOIN {modules} as m ON (cm.module = m.id) 
						   		INNER JOIN {assign} as a ON (a.course = cm.course) 
    					   		INNER JOIN {assign_submission} as asub ON ( asub.assignment = a.id) 
    							INNER JOIN {user} as us ON (us.id = asub.userid) 
						 	WHERE m.name in ('assign') 
								AND cm.visible = ? 
    							AND m.visible = ?
    							AND cm.course = ?
							ORDER BY asub.timemodified DESC,asub.id
    					  	LIMIT 5";
			$lastassings = $DB->get_records_sql($sql_assing, $params);
			
			//Traer los quiz
			$sql_quiz = "SELECT qatt.id, q.name, us.firstname, us.lastname, qatt.timestart, qatt.timefinish
						 	FROM {course_modules} as cm INNER JOIN {modules} as m ON (cm.module = m.id) 
						   		INNER JOIN {quiz} as q ON (q.course = cm.course) 
    					   		INNER JOIN {quiz_attempts} as qatt ON ( qatt.quiz = q.id) 
    							INNER JOIN {user} as us ON (us.id = qatt.userid) 
						 	WHERE m.name in ('quiz')
								AND cm.visible = ? 
    							AND m.visible = ?
    							AND cm.course = ?
    					  	ORDER BY qatt.timefinish DESC, qatt.id
							LIMIT 5";
			$lastquiz = $DB->get_records_sql($sql_quiz, $params);
			
			// Traer los recursos
			$sql_resources = "SELECT *
						 	FROM {course_modules} as cm INNER JOIN {modules} as m ON (cm.module = m.id) 
						   		INNER JOIN {resource} as r ON (r.course = cm.course)
						 	WHERE m.name in ('resource')
								AND cm.visible = ? 
    							AND m.visible = ?
    							AND cm.course = ?
    					  	ORDER BY m.name DESC LIMIT 5";
			$lastresources = $DB->get_records_sql($sql_resources, $params);
			
			// Creación de tabla que muestra las últimas 5 tareas enviadas
			$table_assign = new html_table();
			$table_assign->head = array('Assing', '', '');
			foreach($lastassings as $assing){
				$timefinish = date('d-m-Y  H:i',$assing->timemodified);
				$table_assign->data[] = array($assing->name,$assing->firstname." ".$assing->lastname, $timefinish);
			}
			
			// Creación de tabla que muestra los ultimos 5 quiz
			$table_quiz = new html_table();
			$table_quiz->head = array('Quiz', '', '');
			foreach($lastquiz as $quiz){
				$timefinish = date('d-m-Y  H:i',$quiz->timefinish);
				$table_quiz->data[] = array($quiz->name,$quiz->firstname." ".$quiz->lastname, $timefinish);
			}
			
					
			$lookassign = new moodle_url('local/actividadSocial/index.php', array('action'=>'assign'));
			$lookquiz = new moodle_url('local/actividadSocial/index.php', array('action'=>'quiz'));
			$this->content->text = html_writer::table($table_assign).$OUTPUT->single_button($lookassign,"See more").
									"".html_writer::table($table_quiz).$OUTPUT->single_button($lookquiz,"See more");;
			$this->content->footer = "";
			
			return $this->content;
		}
		

	}


	

}