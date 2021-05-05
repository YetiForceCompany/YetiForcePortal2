<?php
/**
 * Dashboard View.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 */

namespace YF\Modules\Home\View;

use App\Api;
use App\Purifier;

/**
 * View to display dashboard with widgets.
 */
class Dashboard extends \App\Controller\View
{
	private $dashboardData = [];

	/**
	 * Function to get data to dashboard from CRM.
	 *
	 * @param string $moduleName
	 * @param int    $selectedDashboard
	 *
	 * @return array
	 */
	private function getDashboardData(string $moduleName, int $selectedDashboard): array
	{
		if (empty($this->dashboardData)) {
			$this->dashboardData = Api::getInstance()->call("$moduleName/Dashboard/$selectedDashboard");
		}
		return $this->dashboardData;
	}

	/** {@inheritdoc} */
	public function preProcess($display = true): void
	{
		parent::preProcess();
		$moduleName = $this->request->getModule();
		$selectedDashboard = $this->request->getByType('dashboard', Purifier::INTEGER);
		$dashboard = $this->getDashboardData($moduleName, $selectedDashboard);
		$this->viewer->assign('DASHBOARD_TYPE', $dashboard['types']);
		$this->viewer->assign('SELECTED_DASHBOARD', $selectedDashboard);
		$this->viewer->view('Dashboard/PreDashboard.tpl', $moduleName);
	}

	/** {@inheritdoc} */
	public function process()
	{
		$moduleName = $this->request->getModule();
		$selectedDashboard = $this->request->getByType('dashboard', Purifier::INTEGER);
		$dashboard = $this->getDashboardData($moduleName, $selectedDashboard);
		$widgets = [];
		foreach ($dashboard['widgets'] as $widgetData) {
			$widgets[] = \YF\Modules\Base\Dashboard\Base::getInstance($widgetData['type'], $widgetData['data']);
		}
		$this->viewer->assign('WIDGETS', $widgets);
		$this->viewer->view('Dashboard/Dashboard.tpl', $moduleName);
	}

	/** {@inheritdoc} */
	public function getFooterScripts(): array
	{
		return array_merge(
			parent::getFooterScripts(),
			$this->convertScripts([
				'libraries/chart.js/dist/Chart.js',
				'libraries/chartjs-plugin-funnel/dist/chart.funnel.js',
				'libraries/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.js',
				'layouts/' . \App\Viewer::getLayoutName() . '/modules/Base/resources/Widgets.js',
			], 'js'));
	}
}
