<?php

/**
 * Library More Info View Class.
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Dudek <a.dudek@yetiforce.com>
 */

namespace YF\Modules\YetiForce\View;

class LibraryMoreInfo
{
	/**
	 * Viewer instance.
	 *
	 * @var \App\Viewer
	 */
	protected $viewer = false;

	/**
	 * Public libraries package files.
	 *
	 * @var string[]
	 */
	public $packageFiles = ['package.json', 'composer.json', 'bower.json'];

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
		return false;
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
		$result = false;
		$fileContent = '';
		if ($request->isEmpty('type') || $request->isEmpty('libraryName')) {
			$result = false;
		} else {
			if ($request->get('type') === 'public') {
				$dir = ROOT_DIRECTORY . DIRECTORY_SEPARATOR . 'public_html' . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR;
				$libraryName = $request->get('libraryName');
				foreach ($this->packageFiles as $file) {
					$packageFile = $dir . $libraryName . DIRECTORY_SEPARATOR . $file;
					if ($fileContent) {
						continue;
					}
					if (file_exists($packageFile)) {
						$fileContent = file_get_contents($packageFile);
						$result = true;
					} else {
						$result = false;
					}
				}
			} elseif ($request->get('type') === 'vendor') {
				$filePath = 'vendor' . DIRECTORY_SEPARATOR . $request->get('libraryName') . DIRECTORY_SEPARATOR . 'composer.json';
				if (file_exists($filePath)) {
					$fileContent = file_get_contents($filePath);
					$result = true;
				} else {
					$result = false;
				}
			} else {
				$result = false;
			}
		}
		$this->preProcess($request);
		$qualifiedModuleName = $request->getModule(false);
		$viewer = $this->getViewer($request);
		$viewer->assign('QUALIFIED_MODULE', $qualifiedModuleName);
		$viewer->assign('RESULT', $result);
		$viewer->assign('FILE_CONTENT', $fileContent);
		$viewer->view('LibraryMoreInfo.tpl', $qualifiedModuleName);
		$this->postProcess($request);
	}
}
