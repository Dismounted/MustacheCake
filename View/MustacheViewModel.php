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
 * Mustache view model.
 *
 * Mustache views can create an extra file in the same directory and extend this class.
 * The class will be instantiated automatically by the MustacheView class when required.
 *
 * @package       MustacheCake.View
 */
abstract class MustacheViewModel {

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

		foreach ($viewVars as $name => $data) {
			$this->{$name} = $data;
		}

		$this->_init();
	}

/**
 * Called during construction.
 *
 * This is useful if you need to set up class properties or add things to blocks (e.g. CSS).
 * It is better to override this, rather than MustacheViewModel::__construct().
 *
 * This method is not abstract because overriding it is not necessary.
 *
 * @return void
 */
	protected function _init() {
	}

}
