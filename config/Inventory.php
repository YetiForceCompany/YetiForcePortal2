<?php
/**
 * Inventory config file.
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace Conf;

/**
 * Inventory config class.
 */
class Inventory
{
	/**
	 * Custom inventory columns, if empty then it loads like in crm.
	 *
	 * @var string[]
	 */
	public static $columns = [];
	/**
	 * Custom inventory columns by module name, if empty then it loads like in crm.
	 *
	 * @var array
	 */
	public static $columnsByModule = [];
}
