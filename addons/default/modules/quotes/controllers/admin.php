<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Admin Page Layouts controller for the Pages module
 *
 * @author		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\Blog\Controllers
 */
class Admin extends Admin_Controller {

	/**
	 * The current active section
	 * @access protected
	 * @var int
	 */
	protected $section = 'quotes';

	
	/**
	 * The constructor
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->model('quotes_m');
		$this->load->library(array('languages/languages', 'form_validation'));
		$this->load->model('languages/languages_m');
		$this->load->model('pages/page_m');
		$this->lang->load('quotes');

		// Validation rules
		$this->validation_rules = array(
			array(
				'field' => 'author',
				'label' => lang('quotes:author_label'),
				'rules' => 'trim|required|max_length[50]'
			),
			array(
				'field' => 'page',
				'label' => lang('quotes:page_label'),
				'rules' => 'required'
			),
		);
		
		$this->form_validation->set_rules($this->validation_rules);
	}
	
	/**
	 * Index method, lists all categories
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$this->pyrocache->delete_all('modules_m');
		
		// Create pagination links
		$total_rows = $this->quotes_m->count_all();
		$pagination = create_pagination('admin/quotes/index', $total_rows, NULL, 5);
		// Using this data, get the relevant results
		$quotes = $this->quotes_m->order_by('author')->limit($pagination['limit'])->get_all();

		$this->template
			->title($this->module_details['name'], lang('cat_list_title'))
			->set('quotes', $quotes)
			->set('pagination', $pagination)
			->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
			->append_js('module::quotes_form.js')
			->build('quotes/admin/index');
	}
	
	/**
	 * Create method, creates a new category
	 *
	 * @return void
	 */
	public function create()
	{
		if ($_POST)
		{
			$this->form_validation->set_rules($this->validation_rules);

			$author = $this->input->post('author');
			$page = $this->input->post('page');
			$page = $this->page_m->get($page);
			
			if($this->quotes_m->check_page($page)) {
				$this->session->set_flashdata('success', sprintf(lang('quotes:already_exist_error'), $page['title']));
				redirect('admin/quotes/create');
			}
			
			if ($this->form_validation->run())
			{
				if ($id = $this->quotes_m->insert(array(
					'author' => $author,
					'type' => $this->input->post('type'),
					'body' => $this->input->post('body'),
					'page_id' => $page,
				)))
				{
					// Fire an event. A new city has been added.
					Events::trigger('information_created', $id);

					$this->session->set_flashdata('success', sprintf(lang('quotes:add_success'), $author));
				}
				else
				{
					$this->session->set_flashdata('error', sprintf(lang('quotes:add_error'), $author));
				}
				
				redirect('admin/quotes');
			}
		}
		
		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			$quote->{$rule['field']} = set_value($rule['field']);
		}
		$quote->page_id = '';
		$quote->body = '';
		$quote->type = '';
		$this->_form_data();
		
		$this->template
			->title($this->module_details['name'], lang('cat_create_title'))
			->set('quote', $quote)
			->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
			->append_js('module::quotes_form.js')
			->build('quotes/admin/form');	
	}
	
	/**
	 * Edit method, edits an existing category
	 * @access public
	 * @param int id The ID of the category to edit
	 * @return void
	 */
	public function edit($id = 0)
	{
		$quote = $this->quotes_m->get($id);

		// Make sure we found something
		$quote or redirect('admin/quotes');

		if ($_POST)
		{
			$this->form_validation->set_rules($this->validation_rules);

			$author = $this->input->post('author');

			if ($this->form_validation->run())
			{
				if ($success = $this->quotes_m->update($id, array(
					'author' => $author,
					'type' => $this->input->post('type'),
					'body' => $this->input->post('body'),
					'page_id' => $quote->page_id,
				)))
				{
					// Fire an event. A city has been updated.
					Events::trigger('information_updated', $id);
					$this->session->set_flashdata('success', sprintf(lang('quotes:edit_success'), $author));
				}
				else
				{
					$this->session->set_flashdata('error', sprintf(lang('school_informationss:edit_error'), $author));
				}

				redirect('admin/quotes');
			}
		}
		
		$this->_form_data();

		$this->template
			->title($this->module_details['name'], sprintf(lang('school_informations:edit_title'), $quote->author))
			->set('quote', $quote)
			->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
			->append_js('module::quotes_form.js')
			->build('quotes/admin/form');
	}	

	/**
	 * Delete method, deletes an existing category (obvious isn't it?)
	 * @access public
	 * @param int id The ID of the category to edit
	 * @return void
	 */
	public function delete($id = 0)
	{
		if ($success = $this->quotes_m->delete($id))
		{
			// Fire an event. A quote has been deleted.
			Events::trigger('information_deleted', $id);
			$this->session->set_flashdata('success', lang('quotes:delete_success'));
		}
		else
		{
			$this->session->set_flashdata('error', lang('quotes:delete_error'));
		}

		redirect('admin/quotes/');
	}
	
	public function _form_data() {
		$pages_options = array();
		$quote_pages = $this->page_m->order_by('id')->get_all();
		foreach ($quote_pages as $quote_page) {
			$pages_options[$quote_page->id] = $quote_page->title;
		}
		// Contact and page missing pages
		unset($pages_options[2]);
		unset($pages_options[3]);
		$pages_options[0] = 'Sidebar';
		
		$this->template->pages_options = $pages_options;
		$this->template->quote_pages = array_for_select($quote_pages, 'id','title');
	}

}
