<?php
/**
 * The file contains: Cart model class.
 *
 * @package   Model
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 */

namespace YF\Modules\Products\Model;

use App\Api;
use App\Session;

/**
 * Cart model class.
 */
class ReferenceCart extends Cart
{
	public $recordId;
	public $moduleName;

	public function __construct(int $recordId, string $moduleName)
	{
		$this->recordId = $recordId;
		$this->moduleName = $moduleName;
		$details = Api::getInstance()->setCustomHeaders(['x-raw-data' => 1])->call("$moduleName/Record/$recordId", [], 'get');
		foreach ($details['rawInventory'] as $item) {
			$this->cart[$item['name']] = [
				'amount' => $item['qty'],
				'param' => [
					'priceNetto' => $item['price'],
					'priceGross' => $item['price'] + $item['tax'] / $item['qty'],
				]
			];
		}
		$this->address = Session::get('Products.Address', []);
	}
}
