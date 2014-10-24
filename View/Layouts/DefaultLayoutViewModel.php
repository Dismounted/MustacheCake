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
 * init
 *
 * @return void
 */
	protected function _init() {
		$this->cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
	}

/**
 * renders page charset
 *
 * @return string
 */
	public function charset() {
		return $this->_View->Html->charset();
	}

/**
 * renders meta icon
 *
 * @return string icon code
 */
	public function icon() {
		return $this->_View->Html->meta('icon');
	}

/**
 * renders css
 *
 * @return string css code
 */
	public function cssCakeGeneric() {
		return $this->_View->Html->css('cake.generic');
	}

/**
 * renders meta
 *
 * @return string meta tag
 */
	public function meta() {
		return $this->_View->fetch('meta');
	}

/**
 * renders css
 *
 * @return string CSS code
 */
	public function css() {
		return $this->_View->fetch('css');
	}

/**
 * renders java script
 *
 * @return string java script code
 */
	public function script() {
		return $this->_View->fetch('script');
	}

/**
 * renders link to cake
 *
 * @return string cake link
 */
	public function cakeLink() {
		return $this->_View->Html->link($this->cakeDescription, 'http://cakephp.org');
	}

/**
 * renders flash messages
 *
 * @return string html code
 */
	public function sessionFlash() {
		return $this->_View->Session->flash();
	}

/**
 * renders content
 *
 * @return string
 */
	public function content() {
		return $this->_View->fetch('content');
	}

/**
 * renders cake image
 *
 * @return string html code
 */
	public function cakeImage() {
		return $this->_View->Html->link(
			$this->_View->Html->image('cake.power.gif', array('alt' => $this->cakeDescription, 'border' => '0')),
			'http://www.cakephp.org/',
			array('target' => '_blank', 'escape' => false)
		);
	}

/**
 * renders sql dump
 *
 * @return string html code
 */
	public function sqlDump() {
		return $this->_View->element('sql_dump');
	}

}
