<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * traveling model
 *
 * @author	Infocorp Consultoria
 * @developer	Henrique Oliveira Marques
 * @package  	Modules\traveling\Models
 */

class traveling_m extends MY_Model
{
	/**
	 * Insert
	 *
	 * @access	public
	 * @param	array	$input
	 * @return	mixed
	 */
    public function insert($input = array())
    {
    	return parent::insert(array(
    		'name' => $input['name']
        ));
    }

	/**
	 * Update
	 *
    	 * @access	public
	 * @param	id	$id
	 * @param	array	$input
	 * @return	mixed
	 */
    public function update($id, $input = array())
    {
        return parent::update($id, array(
			'name'	=> $input['name']
		));
    }

     public function get_traveling()
     {
	return $this->db->get('traveling')->result();
     }

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

	/**
	 * Get applied
	 *
	 * Gets all the traveling applied with a certain hash
	 *
	 * @param	string	$hash	The unique hash stored for a entry
	 * @return	array
	 */
	public function get_applied($hash)
	{

		return $this->db
			->select('name')
			->where('hash', $hash)
			->join('travelings', 'traveling_id = travelings.id')
			->order_by('name')
			->get('travelings_applied')
			->result();
	}
}

/* End of file traveling_m.php */
