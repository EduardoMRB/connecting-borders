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
class Widget_Internationalization extends Widgets {

    public $title = array(
        'en' => 'Internationalization',
        'br' => 'Internacionalização',
    );
    public $description = array(
        'en' => 'Choose internationalization language',
        'br' => 'Escolha do idioma para internacionalização',
    );
    public $author = 'Gustavo Liberatti';
    public $website = 'http://infocorpconsultoria.com.br';
    public $version = '1.0';
    public $fields = array(
    );

    public function run() {
        
    }

}
