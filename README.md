# MustacheCake #

[![Build Status](https://travis-ci.org/Dismounted/MustacheCake.png)](https://travis-ci.org/Dismounted/MustacheCake])

A Mustache implementation for CakePHP.

## Requirements ##

* CakePHP 2.x
* (Currently unit tested on latest tags from 2.1, 2.2, and 2.3 branches.)

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

MustacheCake tries to be smart: if a template is not found with the extension specified in `Controller::$ext` or `.mustache`, it will search for one with `.ctp`. Any `.ctp` file will be rendered by the default Cake View class. This allows you to gradually migrate across to Mustache and to use plugins without rewriting their views.

### Partials ###

Partials are loaded from `app/View/Elements` automatically. Calling `{{> foo }}` will include `app/View/Elements/foo.mustache`. Missing partials are simply returned as empty strings, no exceptions or errors will be recorded.

While using Mustache syntax to call partials is recommended, you can also call `$this->_View->element()` in a render class. This should only be used if unavoidable. An example of such a situation is when you need to include a non-Mustache partial (i.e. a `.ctp` template).

Note that there is a difference in variable scope between the two methods described above.

You can also call `View::element()` in `.ctp` templates to include a Mustache partial in non-Mustache templates.

### Render Classes ###

You can also create a file to accompany the template as a "render class". Place it in the same directory as the template with a `.php` extension (i.e. for `bar.mustache`, create `bar.php`).

Inside the render class file, create a class that extends `MustacheRender`, ensuring to call `App::uses('MustacheRender', 'MustacheCake.View');` beforehand. The class can be named whatever you like, as long as it does not conflict with any other class's name.

From the render class, you can create methods to run whatever logic you need. One common use case would be to call `$this->_View` to access Cake helpers, elements and blocks. A call to `{{ foo }}` in the template will attempt to call the `foo` method in the render class. If the method does not exist, the `foo` view variable will be returned instead.

`MustacheRender::_init()` will be run during `MustacheCake::__construct()`. Override this method to setup your template (e.g. adding scripts to its view block using `HtmlHelper`).

As you can see, render classes can become a very useful and powerful tool, allowing you to keep your templates "clean". However, it is not necessary to create a render class. If one does not exist, MustacheCake will simply use view variables set from the controller.

## Confused? ##

Sorry! I've tried to make it as straightforward as possible, by providing a light "glue" between CakePHP and Mustache. Once you get the hang of using MustacheCake, it should make a lot of sense.

Included in this repo are the default Cake layouts and views transposed to work with MustacheCake. Looking at these may make the usage scenarios clearer. They are located in `MustacheCake/View/Layouts` and `MustacheCake/View/Pages`.
