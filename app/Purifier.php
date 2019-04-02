<?php

/**
 * Purifier basic class.
 *
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @copyright YetiForce Sp. z o.o
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 */

namespace App;

/**
 * Class to purify data.
 */
class Purifier
{
	/**
	 * Default charset.
	 *
	 * @var string
	 */
	public static $defaultCharset;

	/**
	 * Function to convert the given string to html.
	 *
	 * @param string $string
	 * @param bool   $encode
	 *
	 * @return string
	 */
	public static function encodeHtml($string)
	{
		return htmlspecialchars($string, ENT_QUOTES, static::$defaultCharset);
	}

	/**
	 * Function to decode html.
	 *
	 * @param string $string
	 *
	 * @return string
	 */
	public static function decodeHtml($string)
	{
		return html_entity_decode($string, ENT_QUOTES, static::$defaultCharset);
	}
}

Purifier::$defaultCharset = (string) \App\Config::get('defaultCharset', 'UTF-8');
