<?php
/**
 * Inventory config file.
 *
 * @package Config
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
	/** @var string[] Custom inventory columns, if empty then it loads like in crm. */
	public static $columns = [];

	/** @var string[] Custom inventory columns by module name, if empty then it loads like in crm. */
	public static $columnsByModule = [];

	/** @var bool Sets up the inventory columns on the right side of the screen. */
	public static $showInventoryRightColumn = true;
}
