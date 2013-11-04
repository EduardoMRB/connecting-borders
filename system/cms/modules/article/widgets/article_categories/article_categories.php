<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Show a list of article categories.
 * 
 * @author		PyroCMS Dev Team
 * @author		Stephen Cozart
 * @package 	PyroCMS\Core\Modules\article\Widgets
 */

class Widget_Article_categories extends Widgets
{
	public $title		= array(
		'en' => 'article Categories',
		'br' => 'Categorias do article',
		'pt' => 'Categorias do article',
		'el' => 'Κατηγορίες Ιστολογίου',
		'ru' => 'Категории Блога',
		'id' => 'Kateori article',
	);
	public $description	= array(
		'en' => 'Show a list of article categories',
		'br' => 'Mostra uma lista de navegação com as categorias do article',
		'pt' => 'Mostra uma lista de navegação com as categorias do article',
		'el' => 'Προβάλει την λίστα των κατηγοριών του ιστολογίου σας',
		'ru' => 'Выводит список категорий блога',
		'id' => 'Menampilkan daftar kategori tulisan',
	);
	public $author		= 'Stephen Cozart';
	public $website		= 'http://github.com/clip/';
	public $version		= '1.0';
	
	public function run()
	{
		$this->load->model('article/article_categories_m');
		
		$categories = $this->article_categories_m->order_by('title')->get_all();
		
		return array('categories' => $categories);
	}	
}
