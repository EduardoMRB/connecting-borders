<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Public Blog module controller
 *
 * @author	Infocorp Consultoria
 *
 */
class Schools extends Public_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('schools_m', 'courses_m', 'accommodations_m','fares_m', 'periods_m'));
		$this->load->model('cities/cities_m');
		$this->load->model('countries/countries_m');
		$this->lang->load('schools');
		$this->lang->load('courses');
		$this->lang->load('accommodations');
		$this->load->library('languages/languages');
		$this->load->model('languages/languages_m');
		$this->load->model('users/user_m');
		$this->load->library('pdf');
		$this->load->library('email');
	}


	public function informations($course = 0)
	{
		$course = $this->courses_m->get($course);
		$school = $this->schools_m->get($course->school_id);
		$this->session->set_userdata(array("school_id" => $school->id));
		$accommodations = $this->accommodations_m->get_schools($school->id);
		$fares = $this->fares_m->get_schools($school->id);
		$city = $this->cities_m->get($school->city_id);
		$this->template
			->set('course', $course)
			->set('school', $school)
			->set('accommodations', $accommodations)
			->set('fares', $fares)
			->set('city', $city)
			->build('informations');
	}

	public function estimate($course = 0)
	{
		$course = $this->courses_m->get($course);
		$beginning = explode(",", $course->beginning);
		$now = strtotime(date('d-m-Y'));
		for ($i = 0; $i < count($beginning); $i++) {
			$aux = strtotime($beginning[$i]);
			if($aux <= $now){
				unset($beginning[$i]);
			}
		}
		$school = $this->schools_m->get($course->school_id);
		$this->session->set_userdata(array("school_id" => $school->id));
		$accommodations = $this->accommodations_m->get_schools($school->id);
		$periods = $this->periods_m->get_parent($course->id, 'courses');
		$country = $this -> countries_m -> get($this -> cities_m -> get($school -> city_id) -> country_id);
		$this->template
			->set('course', $course)
			->set('school', $school)
			->set('country', $country)
			->set('beginning', $beginning)
			->set('accommodations', $accommodations)
			->build('estimate');
	}

	public function calculate($course = 0, $date= 0, $periodA = 0)
	{
		$accommodation = $this->accommodations_m->get($this->input->post('accommodation'));
		$course = $this->courses_m->get($course);
		$school = $this->schools_m->get($course->school_id);
		$this->session->set_userdata(array("school_id" => $school->id));
		$fares = $this->fares_m->get_schools($school->id);
		$period = $this->periods_m->get($this->input->post('periods'));
		$periodA = $this->periods_m->get($periodA);
		$beginning = $course->beginning;
		$beginning = explode(',', $beginning);
		$beginning = array('id' => $date, 'value' => $beginning[$date]);
		$transfer = $this->input->post('transfer');
		if ($transfer == 'chegada') {
			$transfer = $school->transferc;
			$trans = 1;
		}else if ($transfer == 'partida') {
			$transfer = $school->transfercp;
			$trans = 2;
		}else {
			$transfer = '0';
			$trans = 0;
		}
		$this->template
			->set('course', $course)
			->set('period', $period)
			->set('periodA', $periodA)
			->set('school', $school)
			->set('transfer', $transfer)
			->set('beginning', $beginning)
			->set('trans', $trans)
			->set('fares', $fares)
			->set('accommodation', $accommodation)
			->build('calculate');
	}
	
	public function pdf($course = 0, $courseP = 0, $accommodation = 0, $accommodationP = 0, $transfer = 0, $inicio = 0) {
		$course = $this->courses_m->get($course);
		$school = $this->schools_m->get($course->school_id);
		$city = $this->cities_m->get($school->city_id);
		$country = $this->countries_m->get($city->country_id);
		$courseP = $this->periods_m->get($courseP);
		$accommodation = $this->accommodations_m->get($accommodation);
		$accommodationP = $this->periods_m->get($accommodationP);
		$fares = $this->fares_m->get_schools($school->id);
		$beginning = $course->beginning;
		$beginning = explode(',', $beginning);
		$beginning = $beginning[$inicio];
		switch ($transfer) {
			case 1:
				$transfer = array('name' => 'Transfer de Chegada', 'value' => $school->transferc, 'id' => 1);
				break;
			case 2:
				$transfer = array('name' => 'Transfer de Chegada e Partida', 'value' => $school->transfercp, 'id' => 2);
				break;
			default:
				$transfer = 0;
				break;
		}
		
		$this->template
			->set('course', $course)
			->set('school', $school)
			->set('city', $city)
			->set('beginning', $beginning)
			->set('country', $country)
			->set('courseP', $courseP)
			->set('fares', $fares)
			->set('transfer', $transfer)
			->set('accommodation', $accommodation)
			->set('accommodationP', $accommodationP)
			->build('pdf');
	}
	
	public function email($course = 0, $courseP = 0, $accommodation = 0, $accommodationP = 0, $transfer = 0, $inicio = 0) {
		$course = $this->courses_m->get($course);
		$school = $this->schools_m->get($course->school_id);
		$this->session->set_userdata(array("school_id" => $school->id));
		$city = $this->cities_m->get($school->city_id);
		$country = $this->countries_m->get($city->country_id);
		$courseP = $this->periods_m->get($courseP);
		$accommodation = $this->accommodations_m->get($accommodation);
		$accommodationP = $this->periods_m->get($accommodationP);
		$fares = $this->fares_m->get_schools($school->id);
		$beginning = $course->beginning;
		$beginning = explode(',', $beginning);
		$beginning = $beginning[$inicio];
		switch ($transfer) {
			case 1:
				$transfer = array('name' => 'Transfer de Chegada', 'value' => $school->transferc);
				break;
			case 2:
				$transfer = array('name' => 'Transfer de Chegada e Partida', 'value' => $school->transfercp);
				break;
			default:
				$transfer = 0;
				break;
		}
		$this->template
			->set('course', $course)
			->set('school', $school)
			->set('city', $city)
			->set('country', $country)
			->set('courseP', $courseP)
			->set('fares', $fares)
			->set('beginning', $beginning)
			->set('transfer', $transfer)
			->set('accommodation', $accommodation)
			->set('accommodationP', $accommodationP)
			->build('email');
	}

	public function submit($course = 0, $courseP = 0, $accommodation = 0, $accommodationP = 0, $transfer = 0, $inicio = 0) {
		$course = $this->courses_m->get($course);
		$school = $this->schools_m->get($course->school_id);
		$city = $this->cities_m->get($school->city_id);
		$country = $this->countries_m->get($city->country_id);
		$courseP = $this->periods_m->get($courseP);
		$accommodation = $this->accommodations_m->get($accommodation);
		$accommodationP = $this->periods_m->get($accommodationP);
		$fares = $this->fares_m->get_schools($school->id);
		$user = array('name' => $this->input->post('name'), 'email' => $this->input->post('email'));
		switch ($transfer) {
			case 1:
				$transfer = array('name' => 'Transfer de Chegada', 'value' => $school->transferc);
				break;
			case 2:
				$transfer = array('name' => 'Transfer de Chegada e Partida', 'value' => $school->transfercp);
				break;
			default:
				$transfer = 0;
				break;
		}
		$beginning = $course->beginning;
		$beginning = explode(',', $beginning);
		$beginning = $beginning[$inicio];
		$this->template
			->set('course', $course)
			->set('school', $school)
			->set('city', $city)
			->set('country', $country)
			->set('courseP', $courseP)
			->set('fares', $fares)
			->set('transfer', $transfer)
			->set('beginning', $beginning)
			->set('user', $user)
			->set('accommodation', $accommodation)
			->set('accommodationP', $accommodationP)
			->build('submit');
	}

}
