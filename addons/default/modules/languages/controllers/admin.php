<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Admin controller for the languages module
 *
 * @author	 Infocorp Consultoria
 * @developer	 Henrique Oliveira Marques
 * @package	 Modules\Languages\Controllers
*/
class Admin extends Admin_Controller
{
	/**
	 * Language's ID
	 *
	 * @var		int
	 */
	public $id = 0;

	public $temp;

	/**
	 * Array containing the validation rules
	 *
	 * @var		array
	 */
	private $_validation_rules = array(
		array(
			'field' => 'name',
			'label' => 'lang:global:name',
			'rules' => 'trim|required|max_length[50]|callback__check_name[0]'
		),
	);

	/**
	 * Constructor method
	 */
	public function __construct()
	{
		parent::__construct();

		// Load the required classes
		$this->load->library('form_validation');
		$this->load->model('languages_m');
		$this->lang->load('languages');

		// Set the validation rules
		$this->form_validation->set_rules($this->_validation_rules);

		// Set template layout to false if request is of ajax type
		if ($this->input->is_ajax_request())
		{
			$this->template->set_layout(FALSE);
		}
	}

	/**
	 * List all languages
	 */
	public function index()
	{

		// Create pagination links
		$this->template->pagination = create_pagination('admin/languages/index', $this->languages_m->count_all());

		// Using this data, get the relevant results
		$this->template->languages = $this->languages_m
			->limit($this->template->pagination['limit'])
			->get_all();

		$this->template
			->title($this->module_details['name'])
			->append_js('module::languages.js')
			->build('admin/index');
	}

	/**
	 * Create a new language
	 */
	public function create()
	{
		// Got validation?
		if ($this->form_validation->run())
		{
			$name = $this->input->post('name');

			if ($this->languages_m->insert($this->input->post()))
			{
				$message = sprintf(lang('languages:add_success'), $name);
				$status = 'success';
			}
			else
			{
				$message = sprintf(lang('languages:add_error'), $name);
				$status = 'error';
			}


			$this->session->set_flashdata($status, $message);
			redirect('admin/languages'.($status === 'error' ? '/create' : ''));
		}
		elseif (validation_errors())
		{
			// if request is ajax return json data, otherwise do normal stuff
			if ($this->input->is_ajax_request())
			{
				$message = $this->load->view('admin/partials/notices', array(), TRUE);

				return $this->template->build_json(array(
					'status' => 'error',
					'message' => $message
				));
			}
		}

		// Loop through each validation rule
		foreach ($this->_validation_rules as $rule)
		{
			$language->{$rule['field']} = set_value($rule['field']);
		}

		$this->template
			->title($this->module_details['name'], lang('languages:create_title'))
			->set('language', $language)
			->build('admin/form');
	}

	/**
	 * Edit an existing language
	 *
	 * @param int $id The ID of the language
	 */
	public function edit($id = 0)
	{
		// Got ID?
		$id OR redirect('admin/languages');

		// Get the language
		$this->template->language = $this->languages_m->get($id);
		$this->template->language OR redirect('admin/languages');

		if ($this->form_validation->run())
		{
			$name = $this->input->post('name');

			if ($this->languages_m->update($id, $this->input->post()))
			{
				$message = sprintf(lang('languages:edit_success'), $name);
				$status = 'success';
			}
			else
			{
				$message = sprintf(lang('languages:edit_error'), $name);
				$status = 'error';
			}

			// If request is ajax return json data, otherwise do normal stuff
			if ($this->input->is_ajax_request())
			{
				$data = array();
				$data['messages'][$status] = $message;
				$message = $this->load->view('admin/partials/notices', $data, TRUE);

				return $this->template->build_json(array(
					'status' => $status,
					'message' => $message,
					'title' => sprintf(lang('languages:edit_title'), $name)
				));
			}

			$this->session->set_flashdata($status, $message);
			redirect('admin/languages'.($status === 'error' ? '/edit' : ''));
		}
		elseif (validation_errors())
		{
			if ($this->input->is_ajax_request())
			{
				$message = $this->load->view('admin/partials/notices', array(), TRUE);

				return $this->template->build_json(array(
					'status' => 'error',
					'message' => $message
				));
			}
		}

		// Loop through each validation rule
		foreach ($this->_validation_rules as $rule)
		{
			if ($this->input->post($rule['field']) !== FALSE)
			{
				$language->{$rule['field']} = set_value($rule['field']);
			}
		}

		if ($this->input->is_ajax_request())
		{
			return $this->template->build('admin/form_inline');
		}

		$this->template
			->title($this->module_details['name'], sprintf(lang('languages:edit_title'), $this->template->language->name))
			->build('admin/form');
	}

	/**
	 * Delete an existing language
	 *
	 * @param	int $id The ID of the language
	 */
	public function delete($id = 0)
	{
		$ids = $id ? array($id) : $this->input->post('action_to');
		$total = count($ids);
		$deleted = array();

		// Try do deletion
		foreach ($ids as $id)
		{
			// Get the row to use a value.. as title, name
			if ($language = $this->languages_m->get($id))
			{
				// Make deletion retrieving an status and store an value to display in the messages
				$deleted[($this->languages_m->delete($id) ? 'success' : 'error')][] = $language->name;
			}
		}

		// Set status messages
		foreach ($deleted as $status => $values)
		{
			// Mass deletion
			if (($status_total = sizeof($values)) > 1)
			{
				$last_value = array_pop($values);
				$first_values = implode(', ', $values);

				// Success / Error message
				$this->session->set_flashdata($status, sprintf(lang('languages:mass_delete_'.$status), $status_total, $total, $first_values, $last_value));
			}

			// Single deletion
			else
			{
				// Success / Error messages
				$this->session->set_flashdata($status, sprintf(lang('languages:delete_'.$status), $values[0]));
			}
		}

		// He arrived here but it was not done nothing, certainly valid ids not were selected
		if ( ! $deleted)
		{
			$this->session->set_flashdata('error', lang('languages:no_select_error'));
		}

		redirect('admin/languages');
	}

	/**
	 * Callback method for validating the language's name
	 *
	 * @param str|string $name The name of the language
	 *
	 * @return	bool
	 */
	public function _check_name($name = '')
	{
		$this->form_validation->set_message('_check_name', sprintf(lang('languages:already_exist_error'), $name));

		return ! $this->languages_m->check_name($name, (int)$this->input->post('language_id'));
	}
}
