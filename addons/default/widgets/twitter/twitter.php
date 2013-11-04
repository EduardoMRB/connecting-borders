<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package 		PyroCMS
 * @subpackage 		Tweet Widget
 * @author		Henrique Oliveira Marques - Infocorp Development Team
 *
 * Show Twitter button in your site
 */
class Widget_Twitter extends Widgets {

    public $title = array(
        'en' => 'Tweet',
        'pt' => 'Tweet',
    );
    public $description = array(
        'en' => 'Display tweet button.',
        'pt' => 'Habilita botão tweet do Twitter.',
    );
    public $author = 'Henrique Oliveira Marques';
    public $website = 'http://infocorpconsultoria.com.br';
    public $version = '1.0';
    public $fields = array(
        array(
            'field' => 'via',
            'label' => 'Twitter',
            'rules' => 'required'
        ),
        array(
            'field' => 'count',
            'label' => 'Escolha o layout do  botão.',
            'rules' => 'required'
        )
    );

    public function form($options) {
        return array('count' => array(
                'vertical' => 'vertical',
                'horizontal' => 'horizontal',
                'none' => 'none',
            )
        );
    }

    public function run($options) {
        return $options;
    }

}