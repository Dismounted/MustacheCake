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

App::uses('MustacheView', 'MustacheCake.View');

/**
 * Mustache string view class.
 *
 * This extends MustacheView to render from a string, rather than a file.
 *
 * @package       MustacheCake.View
 */
class MustacheStringView extends MustacheView {

/**
 * Renders view from string.
 *
 * Take note that this bypasses many routines - e.g. View::_render().
 *
 * @param string $view Mustache string to render.
 * @param string $layout Layout to use.
 * @return string|null
 */
	public function render($view = null, $layout = null) {
		if (empty($view) === true) {
			return;
		}

		$this->_currentType = self::TYPE_VIEW;
		$this->getEventManager()->dispatch(new CakeEvent('View.beforeRender', $this, array('MustacheStringView', $view)));
		$this->Blocks->set('content', $this->mustache->render($view, $this->viewVars));
		$this->getEventManager()->dispatch(new CakeEvent('View.afterRender', $this, array('MustacheStringView', $view)));

		return parent::render(false, $layout);
	}

}
