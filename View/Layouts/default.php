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

App::uses('MustacheRender', 'MustacheCake.View');

/**
 * Cake default layout render class.
 *
 * @package       MustacheCake.View
 */
class DefaultLayoutRender extends MustacheRender {

	public function __construct(MustacheView $view = null, $viewVars = array()) {
		parent::__construct($view, $viewVars);
		$this->cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
	}

	public function charset() {
		return $this->_view->Html->charset();
	}

	public function icon() {
		return $this->_view->Html->meta('icon');
	}

	public function cssCakeGeneric() {
		return $this->_view->Html->css('cake.generic');
	}

	public function cakeLink() {
		return $this->_view->Html->link($this->cakeDescription, 'http://cakephp.org');
	}

	public function sessionFlash() {
		return $this->_view->Session->flash();
	}

	public function cakeImage() {
		return $this->_view->Html->link(
			$this->_view->Html->image('cake.power.gif', array('alt' => $this->cakeDescription, 'border' => '0')),
			'http://www.cakephp.org/',
			array('target' => '_blank', 'escape' => false)
		);
	}

	public function sqlDump() {
		return $this->_view->element('sql_dump');
	}

}
