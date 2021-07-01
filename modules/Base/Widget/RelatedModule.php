<?php
/**
 * The file contains: widget of RelatedModule type.
 *
 * @package 	Widget
 *
 * @copyright	YetiForce Sp. z o.o.
 * @license		YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author		Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\Widget;

use YF\Modules\Base\Model\Record;

/**
 * RelatedModule type widget class.
 */
class RelatedModule extends \App\BaseModel
{
	/** @var string Widget type. */
	protected $type = 'RelatedModule';

	/** @var string Module name. */
	protected $moduleName;

	/** @var int Source record ID. */
	protected $recordId;

	/** @var int Page number. */
	protected $page = 1;

	/** @var array Entries. */
	protected $entries;

	/** @var array Field list. */
	protected $headers;

	/** @var bool More pages. */
	protected $isMorePages;

	/** @var array Scripts. */
	public $scripts = [];

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
	 * Gets related module name.
	 *
	 * @return string
	 */
	public function getRelatedModuleName(): string
	{
		return $this->get('data')['relatedModuleName'];
	}

	/**
	 * Gets fields from related module.
	 *
	 * @return array
	 */
	public function getFields(): array
	{
		return $this->get('data')['relatedfields'] ?: [];
	}

	/**
	 * Gets relation ID.
	 *
	 * @return int|null
	 */
	public function getRelationId()
	{
		return $this->get('data')['relation_id'] ?? null;
	}

	/**
	 * Gets custom view ID.
	 *
	 * @return int|null
	 */
	public function getCvId()
	{
		return isset($this->get('data')['customView']) ? current($this->get('data')['customView']) : null;
	}

	/**
	 * Check if is more pages.
	 *
	 * @return bool
	 */
	public function isMorePages(): bool
	{
		return $this->isMorePages;
	}

	/**
	 * Gets entries.
	 *
	 * @return array
	 */
	public function getEntries(): array
	{
		if (null === $this->entries) {
			$this->loadData();
		}
		return $this->entries;
	}

	/**
	 * Gets headers.
	 *
	 * @return array
	 */
	public function getHeaders(): array
	{
		if (null === $this->headers) {
			$this->loadData();
		}
		return $this->headers;
	}

	public function loadData()
	{
		$this->headers = $this->entries = [];
		$apiHeaders = ['x-fields' => \App\Json::encode($this->getFields())];
		if ($orderBy = $this->get('data')['orderby'] ?? null) {
			$apiHeaders['x-order-by'] = \App\Json::encode($orderBy);
		}
		if ($limit = (int) ($this->get('data')['limit'] ?? 10)) {
			$apiHeaders['x-row-limit'] = $limit;
		}
		if ($limit && $this->page && $this->page > 1) {
			$apiHeaders['x-row-offset'] = $limit * ($this->page - 1);
		}
		$api = \App\Api::getInstance();
		$api->setCustomHeaders($apiHeaders);

		$body = [];
		if ($relationId = $this->getRelationId()) {
			$body['relationId'] = $relationId;
		}
		if ($cvId = $this->getCvId()) {
			$body['cvId'] = $cvId;
		}

		$response = $api->call("{$this->moduleName}/RecordRelatedList/{$this->recordId}/{$this->getRelatedModuleName()}", $body) ?: [];
		if (!empty($response['records'])) {
			foreach ($response['records'] as $id => $data) {
				$recordModel = Record::getInstance($this->getRelatedModuleName());
				$recordModel->setData($data);
				$recordModel->setId($id);
				$this->entries[$id] = $recordModel;
			}
		}
		$this->headers = array_intersect_key($response['headers'], array_flip($this->getFields()));
		$this->isMorePages = (bool) $response['isMorePages'];
	}

	/**
	 * Gets template path for widget.
	 *
	 * @return string
	 */
	public function getTemplatePath(): string
	{
		return "Widget/{$this->type}.tpl";
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
