<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Languages module
 *
 * @author Infocorp Consultoria
 * @developer Henrique Oliveira Marques
 * @package Modules\Languages
 */
class Module_Languages extends Module {

	public $version = '0';

	public $_tables = array('languages', 'languages_applied');

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Languages',
				'br' => 'Idiomas'
			),
			'description' => array(
				'en' => 'Manage possible languages for exchange',
				'br' => 'Gerencia os idiomas possíveis para intercâmbio.'
			),
			'frontend' => false,
			'backend'  => true,
			'menu'     => 'content',
			'shortcuts' => array(
				array(
			 	   'name' => 'languages:create_title',
				   'uri' => 'admin/languages/create',
				   'class' => 'add',
				),
			),
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('languages');
		$this->dbforge->drop_table('languages_applied');

		$tables = array(
			'languages' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'name' => array('type' => 'VARCHAR', 'constraint' => 50,),
			),
			'languages_applied' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'hash' => array('type' => 'CHAR', 'constraint' => 32, 'default' => '',),
				'language_id' => array('type' => 'INT', 'constraint' => 11,),
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
