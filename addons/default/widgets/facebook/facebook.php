<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package 		PyroCMS
 * @subpackage 		Facebook Like Widget
 * @author		Henrique Oliveira Marques - Infocorp Development Team
 * 
 * Show Facebook like button in your site
 */
class Widget_Facebook extends Widgets {

    public $title = array(
        'en' => 'Facebook +1',
        'pt' => 'Facebook +1',
    );
    public $description = array(
        'en' => 'Display Facebook like button.',
        'pt' => 'Habilita botão curtir do Facebook.',
    );
    public $author = 'Henrique Oliveira Marques';
    public $website = 'http://infocorpconsultoria.com.br';
    public $version = '1.0';
    public $fields = array(
        array(
            'field' => 'link',
            'label' => 'Página para curtir',
            'rules' => 'required'
        ),
        array(
            'field' => 'layout',
            'label' => 'Escolha o layout do  botão.',
            'rules' => 'required'
        ),
        array(
            'field' => 'width',
            'label' => 'Escolha a largura do botão.',
            'rules' => 'required'
        ),
        array(
            'field' => 'faces',
            'label' => 'Deseja mostrar os Faces.',
            'rules' => 'required'
        ),
        array(
            'field' => 'button',
            'label' => 'Escolha o botão',
            'rules' => 'required'
        ), array(
            'field' => 'color',
            'label' => 'Escolha a cor dos botões.',
            'rules' => 'required'
        ), array(
            'field' => 'font',
            'label' => 'Escolha a fonte do botão',
            'rules' => 'required'
        )
    );

    public function form($options) {
        return array('layout' => array(
                'standard' => 'standard',
                'button_count' => 'button_count',
                'box_count' => 'box_count',
            ),
            'faces' => array(
                'true' => 'true',
                'false' => 'false',
            ),
            'button' => array(
                'like' => 'like',
                'recommend' => 'recommend',
            ),
            'color' => array(
                'light' => 'light',
                'dark' => 'dark',
            ),
            'font' => array(
                'arial' => 'arial',
                'lucida grande' => 'lucinda grande',
                'segoe ui' => 'segoe ui',
                'tahoma' => 'tahoma',
                'trebuchet ms' => 'trebuchet ms',
                'verdana' => 'verdana',
            ),
        );
    }

    public function run($options) {
        return $options;
    }

}
