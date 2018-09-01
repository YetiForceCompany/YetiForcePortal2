<?php
/**
 * Integration test class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Michał Lorencik <m.lorencik@yetiforce.com>
 */
use App\Api;
use App\User;
use PHPUnit\Framework\TestCase;

/**
 * @covers Integration::<public>
 */
class Integration extends TestCase
{
	/**
	 * Test portal is integrated with crm.
	 */
	public function testIntegration()
	{
		$response = (new Api())->call('');
		$result = (isset($response['code']) && $response['code'] != 401);
		$this->assertTrue($result);
	}

	/**
	 * Test login with default data.
	 */
	public function testLogin()
	{
		$login = 'demo@yetiforce.com';
		$pass = 'demo';

		$response = (new User())->login($login, $pass);
		$this->assertTrue($response);
	}

	/**
	 * Test login with bad password.
	 */
	public function testLoginBadData()
	{
		$login = 'demo@yetiforce.crm';
		$pass = 'wrongpassword';

		$response = (new User())->login($login, $pass);
		$this->assertFalse($response);
	}
}
