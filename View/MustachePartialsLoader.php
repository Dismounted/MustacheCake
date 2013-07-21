<?php
/**
 * MustacheCake
 *
 * A Mustache implementation for CakePHP.
 *
 * @copyright     Copyright (c) Hanson Wong
 * @link          https://github.com/Dismounted/MustacheCake
 * @package       MustacheCake.View
 * @license       https://github.com/Dismounted/MustacheCake/blob/master/LICENSE Simplified BSD License
 */

if (class_exists('Mustache_Autoloader', false) === false) {
	App::import('Vendor', 'MustacheCake.Mustache_Autoloader', array('file' => 'Mustache' . DS . 'src' . DS . 'Mustache' . DS . 'Autoloader.php'));
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
	protected $_View;

	/**
	 * Constructor.
	 *
	 * @param MustacheView $View View object calling the render.
	 */
	public function __construct(MustacheView $View) {
		$this->_View = $View;
	}

	/**
	 * Load a Template by name. Returning empty string on failure matches Cake behaviour.
	 *
	 * @param string $name
	 * @return string Mustache template source.
	 */
	public function load($name) {
		$file = $this->_View->getPartialFileName($name);

		if ($file === false) {
			return '';
		}

		return file_get_contents($file);
	}

}
