<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Show a login box in your widget areas
 * 
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Widgets
 */
class Widget_Exchange extends Widgets
{

	/**
	 * The translations for the widget title
	 *
	 * @var array
	 */
	public $title = array(
		'en' => 'Exchange',
		'br' => 'Intercambio',
	);

	/**
	 * The translations for the widget description
	 *
	 * @var array
	 */
	public $description = array(
		'en' => '',
		'br' => 'Permite que o usuário monte seu pacote de intercambio.',

	);

	/**
	 * The author of the widget
	 *
	 * @var string
	 */
	public $author = 'Infocorp Consultoria';

	/**
	 * The author's website.
	 * 
	 * @var string 
	 */
	public $website = 'http://infocorpconsultoria.com.br/';

	/**
	 * The version of the widget
	 *
	 * @var string
	 */
	public $version = '1.0';

	/**
	 * Runs code and logic required to display the widget.
	 */
	public function run()
	{
		return true;
	}

}
