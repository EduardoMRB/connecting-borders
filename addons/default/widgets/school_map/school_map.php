<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * Show Latest article in your site with a widget. 
 * 
 * Intended for use on cms pages. Usage : 
 * on a CMS page add:
 * 
 * 		{widget_area('name_of_area')} 
 * 
 * 'name_of_area' is the name of the widget area you created in the  admin 
 * control panel
 * 
 * @author		Erik Berman
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\article\Widgets
 */
class Widget_School_map extends Widgets {

    public $title = array(
        'en' => 'Schoop map',
        'br' => 'Mapa escolar',
    );
    public $description = array(
        'en' => 'Show school map ',
        'br' => 'Visualização do mapa do módulo escola',
    );
    public $author = 'Gustavo Liberatti';
    public $website = 'http://infocorpconsultoria.com.br';
    public $version = '1.0';
    public $fields = array(
        array(
            'field' => 'width',
            'label' => 'Width',
            'rules' => 'required'
        ),
        array(
            'field' => 'height',
            'label' => 'Height',
            'rules' => 'required'
        ),
        array(
            'field' => 'zoom',
            'label' => 'Zoom Level',
            'rules' => 'numeric'
        )
    );

    public function form($options) {
       return array(
            'options' => $options
        );
    }

    public function run($options) {

        class_exists('schools_m') OR $this->load->model('schools/schools_m');
        class_exists('cities_m') OR $this->load->model('cities/cities_m');
        class_exists('countries_m') OR $this->load->model('countries/countries_m');
        $school = $this->schools_m->get($this->session->userdata('school_id'));
        $school->city = $this->cities_m->get($school->city_id);
        $school->country = $this->countries_m->get($school->city->country_id);
        return array(
            'school' => $school
            , 'options' => $options);
    }

}
