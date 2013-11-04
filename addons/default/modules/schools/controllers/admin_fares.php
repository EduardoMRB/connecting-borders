<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Admin Page Layouts controller for the Pages module
 *
 * @author		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\Blog\Controllers
 */
class Admin_Fares extends Admin_Controller {

	/**
	 * The current active section
	 * @access protected
	 * @var int
	 */
	protected $section = 'schools';

	
	/**
	 * The constructor
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->model('fares_m');
		$this->lang->load(array('fares','schools'));
		$this->load->library(array('languages/languages', 'form_validation'));
		$this->load->model('languages/languages_m');
		$this->load->model('schools_m');

		// Validation rules
		$this->validation_rules = array(
			array(
				'field' => 'name',
				'label' => lang('fares:name'),
				'rules' => 'trim|required|max_length[50]'
			),
			array(
				'field' => 'price',
				'label' => lang('fares:price'),
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
		$total_rows = $this->fares_m->count_all();
		$pagination = create_pagination('admin/schools/fares/index', $total_rows, NULL, 5);
			
		// Using this data, get the relevant results
		$fares = $this->fares_m->order_by('name')->limit($pagination['limit'])->get_all();

		$this->template
			->title($this->module_details['name'], lang('cat_list_title'))
			->set('fares', $fares)
			->set('pagination', $pagination)
			->build('admin/fares/index');
	}
	
	/**
	 * Create method, creates a new category
	 *
	 * @return void
	 */
	public function create($id = 0)
	{
		if ($_POST)
		{
			$this->form_validation->set_rules($this->validation_rules);

			$name = $this->input->post('name');

			if ($this->form_validation->run())
			{
				if ($id == 0){
					$id = $this->schools_m->insert(array(
						'name' => '',
						'city_id' => 0,
						'street' => '',
						'number' => '',
						'cep' => '',
						'relative' =>  '',
						'absolute' =>  '',
						'body' => '',
						'type' => 'wysiwyg-advanced',
					));
				}
				if ($idc = $this->fares_m->insert(array(
					'name' => $name,
					'price' => $this->input->post('price'),
					'school_id' => $id,
				)))
				{
					// Fire an event. A new city has been added.
					Events::trigger('fare_created', $idc);

					$this->session->set_flashdata('success', sprintf(lang('fares:add_success'), $name));
				}
				else
				{
					$this->session->set_flashdata('error', sprintf(lang('fares:add_error'), $name));
				}
				
				redirect('admin/schools/edit/'.$id);
			}
		}
		
		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			$fare->{$rule['field']} = set_value($rule['field']);
		}
		$this->template
			->title($this->module_details['name'], lang('cat_create_title'))
			->set('fare', $fare)
			->build('admin/fares/form');	
	}
	
	/**
	 * Edit method, edits an existing category
	 * @access public
	 * @param int id The ID of the category to edit
	 * @return void
	 */
	public function edit($id = 0)
	{	
		$fare = $this->fares_m->get($id);

		// Make sure we found something
		$fare or redirect('admin/fares');

		if ($_POST)
		{
			$this->form_validation->set_rules($this->validation_rules);

			$name = $this->input->post('name');

			if ($this->form_validation->run())
			{
				if ($success = $this->fares_m->update($id, array(
					'name' => $name,
					'price' => $this->input->post('price'),
					'school_id' => $fare->school_id,

				)))
				{
					// Fire an event. A city has been updated.
					Events::trigger('fare_updated', $id);
					$this->session->set_flashdata('success', sprintf(lang('fares:edit_success'), $name));
				}
				else
				{
					$this->session->set_flashdata('error', sprintf(lang('fares:edit_error'), $name));
				}

				redirect('admin/schools/edit/'.$fare->school_id);
			}
		}

		$this->template
			->title($this->module_details['name'], sprintf(lang('fares:edit_title'), $fare->name))
			->set('fare', $fare)
			->build('admin/fares/form');
	}	

	/**
	 * Delete method, deletes an existing category (obvious isn't it?)
	 * @access public
	 * @param int id The ID of the category to edit
	 * @return void
	 */
	public function delete($id = 0)
	{
		$fare = $this->fares_m->get($id);
		if ($success = $this->fares_m->delete($id))
		{
			// Fire an event. A city has been deleted.
			Events::trigger('fare_deleted', $id);
			$this->session->set_flashdata('success', lang('fares:delete_success'));
		}
		else
		{
			$this->session->set_flashdata('error', lang('fares:delete_error'));
		}

		redirect('admin/schools/edit/'.$fare->school_id);
	}

}
