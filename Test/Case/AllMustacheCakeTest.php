<?php
/**
 * MustacheCake
 *
 * A Mustache implementation for CakePHP.
 *
 * @copyright     Copyright (c) Hanson Wong
 * @link          https://github.com/Dismounted/MustacheCake
 * @package       MustacheCake.Test.Case
 * @license       https://github.com/Dismounted/MustacheCake/blob/master/LICENSE Simplified BSD License
 */

/**
 * MustacheCake test suite.
 *
 * This suite runs all the available tests for MustacheCake.
 *
 * @package       MustacheCake.Test.Case
 */
class AllMustacheCakeTest extends CakeTestSuite {

	/**
	 * Define the tests for this suite.
	 *
	 * @return void
	 */
	public static function suite() {
		$path = CakePlugin::path('MustacheCake') . 'Test' . DS . 'Case';
		$suite = new CakeTestSuite('All MustacheCake Tests');
		$suite->addTestDirectoryRecursive($path);
		return $suite;
	}

}
