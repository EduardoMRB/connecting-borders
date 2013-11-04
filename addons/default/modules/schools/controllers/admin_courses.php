<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Admin Page Layouts controller for the Pages module
 *
 * @author		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\Blog\Controllers
 */
class Admin_Courses extends Admin_Controller {

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

		$this->load->model('courses_m');
		$this->lang->load(array('courses','schools'));
		$this->load->library(array('languages/languages', 'form_validation'));
		$this->load->model('languages/languages_m');
		$this->load->model('schools_m');
		$this->load->model('periods_m');

		// Validation rules
		$this->validation_rules = array(
			array(
				'field' => 'name',
				'label' => lang('courses:name'),
				'rules' => 'trim|required|max_length[50]'
			),
			array(
				'field' => 'language_id',
				'label' => lang('courses:language'),
				'rules' => 'callback__check_language'
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
		$total_rows = $this->courses_m->count_all();
		$pagination = create_pagination('admin/schools/courses/index', $total_rows, NULL, 5);
			
		// Using this data, get the relevant results
		$courses = $this->courses_m->order_by('name')->limit($pagination['limit'])->get_all();

		$this->template
			->title($this->module_details['name'], lang('cat_list_title'))
			->set('courses', $courses)
			->set('pagination', $pagination)
			->build('admin/courses/index');
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
			if ($this->input->get_post('period') == lang('courses:add_period')){
				$course = array(
						'course_name'  => $this->input->post('name'),
						'course_beginning' => strtotime($this->input->post('beginning')),
						'course_language_id' => $this->input->post('language_id'),
						'course_hourly_load' => $this->input->post('hourly_load'),
						'course_body' => $this->input->post('body'),
						'course_type' => $this->input->post('type')
					       );

				$this->session->set_userdata($course);
				redirect('admin/schools/periods/create/courses/0/'.$id);
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
							'relative' =>  '',
							'absolute' =>  '',
							'body' => '',
							'type' => 'wysiwyg-advanced',
						));
					}
	
					if ($idc = $this->courses_m->insert(array(
						'name' => $name,
						'beginning' => $this->input->post('beginning'),
						'school_id' => $id,
						'language_id' => $this->input->post('language_id'),
						'hourly_load' => $this->input->post('hourly_load'),
						'body' => $this->input->post('body'),
						'type' => $this->input->post('type'),
					)))
					{
						// Fire an event. A new city has been added.
						Events::trigger('course_created', $idc);

						$this->session->set_flashdata('success', sprintf(lang('courses:add_success'), $name));
					}
					else
					{
						$this->session->set_flashdata('error', sprintf(lang('courses:add_error'), $name));
					}
									$this->session->unset_userdata('school_name');

					$this->session->unset_userdata('course_name');
					$this->session->unset_userdata('course_beginning');
					$this->session->unset_userdata('course_language_id');
					$this->session->unset_userdata('course_hourly_load');
					$this->session->unset_userdata('course_body');
					$this->session->unset_userdata('course_type');

