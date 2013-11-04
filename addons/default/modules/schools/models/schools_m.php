<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Keyword model
 *
 * @author		Infocorp Consultoria
 * @developer		Henrique Oliveira Marques
 * @package		Modules\Cities\Models
 */
class schools_m extends MY_Model {
	
	/**
	 * Check name
	 *
     	 * @access	public
	 * @param	string	$name
	 * @param	id	$id
	 * @param	string 	$current_name
	 * @return	bool
	 */
      public function check_name($name = '', $id = 0)
      {
      	return (int) parent::count_by(array(
			'id !='	=>	$id,
			'name'	=>	$name
		)) > 0;
      }

	function get_cities($id)
	{
		return $this->db
			->where('city_id', $id)
			->get('schools')
			->result();
	}
}
