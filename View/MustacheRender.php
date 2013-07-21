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

/**
 * Mustache render class.
 *
 * Mustache views can create an extra file in the same directory and extend this class.
 * The class will be instantiated automatically by the MustacheView class when required.
 *
 * Note that Cake's "view blocks" are auto-imported as view variables with this class.
 *
 * @package       MustacheCake.View
 */
abstract class MustacheRender {

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
	 * @param array $viewVars Variables to plug into the template.
	 */
	public function __construct(MustacheView $View = null, $viewVars = array()) {
		$this->_View = $View;

		if (method_exists($this, 'init') === true) {
			$this->init();
		}

		foreach ($viewVars as $name => $data) {
			$this->{$name} = $data;
		}

		foreach ($View->blocks() as $name) {
			$this->{$name} = $View->fetch($name);
		}
	}

}
