<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Countries module
 *
 * @author Infocorp Consultoria
 * @developer Henrique Oliveira Marques
 * @package Modules\Countries
 */
class Module_Ajax extends Module {

    public $version = '0';

    public function info() {
        return array(
            'name' => array(
                'en' => 'Ajax integration',
                'br' => "Integração Ajax",
            ),
            'description' => array(
                'en' => 'Manager ajax request to models',
                'br' => 'Centralizar requisições ajax a camada de banco',
            ),
            'frontend' => true,
            'backend' => false,
            'menu' => 'utils',
            'shortcuts' => array(
            ),
        );
    }

    public function install() {

        return true;
    }

    public function uninstall() {
        return true;
    }

    public function upgrade($old_version) {
        
    }

}
