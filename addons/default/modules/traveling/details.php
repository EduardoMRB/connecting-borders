<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Languages module
 *
 * @author Infocorp Consultoria
 * @developer Henrique Oliveira Marques
 * @package Modules\traveling
 */
class Module_traveling extends Module {

	public $version = '0';

	public $_tables = 'travelings';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'traveling',
				'br' => 'Viagens'
			),
			'description' => array(
				'en' => 'Manages the possible types of travel tourism.',
				'br' => 'Gerencia os possíveis tipos de viagens para turismo.'
			),
			'frontend' => false,
			'backend'  => true,
			'menu'     => 'content',
			'shortcuts' => array(
				array(
			 	   'name' => 'traveling:create_title',
				   'uri' => 'admin/traveling/create',
				   'class' => 'add',
				),
			),
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('travelings');

		$tables = array(
			'travelings' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'name' => array('type' => 'VARCHAR', 'constraint' => 50,),
			),
			'travelings_applied' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'hash' => array('type' => 'CHAR', 'constraint' => 32, 'default' => '',),
				'traveling_id' => array('type' => 'INT', 'constraint' => 11,),
			),
		);

		if ( ! $this->install_tables($tables))
		{
			return false;
		}

		return true;
	}

	public function uninstall()
	{
		return true;
	}

	public function upgrade($old_version)
	{
		return true;
	}

}
