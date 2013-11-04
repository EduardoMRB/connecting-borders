<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Traveling Library
 *
 * Handles the travelings data
 *
 * @author	Infocorp Consultoria
 * @developer	Henrique Oliveira Marques
 * @package  	Modules\travelings\Libraries
 */
class Travelings {

	private $_CI;
	private $_vars = array();

	// ------------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * Get all the traveling and assign them to the vars array
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->_CI =& get_instance();
		$this->_CI->load->model('traveling/traveling_m');

		$vars = $this->_CI->traveling_m->get_all();

		foreach ($vars as $var)
		{
			$this->_vars[$var->name] = $var->name;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Magic get
	 *
	 * Used to pull out a traveling's data
	 *
	 * @param	string
	 * @return 	mixed
	 */
	public function __get($name)
	{
		// Getting data
		if (isset($this->_vars[$name]))
		{
			return $this->_vars[$name];
		}

		return NULL;
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Magic set
	 *
	 * Used to set a traveling's data
	 *
	 * @param	string
	 * @return 	mixed
	 */
	public function __set($name, $value)
	{
		$this->_vars[$name] = $value;
	}

	// ------------------------------------------------------------------------

	/**
	 * Get all
	 *
	 * Get an array of all the vars
	 *
	 * @return array
	 */
	public function get_all()
	{
		return $this->_vars;
	}

	/**
	 * Get traveling
	 *
	 * Gets all the traveling
	 *
	 * @param	string	$hash	The unique hash stored for a entry
	 * @return	array
	 */
	public function get_string($hash)
	{
		$travelings = array();
		
		foreach (ci()->traveling_m->get_applied($hash) as $traveling)
		{
			$travelings[] = $traveling->name;
		}
		return $travelings;
	}


	/**
	 * Prepare travelings
	 *
	 * Gets a traveling ready to be saved
	 *
	 * @param	string	$traveling
	 * @return	string
	 */
	public function prep($traveling)
	{
		return trim($traveling);
	}

	public function process($travelings, $old_hash = null)
	{

		// No travelings? Let's not bother then
		if ( is_string($travelings) && ! ($travelings = trim($travelings)))
		{
			return '';
		} elseif (is_array($travelings) && count($travelings) == 0 ) {
			return '';
		}
		
		
		// Remove the old traveling assignments if we're updating
		if ($old_hash !== null)
		{
			ci()->db->where('hash', $old_hash)->get('travelings_applied');
		}
		
		$assignment_hash = md5(microtime().mt_rand());
		
		// Split em up and prep away
		if(is_string($travelings)) {
			$travelings = explode(',', $travelings);
		}
		foreach ($travelings as $traveling)
		{
			$traveling = self::prep($traveling);

			// traveling already exists
			if ( ($row = ci()->db->where('name', $traveling)->get('travelings')->row() ))
			{
				$traveling_id = $row->id;
			}
			
			// Create it, and keep the record
			else
			{
				$traveling_id = self::add($traveling);
			}
			
			// Create assignment record

			ci()->db->insert('travelings_applied', array(
				'hash' => $assignment_hash,
				'traveling_id' => $traveling_id,
			));
		}
		
		return $assignment_hash;
	}


}

/* End of file travelings.php */
