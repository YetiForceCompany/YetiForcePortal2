<?php

class AppException extends \Exception
{

	public function __construct($message, $code = 200, Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}

function exceptionErrorHandler($errno, $errstr, $errfile, $errline, $errcontext)
{
	throw new \AppException($errstr, $errno);
}
set_error_handler('exceptionErrorHandler');
