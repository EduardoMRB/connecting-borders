<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Keyword model
 *
 * @author		Infocorp Consultoria
 * @developer		Henrique Oliveira Marques
 * @package		Modules\Periods\Models
 */
class periods_m extends MY_Model {

	function get_parent($id, $parent)
	{
		return $this->db
			->where('parent_id', $id)
			->where('parent', $parent)
			->get('periods')
			->result();
	}

	function get_courses_year($course_id = 0, $year) {
		return $this->db
			->where('parent', 'courses')
			->where('parent_id' ,$course_id)
			->where('year' ,$year)
			->get('periods')
			->result();
	}

}
