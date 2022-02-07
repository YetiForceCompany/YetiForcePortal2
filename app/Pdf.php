<?php
/**
 * PDF base file.
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace App;

/**
 * Pdf class.
 */
class Pdf
{
	/**
	 * Gets pdf templates.
	 *
	 * @param string $moduleName
	 * @param int    $recordId
	 *
	 * @return array
	 */
	public static function getTemplates(string $moduleName, int $recordId = null)
	{
		return \App\Api::getInstance()->call("{$moduleName}/PdfTemplates/{$recordId}");
	}
}
