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
class Widget_Schools_informations extends Widgets {

    public $title = array(
        'en' => 'Schools Informations',
        'br' => 'Informações da Escola',
    );
    public $description = array(
        'en' => 'Show the schools informations ',
        'br' => 'Visualização das informações extras do módulo escola',
    );
    public $author = 'Mattyws Ferreira Grawe';
    public $website = 'http://infocorpconsultoria.com.br';
    public $version = '1.0';
    public $fields = array(
    );

    public function form($options) {
    	!empty($options['limit']) OR $options['limit'] = 7;		
		
        return array(
            'options' => $options
        );
    }

    public function run($options) {

        class_exists('schools_m') OR $this->load->model('schools/schools_m');
        class_exists('cities_m') OR $this->load->model('cities/cities_m');
        class_exists('countries_m') OR $this->load->model('countries/countries_m');
		class_exists('school_informations_m') OR $this->load->model('schools/school_informations_m');
        $school = $this->schools_m->get($this->session->userdata('school_id'));
        $school->city = $this->cities_m->get($school->city_id);
        $school->country = $this->countries_m->get($school->city->country_id);
		$school->informations = $this->school_informations_m->get_schools($school->id);
        return array(
            'school' => $school
            , 'options' => $options);
    }

}
