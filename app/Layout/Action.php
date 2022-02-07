<?php
/**
 * Layout action file.
 *
 * @package App
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace App\Layout;

/**
 * Layout action class.
 */
class Action
{
	/**
	 * Get list view actions html.
	 *
	 * @param array $links
	 *
	 * @return string
	 */
	public static function getListViewActions(array $links): string
	{
		return '<div class="actions">' . self::getDropdownButton([
			'label' => 'actions',
			'icon' => 'fas fa-wrench',
			'class' => 'btn-sm btn-light',
			'items' => $links,
		]) . '</div>';
	}

	/**
	 * Get button html.
	 *
	 * @param array $link
	 *
	 * @return string
	 */
	public static function getButton(array $link): string
	{
		$showLabel = $link['showLabel'] ?? false;
		$btn = '<div class="c-btn-link btn-group">';
		if (isset($link['href'])) {
			$btn .= "<a role=\"button\" href=\"{$link['href']}\" ";
		} else {
			$btn .= '<button type="button" ';
		}
		$class = $link['btnClass'] ?? 'btn ';
		if (isset($link['class'])) {
			$class .= $link['class'];
		}
		$btn .= "class=\"$class ml-1\" ";
		if (isset($link['data']) && \is_array($link['data'])) {
			foreach ($link['data'] as $key => $value) {
				$btn .= "data-{$key}=\"{$value}\" ";
			}
		}
		if (!$showLabel && isset($link['label'])) {
			$btn .= 'data-placement="top" data-target="focus hover" data-content="' . \App\Language::translate($link['label'], $link['moduleName']) . '" ';
		}
		$btn .= '>';
		if (isset($link['icon'])) {
			if ($showLabel) {
				$link['icon'] .= ' mr-2';
			}
			$btn .= "<span class=\"{$link['icon']}\"></span>";
		}
		if ($showLabel && isset($link['label'])) {
			$btn .= \App\Language::translate($link['label'], $link['moduleName']);
		}
		$btn .= isset($link['href']) ? '</a>' : '</button>';
		return $btn . '</div>';
	}

	/**
	 * Get dropdown button html.
	 *
	 * @param array $link
	 *
	 * @return string
	 */
	public static function getDropdownButton(array $link): string
	{
		$html = '<div class="dropdown"><button type="button"';
		$class = 'dropdown-toggle btn ';
		if (isset($link['class'])) {
			$class .= $link['class'];
		}
		$html .= "class=\"$class\" data-toggle=\"dropdown\" aria-haspopup=\"true\">";
		if (isset($link['icon'])) {
			$html .= "<span class=\"{$link['icon']}\"></span>";
		}
		$html .= '</button><div class="dropdown-menu pl-1 pr-2 text-right">';
		foreach ($link['items'] as $item) {
			$html .= self::getButton($item);
		}
		$html .= '</div></div>';
		return $html;
	}
}
