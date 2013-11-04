<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 * @author Infocorp Consultoria
 * @developer Henrique Oliveira Marques
 * @package Modules\Schools\Controllers
 *
 */
class Admin extends Admin_Controller
{
	/**		$this->input->is_ajax_request() ? $this->template->set_layout(FALSE) : '';
	 * Constructor method
	 */

	protected $section = 'schools';

	public function __construct()
	{
		parent::__construct();

		// Load the required classes
		$this->load->library('form_validation');
		$this->load->model(array('schools_m', 'courses_m', 'accommodations_m','fares_m', 'school_informations_m'));
		$this->load->model('cities/cities_m');
		$this->lang->load('schools');
		$this->lang->load('fares');
		$this->lang->load('courses');
		$this->lang->load('accommodations');
		$this->lang->load('school_informations');
		$this->load->library(array('languages/languages', 'form_validation'));
		$this->load->model('languages/languages_m');

		$config['upload_path'] = './uploads/schools/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '500';
		$config['max_width'] = '1024';
		$config['max_height'] = '768';

		$this->load->library('upload', $config);

		// Validation rules
		$this->validation_rules = array(
			array(
				'field' => 'name',
				'label' => lang('schools:name'),
				'rules' => 'trim|required|max_length[50]'
			),
			array(
				'field' => 'city_id',
				'label' => lang('schools:country'),
				'rules' => 'callback__check_city'
			),
		);

	}

	/**
	 * Create a new school
	 */
	public function index()
	{
		$schools = $this->schools_m->order_by('name')->get_all();
		
		$this->template
			->title($this->module_details['name'])
			->set('schools', $schools)
			->build('admin/index');
	}

