<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Example Plugin
 *
 * Quick plugin to demonstrate how things work
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Addon\Plugins
 * @copyright	Copyright (c) 2009 - 2010, PyroCMS
 */
class Plugin_Language extends Plugin
{
	/**
	 * Is BR.
	 * Check if the language is br
	 *
	 * Usage:
	 * {{ example:hello }}
	 *
	 * @return bool
	 */
	function isBr()
	{
		return $this->session->userdata('lang') == "br";
	}
	
}

/* End of file example.php */