<?php
/**
 * MustacheCake
 *
 * A Mustache implementation for CakePHP.
 *
 * @copyright     Copyright (c) Hanson Wong
 * @link          https://github.com/Dismounted/MustacheCake
 * @package       MustacheCake.Test.Case.View
 * @license       https://github.com/Dismounted/MustacheCake/blob/master/LICENSE Simplified BSD License
 */

App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');
App::uses('Controller', 'Controller');
App::uses('MustacheView', 'MustacheCake.View');

/**
 * Test MustacheView class.
 *
 * Exposes protected methods so we can test them.
 *
 * @package       MustacheCake.Test.Case.View
 */
class TestMustacheView extends MustacheView {

	public function evaluate($viewFile, $dataForView) {
		return $this->_evaluate($viewFile, $dataForView);
	}

	public function getViewExt($viewFile) {
		return $this->_getViewExt($viewFile);
	}

	public function getTemplateAsString($viewFile) {
		return $this->_getTemplateAsString($viewFile);
	}

	public function getRenderData($viewFile, $dataForView) {
		return $this->_getRenderData($viewFile, $dataForView);
	}

	public function getRenderClassName($file) {
		return $this->_getRenderClassName($file);
	}

	public function getMustacheCachePath() {
		return $this->_getMustacheCachePath();
	}

	public function getExtensions() {
		return $this->_getExtensions();
	}

}

/**
 * MustacheView test case.
 *
 * @package       MustacheCake.Test.Case.View
 */
class MustacheViewTest extends CakeTestCase {

	/**
	 * An instance of the mock request.
	 *
	 * @var CakeRequest
	 */
	public $Request;

	/**
	 * An instance of the mock response.
	 *
	 * @var CakeResponse
	 */
	public $Response;

	/**
	 * An instance of the mock controller.
	 *
	 * @var CakeResponse
	 */
	public $Controller;

	/**
	 * Set up needed objects to test with. Run before every test method.
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$this->Request = new CakeRequest();
		$this->Response = new CakeResponse();
		$this->Controller = new Controller($this->Request, $this->Response);
	}

	/**
	 * Unset things so we don't get mixed up.
	 *
	 * @return void
	 */
	public function tearDown() {
		parent::tearDown();
		unset($this->Request);
		unset($this->Response);
		unset($this->Controller);
	}

	/**
	 * Reusable method to fetch an instance of MustacheView.
	 *
	 * @return MustacheView A fresh object.
	 */
	protected function _getView() {
		return new MustacheView($this->Controller);
	}

}
