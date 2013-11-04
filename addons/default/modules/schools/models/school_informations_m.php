<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Keyword model
 *
 * @author		Infocorp Consultoria
 * @developer		Henrique Oliveira Marques
 * @package		Modules\Cities\Models
 */
class school_informations_m extends MY_Model {

	function get_schools($id)
	{
		return $this->db
			->where('school_id', $id)
			->get('school_informations')
			->result();
	}

}
