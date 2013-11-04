<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Admin Page Layouts controller for the Pages module
 *
 * @author		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\Blog\Controllers
 */
class Admin_Accommodations extends Admin_Controller {

	/**
	 * The current active section
	 * @access protected
	 * @var int
	 */
	protected $section = 'schools';
	
	/**
	 * Array that contains the validation rules
	 * @access protected
	 * @var array
	 */
	protected $validation_rules = array(
		array(
			'field' => 'name',
			'label' => 'lang:accommodations:name',
			'rules' => 'trim|required|max_length[100]'
		),
	);
	
	/**
	 * The constructor
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->model(array('accommodations_m', 'schools_m','periods_m'));
		$this->lang->load(array('schools','accommodations'));
		$this->load->library('form_validation');
		
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
		$total_rows = $this->accommodations_m->count_all();
		$pagination = create_pagination('admin/schools/accommodations/index', $total_rows, NULL, 5);
			
		// Using this data, get the relevant results
		$accommodations = $this->accommodations_m->order_by('name')->limit($pagination['limit'])->get_school_accommodations();
		$this->template
			->title($this->module_details['name'], lang('cat_list_title'))
			->set('accommodations', $accommodations)
			->set('pagination', $pagination)
			->build('admin/accommodations/index');
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
			if ($this->input->get_post('period') == lang('accommodations:add_period')){
				$accommodation_session = array(
						'accommodation_name'  => $this->input->post('name'),
						'accommodation_body' => $this->input->post('body'),
					       );

				$this->session->set_userdata($accommodation_session);
				redirect('admin/schools/periods/create/accommodations/0/'.$id);
			}else{

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
							'transferc' =>  '',
							'transfercp' =>  '',
							'body' => '',
							'type' => 'wysiwyg-advanced',
						));
					}
					if ($ida = $this->accommodations_m->insert(array(
						'name' => $name,
						'school_id' => $id,
                                                'city_id' => 0,
						'body' => $this->input->post('body'),
					)))
					{
						// Fire an event. A new city has been added.
						Events::trigger('accommodation_created', $ida);
							$this->session->set_flashdata('success', sprintf(lang('accommodations:add_success'), $name));
					}
					else
					{
						$this->session->set_flashdata('error', sprintf(lang('accommodations:add_error'), $name));
					}

					$this->session->unset_userdata('accommodation_name');
					$this->session->unset_userdata('accommodation_body');

					redirect('admin/schools/edit/'.$id);
				}
			}
		}
		
		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			$accommodation->{$rule['field']} = set_value($rule['field']);
		}

		$accommodation->name = '';
		$this->template
			->title($this->module_details['name'], lang('cat_create_title'))
			->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
			->set('accommodation', $accommodation)
			->build('admin/accommodations/form');	
	}
		
	/**
	 * Edit method, edits an existing category
	 * @access public
	 * @param int id The ID of the category to edit
	 * @return void
	 */
	public function edit($id = 0)
	{	
		$accommodation = $this->accommodations_m->get($id);

		// Make sure we found something
		$accommodation or redirect('admin/accommodations');

		if (!$accommodation->name){
			$accommodation->name = $this->session->userdata('accommodation_name');
			$accommodation->body = $this->session->userdata('accommodation_body');
		}

		if ($_POST)
		{
			if ($this->input->get_post('period') == lang('accommodations:add_period')){
				$accommodation_session = array(
						'accommodation_name'  => $this->input->post('name'),
						'accommodation_body' => $this->input->post('body'),
					       );

				$this->session->set_userdata($accommodation_session);
				redirect('admin/schools/periods/create/accommodations/'.$id.'/'.$accommodation->school_id);
			}

			$this->form_validation->set_rules($this->validation_rules);

			$name = $this->input->post('name');
			if ($this->form_validation->run())
			{
				if ($success = $this->accommodations_m->update($id, array(
					'name' => $name,
					'school_id' => $accommodation->school_id,                                        
					'body' => $this->input->post('body'),
				)))
				{
					// Fire an event. A country has been updated.
					Events::trigger('accommodation_updated', $id);
					$this->session->set_flashdata('success', sprintf(lang('accommodations:edit_success'), $name));
				}
				else
				{
					$this->session->set_flashdata('error', sprintf(lang('accommodations:edit_error'), $name));
				}
				$this->session->unset_userdata('accommodation_name');
				$this->session->unset_userdata('accommodation_body');
				redirect('admin/schools/edit/'.$accommodation->school_id);
			}
		}
		$this->_form_period($id);

		$this->template
			->title($this->module_details['name'], sprintf(lang('accommodations:edit_title'), $accommodation->name))
			->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
			->set('accommodation', $accommodation)
			->build('admin/accommodations/form');
	}	

	/**
	 * Delete method, deletes an existing category (obvious isn't it?)
	 * @access public
	 * @param int id The ID of the category to edit
	 * @return void
	 */
	public function delete($id = 0)
	{	
		$accommodation = $this->accommodations_m->get($id);
		if ($success = $this->accommodations_m->delete($id))
		{
			// Fire an event. A city has been deleted.
			Events::trigger('accommodation_deleted', $id);
			$this->session->set_flashdata('success', lang('accommodations:delete_success'));
		}
		else
		{
			$this->session->set_flashdata('error', lang('accommodations:delete_error'));
		}

		redirect('admin/schools/edit/'.$accommodations->school_id);
	}

	private function _form_period($id)
	{
		$periods = $this->periods_m->get_parent($id, 'accommodations');
                $parent = 'accommodations';
		$this->template->periods = $periods;
                $this->template->parent = $parent;
	}
		
	
}
	
