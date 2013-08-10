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

App::uses('MustacheViewModel', 'MustacheCake.View');
App::uses('Debugger', 'Utility');

if (!Configure::read('debug')) {
	throw new NotFoundException();
}

/**
 * Cake default home view model.
 *
 * @package       MustacheCake.View.Pages
 */
class PagesHomeViewModel extends MustacheViewModel {

	public function mainHeading() {
		return __d('cake_dev', 'Release Notes for CakePHP %s.', Configure::version());
	}

	public function version() {
		return Configure::version();
	}

	public function readChangelogText() {
		return __d('cake_dev', 'Read the changelog');
	}

	public function checkSecurityKeys() {
		if (Configure::read('debug') > 0) {
			Debugger::checkSecurityKeys();
		}
	}

	public function urlRewritingText() {
		return __d('cake_dev', 'URL rewriting is not properly configured on your server.');
	}

	public function runTests() {
		$tests = array(
			'PhpVersion',
			'TmpDirectory',
			'Cache',
			'DbConfig',
			'DbConnection',
			'PcreUnicode',
			'DebugKit'
		);

		$output = array();
		foreach ($tests as $test) {
			$testMethod = '_check' . $test;
			$result = $this->{$testMethod}();
			if (empty($result) === false) {
				$output[] = $result;
			}
		}
		return $output;
	}

	protected function _checkPhpVersion() {
		if (version_compare(PHP_VERSION, '5.2.8', '>=')) {
			return array('extraClass' => ' success', 'message' => __d('cake_dev', 'Your version of PHP is 5.2.8 or higher.'));
		} else {
			return array('message' => __d('cake_dev', 'Your version of PHP is too low. You need PHP 5.2.8 or higher to use CakePHP.'));
		}
	}

	protected function _checkTmpDirectory() {
		if (is_writable(TMP)) {
			return array('extraClass' => ' success', 'message' => __d('cake_dev', 'Your tmp directory is writable.'));
		} else {
			return array('message' => __d('cake_dev', 'Your tmp directory is NOT writable.'));
		}
	}

	protected function _checkCache() {
		$settings = Cache::settings();
		if (!empty($settings)) {
			return array('extraClass' => ' success', 'message' => __d('cake_dev', 'The %s is being used for core caching. To change the config edit APP/Config/core.php ', '<em>' . $settings['engine'] . 'Engine</em>'));
		} else {
			return array('message' => __d('cake_dev', 'Your cache is NOT working. Please check the settings in APP/Config/core.php'));
		}
	}

	protected function _checkDbConfig() {
		$this->filePresent = null;
		if (file_exists(APP . 'Config' . DS . 'database.php')) {
			$this->filePresent = true;
			return array('extraClass' => ' success', 'message' => __d('cake_dev', 'Your database configuration file is present.'));
		} else {
			$message = __d('cake_dev', 'Your database configuration file is NOT present.') .
				'<br/>' .
				__d('cake_dev', 'Rename APP/Config/database.php.default to APP/Config/database.php');
			return array('message' => $message);
		}
	}

	protected function _checkDbConnection() {
		if (isset($this->filePresent)) {
			App::uses('ConnectionManager', 'Model');
			try {
				$connected = ConnectionManager::getDataSource('default');
			} catch (Exception $connectionError) {
				$connected = false;
				$errorMsg = $connectionError->getMessage();
				if (method_exists($connectionError, 'getAttributes')) {
					$attributes = $connectionError->getAttributes();
					if (isset($errorMsg['message'])) {
						$errorMsg .= '<br />' . $attributes['message'];
					}
				}
			}

			if ($connected && $connected->isConnected()) {
				return array('extraClass' => ' success', 'message' => __d('cake_dev', 'Cake is able to connect to the database.'));
			} else {
				$message = __d('cake_dev', 'Cake is NOT able to connect to the database.') .
					'<br /><br />' .
					$errorMsg;
				return array('message' => $message);
			}
		}
	}

	protected function _checkPcreUnicode() {
		App::uses('Validation', 'Utility');
		if (!Validation::alphaNumeric('cakephp')) {
			$message = __d('cake_dev', 'PCRE has not been compiled with Unicode support.') .
				'<br/>' .
				__d('cake_dev', 'Recompile PCRE with Unicode support by adding <code>--enable-unicode-properties</code> when configuring');
			return array('message' => $message);
		}
	}

	protected function _checkDebugKit() {
		if (CakePlugin::loaded('DebugKit')) {
			return array('extraClass' => ' success', 'message' => __d('cake_dev', 'DebugKit plugin is present'));
		} else {
			$message = __d('cake_dev', 'DebugKit is not installed. It will help you inspect and debug different aspects of your application.') .
				'<br/>' .
				__d('cake_dev', 'You can install it from %s', $this->_View->Html->link('github', 'https://github.com/cakephp/debug_kit'));
			return array('message' => $message);
		}
	}

