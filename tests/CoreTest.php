<?php
namespace PornTerminal\Tests;

use PornTerminal\Api;
use PornTerminal\Core;
use PornTerminal\Command;
use PornTerminal\Wording;

/**
 * CoreTest
 *
 * @since 2.0.0
 *
 * @package PornTerminal
 * @category Tests
 * @author Henry Ruhs
 */

class CoreTest extends TestCaseAbstract
{
	/**
	 * testRun
	 *
	 * @since 2.0.0
	 */

	public function testRun()
	{
		/* setup */

		$api = new Api();
		$api->init();
		$wording = new Wording();
		$wording->init();
		$core = new Core($api, $wording);
		$command = new Command($api, $wording);
		$command
			->init()
			->option('t')
			->default(10);

		/* actual */

		$actual = $core->run($command);

		/* compare */

		$this->assertString($actual);
	}
}
