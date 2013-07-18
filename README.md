MustacheCake
============

A Mustache implementation for CakePHP.

Requirements
------------

* CakePHP 2.3 (May work on older versions of 2.x, not tested.)

Installation
------------

* Clone this repo into `app/Plugin/MustacheCake`.
		git submodule add https://github.com/Dismounted/MustacheCake.git app/Plugin/MustacheCake
* Initialise all submodules.
		git submodule update --init --recursive
* Ensure the plugin is loaded in `app/Config/bootstrap.php` by calling `CakePlugin::load('MustacheCake');`
* Specify the Mustache view class in your controller (either individually or through AppController).
		class AppController extends Controller {
			public $viewClass = 'MustacheCake.Mustache';
			public $ext = '.mustache';
		}
* Start using Mustache!
