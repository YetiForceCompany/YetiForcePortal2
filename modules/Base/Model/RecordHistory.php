<?php
/**
 * Basic record history model file.
 *
 * @package Model
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\Model;

/**
 * Basic record history model class.
 */
class RecordHistory extends \App\BaseModel
{
	/** @var string[] Icon actions. */
	public static $iconActions = [
		'LBL_UPDATED' => 'yfi yfi-full-editing-view',
		'LBL_DELETED' => 'fas fa-trash-alt',
		'LBL_CREATED' => 'fas fa-plus',
		'LBL_ACTIVE' => 'fas fa-undo-alt',
		'LBL_ADDED' => 'fas fa-link',
		'LBL_REMOVED' => 'fas fa-unlink',
		'LBL_CONVERTED_FROM_LEAD' => 'fas fa-exchange-alt',
		'LBL_ARCHIVED' => 'fas fa-archive',
		'LBL_TRANSFER_EDIT' => 'yfi yfi-full-editing-view',
		'LBL_TRANSFER_DELETE' => 'fas fa-trash-alt',
		'LBL_TRANSFER_UNLINK' => 'fas fa-unlink',
		'LBL_TRANSFER_LINK' => 'fas fa-link',
	];

	/** @var string[] Colors actions. */
	public static $colorsActions = [
		'LBL_UPDATED' => '#9c27b0',
		'LBL_DELETED' => '#ab0505',
		'LBL_CREATED' => '#607d8b',
		'LBL_ACTIVE' => '#009405',
		'LBL_ADDED' => '#009cb9',
		'LBL_REMOVED' => '#de9100',
		'LBL_CONVERTED_FROM_LEAD' => '#e2e3e5',
		'LBL_ARCHIVED' => '#0032a2',
		'LBL_TRANSFER_EDIT' => '#000',
		'LBL_TRANSFER_DELETE' => '#000',
		'LBL_TRANSFER_UNLINK' => '#000',
		'LBL_TRANSFER_LINK' => '#000',
	];

	/** @var int Limit */
	protected $limit = 50;

	/** @var int Page number */
	protected $page = 1;

	/** @var bool More pages. */
	public $isMorePages;

	/**
	 * Static Function to get the instance of a clean record history.
	 *
	 * @param string $moduleName
	 * @param int    $recordId
	 *
	 * @return \self
	 */
	public static function getInstanceById(string $moduleName, int $recordId): self
	{
		$handlerModule = \App\Loader::getModuleClassName($moduleName, 'Model', 'RecordHistory');
		$instance = new $handlerModule();
		$instance->set('moduleName', $moduleName);
		$instance->set('id', $recordId);
		return $instance;
	}

	/**
	 * Set records limit.
	 *
	 * @param int $limit
	 *
	 * @return $this
	 */
	public function setLimit(int $limit): self
	{
		$this->limit = $limit;
		return $this;
	}

	/**
	 * Set page number.
	 *
	 * @param int $page
	 *
	 * @return $this
	 */
	public function setPage(int $page): self
	{
		$this->page = $page;
		return $this;
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
	 * Get record history.
	 *
	 * @return array
	 */
	public function getHistory(): array
	{
		$api = \App\Api::getInstance();
		$api->setCustomHeaders([
			'x-raw-data' => true,
			'x-row-limit' => $this->limit,
			'x-page' => $this->page,
		]);
		$result = $api->call("{$this->get('moduleName')}/RecordHistory/{$this->get('id')}");
		$this->isMorePages = $result['isMorePages'];
		return $result['records'];
	}
}
