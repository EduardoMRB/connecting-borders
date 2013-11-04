<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Blog module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Blog
 */
class Module_Schools extends Module {

	public $version = '0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Schools',
				'br' => 'Escolas'
			),
			'description' => array(
				'en' => 'Manage possible schools for exchange',
				'br' => 'Gerencia as escolas possíveis para intercâmbio.'
			),

			'frontend'	=> false,
			'backend'	=> true,
			'menu'		=> 'content',

			'sections' => array(
			    'schools' => array(
				    'name' => 'schools:title',
				    'uri' => 'admin/schools',
				    'shortcuts' => array(
						array(
					 	   'name' => 'schools:add_title',
						    'uri' => 'admin/schools/create',
						    'class' => 'add'
						),
					),
				),
				'courses' => array(
				    'name' => 'schools:courses',
				    'uri' => 'admin/schools/courses',
				    'shortcuts' => array(
						array(
						    'name' => 'schools:add_course',
						    'uri' => 'admin/schools/courses/create',
						    'class' => 'add'
						),
				    ),
			    ),
				'fares' => array(
				    'name' => 'schools:fares',
				    'uri' => 'admin/schools/fares',
				    'shortcuts' => array(
						array(
						    'name' => 'fares:add_course',
						    'uri' => 'admin/schools/fares/create',
						    'class' => 'add'
						),
				    ),
			    ),
				'accommodations' => array(
				    'name' => 'schools:accommodations',
				    'uri' => 'admin/schools/accommodations',
				    'shortcuts' => array(
						array(
						    'name' => 'schools:add_accommodations',
						    'uri' => 'admin/schools/accommodations/create',
						    'class' => 'add'
						),
				    ),
			    ),
			    'school_informations' => array(
				    'name' => 'schools:school_informations',
				    'uri' => 'admin/schools/school_informations',
				    'shortcuts' => array(
						array(
						    'name' => 'school_informations:add_course',
						    'uri' => 'admin/schools/school_informations/create',
						    'class' => 'add'
						),
				    ),
			    ),
				
		    ),
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('schools');
		$this->dbforge->drop_table('courses');
		$this->dbforge->drop_table('fares');
		$this->dbforge->drop_table('accommodations');
		$this->dbforge->drop_table('school_informations');

		$tables = array(
			'schools' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'city_id' => array('type' => 'INT', 'constraint' => 11, 'key' => true),
				'relative' => array('type' => 'VARCHAR', 'constraint' => 100,),
				'absolute' => array('type' => 'VARCHAR', 'constraint' => 100,),
				'name' => array('type' => 'VARCHAR', 'constraint' => 60),
				'transferc' => array('type' => 'VARCHAR', 'constraint' => 18, 'default' => ''),
				'transfercp' => array('type' => 'VARCHAR', 'constraint' => 18, 'default' => ''),
				'street' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => ''),
				'number' => array('type' => 'VARCHAR', 'constraint' => 10, 'default' => ''),
				'cep' => array('type' => 'VARCHAR', 'constraint' => 18, 'default' => ''),
				'body' => array('type' => 'TEXT'),
				'type' => array('type' => 'SET', 'constraint' => array('html', 'markdown', 'wysiwyg-advanced', 'wysiwyg-simple')),
			),
			'courses' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'school_id' => array('type' => 'INT', 'constraint' => 11, 'key' => true),
				'language_id' => array('type' => 'INT', 'constraint' => 11, 'key' => true),
				'name' => array('type' => 'VARCHAR', 'constraint' => 60,),
				'hourly_load' => array('type' => 'VARCHAR', 'constraint' => 50,),
				'beginning' => array('type' => 'TEXT'),
				'type' => array('type' => 'SET', 'constraint' => array('html', 'markdown', 'wysiwyg-advanced', 'wysiwyg-simple')),
				'body' => array('type' => 'TEXT'),
			),
			'fares' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'school_id' => array('type' => 'INT', 'constraint' => 11, 'key' => true),
				'name' => array('type' => 'VARCHAR', 'constraint' => 60,),
				'price' => array('type' => 'VARCHAR', 'constraint' => 24,),
			),
			'accommodations' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'school_id' => array('type' => 'INT', 'constraint' => 11, 'key' => true),
				'city_id' => array('type' => 'INT', 'constraint' => 11, 'key' => true),
				'name' => array('type' => 'VARCHAR', 'constraint' => 60,),
				'body' => array('type' => 'TEXT'),
			),
			'school_informations' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'school_id' => array('type' => 'INT', 'constraint' => 11, 'key' => true),
				'name' => array('type' => 'VARCHAR', 'constraint' => 60,),
				'body' => array('type' => 'VARCHAR', 'constraint' => 70,),
			),

			'periods' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'parent' => array('type' => 'VARCHAR', 'constraint' => 16,),
				'parent_id' => array('type' => 'INT', 'constraint' => 11, 'key' => true),
				'name' => array('type' => 'VARCHAR', 'constraint' => 40,),
				'price' => array('type' => 'VARCHAR', 'constraint' => 16,),
				'year' => array('type' => 'INT', 'constraint' => 4),
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
