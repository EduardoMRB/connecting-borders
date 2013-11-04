<?php defined('BASEPATH') OR exit('No script access alowed.');

/**
 * quotes model
 *
 * @author	Infocorp Consultoria
 * @developer	Mattyws Ferreira Grawe
 * @package  	Modules\quotes\Models
 */

class quotes_m extends MY_Model {

	public function check_page($page = 0) {
		return $this -> get_by(array('page_id' => $page));
	}
	
	public function get_sidebar_quote() {
		return $this->get_by(array('page_id'=>NULL));
	}
}