	/**
	 * Create a new school
	 *
	 * @access public
	 * @return void
	 */
	public function create()
	{
		if ($_POST)
		{

			if ($this->input->get_post('courses') == lang('schools:add_course')){
				$school = array(
						'school_name'  => $this->input->post('name'),
						'school_city_id' => $this->input->post('city_id'),
						'school_transferc' => $this->input->post('transferc'),
						'school_transfercp' => $this->input->post('transfercp'),
						'school_street' => $this->input->post('street'),
						'school_number' => $this->input->post('number'),
						'school_cep' => $this->input->post('cep'),
						'school_body' => $this->input->post('body'),
						'school_type' => $this->input->post('type')
					       );

				$this->session->set_userdata($school);
				redirect('admin/schools/courses/create/');
			}

			if ($this->input->get_post('fares') == lang('schools:add_fare')){
				$school = array(
						'school_name'  => $this->input->post('name'),
						'school_city_id' => $this->input->post('city_id'),
						'school_street' => $this->input->post('street'),
						'school_number' => $this->input->post('number'),
						'school_transferc' => $this->input->post('transferc'),
						'school_transfercp' => $this->input->post('transfercp'),
						'school_cep' => $this->input->post('cep'),
						'school_body' => $this->input->post('body'),
						'school_type' => $this->input->post('type')
					       );

				$this->session->set_userdata($school);
				redirect('admin/schools/fares/create/');
			}

			if ($this->input->get_post('school_informations') == lang('schools:add_information')){
				$school = array(
						'school_name'  => $this->input->post('name'),
						'school_city_id' => $this->input->post('city_id'),
						'school_street' => $this->input->post('street'),
						'school_number' => $this->input->post('number'),
						'school_transferc' => $this->input->post('transferc'),
						'school_transfercp' => $this->input->post('transfercp'),
						'school_cep' => $this->input->post('cep'),
						'school_body' => $this->input->post('body'),
						'school_type' => $this->input->post('type')
					       );

				$this->session->set_userdata($school);
				redirect('admin/schools/school_informations/create/');
			}
			

			if ($this->input->get_post('accommodations') == lang('accommodations:add_accommodation')){
				$school = array(
						'school_name'  => $this->input->post('name'),
						'school_city_id' => $this->input->post('city_id'),
						'school_transferc' => $this->input->post('transferc'),
						'school_transfercp' => $this->input->post('transfercp'),
						'school_street' => $this->input->post('street'),
						'school_number' => $this->input->post('number'),
						'school_cep' => $this->input->post('cep'),
						'school_body' => $this->input->post('body'),
						'school_type' => $this->input->post('type')
					       );

				$this->session->set_userdata($school);
				redirect('admin/schools/accommodations/create/');
			}else{
			    $this->upload->do_upload();
			    $data = $this->upload->data();
			    $post = $this->input->post();
			    $post['absolute'] = $data['full_path'];
			    $post['relative'] = './uploads/schools/' . $data['file_name'];
			    if (!($data['file_name'])) {
				$post['absolute'] = $post['absolute'] . "school.jpg";
				$post['relative'] = $post['relative'] . "school.jpg";
			    }
				$this->form_validation->set_rules($this->validation_rules);

				$name = $this->input->post('name');

				if ($this->form_validation->run())
				{
					if ($id = $this->schools_m->insert(array(
						'name' => $name,
						'city_id' => $this->input->post('city_id'),
						'transferc' => $this->input->post('transferc'),
						'transfercp' => $this->input->post('transfercp'),
						'absolute' => $post['absolute'],
						'relative' => $post['relative'],
						'body' => $this->input->post('body'),
						'street' => $this->input->post('street'),
						'number' => $this->input->post('number'),
						'cep' => $this->input->post('cep'),
						'type' => $this->input->post('type'),
					)))
					{
						//Fire an event. A new city has been added.
						Events::trigger('school_created', $id);

						$this->session->set_flashdata('success', sprintf(lang('schools:add_success'), $name));
					}
					else
					{
						$this->session->set_flashdata('error', sprintf(lang('schools:add_error'), $name));
					}
					$this->session->unset_userdata('school_name');
					$this->session->unset_userdata('school_city_id');
					$this->session->unset_userdata('school_street');
					$this->session->unset_userdata('school_number');
					$this->session->unset_userdata('school_cep');
					$this->session->unset_userdata('school_transferc');
					$this->session->unset_userdata('school_transfercp');
					$this->session->unset_userdata('school_body');
					$this->session->unset_userdata('school_type');
					redirect('admin/schools');
				}
			}
		}

		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			$school->{$rule['field']} = set_value($rule['field']);
		}
		$school->city_id = array();
		$school->body = '';
		$school->type = '';
		$this->_form_data();
		if ($school->type == '') $school->type = 'wysiwyg-advanced';
		$this->template
			->title($this->module_details['name'], lang('schools:add_title'))
			->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
			->append_js('module::schools_form.js')
			->set('school', $school)
			->build('admin/form');
	}


	/**
	 * Edit a school
	 *
	 * @access public
	 *
	 * @param int $id The ID of the school to edit
	 *
	 * @return void
	 */
	public function edit($id = 0)
	{
		$school = $this->schools_m->get($id);

		// Make sure we found something
		$school or redirect('admin/schools');
		if (!$school->name){
			$school->name = $this->session->userdata('school_name');
			$school->city_id = $this->session->userdata('school_city_id');
			$school->type = $this->session->userdata('school_type');
			$school->transferc = $this->session->userdata('school_transferc');
			$school->transfercp = $this->session->userdata('school_transfercp');
			$school->body = $this->session->userdata('school_body');
			$school->number = $this->session->userdata('school_number');
			$school->street = $this->session->userdata('school_street');
			$school->cep = $this->session->userdata('school_cep');
		}
		if ($_POST)
		{
		    $post = $this->input->post();
		    if (!$this->upload->do_upload()) {
		        $post['absolute'] = $school->absolute;
		        $post['relative'] = $school->relative;
		    } else {
		        $data = $this->upload->data();
		        $post['absolute'] = $data['full_path'];
		        $post['relative'] = './uploads/schools/' . $data['file_name'];
		        if (strcmp($school->relative, "./uploads/schools/school.jpg")) {
		            unlink($school->absolute);
		        }
		    }
			if ($this->input->get_post('courses') == lang('schools:add_course')){
				$school = array(
						'school_name'  => $this->input->post('name'),
						'school_city_id' => $this->input->post('city_id'),
						'school_body' => $this->input->post('body'),
						'school_street' => $this->input->post('street'),
						'school_number' => $this->input->post('number'),
						'school_transferc' => $this->input->post('transferc'),
						'school_transfercp' => $this->input->post('transfercp'),
						'school_cep' => $this->input->post('cep'),
						'school_type' => $this->input->post('type')
					       );

				$this->session->set_userdata($school);
				redirect('admin/schools/courses/create/'.$id);
			}
			if ($this->input->get_post('fares') == lang('schools:add_fare')){
				$school = array(
						'school_name'  => $this->input->post('name'),
						'school_city_id' => $this->input->post('city_id'),
						'school_body' => $this->input->post('body'),
						'school_street' => $this->input->post('street'),
						'school_number' => $this->input->post('number'),
						'school_transferc' => $this->input->post('transferc'),
						'school_transfercp' => $this->input->post('transfercp'),
						'school_cep' => $this->input->post('cep'),
						'school_type' => $this->input->post('type')
					       );

				$this->session->set_userdata($school);
				redirect('admin/schools/fares/create/'.$id);
			}
			if ($this->input->get_post('school_informations') == lang('school_informations:add_information')){
				$school = array(
						'school_name'  => $this->input->post('name'),
						'school_city_id' => $this->input->post('city_id'),
						'school_body' => $this->input->post('body'),
						'school_street' => $this->input->post('street'),
						'school_number' => $this->input->post('number'),
						'school_transferc' => $this->input->post('transferc'),
						'school_transfercp' => $this->input->post('transfercp'),
						'school_cep' => $this->input->post('cep'),
						'school_type' => $this->input->post('type')
					       );

				$this->session->set_userdata($school);
				redirect('admin/schools/school_informations/create/'.$id);
			}
			if ($this->input->get_post('accommodations') == lang('accommodations:add_accommodation')){
				$school = array(
						'school_name'  => $this->input->post('name'),
						'school_city_id' => $this->input->post('city_id'),
						'school_body' => $this->input->post('body'),
						'school_street' => $this->input->post('street'),
						'school_number' => $this->input->post('number'),
						'school_transferc' => $this->input->post('transferc'),
						'school_transfercp' => $this->input->post('transfercp'),
						'school_cep' => $this->input->post('cep'),
						'school_type' => $this->input->post('type')
					       );

				$this->session->set_userdata($school);
				redirect('admin/schools/accommodations/create/'.$id);
			}else{
				$this->form_validation->set_rules($this->validation_rules);

				$name = $this->input->post('name');

				if ($this->form_validation->run())
				{
					if ($success = $this->schools_m->update($id, array(
						'name' => $name,
						'city_id' => $this->input->post('city_id'),
						'absolute' => $post['absolute'],
						'relative' => $post['relative'],
						'body' => $this->input->post('body'),
						'street' => $this->input->post('street'),
						'number' => $this->input->post('number'),
						'cep' => $this->input->post('cep'),
						'transferc' => $this->input->post('transferc'),
						'transfercp' => $this->input->post('transfercp'),
						'type' => $this->input->post('type'),
					)))
					{
						// Fire an event. A city has been updated.
						Events::trigger('school_updated', $id);
						$this->session->set_flashdata('success', sprintf(lang('schools:edit_success'), $name));
					}
					else
					{
						$this->session->set_flashdata('error', sprintf(lang('schools:edit_error'), $name));
					}
					$this->session->unset_userdata('school_name');
					$this->session->unset_userdata('school_city_id');
					$this->session->unset_userdata('school_street');
					$this->session->unset_userdata('school_number');
					$this->session->unset_userdata('school_cep');
					$this->session->unset_userdata('school_transferc');
					$this->session->unset_userdata('school_transfercp');
					$this->session->unset_userdata('school_body');
					$this->session->unset_userdata('school_type');
					redirect('admin/schools');
				}
			}
		}
		$this->_form_data();
		$this->_form_courses($id);
		$this->_form_accommodations($id);
		$this->_form_fares($id);
		$this->_form_school_informations($id);
		$this->template
			->title($this->module_details['name'], sprintf(lang('schools:edit_title'), $school->name))
			->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
			->append_js('module::schools_form.js')
			->set('school', $school)
			->build('admin/form');
	}

	/**
	 * Delete city role(s)
	 *
	 * @access public
	 *
	 * @param int $id The ID of the city to delete
	 *
	 * @return void
	 */
	public function delete($id = 0)
	{
		if ($success = $this->schools_m->delete($id))
		{
			// Fire an event. A city has been deleted.
			Events::trigger('school_deleted', $id);
			$this->session->set_flashdata('success', lang('schools:delete_success'));
		}
		else
		{
			$this->session->set_flashdata('error', lang('schools:delete_error'));
		}

		redirect('admin/schools');
	}

	private function _form_data()
	{
		$city_options = array();
		$cities = $this->cities_m->order_by('name')->get_all();
		foreach ($cities as $city)
		{
			$city_options[$city->id] = $city->name;
		}
		$this->template->city_options = $city_options;
		$this->template->cities = array_for_select($cities, 'id','name');
	
	}

	private function _form_courses($id)
	{
		$courses = $this->courses_m->get_schools($id);
		$this->template->courses = $courses;
	}

	private function _form_fares($id)
	{
		$fares = $this->fares_m->get_schools($id);
		$this->template->fares = $fares;
	}

	private function _form_accommodations($id)
	{
		$accommodations = $this->accommodations_m->get_schools($id);
		$this->template->accommodations = $accommodations;
	
	}
	
	private function _form_school_informations($id){
		$informations = $this->school_informations_m->get_schools($id);
		$this->template->informations = $informations;
	}

	/**
	 * Callback method for validating the school's name
	 *
	 * @param str|string $name The name of the school
	 *
	 * @return	bool
	 */
	public function _check_name($name = '')
	{
		$this->form_validation->set_message('_check_name', sprintf(lang('schools:already_exist_error'), $name));

		return ! $this->schools_m->check_name($name, (int)$this->input->post('school_id'));
	}
	/**
	 * Callback method for validating the city selected
	 *
	 *
	 * @return	bool
	 */
	public function _check_city()
	{
		$this->form_validation->set_message('_check_city', sprintf(lang('schools:no_selected_error')));
		return (bool)$this->input->post('city_id');
	}

}
