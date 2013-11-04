<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Keyword model
 *
 * @author		Infocorp Consultoria
 * @developer		Henrique Oliveira Marques
 * @package		Modules\Cities\Models
 */
class cities_m extends MY_Model {
	
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
	  
	  public function get_travel_cities($country = 0) {
	  	return $this->db
	  		->where('country_id', $country)
			->where("travelings != ''")
			->get('cities')
			->result();
	  }

}
