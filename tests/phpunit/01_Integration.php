<?php
/**
 * Integration test class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Michał Lorencik <m.lorencik@yetiforce.com>
 */
use App\Api;
use App\Config;
use App\Language;
use App\Server;
use App\User;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Integration::<public>
 *
 * @internal
 */
final class Integration extends TestCase
{
	private const EMAIL = 'demo@yetiforce.com';
	private const PASSWORD = 'demo';

	private static $apiObject;
	private static $token;

	public static function setUpBeforeClass(): void
	{
		static::$apiObject = new class() extends \App\Api {
			public static function clearSelf()
			{
				static::$instance = null;
			}
		};
	}

	protected function setUp(): void
	{
		static::$apiObject::clearSelf();
		$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
		User::getUser()->set('token', static::$token);
		User::getUser()->set('logged', true);
	}

	/**
	 * Test portal is integrated with crm.
	 */
	public function testIntegration()
	{
		$this->expectException(\App\AppException::class);
		$response = (new Api())->call('');
		$result = (isset($response['code']) && 401 != $response['code']);
		$this->assertTrue($result);
	}

	public function testLangAfterLogin()
	{
		$params = [
			'version' => Config::$version,
			'language' => Language::getLanguage(),
			'ip' => Server::getRemoteIp(),
			'fromUrl' => Config::$portalUrl
		];
		$response = Api::getInstance()->call('Users/Login', ['userName' => static::EMAIL, 'password' => static::PASSWORD, 'params' => $params], 'post');
		$this->assertNotFalse($response);
		$this->assertTrue($response['logged']);
		$this->assertSame(Language::getLanguage(), $response['language']);
		static::$token = $response['token'];
	}

	public function testModulesLang()
	{
		$response = (new User())->login(static::EMAIL, static::PASSWORD);
		$this->assertTrue($response);
		$modulesList = Api::getInstance()->call('Modules');
		$this->assertIsArray($modulesList);
		$this->assertSame('Contacts', $modulesList['Contacts']);
		$this->assertSame('Accounts', $modulesList['Accounts']);
		$this->assertSame('Leads', $modulesList['Leads']);
	}

	/**
	 * Test login with default data.
	 */
	public function testLogin()
	{
		$response = (new User())->login(static::EMAIL, static::PASSWORD);
		$this->assertTrue($response);
	}

	/**
	 * Test login with bad password.
	 */
	public function testLoginBadData()
	{
		$this->expectException(\App\AppException::class);
		(new User())->login(static::EMAIL, 'wrongpassword');
	}
}
