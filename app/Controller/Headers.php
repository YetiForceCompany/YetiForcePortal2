<?php
/**
 * Headers controller file.
 *
 * @package Controller
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace App\Controller;

/**
 * Headers controller class.
 */
class Headers
{
	/**
	 * Default header values.
	 *
	 * @var string[]
	 */
	protected $headers = [
		'Access-Control-Allow-Methods' => 'GET, POST',
		'Access-Control-Allow-Origin' => '*',
		'Expires' => '-',
		'Last-Modified' => '-',
		'Pragma' => 'no-cache',
		'Cache-Control' => 'private, no-cache, no-store, must-revalidate, post-check=0, pre-check=0',
		'Content-Type' => 'text/html; charset=UTF-8',
		'Referrer-Policy' => 'no-referrer',
		'Permissions-Policy' => 'fullscreen=(self),	geolocation=(), camera=()',
		'Cross-Origin-Embedder-Policy' => 'require-corp',
		'Cross-Origin-Opener-Policy: ' => 'same-origin',
		'Cross-Origin-Resource-Policy: ' => 'same-origin',
		'Expect-Ct' => 'enforce; max-age=3600',
		'X-Frame-Options' => 'sameorigin',
		'X-Xss-Protection' => '1; mode=block',
		'X-Content-Type-Options' => 'nosniff',
		'X-Robots-Tag' => 'none',
		'X-Permitted-Cross-Domain-Policies' => 'none',
	];
	/**
	 * Default CSP header values.
	 *
	 * @var string[]
	 */
	public $csp = [
		'default-src' => '\'self\' blob:',
		'img-src' => '\'self\' data:',
		'script-src' => '\'self\' \'unsafe-inline\' blob:',
		'form-action' => '\'self\'',
		'frame-ancestors' => '\'self\'',
		'frame-src' => '\'self\' mailto: tel:',
		'style-src' => '\'self\' \'unsafe-inline\'',
		'connect-src' => '\'self\'',
	];
	/**
	 * Headers to delete.
	 *
	 * @var string[]
	 */
	protected $headersToDelete = ['x-powered-by', 'server'];

	/**
	 * Headers instance..
	 *
	 * @var self
	 */
	public static $instance;

	/**
	 * Get headers instance.
	 *
	 * @return \self
	 */
	public static function getInstance()
	{
		if (isset(self::$instance)) {
			return self::$instance;
		}
		return self::$instance = new self();
	}

	/**
	 * Construct, loads default headers depending on the browser and environment.
	 */
	public function __construct()
	{
		$browser = \App\RequestUtil::getBrowserInfo();
		$this->headers['expires'] = gmdate('D, d M Y H:i:s') . ' GMT';
		$this->headers['last-modified'] = gmdate('D, d M Y H:i:s') . ' GMT';
		if ($browser->ie) {
			$this->headers['x-ua-compatible'] = 'IE=11,edge';
			if ($browser->https) {
				$this->headers['pragma'] = 'private';
				$this->headers['cache-control'] = 'private, must-revalidate';
			}
		}
		if ($browser->https) {
			$this->headers['strict-transport-security'] = 'max-age=31536000; includeSubDomains; preload';
		}
		if (\App\Config::$cspHeaderActive ?? false) {
			$this->loadCsp();
		}
		if ($keys = (\App\Config::$hpkpKeysHeader ?? [])) {
			$this->headers['public-key-pins'] = 'pin-sha256="' . implode('"; pin-sha256="', $keys) . '"; max-age=10000;';
		}
		$this->headers['access-control-allow-origin'] = \App\Config::$portalUrl;
	}

	/**
	 * Set header.
	 *
	 * @param string $key
	 * @param string $value
	 */
	public function setHeader(string $key, string $value)
	{
		$this->headers[$key] = $value;
	}

	/**
	 * Send headers.
	 *
	 * @return void
	 */
	public function send()
	{
		if (headers_sent()) {
			return;
		}
		foreach ($this->getHeaders() as $value) {
			header($value);
		}
		foreach ($this->headersToDelete as $name) {
			header_remove($name);
		}
	}

	/**
	 * Get headers string.
	 *
	 * @return string[]
	 */
	public function getHeaders(): array
	{
		if (\App\Config::$cspHeaderActive ?? false) {
			$this->headers['Content-Security-Policy'] = $this->getCspHeader();
		}
		$return = [];
		foreach ($this->headers as $name => $value) {
			$return[] = "$name: $value";
		}
		return $return;
	}

	/**
	 * Load CSP directive.
	 *
	 * @return void
	 */
	public function loadCsp()
	{
	}

	/**
	 * Get CSP headers string.
	 *
	 * @return string
	 */
	public function getCspHeader(): string
	{
		$scp = '';
		foreach ($this->csp as $key => $value) {
			$scp .= "$key $value; ";
		}
		return $scp;
	}
}
