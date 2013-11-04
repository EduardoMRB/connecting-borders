<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Admin Page Layouts controller for the Pages module
 */
class Admin_Periods extends Admin_Controller {

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

		$this->load->model(array('periods_m', 'courses_m', 'schools_m','accommodations_m'));
		$this->lang->load(array('periods','schools'));

		// Validation rules
		$this->validation_rules = array(
			array(
				'field' => 'name',
				'label' => lang('periods:period'),
				'rules' => 'trim|required|max_length[50]'
			),
			array(
				'field' => 'price',
				'label' => lang('periods:price'),
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
		$total_rows = $this->periods_m->count_all();
		$pagination = create_pagination('admin/schools/periods/index', $total_rows, NULL, 5);
			
		// Using this data, get the relevant results
		$periods = $this->periods_m->order_by('name')->limit($pagination['limit'])->get_all();

		$this->template
			->title($this->module_details['name'], lang('cat_list_title'))
			->set('periods', $periods)
			->set('pagination', $pagination)
			->build('admin/periods/index');
	}
	
	/**
	 * Create method, creates a new category
	 *
	 * @return void
	 */
	public function create($parent = 0, $parentID = 0, $schoolID = 0)
	{
		if ($_POST)
		{
			$this->form_validation->set_rules($this->validation_rules);

			$name = $this->input->post('name');
			$price = $this->input->post('price');
			$price = str_replace(",", ".", $price);
			$semana = explode(" ", $name);
			$price *= $semana[0];
			$price = str_replace('.', ',', sprintf('%01.2f', $price));

			if ($this->form_validation->run())
			{
				if ($schoolID == 0){
					$schoolID = $this->schools_m->insert(array(
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
				if ($parentID == 0){
					if ($parent == 'courses'){
						$parentID = $this->courses_m->insert(array(
							'name' => '',
							'beginning' => $this->session->userdata('course_beginning'),
							'school_id' => $schoolID,
							'language_id' => '0',
							'hourly_load' => '',
							'body' => '',
							'type' => 'wysiwyg-advanced',
						));
					}

					if ($parent == 'accommodations'){
						$parentID = $this->accommodations_m->insert(array(
							'name' => '',
							'school_id' => $schoolID,
							'city_id' => '0',
							'body' => '',
						));
					}
				}
				if ($id = $this->periods_m->insert(array(
					'name' => $name,
					'price' => $price,
					'parent_id' => $parentID,
					'parent' => $parent,
					'year' => $this->input->post('year'),
				)))
				{
					// Fire an event. A new city has been added.
					Events::trigger('period_created', $id);

					$this->session->set_flashdata('success', sprintf(lang('periods:add_success'), $name));
				}
				else
				{
					$this->session->set_flashdata('error', sprintf(lang('periods:add_error'), $name));
				}
				redirect('admin/schools/'.$parent.'/edit/'.$parentID);
			}
		}
		
		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			$period->{$rule['field']} = set_value($rule['field']);
		}
		$period->year = '';
		$this->template
			->title($this->module_details['name'], lang('cat_create_title'))
			->set('period', $period)
                        ->set('parent', $parent)
			->build('admin/periods/form');	
	}
	
	/**
	 * Edit method, edits an existing category
	 * @access public
	 * @param int id The ID of the category to edit
	 * @return void
	 */
	public function edit($id = 0)
	{	
		$period = $this->periods_m->get($id);

		// Make sure we found something
		$period or redirect('admin/schools');
        $parent = $period->parent;
		$price = $period->price;
		$semana = explode(' ', $period->name);
		$price = str_replace(',', '.', $price);
		$price /= $semana[0];
		$price = str_replace('.', ',', sprintf('%01.2f', $price));
		$period->price = $price;
		if ($_POST)
		{			
			$this->form_validation->set_rules($this->validation_rules);

			$name = $this->input->post('name');
			$price = $this->input->post('price');
			$price = str_replace(",", ".", $price);
			$semana = explode(" ", $name);
			$price *= $semana[0];
			$price = str_replace('.', ',', sprintf('%01.2f', $price)); 

			if ($this->form_validation->run())
			{
				if ($success = $this->periods_m->update($id, array(
					'name' => $name,
					'price' => $price,
					'parent_id' => $period->parent_id,
					'parent' => $period->parent,
					'year' => $this->input->post('year'),
				)))
				{
					// Fire an event. A period has been updated.
					Events::trigger('period_updated', $id);
					$this->session->set_flashdata('success', sprintf(lang('periods:edit_success'), $name));
				}
				else
				{
					$this->session->set_flashdata('error', sprintf(lang('periods:edit_error'), $name));
				}
				redirect('admin/schools/'.$period->parent.'/edit/'.$period->parent_id);
			}
		}
		if(!$name) $name = '';
		$this->template
			->title($this->module_details['name'], sprintf(lang('periods:edit_title'), $name))
			->set('period', $period)
                        ->set('parent', $parent)
			->build('admin/periods/form');
	}	

	/**
	 * Delete method, deletes an existing category (obvious isn't it?)
	 * @access public
	 * @param int id The ID of the category to edit
	 * @return void
	 */
	public function delete($id = 0, $parent = NULL, $parentId = 0)
	{
		if ($success = $this->periods_m->delete($id))
		{
			// Fire an event. A period has been deleted.
			Events::trigger('period_deleted', $id);
			$this->session->set_flashdata('success', lang('periods:delete_success'));
		}
		else
		{
			$this->session->set_flashdata('error', lang('periods:delete_error'));
		}

		redirect('admin/schools/'.$parent.'/edit/'.$parentId);
	}

}
	
