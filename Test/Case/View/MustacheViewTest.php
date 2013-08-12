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

	public function testMustacheEngineInstance() {
		$View = new TestMustacheView;
		$this->assertInstanceOf('Mustache_Engine', $View->mustache);
	}

	public function testGetViewExt() {
		$View = new TestMustacheView;
		$this->assertEquals('.mustache', $View->getViewExt('/Posts/index.mustache'));
	}

	public function testGetViewModelName() {
		$View = new TestMustacheView;
		$this->assertEquals('IndexViewModel', $View->getViewModelName('/Posts/index.mustache'));
	}

	public function testGetMustacheCachePath() {
		$View = new TestMustacheView;
		// We're using default config, so file cache is enabled.
		$this->assertInternalType('string', $View->getMustacheCachePath());
		// Do something to make it return null...
	}

	public function testGetExtensions() {
		$View = new TestMustacheView;
		$exts = $View->getExtensions();
		$this->assertInternalType('array', $exts);
		$this->assertContains('.mustache', $exts);
		$this->assertContains('.ctp', $exts);
	}

	public function testTokenErrorSuppress() {
		$this->assertTrue(TestMustacheView::handleTokenError());
	}

}
