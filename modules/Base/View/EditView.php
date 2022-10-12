<?php
/**
 * Edit view file.
 *
 * @package View
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\View;

/**
 * Edit view class.
 */
class EditView extends \App\Controller\View
{
	use \App\Controller\EditViewTrait;

	/** {@inheritdoc} */
	public function processTplName(): string
	{
		return 'Edit/EditView.tpl';
	}

	/** {@inheritdoc} */
	public function getFooterScripts(bool $loadForModule = true): array
	{
		$files = [
			['layouts/' . \App\Viewer::getLayoutName() . '/modules/Base/resources/EditView.js'],
		];
		if ($loadForModule) {
			$files[] = ['layouts/' . \App\Viewer::getLayoutName() . '/modules/' . $this->getModuleNameFromRequest() . '/resources/EditView.js', true];
		}
		return array_merge(
			parent::getFooterScripts($loadForModule),
			$this->convertScripts($files, 'js')
		);
	}
}
