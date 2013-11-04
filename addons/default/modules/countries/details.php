<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Countries module
 *
 * @author Infocorp Consultoria
 * @developer Henrique Oliveira Marques
 * @package Modules\Countries
 */
class Module_Countries extends Module {

	public $version = '0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Countries',
				'br' => 'Países'
			),
			'description' => array(
				'en' => 'Manage possible countries for exchange',
				'br' => 'Gerencia os países possíveis para intercâmbio.'
			),
			'frontend' => false,
			'backend'  => true,
			'menu'     => 'content',
			'shortcuts' => array(
				array(
			 	   'name' => 'countries:add_title',
				   'uri' => 'admin/countries/add',
				   'class' => 'add',
				),
			),
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('countries');

		$tables = array(
			'countries' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'name' => array('type' => 'VARCHAR', 'constraint' => 50,),
				'languages' => array('type' => 'VARCHAR', 'constraint' => 32, 'default' => ''),
				'relative' => array('type' => 'VARCHAR', 'constraint' => 100,),
				'absolute' => array('type' => 'VARCHAR', 'constraint' => 100,),
				'body' => array('type' => 'TEXT'),
				'type' => array('type' => 'SET', 'constraint' => array('html', 'markdown', 'wysiwyg-advanced', 'wysiwyg-simple')),
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
