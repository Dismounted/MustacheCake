<?php
/**
 * MustacheCake
 *
 * A Mustache implementation for CakePHP.
 *
 * @copyright     Copyright (c) Hanson Wong
 * @link          https://github.com/Dismounted/MustacheCake
 * @package       MustacheCake.View
 * @license       Simplified BSD License (https://github.com/Dismounted/MustacheCake/blob/master/LICENSE)
 */

if (class_exists('Mustache_Autoloader', false) === false) {
	App::import('Vendor', 'Mustache_Autoloader', array('file' => 'Mustache' . DS . 'src' . DS . 'Mustache' . DS . 'Autoloader.php'));
	Mustache_Autoloader::register();
}

/**
 * Mustache partials loader.
 *
 * This class attempts to bridge Cake's elements and Mustache's partials.
 *
 * @package       MustacheCake.View
 */
class MustachePartialsLoader implements Mustache_Loader {

	/**
	 * An instance of the View object.
	 *
	 * @var MustacheView
	 */
	protected $_view;

	/**
	 * Constructor.
	 *
	 * @param MustacheView $view View object calling the render.
	 */
	public function __construct(MustacheView $view) {
		$this->_view = $view;
	}

	/**
	 * Load a Template by name.
	 *
	 * @param string $name
	 * @return string Mustache Template source
	 */
	public function load($name) {
		$file = $this->_view->getPartialFileName();

		if ($file === false) {
			throw new MissingViewException(array('file' => $name));
		}

		return file_get_contents($file);
	}

}
