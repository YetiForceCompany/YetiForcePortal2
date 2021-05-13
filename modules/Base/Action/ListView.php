<?php
/**
 * List view action file.
 *
 * @package Action
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\Action;

use App\Purifier;

/**
 * List view action class.
 */
class ListView extends \App\Controller\Action
{
	/** {@inheritdoc} */
	public function process(): void
	{
		$moduleName = $this->request->getModule();
		$record = $this->request->getByType('record', Purifier::INTEGER);
		$templates = $this->request->getArray('templates', Purifier::INTEGER);

		$count = $logsCountAll = 0;
		$rows = $columns = [];
		foreach ($this->request->getArray('columns') as $key => $value) {
			$columns[$key] = $value['name'];
		}
		header('content-type: text/json; charset=UTF-8');
		echo \App\Json::encode([
			'draw' => $this->request->getInteger('draw'),
			'iTotalRecords' => $logsCountAll,
			'iTotalDisplayRecords' => $count,
			'aaData' => $rows
		]);
	}
}
