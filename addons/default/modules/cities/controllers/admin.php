<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 * @author Infocorp Consultoria
 * @developer Henrique Oliveira Marques
 * @package Modules\Cities\Controllers
 *
 */
class Admin extends Admin_Controller {
	/**
	 * Constructor method
	 */
	public function __construct() {
		parent::__construct();

		// Load the required classes
		$this -> load -> library(array('form_validation', 'traveling/travelings'));
		$this -> load -> model(array('cities_m', 'accommodations_m'));
		$this -> load -> model('traveling/traveling_m');
		$this -> load -> model('countries/countries_m');
		$this -> lang -> load('accommodations');
		$this -> lang -> load('cities');

		$config['upload_path'] = './uploads/cities/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '100';
		$config['max_width'] = '1024';
		$config['max_height'] = '768';

		$this -> load -> library('upload', $config);

		// Validation rules
		$this -> validation_rules = array( array('field' => 'name', 'label' => lang('cities:name'), 'rules' => 'trim|required|max_length[50]|callback__check_name[0]'), array('field' => 'country_id', 'label' => lang('cities:country'), 'rules' => 'callback__check_country'), );
	}

	/**
	 * Create a new city
	 */
	public function index() {
		$cities = $this -> cities_m -> order_by('name') -> get_all();

		$this -> template -> title($this -> module_details['name']) -> set('cities', $cities) -> build('admin/index');
	}

	/**
	 * Create a new city
	 *
	 * @access public
	 * @return void
	 */
	public function add() {
		if ($_POST) {
			if ($this -> input -> get_post('accommodations') == lang('accommodations:add_accommodation')) {
				$city = array('city_name' => $this -> input -> post('name'), 'city_country' => $this -> input -> post('country_id'), 'city_travel' => $this -> input -> post('travelings'), 'city_body' => $this -> input -> post('body'), 'city_type' => $this -> input -> post('type'));

				$this -> session -> set_userdata($city);
				redirect('admin/cities/accommodations/create/');
			} else {
				$this -> form_validation -> set_rules($this -> validation_rules);
				$this -> upload -> do_upload();
				$data = $this -> upload -> data();
				$post = $this -> input -> post();
				$post['absolute'] = $data['full_path'];
				$post['relative'] = './uploads/cities/' . $data['file_name'];

				if (!($data['file_name'])) {
					$post['absolute'] = $post['absolute'] . "city.jpg";
					$post['relative'] = $post['relative'] . "city.jpg";
				}

				$name = $this -> input -> post('name');

				if ($this -> form_validation -> run()) {
					if ($id = $this -> cities_m -> insert(array('name' => $name, 'country_id' => $this -> input -> post('country_id'), 'travelings' => Travelings::process(implode(',',$this -> input -> post('travelings'))), 'relative' => $post['relative'], 'absolute' => $post['absolute'], 'body' => $this -> input -> post('body'), 'type' => $this -> input -> post('type'), ))) {
						// Fire an event. A new city has been added.
						Events::trigger('city_created', $id);

						$this -> session -> set_flashdata('success', sprintf(lang('cities:add_success'), $name));
					} else {
						$this -> session -> set_flashdata('error', sprintf(lang('cities:add_error'), $name));
					}
					$this -> session -> unset_userdata('city_name');
					$this -> session -> unset_userdata('city_country');
					$this -> session -> unset_userdata('city_travel');
					$this -> session -> unset_userdata('city_body');
					$this -> session -> unset_userdata('city_type');
					redirect('admin/cities');
				}
			}
		}

		// Loop through each validation rule
		foreach ($this->validation_rules as $rule) {
			$city -> {$rule['field']} = set_value($rule['field']);
		}
		$city -> country_id = array();
		$city -> body = '';
		$city -> type = '';
		$city -> travelings = '';
		$this -> _form_data();
		if ($city -> type == '')
			$city -> type = 'wysiwyg-advanced';

		$this -> template -> title($this -> module_details['name'], lang('cities:add_title')) -> append_metadata($this -> load -> view('fragments/wysiwyg', $this -> data, TRUE)) -> append_js('module::cities_form.js') -> set('city', $city) -> build('admin/form');
	}

