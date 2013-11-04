<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * article module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\article
 */
class Module_Article extends Module {

    public $version = '2.0';

    public function info() {
        return array(
            'name' => array(
                'en' => 'News',
                'br' => 'Noticias',
            ),
            'description' => array(
                'en' => 'Post article entries.',
                'br' => 'Escrever publicações de article',
            ),
            'frontend' => true,
            'backend' => true,
            'skip_xss' => true,
            'menu' => 'content',
            'roles' => array(
                'put_live', 'edit_live', 'delete_live'
            ),
            'sections' => array(
                'posts' => array(
                    'name' => 'article_posts_title',
                    'uri' => 'admin/article',
                    'shortcuts' => array(
                        array(
                            'name' => 'article_create_title',
                            'uri' => 'admin/article/create',
                            'class' => 'add'
                        ),
                    ),
                ),
                'categories' => array(
                    'name' => 'cat_list_title',
                    'uri' => 'admin/article/categories',
                    'shortcuts' => array(
                        array(
                            'name' => 'cat_create_title',
                            'uri' => 'admin/article/categories/create',
                            'class' => 'add'
                        ),
                    ),
                ),
                'movies' => array(
                    'name' => 'article_movie_title',
                    'uri' => 'admin/article/movies',
                    'shortcuts' => array(
                        array(
                            'name' => 'article_movie_create_title',
                            'uri' => 'admin/article/movies/create',
                            'class' => 'add'
                        ),
                    ),
                ),
            ),
        );
    }

    public function install() {
        $this->dbforge->drop_table('article_categories');
        $this->dbforge->drop_table('article');

        $tables = array(
            'article_categories' => array(
                'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
                'slug' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false, 'unique' => true, 'key' => true),
                'title' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false, 'unique' => true),
            ),
            'article' => array(
                'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
                'title' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false, 'unique' => true),
                'slug' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false),
                'category_id' => array('type' => 'INT', 'constraint' => 11, 'key' => true),
                'attachment' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
                'intro' => array('type' => 'TEXT'),
                'body' => array('type' => 'TEXT'),
                'parsed' => array('type' => 'TEXT'),
                'keywords' => array('type' => 'VARCHAR', 'constraint' => 32, 'default' => ''),
                'author_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
                'created_on' => array('type' => 'INT', 'constraint' => 11),
                'updated_on' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
                'comments_enabled' => array('type' => 'INT', 'constraint' => 1, 'default' => 1),
                'status' => array('type' => 'ENUM', 'constraint' => array('draft', 'live'), 'default' => 'draft'),
                'type' => array('type' => 'SET', 'constraint' => array('html', 'markdown', 'wysiwyg-advanced', 'wysiwyg-simple')),
            ),
        );

        if (!$this->install_tables($tables)) {
            return false;
        }

        return true;
    }

    public function uninstall() {
        // This is a core module, lets keep it around.
        return false;
    }

    public function upgrade($old_version) {
        return true;
    }

}