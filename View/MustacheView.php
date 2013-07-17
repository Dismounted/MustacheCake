<?php
/**
 * MustacheCake
 *
 * A Mustache implementation for CakePHP.
 *
 * @copyright     Copyright (c) Hanson Wong
 * @link          https://github.com/Dismounted/MustacheCake
 * @package       MustacheCake.View
 * @license       Simplified BSD License (https://github.com/Dismounted/MustacheCake/blob/master/LICENSE)
 */

App::uses('View', 'View');
App::uses('View', 'MustachePartialsLoader');

/**
 * Mustache view class.
 *
 * This extends the default View class to provide Mustache rendering functionality.
 *
 * @package       MustacheCake.View
 */
class MustacheView extends View {

	/**
	 * File extension. Overrides Cake default.
	 *
	 * @var string
	 */
	public $ext = '.mustache';

	/**
	 * File extension for render classes.
	 *
	 * @var string
	 */
	public $extRenderClass = '.php';

	/**
	 * An instance of the Mustache engine.
	 *
	 * @var Mustache_Engine
	 */
	public $mustache;

	/**
	 * Constructor.
	 *
	 * @param Controller $controller A controller object to pull View::_passedVars from.
	 */
	public function __construct(Controller $controller = null) {
		parent::__construct();

		if (class_exists('Mustache_Autoloader') === false) {
			App::import('Vendor', 'MustacheAutoloader', array('file' => 'Mustache' . DS . 'src' . DS 'Mustache' . DS . 'Autoloader.php'));
			Mustache_Autoloader::register();
		}

		$this->mustache = new Mustache_Engine(array(
			'partials_loader' => new MustachePartialsLoader($this)
		));
	}

	/**
	 * Override to evaluate template through Mustache.
	 *
	 * @param string $viewFn Filename of the view.
	 * @param array $dataForView Data to include in rendered view.
	 * @return string Rendered output.
	 */
	protected function _evaluate($viewFile, $dataForView) {
		$this->__viewFile = $viewFile;

		$template = $this->_getTemplateAsString($viewFile);
		$renderData = $this->_getRenderData($viewFile, $dataForView);
		$rendered = $this->mustache->render($template, $renderData);

		unset($this->__viewFile);
		return $rendered;
	}

	/**
	 * Grab the template as a string.
	 *
	 * @param string $viewFn Filename of the view.
	 * @return string Template before output.
	 */
	protected function _getTemplateAsString($viewFile) {
		return file_get_contents($viewFile);
	}

	/**
	 * Grab the render class associated with the view, if it exists.
	 *
	 * @param string $viewFn Filename of the view.
	 * @param array $dataForView Data to include in rendered view.
	 * @return array|MustacheRender Return an object, or hand back untouched data.
	 */
	protected function _getRenderData($viewFile, $dataForView) {
		$renderClassPath = preg_replace(
			'/' . preg_quote($this->ext) . '$/i',
			$this->extRenderClass,
			$viewFile
		);

		if (file_exists($renderClassPath) === false) {
			return $dataForView;
		}

		require_once($renderClassPath);
		$renderClassName = $this->_getRenderClassName($renderClassPath);

		return new $renderClassName($this, $dataForView);
	}

	/**
	 * Looks through a file to find the name of the first declared class.
	 *
	 * @param string $file Filename of the class.
	 * @return string Class name.
	 */
	protected function _getRenderClassName($file) {
		$fp = fopen($file, 'r');
		$class = $buffer = '';
		$i = 0;

		while (!$class) {
			if (feof($fp)) {
				break;
			}

			$buffer .= fread($fp, 512);
			$tokens = token_get_all($buffer);

			if (strpos($buffer, '{') === false) {
				continue;
			}

			$tokenCount = count($tokens);
			for (; $i < $tokenCount; ++$i) {
				if ($tokens[$i][0] === T_CLASS) {
					for ($j = ($i + 1); $j < $tokenCount; ++$j) {
						if ($tokens[$j] === '{') {
							$class = $tokens[$i + 2][1];
						}
					}
				}
			}
		}

		return $class;
	}

	/**
	 * Be good and pass on an element filename to the partials loader.
	 *
	 * @param string $name The name of the element to find.
	 * @return mixed Either a string to the element filename or false when one can't be found.
	 */
	public function getPartialFileName($name) {
		return $this->_getElementFilename($name);
	}

}
