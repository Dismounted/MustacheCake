<?php
App::uses('MustacheViewModel', 'MustacheCake.View');

class TestViewModel extends MustacheViewModel {

/**
 * Returns the view instance.
 *
 * @return MustacheView
 */
	public function getView() {
		return $this->_View;
	}

/**
 * Returns a simple greeting.
 *
 * @return string
 */
	public function greeting() {
		return 'Hello';
	}

}
