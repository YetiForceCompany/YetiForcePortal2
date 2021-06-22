<?php
/**
 * Related list view model file.
 *
 * @package   Model
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\Model;

use App\Purifier;

/**
 * Related list view model class.
 */
class RelatedList extends AbstractListView
{
	/** @var \YF\Modules\Base\Model\DetailView Record view model. */
	protected $detailViewModel;

	/** @var \App\Request Request object. */
	protected $request;

	/** {@inheritdoc} */
	protected $actionName = 'RecordRelatedList';

	/** {@inheritdoc} */
	protected function getFromApi(array $headers): array
	{
		$api = \App\Api::getInstance();
		$api->setCustomHeaders($headers);
		return $api->call("{$this->getModuleName()}/RecordRelatedList/{$this->detailViewModel->getRecordModel()->getId()}/" . $this->request->getByType('relatedModuleName', Purifier::ALNUM), [
			'relationId' => $this->request->getInteger('relationId'),
		]);
	}

	/** {@inheritdoc} */
	public function getDefaultCustomView(): ?int
	{
		return null;
	}

	/**
	 * Set detail view model.
	 *
	 * @param \YF\Modules\Base\Model\DetailView $view
	 *
	 * @return void
	 */
	public function setViewModel(DetailView $view): void
	{
		$this->detailViewModel = $view;
	}

	/**
	 * Set request.
	 *
	 * @param \App\Request $request
	 *
	 * @return void
	 */
	public function setRequest(\App\Request $request): void
	{
		$this->request = $request;
	}
}
