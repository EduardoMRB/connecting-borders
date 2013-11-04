<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Admin Page Layouts controller for the Pages module
 *
 * @author		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\Blog\Controllers
 */
class Admin_School_Informations extends Admin_Controller {

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

		$this->load->model('school_informations_m');
		$this->lang->load(array('school_informations','schools'));
		$this->load->library(array('languages/languages', 'form_validation'));
		$this->load->model('languages/languages_m');
		$this->load->model('schools_m');

		// Validation rules
		$this->validation_rules = array(
			array(
				'field' => 'name',
				'label' => lang('school_informations:name'),
				'rules' => 'trim|required|max_length[50]'
			),
			array(
				'field' => 'body',
				'label' => lang('school_informations:body'),
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
		$total_rows = $this->school_informations_m->count_all();
		$pagination = create_pagination('admin/schools/school_informations/index', $total_rows, NULL, 5);
			
		// Using this data, get the relevant results
		$informations = $this->school_informations_m->order_by('name')->limit($pagination['limit'])->get_all();

		$this->template
			->title($this->module_details['name'], lang('cat_list_title'))
			->set('informations', $informations)
			->set('pagination', $pagination)
			->build('admin/school_informations/index');
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
						'body' => '',
						'type' => 'wysiwyg-advanced',
					));
				}
				if ($idc = $this->school_informations_m->insert(array(
					'name' => $name,
					'body' => $this->input->post('body'),
					'school_id' => $id,
				)))
				{
					// Fire an event. A new city has been added.
					Events::trigger('information_created', $idc);

					$this->session->set_flashdata('success', sprintf(lang('school_informations:add_success'), $name));
				}
				else
				{
					$this->session->set_flashdata('error', sprintf(lang('school_informations:add_error'), $name));
				}
				
				redirect('admin/schools/edit/'.$id);
			}
		}
		
		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			$information->{$rule['field']} = set_value($rule['field']);
		}
		$this->template
			->title($this->module_details['name'], lang('cat_create_title'))
			->set('information', $information)
			->build('admin/school_informations/form');	
	}
	
	/**
	 * Edit method, edits an existing category
	 * @access public
	 * @param int id The ID of the category to edit
	 * @return void
	 */
	public function edit($id = 0)
	{	
		$information = $this->school_informations_m->get($id);

		// Make sure we found something
		$information or redirect('admin/school_informations');

		if ($_POST)
		{
			$this->form_validation->set_rules($this->validation_rules);

			$name = $this->input->post('name');

			if ($this->form_validation->run())
			{
				if ($success = $this->school_informations_m->update($id, array(
					'name' => $name,
					'body' => $this->input->post('body'),
					'school_id' => $informations->school_id,

				)))
				{
					// Fire an event. A city has been updated.
					Events::trigger('information_updated', $id);
					$this->session->set_flashdata('success', sprintf(lang('school_informations:edit_success'), $name));
				}
				else
				{
					$this->session->set_flashdata('error', sprintf(lang('school_informationss:edit_error'), $name));
				}

				redirect('admin/schools/edit/'.$information->school_id);
			}
		}

		$this->template
			->title($this->module_details['name'], sprintf(lang('school_informations:edit_title'), $information->name))
			->set('information', $information)
			->build('admin/school_informations/form');
	}	

	/**
	 * Delete method, deletes an existing category (obvious isn't it?)
	 * @access public
	 * @param int id The ID of the category to edit
	 * @return void
	 */
	public function delete($id = 0)
	{
		$information = $this->school_informations_m->get($id);
		if ($success = $this->school_informations_m->delete($id))
		{
			// Fire an event. A city has been deleted.
			Events::trigger('information_deleted', $id);
			$this->session->set_flashdata('success', lang('school_informations:delete_success'));
		}
		else
		{
			$this->session->set_flashdata('error', lang('school_informations:delete_error'));
		}

		redirect('admin/schools/edit/'.$information->school_id);
	}

}
