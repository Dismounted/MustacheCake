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

App::uses('MustacheView', 'MustacheCake.View');
App::uses('MustachePartialsLoader', 'MustacheCake.View');

/**
 * MustachePartialsLoader test case.
 *
 * @package       MustacheCake.Test.Case.View
 */
class MustachePartialsLoaderTest extends CakeTestCase {

	public $PartialsLoader;

	public $viewPath;

	public function setUp() {
		parent::setUp();

		$View = new MustacheView();
		$this->PartialsLoader = new MustachePartialsLoader($View);

		$this->viewPath = CakePlugin::path('MustacheCake') . 'Test' . DS . 'test_app' . DS . 'View' . DS;
		App::build(array('View' => array($this->viewPath)), App::RESET);
	}

	public function tearDown() {
		parent::tearDown();

		unset($this->PartialsLoader);
		unset($this->viewPath);
	}

	public function testValidPartial() {
		$expected = 'Partial Test';
		$result = $this->PartialsLoader->load('test_partial');
		$this->assertEquals($expected, $result);
	}

	public function testInvalidPartial() {
		$expected = '';
		$result = $this->PartialsLoader->load('blah');
		$this->assertEquals($expected, $result);
	}

}
