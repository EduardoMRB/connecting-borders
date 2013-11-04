<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Public Blog module controller
 *
 * @author	Infocorp Consultoria
 *
 */
class Cities extends Public_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('cities_m', 'accommodations_m'));
		$this->load->model('countries/countries_m');
		$this->load->model('traveling/traveling_m');
		$this->lang->load('cities');
		$this->load->model('users/user_m');
	}


	public function informations($id = 0, $travel = 0, $accommodation = 0)
	{
		$city = $this->cities_m->get($id);
		$country = $this->countries_m->get($city->country_id); 
		$accommodation = $this->accommodations_m->get($accommodation);
		$this->template
			->set('city', $city)
			->set('country', $country)
			->set('travel', $travel)
			->set('accommodation', $accommodation)
			->build('informations');
	}

	public function estimate($id = 0, $travel = 0, $accommodation = 0)
	{
		$city = $this->cities_m->get($id);
		$accommodation = $this->accommodations_m->get($accommodation);
		$travel = $this->traveling_m->get($travel);
		$this->template
			->set('city', $city)
			->set('travel', $travel)
			->set('accommodation', $accommodation)
			->build('estimate');
	}
	
	/*
	 public function pdf($tourism = 0, $accommodation = 0 ,$period = 0, $travel = 0) {
		$tourism = $this->tourisms_m->get($tourism);
		$period = $this->periods_m->get($period);
		$accommodation = $this->accommodations_m->get($accommodation);
		$travel = $this->travelling_m->get($travel);
		$this->template
			->set('tourism', $tourism)
			->set('period', $period)
			->set('accommodation', $accommodation)
			->set('travel', $travel)
			->build('pdf');
	}
	
	public function email($tourism = 0, $accommodation = 0, $period = 0, $travel = 0) {
		$tourism = $this->tourisms_m->get($tourism);
		$period = $this->periods_m->get($period);
		$accommodation = $this->accommodations_m->get($accommodation);
		$travel = $this->travelling_m->get($travel);
		$this->template
			->set('tourism', $tourism)
			->set('period', $period)
			->set('accommodation', $accommodation)
			->set('travel', $travel)
			->build('email');
	} */

	public function submit($id = 0, $travel = 0, $accommodation = 0) {
		$city = $this->cities_m->get($id);
		$country = $this->countries_m->get($city->country_id);
		$accommodation = $this->accommodations_m->get($accommodation);
		$user = array('name' => $this->input->post('name'), 'email' => $this->input->post('email'));
		$travel = $this->traveling_m->get($travel);
		$date = $this->input->post('data');
		$this->template
			 ->set('city', $city)
			 ->set('user', $user)
			 ->set('travel', $travel)
			 ->set('accommodation', $accommodation)
			 ->set('country', $country)
			 ->set('date', $date)
			 ->build('submit');
	}
}