	/**
	 * Edit a city
	 *
	 * @access public
	 *
	 * @param int $id The ID of the city to edit
	 *
	 * @return void
	 */
	public function edit($id = 0) {
		$city = $this -> cities_m -> get($id);
		$city->travelings = Travelings::get_string($city->travelings);

		// Make sure we found something
		$city or redirect('admin/cities');
		if (!$city -> name) {
			$city -> name = $this -> session -> userdata('city_name');
			$city -> country_id = $this -> session -> userdata('city_country');
			$city -> travelings = $this -> session -> userdata('city_travel');
			$city -> body = $this -> session -> userdata('city_body');
			$city -> type = $this -> session -> userdata('city_type');
		}
		if ($_POST) {

			$name = $this -> input -> post('name');
			$post = $this -> input -> post();
			if (!$this -> upload -> do_upload()) {
				$post['absolute'] = $city -> absolute;
				$post['relative'] = $city -> relative;
			} else {
				$data = $this -> upload -> data();
				$post['absolute'] = $data['full_path'];
				$post['relative'] = './uploads/cities/' . $data['file_name'];
				if (strcmp($city -> relative, "./uploads/cities/city.jpg")) {
					unlink($city -> absolute);
				}
			}
			if ($this -> input -> get_post('accommodations') == lang('accommodations:add_accommodation')) {
				$city = array('city_name' => $this -> input -> post('name'), 'city_country' => $this -> input -> post('country_id'), 'city_travel' => $this -> input -> post('travelings'), 'city_body' => $this -> input -> post('body'), 'city_type' => $this -> input -> post('type'));

				$this -> session -> set_userdata($city);
				redirect('admin/cities/accommodations/create/'.$id);
			} else {
				$this -> form_validation -> set_rules($this -> validation_rules);
				if ($this -> form_validation -> run()) {
					if ($success = $this -> cities_m -> update($id, array(
						'name' => $name, 
						'country_id' => $this -> input -> post('country_id'), 
						'travelings' => Travelings::process($this -> input -> post('travelings') ? $this -> input -> post('travelings') : '' ), 
						'relative' => $post['relative'], 
						'absolute' => $post['absolute'], 
						'body' => $this -> input -> post('body'), 
						'type' => $this -> input -> post('type'), ))) {
						// Fire an event. A city has been updated.
						Events::trigger('city_updated', $id);
						$this -> session -> set_flashdata('success', sprintf(lang('cities:edit_success'), $name));
					} else {
						$this -> session -> set_flashdata('error', sprintf(lang('cities:edit_error'), $name));
					}
					$this -> session -> unset_userdata('city_name');
					$this -> session -> unset_userdata('city_country');
					$this -> session -> unset_userdata('city_travel');
					$this -> session -> unset_userdata('city_body');
					$this -> session -> unset_userdata('city_type');
					redirect('admin/cities');
				}
			}
		}
		$this -> _form_data();
		$this -> _form_accommodations($id);
		$this -> template -> title($this -> module_details['name'], sprintf(lang('cities:edit_title'), $city -> name)) -> append_metadata($this -> load -> view('fragments/wysiwyg', $this -> data, TRUE)) -> append_js('module::cities_form.js') -> set('city', $city) -> build('admin/form');
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
	public function delete($id = 0) {
		if ($success = $this -> cities_m -> delete($id)) {
			// Fire an event. A city has been deleted.
			Events::trigger('city_deleted', $id);
			$this -> session -> set_flashdata('success', lang('cities:delete_success'));
		} else {
			$this -> session -> set_flashdata('error', lang('cities:delete_error'));
		}

		redirect('admin/cities');
	}

	private function _form_data() {
		$country_options = array();
		$countries = $this -> countries_m -> order_by('name') -> get_all();
		foreach ($countries as $country) {
			$country_options[$country -> id] = $country -> name;
		}
		$this -> template -> country_options = $country_options;

		$travel_options = array();
		$travelings = $this -> traveling_m -> order_by('name') -> get_all();
		foreach ($travelings as $traveling) {
			$travel_options[$traveling -> name] = $traveling -> name;
		}
		$this -> template -> travel_options = $travel_options;
		$this -> template -> countries = array_for_select($countries, 'id', 'name');
		$this -> template -> travelings = array_for_select($travelings, 'id', 'name');

	}

	private function _form_accommodations($id) {
		$accommodations = $this -> accommodations_m -> get_accommodations_by_city($id);
		$this -> template -> accommodations = $accommodations;
	}

	/**
	 * Callback method for validating the city's name
	 *
	 * @param str|string $name The name of the city
	 *
	 * @return	bool
	 */
	public function _check_name($name = '') {
		$this -> form_validation -> set_message('_check_name', sprintf(lang('cities:already_exist_error'), $name));

		return !$this -> cities_m -> check_name($name, (int)$this -> input -> post('city_id'));
	}

	/**
	 * Callback method for validating the country selected
	 *
	 *
	 * @return	bool
	 */
	public function _check_country() {
		$this -> form_validation -> set_message('_check_country', sprintf(lang('cities:no_selected_error')));
		return (bool)$this -> input -> post('country_id');
	}

}
