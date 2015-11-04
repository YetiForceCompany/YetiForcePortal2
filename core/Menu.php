<?php
/**
 * Menu class
 * @package YetiForce.Config
 * @license licenses/License.html
 * @author Tomasz Kur <t.kur@yetiforce.com>
 */
namespace Core;
class Menu
{
	static private $icons = [
		'Potentials' => 'moduleIcon-opportunities',
		'Contacts' => 'moduleIcon-contacts',
		'Accounts' => 'moduleIcon-accounts',
		'Leads' => 'moduleIcon-leads',
		'Documents' => 'moduleIcon-documents',
		'Calendar' => 'moduleIcon-calendar',
		'Emails' => 'moduleIcon-my-mailbox',
		'HelpDesk' => 'moduleIcon-tickets',
		'Products' => 'moduleIcon-products',
		'Faq' => 'moduleIcon-faq',
		'Vendors' => 'moduleIcon-vendors',
		'PriceBooks' => 'moduleIcon-price-books',
		'Quotes' => 'moduleIcon-quotes',
		'PurchaseOrder' => 'moduleIcon-purchase-order',
		'SalesOrder' => 'moduleIcon-sales-order',
		'Invoice' => 'moduleIcon-invoices',
		'Campaigns' => 'moduleIcon-campaigns',
		'PBXManager' => '',
		'ServiceContracts' => 'moduleIcon-service-contracts',
		'Services' => 'moduleIcon-services',
		'Assets' => 'moduleIcon-assets',
		'ModComments' => '',
		'ProjectMilestone' => 'moduleIcon-project_milestones',
		'ProjectTask' => 'moduleIcon-project-task',
		'Project' => 'moduleIcon-projects2',
		'SMSNotifier' => 'moduleIcon-text-messages',
		'OSSPdf' => 'moduleIcon-pdf',
		'OSSMailTemplates' => 'moduleIcon-mail-templates',
		'OSSTimeControl' => 'moduleIcon-time-control',
		'OSSMailView' => 'moduleIcon-corporate-emails',
		'OSSOutsourcedServices' => 'moduleIcon-outsourced-services',
		'OSSSoldServices' => 'moduleIcon-sold-services',
		'OutsourcedProducts' => 'moduleIcon-outsourced-products',
		'OSSPasswords' => 'moduleIcon-user-access-control',
		'OSSEmployees' => 'moduleIcon-employees',
		'Calculations' => 'moduleIcon-calculations',
		'OSSCosts' => 'moduleIcon-costs',
		'CallHistory' => 'moduleIcon-call-history',
		'Ideas' => 'moduleIcon-ideas',
		'RequirementCards' => 'moduleIcon-requirement-cards',
		'QuotesEnquires' => 'moduleIcon-quotes-enquires',
		'HolidaysEntitlement' => 'moduleIcon-annual-holiday-entitlement',
		'PaymentsIn' => 'moduleIcon-payments-in',
		'PaymentsOut' => 'moduleIcon-payments-out',
		'LettersIn' => 'moduleIcon-letters-incoming',
		'LettersOut' => 'moduleIcon-letters-outgoing',
		'NewOrders' => 'moduleIcon-new-orders',
		'Reservations' => 'moduleIcon-reservations'
	];
	static public function getBreadcrumbs()
	{
		$breadcrumbs = false;
		$request = new Request($_REQUEST);
		$moduleName = $request->get('module');
		$view = $request->get('view');
		$breadcrumbs[] = [ 'name' => Language::translate($moduleName)];
		if ($view == 'EditView' && $request->get('record') == '') {
			$breadcrumbs[] = [ 'name' => Language::translate('LBL_VIEW_CREATE', $moduleName)];
		} elseif ($view != '' && $view != 'index' && $view != 'Index') {
			$breadcrumbs[] = [ 'name' => Language::translate('LBL_VIEW_' . strtoupper($view), $moduleName)];
		} elseif ($view == '') {
			$breadcrumbs[] = [ 'name' => Language::translate('LBL_HOME', $moduleName)];
		}
		if ($request->get('record') != '') {
			$recordLabel = $request->get('record');
			if ($recordLabel != '') {
				$breadcrumbs[] = [ 'name' => $recordLabel];
			}
		}
		return $breadcrumbs;
	}
	static public function getIcon($moduleName)
	{ 
		return self::$icons[$moduleName];
	}
}
