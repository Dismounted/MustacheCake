# MustacheCake #

A Mustache implementation for CakePHP.

## Requirements ##

* CakePHP 2.3 (May work on older versions of 2.x, not tested.)

## Installation ##

1. Clone this repo into `app/Plugin/MustacheCake`.

	```
	git submodule add https://github.com/Dismounted/MustacheCake.git app/Plugin/MustacheCake
	git submodule update --init --recursive
	```

2. Load the plugin in `app/Config/bootstrap.php` by calling `CakePlugin::load('MustacheCake');`.

3. Specify the Mustache view class in your controller (either individually or through `AppController`).

	```php
	class AppController extends Controller {
		...
		public $viewClass = 'MustacheCake.Mustache';
		public $ext = '.mustache';
		...
	}
	```

4. Start using Mustache!

## Usage ##

For a reference of Mustache syntax, see the Mustache manual: [http://mustache.github.io/mustache.5.html](http://mustache.github.io/mustache.5.html).

Layouts and views are processed via Cake conventions; just create templates in the same place as usual. The only difference is that the extension becomes `.mustache`.

So for the `bar` action in `FooController`, create `bar.mustache` in `app/View/Foo`.

MustacheCake tries to be smart: any template with the extension `.ctp` will be rendered by the default Cake View class. This allows you to gradually migrate across to Mustache.

### Partials ###

Partials are loaded from `app/View/Elements` automatically. Calling `{{> foo }}` will include `app/View/Elements/foo.mustache`. Missing partials are simply returned as empty strings, no exceptions or errors will be recorded.

It is not recommended to call `View::element()` while using MustacheCake as the partials syntax should cover all your needs. However, it is not explicitly disallowed. Calling it will render the element as a separate template, so watch out for variable scope issues if you decide you need to call `View::element()`.

### Render Classes ###

You can also create a file to accompany the template as a "render class". Place it in the same directory as the template with a `.php` extension (i.e. for `bar.mustache`, create `bar.php`).

Inside the render class file, create a class that extends `MustacheRender`, ensuring to call `App::uses('MustacheRender', 'MustacheCake.View');` beforehand. The class can be named whatever you like, as long as it does not conflict with any other class's name.

From the render class, you can create methods to run whatever logic you need. One common use case would be to call Cake helpers (through `$this->_View`). A call to `{{ foo }}` in the template will attempt to call the `foo` method in the render class. If the method does not exist, the `foo` view variable will be returned instead.

A render class extending `MustacheRender` will also import any defined "view blocks" as view variables, overwriting view variables of the same name (if they exist). View blocks are not recommended to be used, but they are necessary to grab special Cake ones like `content`, `css`, and `script`.

`MustacheRender::init()` will be run, if it exists, immediately after instantiation.

As you can see, render classes can become a very useful and powerful tool, allowing you to keep your templates "clean". However, it is not necessary to create a render class. If one does not exist, MustacheCake will simply use view variables set from the controller.

## Confused? ##

Sorry! I've tried to make it as straightforward as possible, by providing a light "glue" between CakePHP and Mustache. Once you get the hang of using MustacheCake, it should make a lot of sense.

Included in this repo are the default Cake layouts and views transposed to work with MustacheCake. Looking at these may make the usage scenarios clearer. They are located in `MustacheCake/View/Layouts` and `MustacheCake/View/Pages`.
