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

App::uses('Cache', 'Cache');
App::uses('Controller', 'Controller');
App::uses('MustacheView', 'MustacheCake.View');

/**
 * MustacheCake controller for testing.
 *
 * @package       MustacheCake.Test.Case.View
 */
class TestMustacheController extends Controller {

	public $name = 'Mustache';
	public $uses = null;
	public $viewClass = 'MustacheCake.Mustache';
	public $ext = '.mustache';

	public function index() {
		$this->set('planet', 'world');
	}

}

/**
 * Test MustacheView class.
 *
 * Exposes protected methods so we can test them.
 *
 * @package       MustacheCake.Test.Case.View
 */
class TestMustacheView extends MustacheView {

	public function getViewExt($viewFile) {
		return $this->_getViewExt($viewFile);
	}

	public function getRenderData($viewFile, $dataForView) {
		return $this->_getRenderData($viewFile, $dataForView);
	}

	public function getViewModelName($file) {
		return $this->_getViewModelName($file);
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

	public $Controller;
	public $View;
	public $viewPath;

	public function setUp() {
		parent::setUp();

		$request = $this->getMock('CakeRequest');
		$this->Controller = new TestMustacheController($request);
		$this->Controller->index();
		$this->View = new TestMustacheView($this->Controller);

		$this->viewPath = CakePlugin::path('MustacheCake') . 'Test' . DS . 'test_app' . DS . 'View' . DS;
		App::build(array('View' => array($this->viewPath)), App::RESET);
	}

	public function tearDown() {
		parent::tearDown();

		unset($this->Controller);
		unset($this->View);
		unset($this->viewPath);
	}

	public function testMustacheEngineInstance() {
		$this->assertInstanceOf('Mustache_Engine', $this->View->mustache);
	}

	public function testGetViewExt() {
		$path = $this->viewPath . 'Mustache/index.mustache';
		$this->assertEquals('.mustache', $this->View->getViewExt($path));
	}

	public function testGetViewModelName() {
		$path = $this->viewPath . 'Mustache/viewmodel.php';
		$this->assertEquals('TestViewModel', $this->View->getViewModelName($path));
		$this->assertEquals('', $this->View->getViewModelName('blah'));
	}

	public function testGetMustacheCachePath() {
		$settings = Cache::config('default');

		Cache::drop('default');
		$this->assertNull($this->View->getMustacheCachePath());

		Cache::config('default', $settings);
		$this->assertInternalType('string', $this->View->getMustacheCachePath());
	}

	public function testGetExtensions() {
		$exts = $this->View->getExtensions();
		$this->assertInternalType('array', $exts);
		$this->assertContains('.mustache', $exts);
		$this->assertContains('.ctp', $exts);
	}

	public function testTokenErrorSuppress() {
		$this->assertTrue(TestMustacheView::handleTokenError());
	}

	public function testGetPartialFileName() {
		$path = $this->viewPath . 'Elements/test_partial.mustache';
		$this->assertEquals($path, $this->View->getPartialFileName('test_partial'));
		$this->assertFalse($this->View->getPartialFileName('blah'));
	}

	public function testGetRenderData() {
		$vars = array('foo' => 'bar');

		$path = $this->viewPath . 'Mustache/index.mustache';
		$result = $this->View->getRenderData($path, $vars);
		$this->assertEquals($vars, $result);

		$path = $this->viewPath . 'Mustache/viewmodel.mustache';
		$result = $this->View->getRenderData($path, $vars);
		$this->assertInstanceOf('TestViewModel', $result);
	}

	public function testViewModelViewObject() {
		$path = $this->viewPath . 'Mustache/viewmodel.mustache';
		$ViewModel = $this->View->getRenderData($path, array());
		$this->assertInstanceOf('MustacheView', $ViewModel->getView());
	}

	public function testRenderSimple() {
		$expected = 'Mustache Index';
		$result = $this->View->render('index', false);
		$this->assertEquals($expected, $result);
	}

	public function testRenderWithVariables() {
		$expected = 'Hello world!';
		$result = $this->View->render('variables', false);
		$this->assertEquals($expected, $result);
	}

	public function testRenderWithViewModel() {
		$expected = 'Hello world!';
		$result = $this->View->render('viewmodel', false);
		$this->assertEquals($expected, $result);
	}

	public function testRenderWithPartial() {
		$expected = 'Partial Test';
		$result = $this->View->render('partial', false);
		$this->assertEquals($expected, $result);
	}

	public function testRenderCtpFallback() {
		$expected = 'CTP Fallback';
		$result = $this->View->render('ctp_fallback', false);
		$this->assertEquals($expected, $result);
	}

}
