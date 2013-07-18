MustacheCake
============

A Mustache implementation for CakePHP.

Requirements
------------

* CakePHP 2.3 (May work on older versions of 2.x, not tested.)

Installation
------------

1. Clone this repo into `app/Plugin/MustacheCake`.

	```
	git submodule add https://github.com/Dismounted/MustacheCake.git app/Plugin/MustacheCake
	git submodule update --init --recursive
	```

2. Load the plugin in `app/Config/bootstrap.php` by calling `CakePlugin::load('MustacheCake');`.

3. Specify the Mustache view class in your controller (either individually or through AppController).

	```php
	class AppController extends Controller {
		public $viewClass = 'MustacheCake.Mustache';
		public $ext = '.mustache';
	}
	```

4. Start using Mustache!
