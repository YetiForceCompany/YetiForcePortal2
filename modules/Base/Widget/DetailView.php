<?php
/**
 * The file contains: widget of DetailView type.
 *
 * @package 	Widget
 *
 * @copyright	YetiForce Sp. z o.o.
 * @license		YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author		Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\Widget;

/**
 * DetailView type widget class.
 */
class DetailView extends \App\BaseModel
{
	/** @var string Widget type. */
	protected $type = 'DetailView';

	/** @var string Module name. */
	protected $moduleName;

	/** @var int Source record ID. */
	protected $recordId;

	/** @var int Page number. */
	protected $page = 1;

	/** @var bool More pages. */
	protected $isMorePages;

	/** @var array Scripts. */
	public $scripts = [];

	/** @var int Limit. */
	public $limit = 5;

	/** @var \YF\Modules\Base\Model\Record Model of history record. */
	protected $recordModel;

	/**
	 * Constructor.
	 *
	 * @param string $moduleName
	 */
	public function __construct(string $moduleName)
	{
		$this->moduleName = $moduleName;
	}

	/**
	 * Gets widget ID.
	 *
	 * @return int
	 */
	public function getId()
	{
		return $this->get('id');
	}

	/**
	 * Gets widget type.
	 *
	 * @return string
	 */
	public function getType(): string
	{
		return $this->type;
	}

	/**
	 * Gets module name.
	 *
	 * @return string
	 */
	public function getModuleName(): string
	{
		return $this->moduleName;
	}

	/**
	 * Gets widget name.
	 *
	 * @return string
	 */
	public function getTitle(): string
	{
		return $this->get('name');
	}

	/**
	 * Sets record ID.
	 *
	 * @param int $recordId
	 *
	 * @return $this
	 */
	public function setRecordId(int $recordId)
	{
		$this->recordId = $recordId;

		return $this;
	}

	/**
	 * Get URL address.
	 *
	 * @return string
	 */
	public function getUrl(): string
	{
		return "index.php?module={$this->moduleName}&view=Widget&record={$this->recordId}&mode=getContent&widgetId={$this->getId()}";
	}

	/**
	 * Set page number.
	 *
	 * @param int $page
	 *
	 * @return $this
	 */
	public function setPage(int $page)
	{
		$this->page = $page;
		return $this;
	}

	/**
	 * Get page number.
	 *
	 * @return int
	 */
	public function getPage(): int
	{
		return $this->page;
	}

	/**
	 * Gets history model.
	 *
	 * @return \YF\Modules\Base\Model\Record
	 */
	public function getRecordModel(): \YF\Modules\Base\Model\Record
	{
		if (null === $this->recordModel) {
			$this->recordModel = \YF\Modules\Base\Model\Record::getInstanceById($this->getModuleName(), $this->recordId, [
				'x-header-fields' => 1,
			]);
		}
		return $this->recordModel;
	}

	/**
	 * Gets structure.
	 *
	 * @return array
	 */
	public function getStructure(): array
	{
		$structure = [];
		foreach ($this->getRecordModel()->getModuleModel()->getFieldsModels() as $fieldModel) {
			if ($fieldModel->isViewable()) {
				$structure[$fieldModel->get('blockId')][$fieldModel->getName()] = $fieldModel;
			}
		}
		return $structure;
	}

	/**
	 * Check if is more pages.
	 *
	 * @return bool
	 */
	public function isMorePages(): bool
	{
		return false;
	}

	/**
	 * Gets template path for widget.
	 *
	 * @return string
	 */
	public function getTemplatePath(): string
	{
		return 'Widget/RelatedModule.tpl';
	}

	/**
	 * Gets template path for widget content.
	 *
	 * @return string
	 */
	public function getTemplateContentPath(): string
	{
		return "Widget/{$this->type}Content.tpl";
	}

	/**
	 * Set scripts.
	 *
	 * @param array $scripts
	 */
	public function setScriptsObject($scripts)
	{
		return $this->scripts = $scripts;
	}

	/**
	 * Gets scripts.
	 *
	 * @return array
	 */
	public function getScripts(): array
	{
		return [
			['layouts/' . \App\Viewer::getLayoutName() . "/modules/{$this->moduleName}/resources/Widget/{$this->type}.js", true],
			['layouts/' . \App\Viewer::getLayoutName() . "/modules/Base/resources/Widget/{$this->type}.js", true]
		];
	}
}
