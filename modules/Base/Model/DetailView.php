<?php
/**
 * Base model for Detail View.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 */

namespace YF\Modules\Base\Model;

class DetailView
{
	/**
	 * Name of module.
	 *
	 * @var string
	 */
	protected $moduleName;
	/**
	 * Record model.
	 *
	 * @var Record
	 */
	protected $record;

	/**
	 * Returns model for detailview.
	 *
	 * @param string $moduleName
	 *
	 * @return self
	 */
	public static function getInstance(string $moduleName)
	{
		$handlerModule = \App\Loader::getModuleClassName($moduleName, 'Model', 'DetailView');
		return new $handlerModule($moduleName);
	}

	public function __construct(string $moduleName)
	{
		$this->moduleName = $moduleName;
	}

	/**
	 * Sets record model.
	 *
	 * @param Record $recordModel
	 *
	 * @return void
	 */
	public function setRecordModel(Record $recordModel)
	{
		$this->record = $recordModel;
	}

	public function getLinksHeader()
	{
		$links = [];
		if (\YF\Modules\Base\Model\Module::isPermitted($this->moduleName, 'EditView')) {
			$links[] = [
				'linktype' => 'DETAILVIEW_HEADER',
				'linklabel' => \App\Language::translate('BTN_EDIT', $this->moduleName),
				'linkurl' => $this->record->getEditViewUrl(),
				'linkicon' => 'fas fa-pencil-alt',
				'linkclass' => 'btn btn-outline-success btn-sm'
			];
		}
		if ($this->record->isInventory()) {
			$links[] = [
				'linktype' => 'DETAILVIEW_HEADER',
				'linklabel' => \App\Language::translate('BTN_EDIT', $this->moduleName),
				'linkurl' => 'index.php?module=Products&view=ShoppingCart&reference_id=' . $this->record->getId() . '&reference_module=' . $this->moduleName,
				'linkicon' => 'fas fa-shopping-cart',
				'linkclass' => 'btn btn-outline-success btn-sm'
			];
		}
		return $links;
	}
}
