<?php
App::uses('MustacheViewModel', 'MustacheCake.View');

class TestViewModel extends MustacheViewModel {

	public function getView() {
		return $this->_View;
	}

	public function greeting() {
		return 'Hello';
	}

}
