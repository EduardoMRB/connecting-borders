<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Keyword model
 *
 * @author		Infocorp Consultoria
 * @developer		Henrique Oliveira Marques
 * @package		Modules\Cities\Models
 */
class courses_m extends MY_Model {

	function get_schools($id)
	{
		return $this->db
			->where('school_id', $id)
			->get('courses')
			->result();
	}

	function get_languages($id)
	{
		return $this->db
			->where('language_id', $id)
			->get('courses')
			->result();
	}
	
	function get_by_school_language($school_id, $lang_id){
		return $this->db
			   ->where('school_id', $school_id)
			   ->where('language_id', $lang_id)
			   ->get('courses')
			   ->result();
	}
	
	function deletePeriods($id) {
		return $this->db
				->where('parent', 'courses')
				->where('parent_id', $id)
				->delete('periods');
	}

}
