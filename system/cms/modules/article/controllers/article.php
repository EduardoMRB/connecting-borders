<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Public article module controller
 *
 * @author		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\article\Controllers
 */
class Article extends Public_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('article_m');
		$this->load->model('article_categories_m');
	
		$this->load->library(array('keywords/keywords'));
		$this->lang->load('article');
	}

	/**
	 * Shows the article index
	 *
	 * article/page/x also routes here
	 */
	public function index()
	{
		$pagination = create_pagination('article/page', $this->article_m->count_by(array('status' => 'live')), NULL, 3);
		$_article = $this->article_m->limit($pagination['limit'])
			->get_many_by(array('status' => 'live'));

		// Set meta description based on post titles
		$meta = $this->_posts_metadata($_article);

		foreach ($_article as &$post)
		{
			$post->keywords = Keywords::get_links($post->keywords, 'article/tagged');
		}

		$this->template
			->title($this->module_details['name'])
			->set_breadcrumb(lang('article_article_title'))
			->set_metadata('description', $meta['description'])
			->set_metadata('keywords', $meta['keywords'])
			->set('pagination', $pagination)
			->set('article', $_article)
			->build('posts');
	}

	/**
	 * Lists the posts in a specific category.
	 *
	 * @param string $slug The slug of the category.
	 */
	public function category($slug = '')
	{
		$slug OR redirect('article');

		// Get category data
		$category = $this->article_categories_m->get_by('slug', $slug) OR show_404();

		// Count total article posts and work out how many pages exist
		$pagination = create_pagination('article/category/'.$slug, $this->article_m->count_by(array(
			'category' => $slug,
			'status' => 'live'
		)), NULL, 4);

		// Get the current page of article posts
		$article = $this->article_m->limit($pagination['limit'])->get_many_by(array(
			'category' => $slug,
			'status' => 'live'
		));

		// Set meta description based on post titles
		$meta = $this->_posts_metadata($article);

		foreach ($article AS &$post)
		{
			$post->keywords = Keywords::get_links($post->keywords, 'article/tagged');
		}

		// Build the page
		$this->template->title($this->module_details['name'], $category->title)
			->set_metadata('description', $category->title.'. '.$meta['description'])
			->set_metadata('keywords', $category->title)
			->set_breadcrumb(lang('article_article_title'), 'article')
			->set_breadcrumb($category->title)
			->set('article', $article)
			->set('category', $category)
			->set('pagination', $pagination)
			->build('posts');
	}

	/**
	 * Lists the posts in a specific year/month.
	 *
	 * @param null|string $year The year to show the posts for.
	 * @param string $month The month to show the posts for.
	 */
	public function archive($year = NULL, $month = '01')
	{
		$year OR $year = date('Y');
		$month_date = new DateTime($year.'-'.$month.'-01');
		$pagination = create_pagination('article/archive/'.$year.'/'.$month, $this->article_m->count_by(array('year' => $year, 'month' => $month)), NULL, 5);
		$_article = $this->article_m->limit($pagination['limit'])
			->get_many_by(array('year' => $year, 'month' => $month));
		$month_year = format_date($month_date->format('U'), lang('article_archive_date_format'));

		// Set meta description based on post titles
		$meta = $this->_posts_metadata($_article);

		foreach ($_article AS &$post)
		{
			$post->keywords = Keywords::get_links($post->keywords, 'article/tagged');
		}

		$this->template
			->title($month_year, $this->lang->line('article_archive_title'), $this->lang->line('article_article_title'))
			->set_metadata('description', $month_year.'. '.$meta['description'])
			->set_metadata('keywords', $month_year.', '.$meta['keywords'])
			->set_breadcrumb($this->lang->line('article_article_title'), 'article')
			->set_breadcrumb($this->lang->line('article_archive_title').': '.format_date($month_date->format('U'), lang('article_archive_date_format')))
			->set('pagination', $pagination)
			->set('article', $_article)
			->set('month_year', $month_year)
			->build('archive');
	}

	/**
	 * View a post
	 *
	 * @param string $slug The slug of the article post.
	 */
	public function view($slug = '')
	{
		if ( ! $slug or ! $post = $this->article_m->get_by('slug', $slug))
		{
			redirect('article');
		}

		if ($post->status != 'live' && ! $this->ion_auth->is_admin())
		{
			redirect('article');
		}

		// if it uses markdown then display the parsed version
		if ($post->type == 'markdown')
		{
			$post->body = $post->parsed;
		}

		// IF this post uses a category, grab it
		if ($post->category_id && ($category = $this->article_categories_m->get($post->category_id)))
		{
			$post->category = $category;
		}

		// Set some defaults
		else
		{
			$post->category->id = 0;
			$post->category->slug = '';
			$post->category->title = '';
		}

		$this->session->set_flashdata(array('referrer' => $this->uri->uri_string));

		$this->template->title($post->title, lang('article_article_title'))
			->set_metadata('description', $post->intro)
			->set_metadata('keywords', implode(', ', Keywords::get_array($post->keywords)))
			->set_breadcrumb(lang('article_article_title'), 'article');

		if ($post->category->id > 0)
		{
			$this->template->set_breadcrumb($post->category->title, 'article/category/'.$post->category->slug);
		}

		$post->keywords = Keywords::get_links($post->keywords, 'article/tagged');

		$this->template
			->set_breadcrumb($post->title)
			->set('post', $post)
			->build('view');
	}

	/**
	 * @todo Document this.
	 *
	 * @param string $tag
	 */
	public function tagged($tag = '')
	{
		// decode encoded cyrillic characters
		$tag = rawurldecode($tag) OR redirect('article');

		// Count total article posts and work out how many pages exist
		$pagination = create_pagination('article/tagged/'.$tag, $this->article_m->count_tagged_by($tag, array('status' => 'live')), NULL, 4);

		// Get the current page of article posts
		$article = $this->article_m
			->limit($pagination['limit'])
			->get_tagged_by($tag, array('status' => 'live'));

		foreach ($article AS &$post)
		{
			$post->keywords = Keywords::get_links($post->keywords, 'article/tagged');
		}

		// Set meta description based on post titles
		$meta = $this->_posts_metadata($article);

		$name = str_replace('-', ' ', $tag);

		// Build the page
		$this->template
			->title($this->module_details['name'], lang('article_tagged_label').': '.$name)
			->set_metadata('description', lang('article_tagged_label').': '.$name.'. '.$meta['description'])
			->set_metadata('keywords', $name)
			->set_breadcrumb(lang('article_article_title'), 'article')
			->set_breadcrumb(lang('article_tagged_label').': '.$name)
			->set('article', $article)
			->set('tag', $tag)
			->set('pagination', $pagination)
			->build('tagged');
	}

	/**
	 * @todo Document this.
	 *
	 * @param array $posts
	 *
	 * @return array
	 */
	private function _posts_metadata(&$posts = array())
	{
		$keywords = array();
		$description = array();

		// Loop through posts and use titles for meta description
		if ( ! empty($posts))
		{
			foreach ($posts as &$post)
			{
				if ($post->category_title)
				{
					$keywords[$post->category_id] = $post->category_title.', '.$post->category_slug;
				}
				$description[] = $post->title;
			}
		}

		return array(
			'keywords' => implode(', ', $keywords),
			'description' => implode(', ', $description)
		);
	}
}
