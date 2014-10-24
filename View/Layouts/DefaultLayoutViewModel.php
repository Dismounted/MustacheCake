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

/**
 * Initialise view model.
 *
 * @return void
 */
	protected function _init() {
		$this->cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
	}

/**
 * Returns page charset.
 *
 * @return string
 */
	public function charset() {
		return $this->_View->Html->charset();
	}

/**
 * Returns favicon.
 *
 * @return string
 */
	public function icon() {
		return $this->_View->Html->meta('icon');
	}

/**
 * Returns CakePHP default CSS.
 *
 * @return string
 */
	public function cssCakeGeneric() {
		return $this->_View->Html->css('cake.generic');
	}

/**
 * Returns page metadata.
 *
 * @return string
 */
	public function meta() {
		return $this->_View->fetch('meta');
	}

/**
 * Returns additional CSS.
 *
 * @return string
 */
	public function css() {
		return $this->_View->fetch('css');
	}

/**
 * Returns Javascript.
 *
 * @return string
 */
	public function script() {
		return $this->_View->fetch('script');
	}

/**
 * Returns CakePHP website link.
 *
 * @return string
 */
	public function cakeLink() {
		return $this->_View->Html->link($this->cakeDescription, 'http://cakephp.org');
	}

/**
 * Returns SessionComponent flash messages.
 *
 * @return string
 */
	public function sessionFlash() {
		return $this->_View->Session->flash();
	}

/**
 * Returns page content.
 *
 * @return string
 */
	public function content() {
		return $this->_View->fetch('content');
	}

/**
 * Returns CakePHP image.
 *
 * @return string
 */
	public function cakeImage() {
		return $this->_View->Html->link(
			$this->_View->Html->image('cake.power.gif', array('alt' => $this->cakeDescription, 'border' => '0')),
			'http://www.cakephp.org/',
			array('target' => '_blank', 'escape' => false)
		);
	}

/**
 * Returns SQL dump for debugging.
 *
 * @return string
 */
	public function sqlDump() {
		return $this->_View->element('sql_dump');
	}

}
