<?php
/**
 * Base file model for Detail View.
 *
 * @package Model
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
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

	/** @var YF\Modules\Base\Model\Record Record model. */
	protected $record;

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
	 * @param YF\Modules\Base\Model\Record $recordModel
	 *
	 * @return void
	 */
	public function setRecordModel(Record $recordModel): void
	{
		$this->record = $recordModel;
	}

	/**
	 * Get header links.
	 *
	 * @return array
	 */
	public function getLinksHeader(): array
	{
		$links = [];
		if (Module::isPermitted($this->moduleName, 'EditView')) {
			$links[] = [
				'linktype' => 'DETAILVIEW_HEADER',
				'linklabel' => \App\Language::translate('BTN_EDIT', $this->moduleName),
				'linkurl' => $this->record->getEditViewUrl(),
				'linkicon' => 'fas fa-pencil-alt',
				'linkclass' => 'btn btn-success btn-sm'
			];
		}
		if ($this->record->isInventory()) {
			$links[] = [
				'linktype' => 'DETAILVIEW_HEADER',
				'linklabel' => \App\Language::translate('BTN_EDIT', $this->moduleName),
				'linkurl' => 'index.php?module=Products&view=ShoppingCart&reference_id=' . $this->record->getId() . '&reference_module=' . $this->moduleName,
				'linkicon' => 'fas fa-shopping-cart',
				'linkclass' => 'btn btn-success btn-sm'
			];
		}
		if ($this->record->isPermitted('ExportPdf') && \App\Pdf::getTemplates($this->moduleName, $this->record->getId())) {
			$links[] = [
				'linktype' => 'DETAIL_VIEW_ADDITIONAL',
				'linklabel' => \App\Language::translate('BTN_EXPORT_PDF', $this->moduleName),
				'linkdata' => ['url' => 'index.php?module=' . $this->moduleName . '&view=Pdf&&record=' . $this->record->getId()],
				'linkicon' => 'fas fa-file-pdf',
				'linkclass' => 'btn-dark btn-sm js-show-modal js-pdf',
				'title' => \App\Language::translate('BTN_EXPORT_PDF', $this->moduleName),
			];
		}
		return $links;
	}
}
