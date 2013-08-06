<?php
/**
 * MustacheCake
 *
 * A Mustache implementation for CakePHP.
 *
 * @copyright     Copyright (c) Hanson Wong
 * @link          https://github.com/Dismounted/MustacheCake
 * @package       MustacheCake.View.Layouts
 * @license       https://github.com/Dismounted/MustacheCake/blob/master/LICENSE Simplified BSD License
 */

App::uses('MustacheViewModel', 'MustacheCake.View');

/**
 * Cake default layout view model.
 *
 * @package       MustacheCake.View.Layouts
 */
class DefaultLayoutViewModel extends MustacheViewModel {

	protected function _init() {
		$this->cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
	}

	public function charset() {
		return $this->_View->Html->charset();
	}

	public function icon() {
		return $this->_View->Html->meta('icon');
	}

	public function cssCakeGeneric() {
		return $this->_View->Html->css('cake.generic');
	}

	public function meta() {
		return $this->_View->fetch('meta');
	}

	public function css() {
		return $this->_View->fetch('css');
	}

	public function script() {
		return $this->_View->fetch('script');
	}

	public function cakeLink() {
		return $this->_View->Html->link($this->cakeDescription, 'http://cakephp.org');
	}

	public function sessionFlash() {
		return $this->_View->Session->flash();
	}

	public function content() {
		return $this->_View->fetch('content');
	}

	public function cakeImage() {
		return $this->_View->Html->link(
			$this->_View->Html->image('cake.power.gif', array('alt' => $this->cakeDescription, 'border' => '0')),
			'http://www.cakephp.org/',
			array('target' => '_blank', 'escape' => false)
		);
	}

	public function sqlDump() {
		return $this->_View->element('sql_dump');
	}

}
