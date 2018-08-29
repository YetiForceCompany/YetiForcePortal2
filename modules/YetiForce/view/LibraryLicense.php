<?php

/**
 * Library License View Class.
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Dudek <a.dudek@yetiforce.com>
 */

namespace YF\Modules\YetiForce\View;

class LibraryLicense
{
	/**
	 * Viewer instance.
	 *
	 * @var \App\Viewer
	 */
	protected $viewer = false;

	/**
	 * Checking permissions.
	 *
	 * @param \App\Request $request
	 *
	 * @return bool
	 */
	public function checkPermission(\App\Request $request)
	{
		return true;
	}

	/**
	 * Function to check login required permission.
	 *
	 * @return bool
	 */
	public function loginRequired()
	{
		return true;
	}

	/**
	 * Function get modal size.
	 *
	 * @param \App\Request $request
	 *
	 * @return string
	 */
	public function getSize(\App\Request $request)
	{
		return 'modal-lg';
	}

	/**
	 * Pre process function.
	 *
	 * @param \App\Request $request
	 */
	public function preProcess(\App\Request $request)
	{
	}

	/**
	 * Post process function.
	 *
	 * @param \App\Request $request
	 */
	public function postProcess(\App\Request $request)
	{
	}

	/**
	 * Get viewer.
	 *
	 * @param \App\Request $request
	 *
	 * @return \App\Viewer
	 */
	public function getViewer(\App\Request $request)
	{
		if (!$this->viewer) {
			$moduleName = $request->getModule();
			$viewer = new \App\Viewer();
			$userInstance = \App\User::getUser();
			$viewer->assign('MODULE_NAME', $moduleName);
			$viewer->assign('VIEW', $request->get('view'));
			$viewer->assign('USER', $userInstance);
			$viewer->assign('ACTION_NAME', $request->getAction());
			$this->viewer = $viewer;
		}
		return $this->viewer;
	}

	/**
	 * Process function.
	 *
	 * @param \App\Request $request
	 */
	public function process(\App\Request $request)
	{
		$fileContent = '';
		if ($request->isEmpty('license')) {
			$result = false;
		} else {
			$dir = ROOT_DIRECTORY . DIRECTORY_SEPARATOR . 'licenses' . DIRECTORY_SEPARATOR;
			$filePath = $dir . $request->get('license', 'Text') . '.txt';
			if (file_exists($filePath)) {
				$result = true;
				$fileContent = file_get_contents($filePath);
			} else {
				$result = false;
			}
		}

		$this->preProcess($request);
		$qualifiedModuleName = $request->getModule(false);
		$viewer = $this->getViewer($request);
		$viewer->assign('QUALIFIED_MODULE', $qualifiedModuleName);
		$viewer->assign('FILE_EXIST', $result);
		$viewer->assign('FILE_CONTENT', $fileContent);
		$viewer->view('LibraryLicense.tpl', $qualifiedModuleName);
		$this->postProcess($request);
	}
}
