<?php

/**
 * Library more info view file.
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Sołek <a.solek@yetiforce.com>
 */

namespace YF\Modules\YetiForce\View;

/**
 * Library more info view class.
 */
class LibraryMoreInfo extends \App\Controller\Modal
{
	/** @var array Public libraries package files. */
	public $packageFiles = ['package.json', 'composer.json', 'bower.json'];

	/** {@inheritdoc} */
	public function checkPermission(): bool
	{
		return true;
	}

	/**  {@inheritdoc}  */
	public function getTitle(): string
	{
		return \App\Language::translate('LBL_MORE_LIBRARY_INFO', $this->moduleName);
	}

	/** {@inheritdoc} */
	public function validateRequest(): void
	{
		$this->request->validateWriteAccess();
	}

	/** {@inheritdoc} */
	public function process(): void
	{
		$result = false;
		$fileContent = '';
		if ($this->request->isEmpty('type') || $this->request->isEmpty('libraryName')) {
			$result = false;
		} else {
			if ('public' === $this->request->get('type')) {
				$dir = ROOT_DIRECTORY . \DIRECTORY_SEPARATOR . 'public_html' . \DIRECTORY_SEPARATOR . 'libraries' . \DIRECTORY_SEPARATOR;
				$libraryName = $this->request->get('libraryName');
				foreach ($this->packageFiles as $file) {
					$packageFile = $dir . $libraryName . \DIRECTORY_SEPARATOR . $file;
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
			} elseif ('vendor' === $this->request->get('type')) {
				$filePath = 'vendor' . \DIRECTORY_SEPARATOR . $this->request->get('libraryName') . \DIRECTORY_SEPARATOR . 'composer.json';

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
		$qualifiedModuleName = $this->request->getModule(false);
		$this->viewer->assign('QUALIFIED_MODULE', $qualifiedModuleName);
		$this->viewer->assign('RESULT', $result);
		$this->viewer->assign('FILE_CONTENT', $fileContent);
		$this->viewer->view('LibraryMoreInfo.tpl', $qualifiedModuleName);
	}
}
