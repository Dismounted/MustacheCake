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

	public function testTokenErrorSuppress() {
		$View = new TestMustacheView();
		$this->assertEquals(true, $View::handleTokenError());
	}

}
