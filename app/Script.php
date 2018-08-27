<?php
/**
 * Script controller class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace App;

class Script extends BaseModel
{
	protected static $types = [
		'css' => ['type' => 'text/css', 'rel' => 'stylesheet'],
		'js' => ['type' => 'text/javascript'],
	];

	/**
	 * Function to get the src attribute value.
	 *
	 * @return <String>
	 */
	public function getSrc()
	{
		$src = $this->get('src');
		if (empty($src)) {
			$src = $this->get('linkurl');
		}
		return $src;
	}

	public function getRel()
	{
		$type = $this->get('type');
		$script = self::$types;
		return $script[$type]['rel'];
	}
}
