<?php
/**
 * Widget view file.
 *
 * @package View
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\View;

/**
 * Widget view class.
 */
class Widget extends \App\Controller\View
{
	use \App\Controller\ExposeMethodTrait;

	/** @var int Record ID */
	protected $recordId;

	/** @var int Widget ID */
	protected $widgetId;

	/** @var string Module name */
	protected $moduleName;

	/** {@inheritdoc} */
	public function __construct(\App\Request $request)
	{
		parent::__construct($request);
		$this->exposeMethod('getContent');
	}

	/** {@inheritdoc} */
	public function checkPermission(): void
	{
		parent::checkPermission();
		$this->recordId = $this->request->getInteger('record');
		$this->widgetId = $this->request->getInteger('widgetId');
		$this->moduleName = $this->request->getModule();
		if (!$this->recordId || !$this->widgetId || !isset(\App\Widgets::getInstance($this->moduleName)->getAll()[$this->widgetId])) {
			throw new \App\Exceptions\AppException('ERR_PERMISSION_DENIED');
		}
	}

	/** {@inheritdoc} */
	public function process()
	{
		$mode = $this->request->getMode();
		if ($mode && $this->isMethodExposed($mode)) {
			$this->invokeExposedMethod($mode);
		} else {
			$widget = \App\Widgets::getInstance($this->moduleName)->getAll()[$this->widgetId];
			$widget->setRecordId($this->recordId);
			if ($scripts = $widget->getScripts()) {
				$widget->setScriptsObject($this->convertScripts($scripts, 'js'));
			}
			$this->viewer->assign('WIDGET', $widget);
			$this->viewer->view($widget->getTemplatePath(), $this->moduleName);
		}
	}

	/**
	 * Gets widget content.
	 *
	 * @return void
	 */
	public function getContent()
	{
		$widget = \App\Widgets::getInstance($this->moduleName)->getAll()[$this->widgetId];
		$widget->setRecordId($this->recordId);
		if ($page = $this->request->getInteger('page')) {
			$widget->setPage($page);
		}
		$this->viewer->assign('WIDGET', $widget);
		$this->viewer->assign('PAGE', $widget->getPage());
		$this->viewer->view($widget->getTemplateContentPath(), $this->moduleName);
	}
}