	public function editingPageHeading() {
		return __d('cake_dev', 'Editing this Page');
	}

	public function editingPageText() {
		return __d('cake_dev', 'To change the content of this page, edit: APP/View/Pages/home.ctp.<br />
To change its layout, edit: APP/View/Layouts/default.ctp.<br />
You can also add some CSS styles for your pages at: APP/webroot/css.');
	}

	public function gettingStartedHeading() {
		return __d('cake_dev', 'Getting Started');
	}

	public function cakeDocsLink() {
		return $this->_View->Html->link(
			sprintf('<strong>%s</strong> %s', __d('cake_dev', 'New'), __d('cake_dev', 'CakePHP 2.0 Docs')),
			'http://book.cakephp.org/2.0/en/',
			array('target' => '_blank', 'escape' => false)
		);
	}

	public function blogTutorialLink() {
		return $this->_View->Html->link(
			__d('cake_dev', 'The 15 min Blog Tutorial'),
			'http://book.cakephp.org/2.0/en/tutorials-and-examples/blog/blog.html',
			array('target' => '_blank', 'escape' => false)
		);
	}

	public function officialPluginsHeading() {
		return __d('cake_dev', 'Official Plugins');
	}

	public function debugKitLink() {
		return $this->_View->Html->link('DebugKit', 'https://github.com/cakephp/debug_kit') .
			': ' .
			__d('cake_dev', 'provides a debugging toolbar and enhanced debugging tools for CakePHP applications.');
	}

	public function localizedLink() {
		return $this->_View->Html->link('Localized', 'https://github.com/cakephp/localized') .
			': ' .
			__d('cake_dev', 'contains various localized validation classes and translations for specific countries');
	}

	public function moreAboutCakeHeading() {
		return __d('cake_dev', 'More about Cake');
	}

	public function cakeDescription() {
		return __d('cake_dev', 'CakePHP is a rapid development framework for PHP which uses commonly known design patterns like Active Record, Association Data Mapping, Front Controller and MVC.');
	}

	public function cakeGoal() {
		return __d('cake_dev', 'Our primary goal is to provide a structured framework that enables PHP users at all levels to rapidly develop robust web applications, without any loss to flexibility.');
	}

	public function extraLinks() {
		return array(
			array(
				'url' => 'http://cakefoundation.org',
				'title' => __d('cake_dev', 'Cake Software Foundation'),
				'description' => __d('cake_dev', 'Promoting development related to CakePHP')
			),
			array(
				'url' => 'http://www.cakephp.org',
				'title' => __d('cake_dev', 'CakePHP'),
				'description' => __d('cake_dev', 'The Rapid Development Framework')
			),
			array(
				'url' => 'http://book.cakephp.org',
				'title' => __d('cake_dev', 'CakePHP Documentation'),
				'description' => __d('cake_dev', 'Your Rapid Development Cookbook')
			),
			array(
				'url' => 'http://api.cakephp.org',
				'title' => __d('cake_dev', 'CakePHP API'),
				'description' => __d('cake_dev', 'Quick Reference')
			),
			array(
				'url' => 'http://bakery.cakephp.org',
				'title' => __d('cake_dev', 'The Bakery'),
				'description' => __d('cake_dev', 'Everything CakePHP')
			),
			array(
				'url' => 'http://plugins.cakephp.org',
				'title' => __d('cake_dev', 'CakePHP plugins repo'),
				'description' => __d('cake_dev', 'A comprehensive list of all CakePHP plugins created by the community')
			),
			array(
				'url' => 'https://groups.google.com/group/cake-php',
				'title' => __d('cake_dev', 'CakePHP Google Group'),
				'description' => __d('cake_dev', 'Community mailing list')
			),
			array(
				'url' => 'irc://irc.freenode.net/cakephp',
				'title' => 'irc.freenode.net #cakephp',
				'description' => __d('cake_dev', 'Live chat about CakePHP')
			),
			array(
				'url' => 'https://github.com/cakephp',
				'title' => __d('cake_dev', 'CakePHP Code'),
				'description' => __d('cake_dev', 'For the Development of CakePHP Git repository, Downloads')
			),
			array(
				'url' => 'https://cakephp.lighthouseapp.com',
				'title' => __d('cake_dev', 'CakePHP Lighthouse'),
				'description' => __d('cake_dev', 'CakePHP Tickets, Wiki pages, Roadmap')
			)
		);
	}

}
