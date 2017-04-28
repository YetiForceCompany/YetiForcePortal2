<?php
/**
 * Install test class
 * @package YetiForce.Tests
 * @license licenses/License.html
 * @author Michał Lorencik <m.lorencik@yetiforce.com>
 */
use PHPUnit\Framework\TestCase;

/**
 * @covers Install::<public>
 */
class Install extends TestCase
{

	/**
	 * Checking Composer is instlled
	 */
	public function testComposerInstall()
	{
		$this->assertFileExists('vendor/autoload.php');
	}
}
