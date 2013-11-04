<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Blog module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Blog
 */
class Module_Quotes extends Module {

	public $version = '0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Quotes',
				'br' => 'Frases'
			),
			'description' => array(
				'en' => 'Menage quotes for webpages',
				'br' => 'Gerencia frases para paginas do site.'
			),

			'frontend'	=> false,
			'backend'	=> true,
			'menu'		=> 'content',
			'shortcuts' => array(
				array(
			 	   'name' => 'quotes:create_title',
				   'uri' => 'admin/quotes/create',
				   'class' => 'add',
				),
			),
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('quotes');
		

		$tables = array(
			'quotes' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'page_id' => array('type' => 'INT', 'constraint' => 11),
				'author' => array('type' => 'VARCHAR', 'constraint' => 60),
				'type' => array('type' => 'SET', 'constraint' => array('html', 'markdown', 'wysiwyg-advanced', 'wysiwyg-simple')),
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
