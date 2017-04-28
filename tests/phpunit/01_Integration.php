<?php
/**
 * Install test class
 * @package YetiForce.Tests
 * @license licenses/License.html
 * @author Micha³ Lorencik <m.lorencik@yetiforce.com>
 */
use PHPUnit\Framework\TestCase;
use Core\Api;
use Core\User;

/**
 * @covers API::<public>
 */
class Integration extends TestCase
{

	public function testIntegration()
	{
		$response = (new Api)->call('');
		$result = (isset($response['code']) && $response['code'] != 401);
		$this->assertTrue($result);
	}

	public function testLogin()
	{
		$login = 'demo@yetiforce.com';
		$pass = 'demo';

		$response = (new User())->login($login, $pass);
		$this->assertTrue($response);
	}

	public function testLoginBadData()
	{
		$login = 'demo@yetiforce.crm';
		$pass = 'wrongpassword';

		$response = (new User())->login($login, $pass);
		$this->assertFalse($response);
	}
}
