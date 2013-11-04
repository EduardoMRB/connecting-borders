<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Show a list of article categories.
 * 
 * @author		PyroCMS Dev Team
 * @author		Stephen Cozart
 * @package 	PyroCMS\Core\Modules\article\Widgets
 */
class Widget_Faq_categories extends Widgets {

    public $title = array(
        'en' => 'Faq Categories',
        'br' => 'Faq do article',
    );
    public $description = array(
        'en' => 'Show a list of faq categories',
        'br' => 'Mostra uma lista de faz com as categorias do article',
    );
    public $author = 'Gustavo Liberatti';
    public $website = 'http://infocorpconsultoria.com.br';
    public $version = '1.0';
    public $fields = array(
        array(
            'field' => 'category',
            'label' => 'Category',
        )
    );

    public function form($options) {
        $this->load->model('faq/faqs_categories_m');
        $categories = $this->faqs_categories_m->category_options();

        return array(
            'options' => $options,
            'categories' => $categories,
        );
    }

    public function run($options) {
        class_exists('faq/faq_m') OR $this->load->model('faq/faq_m');
        class_exists('faq/faqs_categories_m') OR $this->load->model('faq/faqs_categories_m');
        $faq_widget = $this->faq_m->get_many_by(array('category_id' => $options['category']));
        $category = $this->faqs_categories_m->get($faq_widget[0]->id);

        return array(
            'faq_widget' => $faq_widget,
            'category' => $category
        );
    }

}
