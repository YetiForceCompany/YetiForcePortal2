<?php
/**
 * Install test class
 * @package YetiForce.Tests
 * @license licenses/License.html
 * @author Micha³ Lorencik <m.lorencik@yetiforce.com>
 */
use PHPUnit\Framework\TestCase;

/**
 * @covers API::<public>
 */
class Install extends TestCase
{

	public function testCmposerInstall()
	{
		$this->assertFileExists('vendor/autoload.php');
	}
}
