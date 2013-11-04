<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package 		Infocorp
 * @subpackage 		Slider Widget
 * @author			Gustavo Liberatti
 *
 * Create an image slider from a folder
 */
class Widget_Image_Slider extends Widgets {

    public $title = array(
        'en' => 'Image Slider',
        'pt' => 'Image Slider'
    );
    public $description = array(
        'en' => 'Create an image slider from a folder',
        'pt' => 'Cria um slider de imagens a partir de uma pasta'
    );
    public $author = 'Gustavo Liberatti';
    public $website = 'http://infocorpconsultoria.com.br/';
    public $version = '1.2';
    public $fields = array(
        array(
            'field' => 'folder_id',
            'label' => 'Folder',
            'rules' => 'required'
        ),
        array(
            'field' => 'auto_slide',
            'label' => 'Auto Slide',
            'rules' => 'required'
        ),
        array(
            'field' => 'navigation',
            'label' => 'Navegation',
            'rules' => 'required'
        ),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'required'
        ),
		array(
            'field' => 'id',
            'label' => 'Identification',
            'rules' => 'required'
        )
    );

    public function form() {
        $this->load->model('files/file_folders_m');
        $folders = $this->load->file_folders_m->get_folders();
        $folder_list = array();
        foreach ($folders as $folder) {
            $folder_list[$folder->id] = $folder->name;
        }
        return array('folder_list' => $folder_list);
    }

    public function run($options) {
        $this->load->model('files/file_m');
        $this->load->helper('html');
        foreach ($options as $key => $value) {
            $data[$key] = $value;
        }
        $data['folder']='uploads/default/files/';
        $data['image_list'] = $this->file_m->get_many_by(array('folder_id' => $options['folder_id']));
        return $data;
    }

    public function save($options) {
        return $options;
    }

}