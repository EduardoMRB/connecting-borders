<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Language Library
 *
 * Handles the languages data
 *
 * @author	Infocorp Consultoria
 * @developer	Henrique Oliveira Marques
 * @package  	Modules\Languages\Libraries
 */
class Languages {

	private $_CI;
	private $_vars = array();

	// ------------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * Get all the languages and assign them to the vars array
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->_CI =& get_instance();
		$this->_CI->load->model('languages/languages_m');

		$vars = $this->_CI->languages_m->get_all();

		foreach ($vars as $var)
		{
			$this->_vars[$var->name] = $var->name;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Magic get
	 *
	 * Used to pull out a language's data
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
	 * Used to set a language's data
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
	 * Get languages
	 *
	 * Gets all the languages
	 *
	 * @param	string	$hash	The unique hash stored for a entry
	 * @return	array
	 */
	public function get_string($hash)
	{
		$languages = array();
		
		foreach (ci()->languages_m->get_applied($hash) as $language)
		{
			$languages[] = $language->name;
		}
		return $languages;
	}


	/**
	 * Prepare Languages
	 *
	 * Gets a language ready to be saved
	 *
	 * @param	string	$language
	 * @return	bool
	 */
	public function prep($language)
	{
		return trim($language);
	}

	public function process($languages, $old_hash = null)
	{

		// No languages? Let's not bother then
		if ( ! ($languages = trim($languages)))
		{
			return '';
		}
		
		// Remove the old language assignments if we're updating
		if ($old_hash !== null)
		{
			ci()->db->where('hash', $old_hash)->get('languages_applied');
		}
		
		$assignment_hash = md5(microtime().mt_rand());
		
		// Split em up and prep away
		$languages = explode(',', $languages);
		foreach ($languages as &$language)
		{
			$language = self::prep($language);

			// Language already exists
			if (($row = ci()->db->where('name', $language)->get('languages')->row()))
			{
				$language_id = $row->id;
			}
			
			// Create it, and keep the record
			else
			{
				$language_id = self::add($language);
			}
			
			// Create assignment record

			ci()->db->insert('languages_applied', array(
				'hash' => $assignment_hash,
				'language_id' => $language_id,
			));
		}
		
		return $assignment_hash;
	}


}

/* End of file Languages.php */
