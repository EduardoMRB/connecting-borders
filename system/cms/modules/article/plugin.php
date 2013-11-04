<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * article Plugin
 *
 * Create lists of posts
 * 
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\article\Plugins
 */
class Plugin_Article extends Plugin
{
	/**
	 * article List
	 *
	 * Creates a list of article posts
	 *
	 * Usage:
	 * {{ article:posts order-by="title" limit="5" }}
	 *		<h2>{{ title }}</h2>
	 *		<p> {{ body }} </p>
	 * {{ /article:posts }}
	 *
	 * @param	array
	 * @return	array
	 */
	public function posts()
	{
		$limit		= $this->attribute('limit', 10);
		$category	= $this->attribute('category');
		$order_by 	= $this->attribute('order-by', 'created_on');
													//deprecated
		$order_dir	= $this->attribute('order-dir', $this->attribute('order', 'ASC'));

		if ($category)
		{
			$this->db->where('article_categories.' . (is_numeric($category) ? 'id' : 'slug'), $category);
		}

		$posts = $this->db
			->select('article.*')
			->select('article_categories.title as category_title, article_categories.slug as category_slug')
			->select('p.display_name as author_name')
			->where('status', 'live')
			->where('created_on <=', now())
			->join('article_categories', 'article.category_id = article_categories.id', 'left')
			->join('profiles p', 'article.author_id = p.user_id', 'left')
			->order_by('article.' . $order_by, $order_dir)
			->limit($limit)
			->get('article')
			->result();

		foreach ($posts as &$post)
		{
			$post->url = site_url('article/'.date('Y', $post->created_on).'/'.date('m', $post->created_on).'/'.$post->slug);
		}
		
		return $posts;
	}

	/**
	 * Count Posts By Column
	 *
	 * Usage:
	 * {{ article:count_posts author_id="1" }}
	 *
	 * The attribute name is the database column and 
	 * the attribute value is the where value
	 */
	public function count_posts()
	{
		$wheres = $this->attributes();

		// make sure they provided a where clause
		if (count($wheres) == 0) return FALSE;

		foreach ($wheres AS $column => $value)
		{
			$this->db->where($column, $value);
		}

		return $this->db->count_all_results('article');
	}
}

/* End of file plugin.php */