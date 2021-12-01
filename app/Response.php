<?php
/**
 * Response class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace App;

class Response
{
	/**
	 * Emit response wrapper as raw string.
	 */
	public static $EMIT_RAW = 0;

	/**
	 * Emit response wrapper as json string.
	 */
	public static $EMIT_JSON = 1;

	/**
	 * Emit response wrapper as html string.
	 */
	public static $EMIT_HTML = 2;

	/**
	 * Emit response wrapper as string/jsonstring.
	 */
	public static $EMIT_JSONTEXT = 3;

	/**
	 * Emit response wrapper as padded-json.
	 */
	public static $EMIT_JSONP = 4;

	/**
	 * Error data.
	 */
	private $error;

	/**
	 * Result data.
	 */
	private $result;

	// Active emit type
	private $emitType = 1; // EMIT_JSON

	// JSONP padding
	private $emitJSONPFn = false; // for EMIT_JSONP

	// List of response headers
	private $headers = [];

	/**
	 * Set headers to send.
	 *
	 * @param mixed $header
	 */
	public function setHeader($header)
	{
		$this->headers[] = $header;
	}

	/**
	 * Set padding method name for JSONP emit type.
	 *
	 * @param mixed $fn
	 */
	public function setEmitJSONP($fn)
	{
		$this->setEmitType(self::$EMIT_JSONP);
		$this->emitJSONPFn = $fn;
	}

	/**
	 * Set emit type.
	 *
	 * @param mixed $type
	 */
	public function setEmitType($type)
	{
		$this->emitType = $type;
	}

	/**
	 * Is emit type configured to JSON?
	 */
	public function isJSON()
	{
		return $this->emitType == self::$EMIT_JSON;
	}

	/**
	 * Get the error data.
	 */
	public function getError()
	{
		return $this->error;
	}

	/**
	 * Set error data to send.
	 *
	 * @param string $message
	 *
	 * @return void
	 */
	public function setError($message = null): void
	{
		$this->error = [
			'message' => $message,
		];
	}

	/**
	 * Set exception error to send.
	 *
	 * @param Throwable $e
	 *
	 * @return void
	 */
	public function setException(\Throwable $e): void
	{
		$reasonPhrase = \App\Language::translate('ERR_OCCURRED_ERROR');
		$message = $e->getMessage();
		$error = [
			'message' => $reasonPhrase,
			'code' => $e->getCode(),
		];
		if (\Conf\Config::$displayDetailsException) {
			$error['message'] = $message;
		}
		if (\Conf\Config::$displayTrackingException) {
			$error['trace'] = str_replace(ROOT_DIRECTORY . \DIRECTORY_SEPARATOR, '', $e->getTraceAsString());
		}
		$this->setHeader($_SERVER['SERVER_PROTOCOL'] . ' ' . $e->getCode() . ' Internal Server Error');
		$this->error = $error;
		http_response_code($e->getCode());
	}

	/**
	 * Check the presence of error data.
	 */
	public function hasError()
	{
		return null !== $this->error;
	}

	/**
	 * Update the result data.
	 *
	 * @param mixed $key
	 * @param mixed $value
	 */
	public function updateResult($key, $value)
	{
		$this->result[$key] = $value;
	}

	/**
	 * Get the result data.
	 */
	public function getResult()
	{
		return $this->result;
	}

	/**
	 * Set the result data.
	 *
	 * @param mixed $result
	 */
	public function setResult($result)
	{
		$this->result = $result;
	}

	/**
	 * Send response to client.
	 */
	public function emit()
	{
		$contentTypeSent = false;
		foreach ($this->headers as $header) {
			if (!$contentTypeSent && 0 === stripos($header, 'content-type')) {
				$contentTypeSent = true;
			}
			header($header);
		}

		// Set right charset (UTF-8) to avoid IE complaining about c00ce56e error
		if ($this->emitType == self::$EMIT_JSON) {
			if (!$contentTypeSent) {
				header('Content-type: text/json; charset=UTF-8');
			}
			$this->emitJSON();
		} elseif ($this->emitType == self::$EMIT_JSONTEXT) {
			if (!$contentTypeSent) {
				header('Content-type: text/json; charset=UTF-8');
			}
			$this->emitText();
		} elseif ($this->emitType == self::$EMIT_HTML) {
			if (!$contentTypeSent) {
				header('Content-type: text/html; charset=UTF-8');
			}
			$this->emitRaw();
		} elseif ($this->emitType == self::$EMIT_RAW) {
			if (!$contentTypeSent) {
				header('Content-type: text/plain; charset=UTF-8');
			}
			$this->emitRaw();
		} elseif ($this->emitType == self::$EMIT_JSONP) {
			if (!$contentTypeSent) {
				header('Content-type: application/javascript; charset=UTF-8');
			}
			echo $this->emitJSONPFn . '(';
			$this->emitJSON();
			echo ')';
		}
	}

	/**
	 * Emit response wrapper as JSONString.
	 */
	protected function emitJSON()
	{
		echo Json::encode($this->prepareResponse());
	}

	/**
	 * Prepare the response wrapper.
	 */
	protected function prepareResponse()
	{
		$response = [];
		if (null !== $this->error) {
			$response['success'] = false;
			$response['error'] = $this->error;
		} else {
			$response['success'] = true;
			$response['result'] = $this->result;
		}
		return $response;
	}

	/**
	 * Emit response wrapper as String/JSONString.
	 */
	protected function emitText()
	{
		if (null === $this->result) {
			if (\is_string($this->error)) {
				echo $this->error;
			} else {
				echo Json::encode($this->prepareResponse());
			}
		} else {
			if (\is_string($this->result)) {
				echo $this->result;
			} else {
				echo Json::encode($this->prepareResponse());
			}
		}
	}

	/**
	 * Emit response wrapper as String.
	 */
	protected function emitRaw()
	{
		if (null === $this->result) {
			echo (\is_string($this->error)) ? $this->error : var_export($this->error, true);
		}
		echo $this->result;
	}
}
