<?php
/**
 * Widget mini list.
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 */

namespace YF\Modules\Base\Dashboard;

/**
 * Widget Mini List in dashboard.
 */
class ChartFilter extends Base
{
	/**
	 * Name template to render before content widget.
	 *
	 * @return string
	 */
	public function getPreProcessTemplate(): string
	{
		return 'Dashboard/Widget/PreMiniList.tpl';
	}

	/**
	 * Name template to render content widget.
	 *
	 * @return string
	 */
	public function getProcessTemplate(): string
	{
		return 'Dashboard/Widget/ChartFilter.tpl';
	}
}
