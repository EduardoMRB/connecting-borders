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
class Widget_Latest_posts extends Widgets {

    public $title = array(
        'en' => 'Latest posts',
        'br' => 'Artigos recentes do article',
        'pt' => 'Artigos recentes do article',
        'el' => 'Τελευταίες αναρτήσεις ιστολογίου',
        'ru' => 'Последние записи',
        'id' => 'Post Terbaru',
    );
    public $description = array(
        'en' => 'Display latest article posts with a widget',
        'br' => 'Mostra uma lista de navegação para abrir os últimos artigos publicados no article',
        'pt' => 'Mostra uma lista de navegação para abrir os últimos artigos publicados no article',
        'el' => 'Προβάλει τις πιο πρόσφατες αναρτήσεις στο ιστολόγιό σας',
        'ru' => 'Выводит список последних записей блога внутри виджета',
        'id' => 'Menampilkan posting article terbaru menggunakan widget',
    );
    public $author = 'Erik Berman';
    public $website = 'http://www.nukleo.fr';
    public $version = '1.0';
    // build form fields for the backend
    // MUST match the field name declared in the form.php file
    public $fields = array(
        array(
            'field' => 'limit',
            'label' => 'Number of posts',
        ),
        array(
            'field' => 'category',
            'label' => 'Post category',
        )
    );

    public function form($options) {
        !empty($options['limit']) OR $options['limit'] = 6;
        class_exists('article_categories_m') OR $this->load->model('article/article_categories_m');
        $categories = $this->article_categories_m->get_all();

        foreach ($categories as $o) {
            $categories_options[$o->id] = $o->title;
        }

        return array(
            'options' => $options,
            'categories_options' => $categories_options
        );
    }

    public function run($options) {
        // load the article module's model
        class_exists('article_m') OR $this->load->model('article/article_m');
        // sets default number of posts to be shown
        empty($options['limit']) AND $options['limit'] = 6;

        // retrieve the records using the article module's model
        $article_widget = $this->article_m->distinct()
                ->limit($options['limit'])
                ->where(array('category_id' => $options['category'],'status' => 'live'))
                ->get_all();
        // returns the variables to be used within the widget's view
        return array('article_widget' => $article_widget);
    }

}

