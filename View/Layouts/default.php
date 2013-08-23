<?php
/**
 * MustacheCake
 *
 * A Mustache implementation for CakePHP.
 *
 * @copyright     Copyright (c) Hanson Wong
 * @link          https://github.com/Dismounted/MustacheCake
 * @package       MustacheCake.View.Layouts
 * @license       https://github.com/Dismounted/MustacheCake/blob/master/LICENSE Simplified BSD License
 */

App::uses('DefaultLayoutViewModel', 'MustacheCake.View/Layouts');
Configure::write('MustacheCake.useViewModel', 'DefaultLayoutViewModel');