					redirect('admin/schools/edit/'.$id);
				}
			}
		}
		
		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			$course->{$rule['field']} = set_value($rule['field']);
		}
		$this->_form_language();
		$course->type = '';
		if ($course->type == '') $course->type = 'wysiwyg-advanced';
		$this->template
			->title($this->module_details['name'], lang('cat_create_title'))
			->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
			->set('course', $course)
			->build('admin/courses/form');	
	}
	
	/**
	 * Edit method, edits an existing category
	 * @access public
	 * @param int id The ID of the category to edit
	 * @return void
	 */
	public function edit($id = 0)
	{	
		$course = $this->courses_m->get($id);

		// Make sure we found something
		$course or redirect('admin/courses');

		if (!$course->name){
			$course->name = $this->session->userdata('course_name');
			$course->language_id = $this->session->userdata('course_language_id');
			$course->hourly_load = $this->session->userdata('course_hourly_load');
			$course->body = $this->session->userdata('course_body');
			$course->type = $this->session->userdata('course_type');
		}

		if ($_POST)
		{
			if ($this->input->get_post('period') == lang('courses:add_period')){
				$course_session = array(
						'course_name'  => $this->input->post('name'),
						'course_beginning' => strtotime($this->input->post('beginning')),
						'course_language_id' => $this->input->post('language_id'),
						'course_hourly_load' => $this->input->post('hourly_load'),
						'course_body' => $this->input->post('body'),
						'course_type' => $this->input->post('type')
					       );

				$this->session->set_userdata($course_session);
				redirect('admin/schools/periods/create/courses/'.$id.'/'.$course->school_id);
			}
			$this->form_validation->set_rules($this->validation_rules);

			$name = $this->input->post('name');

			if ($this->form_validation->run())
			{
				if ($success = $this->courses_m->update($id, array(
					'name' => $name,
					'beginning' => $this->input->post('beginning'),
					'school_id' => $course->school_id,
					'language_id' => $this->input->post('language_id'),
					'hourly_load' => $this->input->post('hourly_load'),
					'body' => $this->input->post('body'),
					'type' => $this->input->post('type'),
				)))
				{
					// Fire an event. A course has been updated.
					Events::trigger('course_updated', $id);
					$this->session->set_flashdata('success', sprintf(lang('courses:edit_success'), $name));
				}
				else
				{
					$this->session->set_flashdata('error', sprintf(lang('courses:edit_error'), $name));
				}

				$this->session->unset_userdata('course_name');
				$this->session->unset_userdata('course_beginning');
				$this->session->unset_userdata('course_language_id');
				$this->session->unset_userdata('course_hourly_load');
				$this->session->unset_userdata('course_body');
				$this->session->unset_userdata('course_type');
				
				redirect('admin/schools/edit/'.$course->school_id);
			}
		}
		$this->_form_periods($id);
		$this->_form_language();
		$this->_form_beginning($course);
		$this->template
			->title($this->module_details['name'], sprintf(lang('courses:edit_title'), $course->name))
			->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
			->set('course', $course)
			->build('admin/courses/form');
	}	

	/**
	 * Delete method, deletes an existing category (obvious isn't it?)
	 * @access public
	 * @param int id The ID of the category to edit
	 * @return void
	 */
	public function delete($id = 0)
	{
		$course = $this->courses_m->get($id);
		if ($success = $this->courses_m->delete($id))
		{
			if($success = $this->courses_m->deletePeriods($id)){
				// Fire an event. A city has been deleted.
				Events::trigger('course_deleted', $id);
				$this->session->set_flashdata('success', lang('courses:delete_success'));
			} else {				
				$this->session->set_flashdata('error', lang('courses:delete_error'));
			}
		}
		else
		{
			$this->session->set_flashdata('error', lang('courses:delete_error'));
		}

		redirect('admin/schools/');
	}

	private function _form_language()
	{
		$language_options = array();
		$languages = $this->languages_m->order_by('name')->get_languages();
		foreach ($languages as $language)
		{
			$language_options[$language->id] = $language->name;
		}
		$this->template->language_options = $language_options;
		$this->template->languages = array_for_select($languages, 'id','name');

	
	}

	private function _form_periods($id)
	{
		$periods = $this->periods_m->get_parent($id, 'courses');
                $parent = 'courses';
		$this->template->periods = $periods;
                $this->template->parent = $parent;
	}


	/**
	 * Callback method for validating the city selected
	 *
	 *
	 * @return	bool
	 */
	public function _check_language()
	{
		$this->form_validation->set_message('_check_language', sprintf(lang('courses:no_selected_error')));
		return (bool)$this->input->post('language_id');
	}
	
	public function _form_beginning($course) {
		$beginning = explode(",", $course->beginning);
		$now = strtotime(date('d-m-Y'));
		for ($i = 0; $i < count($beginning); $i++) {
			$aux = strtotime($beginning[$i]);
			if($aux <= $now){
				unset($beginning[$i]);
			}
		}
		$course->beginning = '';
		foreach($beginning as $beg) {
			$course->beginning = $course->beginning . $beg . ',';
		}
		$course->beginning = substr($course->beginning, 0, strlen($course->beginning) - 1);
	}

}
