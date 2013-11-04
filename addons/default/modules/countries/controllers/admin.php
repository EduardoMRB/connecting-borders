<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 * @author Infocorp Consultoria
 * @developer Henrique Oliveira Marques
 * @package Modules\Countries\Controllers
 *
 */
class Admin extends Admin_Controller
{
	/**
	 * Constructor method
	 */
	public function __construct()
	{
		parent::__construct();

		// Load the required classes
		$this->load->library(array('languages/languages', 'form_validation'));
		$this->load->model('countries_m');
		$this->load->model('languages/languages_m');
		$this->lang->load('countries');
    	        $config['upload_path'] = './uploads/countries/';
        	$config['allowed_types'] = 'gif|jpg|png';
        	$config['max_size'] = '100';
		$config['max_width'] = '1024';
		$config['max_height'] = '768';

        	$this->load->library('upload', $config);

		// Validation rules
		$this->validation_rules = array(
			array(
				'field' => 'name',
				'label' => lang('countries:name'),
				'rules' => 'trim|required|max_length[50]|callback__check_name[0]'
			),
			array(
				'field' => 'languages',
				'label' => lang('countries:languages_label'),
				'rules' => 'required'
			),

		);
	}

	/**
	 * Create a new country
	 */
	public function index()
	{
		$countries = $this->countries_m->order_by('name')->get_all();

		$this->template
			->title($this->module_details['name'])
			->set('countries', $countries)
			->build('admin/index');
	}

	/**
	 * Create a new country
	 *
	 * @access public
	 * @return void
	 */
	public function add()
	{
		if ($_POST)
		{
		    $this->upload->do_upload();
		    $data = $this->upload->data();
		    $post = $this->input->post();
		    $post['absolute'] = $data['full_path'];
		    $post['relative'] = './uploads/countries/' . $data['file_name'];
		    if (!($data['file_name'])) {
		        $post['absolute'] = $post['absolute'] . "country.jpg";
		        $post['relative'] = $post['relative'] . "country.jpg";
		    }
			$this->form_validation->set_rules($this->validation_rules);
			$name = $this->input->post('name');
			if ($this->form_validation->run())
			{
				if ($id = $this->countries_m->insert(array(
					'name' => $this->input->post('name'),
					'currency' => $this->input->post('cur'),
					'languages' => Languages::process(implode(',',$this->input->post('languages'))),
					'absolute' => $post['absolute'],
					'relative' => $post['relative'],
					'body' => $this->input->post('body'),
					'type' => $this->input->post('type'),
				)))
				{
					// Fire an event. A new language has been added.
					Events::trigger('country_created', $id);

					$this->session->set_flashdata('success', sprintf(lang('countries:add_success'), $name));
				}
				else
				{
					$this->session->set_flashdata('error', sprintf(lang('countries:add_error'), $name));
				}

				redirect('admin/countries');
			}
		}

		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			$country->{$rule['field']} = set_value($rule['field']);
		}
		$country->languages = array();
		$country->body = '';
		$country->type = '';
		$this->_form_data();
		if ($country->type == '') $country->type = 'wysiwyg-advanced';

		$this->template
			->title($this->module_details['name'], lang('countries:add_title'))
			->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
			->append_js('module::countries_form.js')
			->set('country', $country)
			->build('admin/form');
	}


	/**
	 * Edit a country
	 *
	 * @access public
	 *
	 * @param int $id The ID of the country to edit
	 *
	 * @return void
	 */
	public function edit($id = 0)
	{
		$country = $this->countries_m->get($id);
		$country->languages = Languages::get_string($country->languages);

		// Make sure we found something
		$country or redirect('admin/countries');

		if ($_POST)
		{
		    $post = $this->input->post();
		    if (!$this->upload->do_upload()) {
		        $post['absolute'] = $country->absolute;
		        $post['relative'] = $country->relative;
		    } else {
		        $data = $this->upload->data();
		        $post['absolute'] = $data['full_path'];
		        $post['relative'] = './uploads/countries/' . $data['file_name'];
		        if (strcmp($country->relative, "./uploads/countries/country.jpg")) {
		            unlink($country->absolute);
		        }
		    }
			$this->form_validation->set_rules($this->validation_rules);

			$name = $this->input->post('name');
			if ($this->form_validation->run())
			{
				if ($success = $this->countries_m->update($id, array(
						'name' => $name,
						'currency' => $this->input->post('cur'),
						'languages' => Languages::process(implode(',',$this->input->post('languages'))),
						'absolute' => $post['absolute'],
						'relative' => $post['relative'],
						'body' => $this->input->post('body'),
						'type' => $this->input->post('type'),
				)))
				{
					// Fire an event. A country has been updated.
					Events::trigger('country_updated', $id);
					$this->session->set_flashdata('success', sprintf(lang('countries:edit_success'), $name));
				}
				else
				{
					$this->session->set_flashdata('error', sprintf(lang('countries:edit_error'), $name));
				}

				redirect('admin/countries');
			}
		}
		$this->_form_data();

		$this->template
			->title($this->module_details['name'], sprintf(lang('countries:edit_title'), $country->name))
			->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
			->append_js('module::countries_form.js')
			->set('country', $country)
			->build('admin/form');
	}

	/**
	 * Delete country role(s)
	 *
	 * @access public
	 *
	 * @param int $id The ID of the country to delete
	 *
	 * @return void
	 */
	public function delete($id = 0)
	{
		if ($success = $this->countries_m->delete($id))
		{
			// Fire an event. A country has been deleted.
			Events::trigger('country_deleted', $id);
			$this->session->set_flashdata('success', lang('countries:delete_success'));
		}
		else
		{
			$this->session->set_flashdata('error', lang('countries:delete_error'));
		}

		redirect('admin/countries');
	}
	
	private function _form_data()
	{
		$language_options = array();
		$languages = $this->languages_m->order_by('name')->get_languages();
		foreach ($languages as $language)
		{
			$language_options[$language->name] = $language->name;
		}
		$this->template->language_options = $language_options;
		$this->template->languages = array_for_select($languages, 'id','name');
	
	}
	
	/**
	 * Callback method for validating the country's name
	 *
	 * @param str|string $name The name of the country
	 *
	 * @return	bool
	 */
	public function _check_name($name = '')
	{
		$this->form_validation->set_message('_check_name', sprintf(lang('countries:already_exist_error'), $name));

		return ! $this->countries_m->check_name($name, (int)$this->input->post('country_id'));
	}
}
