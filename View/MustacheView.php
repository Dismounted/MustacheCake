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
App::import('Vendor', 'MustacheAutoloader', array('file' => 'Mustache' . DS . 'src' . DS 'Mustache' . DS . 'Autoloader.php'));
Mustache_Autoloader::register();

/**
 * Mustache view class.
 *
 * This extends the default View class to provide Mustache rendering functionality.
 *
 * @package       MustacheCake.View
 */
class MustacheView extends View {

}
