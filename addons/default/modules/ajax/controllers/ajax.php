<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * @author Infocorp Consultoria
 * @developer Henrique Oliveira Marques
 * @package Modules\Countries\Controllers
 *
 */
class Ajax extends Public_Controller {

    public function __construct() {
        parent::__construct();
    }

    private $public_modules = array(
        "languages" => "languages/languages_m"
        , "periods" => "schools/periods_m"
        , "accommodations" => "cities/accommodations_m"
        , "traveling" => "traveling/traveling_m"
        , "schools" => "schools/schools_m"
        , 'countries' => 'countries/countries_m'
        , 'cities' => 'cities/cities_m'
        , 'courses' => 'schools/courses_m');
    
    private $public_session = array("lang");

    public function permit($model) {


        foreach ($this->public_modules as $key => $value) {
            if ($key == $model) {
                $this->load->model($this->public_modules[$model]);
                return true;
            }
        }
        die('Acesso negado !');
    }

    public function permit_session($attr) {
        foreach ($this->public_session as $a) {
            if ($attr == $a) {
                return true;
            }
        }
        die('Acesso negado !');
    }

    public function index() {
        $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('status' => 'ok')));
    }

    public function get($model, $filter, $attr = null, $value = null) {
        $this->permit($model);
        if (is_null($attr) || is_null($value)) {
            $query = $this->{$model . '_m'}->{$filter}();
        } else {
            $query = $this->{$model . '_m'}->{$filter}($attr, $value);
        }
        $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($this->drop($query)));
    }

    private function drop($query) {
        $options = array();
        if (is_array($query)) {
            foreach ($query as $row) {
                $options[$row->id] = $row->name;
            }
        }else
            $options[$query->id] = $query->name;
        return $options;
    }

    public function session($attr, $value) {
        if ($this->permit_session($attr)) {
            $this->session->set_userdata($attr, $value);
            redirect(); 
        }
    }
	
	public function drop_price($query) {
		$options = array();
        if (is_array($query)) {
            foreach ($query as $row) {
                $options[$row->id] = $row->price;
            }
        }else
            $options[$query->id] = $query->price;
        return $options;
	}
	
	public function price($model, $filter, $attr = null, $value = null) {
		$this->permit($model);
        if (is_null($attr) || is_null($value)) {
            $query = $this->{$model . '_m'}->{$filter}();
        } else {
            $query = $this->{$model . '_m'}->{$filter}($attr, $value);
        }
        $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($this->drop_price($query)));
	}
}
