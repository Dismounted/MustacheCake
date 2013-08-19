<?php
/**
 * MustacheCake
 *
 * A Mustache implementation for CakePHP.
 *
 * @copyright     Copyright (c) Hanson Wong
 * @link          https://github.com/Dismounted/MustacheCake
 * @package       MustacheCake.View.Pages
 * @license       https://github.com/Dismounted/MustacheCake/blob/master/LICENSE Simplified BSD License
 */

App::uses('Configure', 'Core');
App::uses('PagesHomeViewModel', 'MustacheCake.View/Pages');
Configure::write('MustacheCake.currentViewModel', 'PagesHomeViewModel');

if (!Configure::read('debug')) {
	throw new NotFoundException();
}
