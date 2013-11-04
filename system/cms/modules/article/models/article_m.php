<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Article_m extends MY_Model
{
	protected $_table = 'article';

	function get_all()
	{
		$this->db->distinct()->select('article.*, article_categories.title AS category_title, article_categories.slug AS category_slug, profiles.display_name')
			->join('article_categories', 'article.category_id = article_categories.id', 'left')
			->join('profiles', 'profiles.user_id = article.author_id', 'left');

		$this->db->order_by('created_on', 'DESC');

		return $this->db->get('article')->result();
	}

	function get($id)
	{
		return $this->db->select('article.*, profiles.display_name')
					->join('profiles', 'profiles.user_id = article.author_id', 'left')
					->where(array('article.id' => $id))
					->get('article')
					->row();
	}
	
	public function get_by($key, $value = '')
	{
		$this->db->distinct()->select('article.*, profiles.display_name')
			->join('profiles', 'profiles.user_id = article.author_id', 'left');
			
		if (is_array($key))
		{
			$this->db->where($key);
		}
		else
		{
			$this->db->where($key, $value);
		}

		return $this->db->get($this->_table)->row();
	}

	function get_many_by($params = array())
	{
		$this->load->helper('date');

		if (!empty($params['category']))
		{
			if (is_numeric($params['category']))
				$this->db->where('article_categories.id', $params['category']);
			else
				$this->db->where('article_categories.slug', $params['category']);
		}

		if (!empty($params['month']))
		{
			$this->db->where('MONTH(FROM_UNIXTIME(created_on))', $params['month']);
		}

		if (!empty($params['year']))
		{
			$this->db->where('YEAR(FROM_UNIXTIME(created_on))', $params['year']);
		}

		// Is a status set?
		if (!empty($params['status']))
		{
			// If it's all, then show whatever the status
			if ($params['status'] != 'all')
			{
				// Otherwise, show only the specific status
				$this->db->where('status', $params['status']);
			}
		}

		// Nothing mentioned, show live only (general frontend stuff)
		else
		{
			$this->db->where('status', 'live');
		}

		// By default, dont show future posts
		if (!isset($params['show_future']) || (isset($params['show_future']) && $params['show_future'] == FALSE))
		{
			$this->db->where('created_on <=', now());
		}

		// Limit the results based on 1 number or 2 (2nd is offset)
		if (isset($params['limit']) && is_array($params['limit']))
			$this->db->limit($params['limit'][0], $params['limit'][1]);
		elseif (isset($params['limit']))
			$this->db->limit($params['limit']);

		return $this->distinct()->get_all();
	}
	
	public function count_tagged_by($tag, $params)
	{
		return $this->select('*')
			->from('article')
			->join('keywords_applied', 'keywords_applied.hash = article.keywords')
			->join('keywords', 'keywords.id = keywords_applied.keyword_id')
			->where('keywords.name', str_replace('-', ' ', $tag))
			->where($params)
			->count_all_results();
	}
	
	public function get_tagged_by($tag, $params)
	{
		return $this->db->select('article.*, article.title title, article.slug slug, article_categories.title category_title, article_categories.slug category_slug, profiles.display_name')
			->from('article')
			->join('keywords_applied', 'keywords_applied.hash = article.keywords')
			->join('keywords', 'keywords.id = keywords_applied.keyword_id')
			->join('article_categories', 'article_categories.id = article.category_id', 'left')
			->join('profiles', 'profiles.user_id = article.author_id', 'left')
			->where('keywords.name', str_replace('-', ' ', $tag))
			->where($params)
			->get()
			->result();
	}

	function count_by($params = array())
	{
		$this->db->join('article_categories', 'article.category_id = article_categories.id', 'left');

		if (!empty($params['category']))
		{
			if (is_numeric($params['category']))
				$this->db->where('article_categories.id', $params['category']);
			else
				$this->db->where('article_categories.slug', $params['category']);
		}

		if (!empty($params['month']))
		{
			$this->db->where('MONTH(FROM_UNIXTIME(created_on))', $params['month']);
		}

		if (!empty($params['year']))
		{
			$this->db->where('YEAR(FROM_UNIXTIME(created_on))', $params['year']);
		}

		// Is a status set?
		if (!empty($params['status']))
		{
			// If it's all, then show whatever the status
			if ($params['status'] != 'all')
			{
				// Otherwise, show only the specific status
				$this->db->where('status', $params['status']);
			}
		}

		// Nothing mentioned, show live only (general frontend stuff)
		else
		{
			$this->db->where('status', 'live');
		}

		return $this->db->count_all_results('article');
	}

	function update($id, $input)
	{
		$input['updated_on'] = now();

		return parent::update($id, $input);
	}

	function publish($id = 0)
	{
		return parent::update($id, array('status' => 'live'));
	}

	// -- Archive ---------------------------------------------

	function get_archive_months()
	{
		$this->db->select('UNIX_TIMESTAMP(DATE_FORMAT(FROM_UNIXTIME(t1.created_on), "%Y-%m-02")) AS `date`', FALSE);
		$this->db->from('article t1');
		$this->db->distinct();
		$this->db->select('(SELECT count(id) FROM ' . $this->db->dbprefix('article') . ' t2
							WHERE MONTH(FROM_UNIXTIME(t1.created_on)) = MONTH(FROM_UNIXTIME(t2.created_on))
								AND YEAR(FROM_UNIXTIME(t1.created_on)) = YEAR(FROM_UNIXTIME(t2.created_on))
								AND status = "live"
								AND created_on <= ' . now() . '
						   ) as post_count');

		$this->db->where('status', 'live');
		$this->db->where('created_on <=', now());
		$this->db->having('post_count >', 0);
		$this->db->order_by('t1.created_on DESC');
		$query = $this->db->get();

		return $query->result();
	}

	// DIRTY frontend functions. Move to views
	function get_article_fragment($params = array())
	{
		$this->load->helper('date');

		$this->db->where('status', 'live');
		$this->db->where('created_on <=', now());

		$string = '';
		$this->db->order_by('created_on', 'DESC');
		$this->db->limit(5);
		$query = $this->db->get('article');
		if ($query->num_rows() > 0)
		{
			$this->load->helper('text');
			foreach ($query->result() as $article)
			{
				$string .= '<p>' . anchor('article/' . date('Y/m') . '/' . $article->slug, $article->title) . '<br />' . strip_tags($article->intro) . '</p>';
			}
		}
		return $string;
	}

	function check_exists($field, $value = '', $id = 0)
	{
		if (is_array($field))
		{
			$params = $field;
			$id = $value;
		}
		else
		{
			$params[$field] = $value;
		}
		$params['id !='] = (int) $id;

		return parent::count_by($params) == 0;
	}

	/**
	 * Searches article posts based on supplied data array
	 * @param $data array
	 * @return array
	 */
	public function search($data = array())
	{
		if (array_key_exists('category_id', $data))
		{
			$this->db->where('category_id', $data['category_id']);
		}

		if (array_key_exists('status', $data))
		{
			$this->db->where('status', $data['status']);
		}

		if (array_key_exists('keywords', $data))
		{
			$matches = array();
			if (strstr($data['keywords'], '%'))
			{
				preg_match_all('/%.*?%/i', $data['keywords'], $matches);
			}

			if (!empty($matches[0]))
			{
				foreach ($matches[0] as $match)
				{
					$phrases[] = str_replace('%', '', $match);
				}
			}
			else
			{
				$temp_phrases = explode(' ', $data['keywords']);
				foreach ($temp_phrases as $phrase)
				{
					$phrases[] = str_replace('%', '', $phrase);
				}
			}

			$counter = 0;
			foreach ($phrases as $phrase)
			{
				if ($counter == 0)
				{
					$this->db->like('article.title', $phrase);
				}
				else
				{
					$this->db->or_like('article.title', $phrase);
				}

				$this->db->or_like('article.body', $phrase);
				$this->db->or_like('article.intro', $phrase);
				$this->db->or_like('profiles.display_name', $phrase);
				$counter++;
			}
		}
		return $this->get_all();
	}

}