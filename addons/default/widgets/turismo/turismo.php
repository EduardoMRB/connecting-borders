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
class Widget_Turismo extends Widgets {

    public $title = array(
        'en' => 'Tourism',
        'br' => 'Turismo',
    );
    public $description = array(
        'en' => 'Fast path do Stimate',
        'br' => 'Atalho para geração de orçamento',
    );
    public $author = 'Henrique Oliveira Marques';
    public $website = 'http://infocorpconsultoria.com.br';
    public $version = '1.0';
    // build form fields for the backend
    // MUST match the field name declared in the form.php file
    public $fields = array(
    );

    public function form($options) {
        !empty($options['limit']) OR $options['limit'] = 5;

        return array(
            'options' => $options
        );
    }

    public function run() {
        class_exists('countries_m') OR $this->load->model('countries/countries_m');
        class_exists('languages_m') OR $this->load->model('languages/languages_m');
        class_exists('traveling_m') OR $this->load->model('traveling/traveling_m');




        // returns the variables to be used within the widget's view
        return array('data' => json_encode("fu"));
    }

}
