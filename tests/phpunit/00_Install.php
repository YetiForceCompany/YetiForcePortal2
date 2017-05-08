<?php
/**
 * Install test class
 * @package YetiForce.Tests
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
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
