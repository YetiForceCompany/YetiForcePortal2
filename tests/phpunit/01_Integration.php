<?php
/**
 * Integration test class
 * @package YetiForce.Tests
 * @license licenses/License.html
 * @author Michał Lorencik <m.lorencik@yetiforce.com>
 */
use PHPUnit\Framework\TestCase;
use YF\Core\Api;
use YF\Core\User;

/**
 * @covers Integration::<public>
 */
class Integration extends TestCase
{

	/**
	 * Test portal is integrated with crm
	 */
	public function testIntegration()
	{
		$response = (new Api)->call('');
		$result = (isset($response['code']) && $response['code'] != 401);
		$this->assertTrue($result);
	}

	/**
	 * Test login with default data
	 */
	public function testLogin()
	{
		$login = 'demo@yetiforce.com';
		$pass = 'demo';

		$response = (new User())->login($login, $pass);
		$this->assertTrue($response);
	}

	/**
	 * Test login with bad password
	 */
	public function testLoginBadData()
	{
		$login = 'demo@yetiforce.crm';
		$pass = 'wrongpassword';

		$response = (new User())->login($login, $pass);
		$this->assertFalse($response);
	}
}
