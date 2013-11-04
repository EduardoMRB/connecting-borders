<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Countries model
 *
 * @author		Infocorp Consultoria
 * @developer		Henrique Oliveira Marques
 * @package		Modules\Countries\Models
 */
class Countries_m extends MY_Model {

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
      
    public function get_by_mask_language($id, $value = null) {
        return $this->db->query("
                SELECT a.id as id, a.name as name, b.language_id as language_id
                    FROM default_countries a
                    JOIN default_languages_applied b
			ON a.languages = b.hash
                    WHERE b.language_id='" . $id . "'")->result();
    }
	
	public function get_countries_by_traveling($id) {
		return $this->db
				->query(
					"SELECT p.id, p.name FROM default_travelings t
					JOIN default_travelings_applied a 
					ON t.id = a.traveling_id
					JOIN default_cities c 
					ON a.hash = c.travelings
					JOIN default_countries p
					ON c.country_id = p.id
					WHERE t.id = " .$id)->result();
	}
}
