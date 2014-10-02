<?php
/**
	* MustacheCake
	*
	* A Mustache implementation for CakePHP.
	*
	* @copyright     Copyright (c) Hanson Wong
	* @link          https://github.com/Dismounted/MustacheCake
	* @package       MustacheCake.View
	* @license       https://github.com/Dismounted/MustacheCake/blob/master/LICENSE Simplified BSD License
	*/

App::uses('Cache', 'Cache');
App::uses('View', 'View');
App::uses('MustachePartialsLoader', 'MustacheCake.View');

/**
	* Mustache view class.
	*
	* This extends the default View class to provide Mustache rendering functionality.
	*
	* @package       MustacheCake.View
	*/
class MustacheView extends View {

	/**
		* File extension. Overrides Cake default. Need to also override in controller!
		*
		* @var string
		*/
	public $ext = '.mustache';

	/**
		* controls if Mustache template will be rendered from string and not from file
		*
		* @var bool
		*/
	public $renderFromString = false;

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
		parent::__construct($controller);

		if (class_exists('Mustache_Autoloader', false) === false) {
			App::import('Vendor', 'MustacheCake.Mustache_Autoloader', array('file' => 'Mustache' . DS . 'src' . DS . 'Mustache' . DS . 'Autoloader.php'));
			Mustache_Autoloader::register();
		}

		$this->mustache = new Mustache_Engine(array(
			'cache' => $this->_getMustacheCachePath(),
			'partials_loader' => new MustachePartialsLoader($this)
		));
	}

	/**
		* override render as well
		*
		* @param string $view Name of view file to use or Mustache Template String
		* @param string $layout Layout to use
		* @return null|string Rendered content or null if content already rendered and returned earlier.
		* @throws CakeException If there is an error in the view.
		*/
	public function render($view = null, $layout = null) {
		if ($this->hasRendered) {
			return;
		}

		if (!$this->renderFromString) {
			return parent::render($view, $layout);
		}

		$viewFileName = false;

		$this->_currentType = self::TYPE_VIEW;
		$this->getEventManager()->dispatch(new CakeEvent('View.beforeRender', $this, array($viewFileName)));
		$this->Blocks->set('content', $this->_render(false));
		$this->getEventManager()->dispatch(new CakeEvent('View.afterRender', $this, array($viewFileName)));

		if ($layout === null) {
			$layout = $this->layout;
		}
		if ($layout && $this->autoLayout) {
			$this->Blocks->set('content', $this->renderLayout('', $layout));
		}
		$this->hasRendered = true;
		return $this->Blocks->get('content');
	}

	/**
		* Override to evaluate template through Mustache. Falls back on ".ctp" templates.
		*
		* @param string $viewFile Filename of the view.
		* @param array $dataForView Data to include in rendered view.
		* @return string Rendered output.
		*/
	protected function _evaluate($viewFile, $dataForView) {
		if (pathinfo($viewFile, PATHINFO_EXTENSION) == 'ctp') {
			return parent::_evaluate($viewFile, $dataForView);
		}

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
		* @param string $viewFile Filename of the view.
		* @return string Template before output.
		*/
	protected function _getTemplateAsString($viewFile) {
		if ($this->renderFromString) {
			return $this->view;
		}
		return file_get_contents($viewFile);
	}

	/**
		* Grab the view model associated with the view, if it exists.
		*
		* @param string $viewFile Filename of the view.
		* @param array $dataForView Data to include in rendered view.
		* @return mixed Return a MustacheViewModel object, or hand back untouched array.
		*/
	protected function _getRenderData($viewFile, $dataForView) {
		$viewModelName = $this->_getViewModelName($viewFile);

		if ($viewModelName === false) {
			return $dataForView;
		}

		return new $viewModelName($this, $dataForView);
	}

	/**
		* Checks for a file accompanying the view telling us what view model to use.
		*
		* @param string $viewFile Filename of the view.
		* @return mixed String with class name, false if none found.
		*/
	protected function _getViewModelName($viewFile) {
		Configure::write('MustacheCake.useViewModel', false);

		$viewFilePath = pathinfo($viewFile);
		$neededPath = $viewFilePath['dirname'] . DS . $viewFilePath['filename'] . '.php';

		if (file_exists($neededPath) === false) {
			return false;
		}

		include $neededPath;
		return Configure::read('MustacheCake.useViewModel');
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

	/**
		* If Cake is using FileEngine, let's hop on!
		*
		* @return mixed The cache path, null if not applicable.
		*/
	protected function _getMustacheCachePath() {
		$settings = Cache::settings();

		if (isset($settings['engine']) === true && $settings['engine'] == 'File') {
			return $settings['path'] . DS . 'mustache';
		}

		return null;
	}

	/**
		* Get the extensions that view files can use. Override to add ".mustache" into the stack.
		*
		* @return array Array of extensions view files use.
		*/
	protected function _getExtensions() {
		$exts = array($this->ext);

		if ($this->ext !== '.mustache') {
			$exts[] = '.mustache';
		}

		if ($this->ext !== '.ctp') {
			$exts[] = '.ctp';
		}

		return $exts;
	}

}
