<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * Show the quotes in your site with a widget. 
 * 
 * Intended for use on cms pages. Usage : 
 * on a CMS page add:
 * 
 * 		{widget_area('name_of_area')} 
 * 
 * 'name_of_area' is the name of the widget area you created in the  admin 
 * control panel
 * 
 * @author		Infocorp Consultoria
 * @author		Mattyws Ferreira Grawe
 * @package		Widgets/quotes
 */
class Widget_Quotes extends Widgets {

    public $title = array(
        'en' => 'Quotes',
        'br' => 'Frases',
    );
    public $description = array(
        'en' => 'Show the quotes in your website',
        'br' => 'Visualização das frases em seu website',
    );
    public $author = 'Mattyws Ferreira Grawe';
    public $website = 'http://infocorpconsultoria.com.br';
    public $version = '1.0';
    public $fields = array(
    );

    public function form($options) {
    	!empty($options['limit']) OR $options['limit'] = 1;		
		
        return array(
            'options' => $options
        );
    }

    public function run($options) {

        class_exists('page_m') OR $this->load->model('pages/page_m');
        class_exists('quotes_m') OR $this->load->model('quotes/quotes_m');
		$quote = $this->quotes_m->check_page($this->session->userdata('page_id'));
        return array(
            'quote' => $quote
            , 'options' => $options);
    }

}
