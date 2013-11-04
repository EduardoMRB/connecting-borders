<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Cities module
 *
 * @author Infocorp Consultoria
 * @developer Henrique Oliveira Marques
 * @package Modules\Cities
 */
class Module_Cities extends Module {

	public $version = '0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Cities',
				'br' => 'Cidades'
			),
			'description' => array(
				'en' => 'Manage possible cities for exchange',
				'br' => 'Gerencia as cidades possíveis para intercâmbio.'
			),
			'frontend' => false,
			'backend'  => true,
			'menu'     => 'content',
			'shortcuts' => array(
				array(
			 	   'name' => 'cities:add_title',
				   'uri' => 'admin/cities/add',
				   'class' => 'add',
				),
			),
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('cities');

		$tables = array(
			'cities' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'country_id' => array('type' => 'INT', 'constraint' => 11, 'key' => true),
				'travelings' => array('type' => 'VARCHAR', 'constraint' => 32, 'default' => ''),
				'name' => array('type' => 'VARCHAR', 'constraint' => 50,),
				'relative' => array('type' => 'VARCHAR', 'constraint' => 100,),
				'absolute' => array('type' => 'VARCHAR', 'constraint' => 100,),
				'body' => array('type' => 'TEXT'),
				'type' => array('type' => 'SET', 'constraint' => array('html', 'markdown', 'wysiwyg-advanced', 'wysiwyg-simple')),
			),
			'accommodations' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'school_id' => array('type' => 'INT', 'constraint' => 11, 'key' => true),
				'city_id' => array('type' => 'INT', 'constraint' => 11, 'key' => true),
				'name' => array('type' => 'VARCHAR', 'constraint' => 60,),
				'body' => array('type' => 'TEXT'),
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
