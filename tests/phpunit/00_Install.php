<?php
/**
 * Install test class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Michał Lorencik <m.lorencik@yetiforce.com>
 */
use PHPUnit\Framework\TestCase;

/**
 * @covers Install::<public>
 */
class Install extends TestCase
{
	/**
	 * Checking Composer is instlled.
	 */
	public function testComposerInstall()
	{
		$this->assertFileExists('vendor/autoload.php');
	}
}
