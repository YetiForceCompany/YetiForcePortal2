<?php
/**
 * Base file model for Detail View.
 *
 * @package Model
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\Model;

/**
 * Base class model for Detail View.
 */
class DetailView
{
	/** @var string Name of module. */
	protected $moduleName;

	/** @var \YF\Modules\Base\Model\Record Record model. */
	protected $record;

	/** @var Widget list */
	protected $widgets;

	/**
	 * Returns model for detail view.
	 *
	 * @param string $moduleName
	 *
	 * @return self
	 */
	public static function getInstance(string $moduleName): self
	{
		$handlerModule = \App\Loader::getModuleClassName($moduleName, 'Model', 'DetailView');
		return new $handlerModule($moduleName);
	}

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
	 * Sets record model.
	 *
	 * @param \YF\Modules\Base\Model\Record $recordModel
	 *
	 * @return void
	 */
	public function setRecordModel(Record $recordModel): void
	{
		$this->record = $recordModel;
	}

	/**
	 * Get record model.
	 *
	 * @return \YF\Modules\Base\Model\Record
	 */
	public function getRecordModel(): Record
	{
		return $this->record;
	}

	/**
	 * Get detail view header links.
	 *
	 * @return array
	 */
	public function getLinksHeader(): array
	{
		$links = [];
		if (\Conf\Modules\Products::$shoppingMode && $this->record->isInventory()) {
			$links[] = [
				'label' => 'LBL_ADD_TO_CART',
				'moduleName' => $this->moduleName,
				'href' => 'index.php?module=Products&view=ShoppingCart&reference_id=' . $this->record->getId() . '&reference_module=' . $this->moduleName,
				'icon' => 'fas fa-shopping-cart',
				'class' => 'btn-sm btn-primary mr-4',
				'showLabel' => 1,
			];
		}
		if (\YF\Modules\Base\Model\Module::isPermittedByModule($this->moduleName, 'ExportPdf') && \App\Pdf::getTemplates($this->moduleName, $this->record->getId())) {
			$links[] = [
				'label' => 'BTN_EXPORT_PDF',
				'moduleName' => $this->moduleName,
				'data' => ['url' => 'index.php?module=' . $this->moduleName . '&view=Pdf&&record=' . $this->record->getId()],
				'icon' => 'fas fa-file-pdf',
				'class' => 'btn-sm btn-dark js-show-modal js-pdf',
				'showLabel' => 1,
			];
		}
		if ($this->record->isEditable()) {
			$links[] = [
				'label' => 'BTN_EDIT',
				'moduleName' => $this->moduleName,
				'href' => $this->record->getEditViewUrl(),
				'icon' => 'fas fa-edit js-edit-btn',
				'class' => 'btn-sm btn-success',
				'showLabel' => 1,
			];
		}
		if ($this->record->isDeletable()) {
			$links[] = [
				'label' => 'LBL_DELETE',
				'moduleName' => $this->moduleName,
				'data' => ['url' => $this->record->getDeleteUrl()],
				'icon' => 'fas fa-trash-alt',
				'class' => 'btn-sm btn-danger js-delete-record',
				'showLabel' => 1,
			];
		}
		return $links;
	}

	/**
	 * Gets widgets.
	 *
	 * @return array
	 */
	public function getWidgets(): array
	{
		if (null === $this->widgets) {
			$this->widgets = [];
			foreach (\App\Widgets::getInstance($this->moduleName)->getAll() as $widgetObject) {
				$widgetObject->setRecordId($this->record->getId());
				$this->widgets[$widgetObject->getId()] = $widgetObject;
			}
		}
		return $this->widgets;
	}
}
