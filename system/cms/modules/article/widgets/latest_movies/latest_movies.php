<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Widget_Latest_movies extends Widgets {

    public $title = array(
        'en' => 'Latest movies',
        'br' => 'Vídeos recentes',
    );
    public $description = array(
        'en' => 'Display latest article movies with a widget',
        'br' => 'Mostra uma lista de navegação para abrir os últimos vídeos publicados em notícias',
    );
    public $author = 'Gustavo Liberatti';
    public $website = 'http://infocorpconsultoria.com.br';
    public $version = '1.0';
    // build form fields for the backend
    // MUST match the field name declared in the form.php file
    public $fields = array(
        array(
            'field' => 'limit',
            'label' => 'Number of movies',
        )
    );

    public function form($options) {
        !empty($options['limit']) OR $options['limit'] = 5;

        return array(
            'options' => $options
        );
    }

    public function run($options) {
        // load the article module's model
        $this->lang->load('article/movies');
        class_exists('article_movies_m') OR $this->load->model('article/article_movies_m');

        // sets default number of posts to be shown
        empty($options['limit']) AND $options['limit'] = 5;

        // retrieve the records using the article module's model
        $movie_widget = $this->article_movies_m->limit($options['limit'])->get_all();

        // returns the variables to be used within the widget's view
        return array('movie_widget' => $movie_widget);
    }

}