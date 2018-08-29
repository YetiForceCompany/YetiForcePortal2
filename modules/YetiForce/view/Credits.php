<?php

/**
 * Credits View class.
 *
 * @copyright YetiForce Sp. z o.o
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author  Arkadiusz Dudek <a.dudek@yetiforce.com>
 */

namespace YF\Modules\YetiForce\View;

/**
 * Class show credits and licenses.
 */
class Credits extends \YF\Modules\Base\View\Index
{
	/**
	 * Page title.
	 *
	 * @var string
	 */
	protected $pageTitle = 'LBL_VIEW_CREDITS';

	/**
	 * Function process.
	 *
	 * @param \App\Request $request
	 */
	public function process(\App\Request $request)
	{
		$qualifiedModuleName = $request->getModule(false);
		$viewer = $this->getViewer($request);
		$viewer->assign('QUALIFIED_MODULE', $qualifiedModuleName);
		$viewer->view('Credits.tpl', $qualifiedModuleName);
	}

	/**
	 * @param \App\Request $request
	 *
	 * @throws \App\AppException
	 *
	 * @return bool
	 */
	public function checkPermission(\App\Request $request)
	{
		return true;
	}

	/**
	 * Function return footer scripts.
	 *
	 * @param \App\Request $request
	 *
	 * @return array
	 */
	public function getFooterScripts(\App\Request $request)
	{
		return parent::getFooterScripts($request);
	}
}
