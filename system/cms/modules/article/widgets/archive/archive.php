<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Show RSS feeds in your site
 * 
 * @package 	PyroCMS\Core\Modules\article\Widgets
 * @author		Phil Sturgeon
 * @author		PyroCMS Development Team
 */

class Widget_Archive extends Widgets
{
	public $title		= array(
		'en' => 'Archive',
		'br' => 'Arquivo do article',
		'pt' => 'Arquivo do article',
		'el' => 'Αρχείο Ιστολογίου',
		'ru' => 'Архив',
		'id' => 'Archive',
	);
	public $description	= array(
		'en' => 'Display a list of old months with links to posts in those months',
		'br' => 'Mostra uma lista navegação cronológica contendo o índice dos artigos publicados mensalmente',
		'pt' => 'Mostra uma lista navegação cronológica contendo o índice dos artigos publicados mensalmente',
		'el' => 'Προβάλλει μια λίστα μηνών και συνδέσμους σε αναρτήσεις που έγιναν σε κάθε από αυτούς',
		'ru' => 'Выводит список по месяцам со ссылками на записи в этих месяцах',
		'id' => 'Menampilkan daftar bulan beserta tautan post di setiap bulannya',
	);
	public $author		= 'Phil Sturgeon';
	public $website		= 'http://philsturgeon.co.uk/';
	public $version		= '1.0';
	
	public function run($options)
	{
		$this->load->model('article/article_m');
		$this->lang->load('article/article');

		return array(
			'archive_months' => $this->article_m->get_archive_months()
		);
	}	
}
