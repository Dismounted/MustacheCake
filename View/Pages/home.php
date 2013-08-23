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

App::uses('PagesHomeViewModel', 'MustacheCake.View/Pages');
Configure::write('MustacheCake.useViewModel', 'PagesHomeViewModel');

if (!Configure::read('debug')) {
	throw new NotFoundException();
}
