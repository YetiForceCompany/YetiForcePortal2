<?php
/**
 * Image UIType field file.
 *
 * @package UIType
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 * @author	Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\FieldTypes;

/**
 * Image UIType field class.
 */
class MultiImageField extends BaseField
{
	/** {@inheritdoc} */
	public function getTemplateName(): string
	{
		return 'Field/Image.tpl';
	}

	/** {@inheritdoc} */
	public function getEditViewDisplayValue(\YF\Modules\Base\Model\Record $recordModel = null)
	{
		$value = $recordModel->get($this->getName());
		if ($value && !\is_array($value) && $recordModel && !\App\Json::isEmpty($value)) {
			$value = \App\Json::decode($value);
		} elseif (!\is_array($value)) {
			$value = [];
		}
		if (\array_key_exists('postData', $value)) {
			$value = [$value];
		}
		$fieldValue = [];
		foreach ($value as $image) {
			$mime = $image['type'];
			$src = $this->getImg($image, '', true);
			$fieldValue[] = ['key' => $image['postData']['key'], 'imageSrc' => "data:{$mime};base64,{$src}", 'name' => $image['name'], 'size' => \App\Utils::showBytes($image['size'])];
		}

		return \App\Purifier::encodeHtml(\App\Json::encode($fieldValue));
	}

	/** {@inheritdoc} */
	public function getListDisplayValue($value, \YF\Modules\Base\Model\Record $recordModel = null): string
	{
		if (empty($value)) {
			return '';
		}
		$result = '';
		if (\array_key_exists('postData', $value)) {
			$value = [$value];
		}

		$result = '<div class="c-multi-image__result" style="width:100%">';
		$width = 1 / \count($value) * 100;
		foreach ($value as $image) {
			if ($recordModel) {
				$mime = $image['type'];
				$src = $this->getImg($image, '', true);
				$result .= '<div class="d-inline-block mr-1 c-multi-image__preview-img" style="background-image:url(' . "data:{$mime};base64,{$src}" . ')" style="width:' . $width . '%"></div>';
			} else {
				$result .= \App\Purifier::encodeHtml($image['name']) . ', ';
			}
		}
		return trim($result, "\n\t ") . '</div>';
	}

	/** {@inheritdoc} */
	public function getDisplayValue($value, \YF\Modules\Base\Model\Record $recordModel = null): string
	{
		if (empty($value)) {
			return '';
		}
		if (\array_key_exists('postData', $value)) {
			$value = [$value];
		}
		$fieldValue = [];
		foreach ($value as $image) {
			if ($recordModel) {
				$mime = $image['type'];
				$src = $this->getImg($image, '', true);
				$fieldValue[] = ['key' => $image['postData']['key'], 'imageSrc' => "data:{$mime};base64,{$src}", 'name' => $image['name'], 'size' => \App\Utils::showBytes($image['size'])];
			}
		}

		$fieldInfo = \App\Purifier::encodeHtml(\App\Json::encode($this->getFieldInfo()));
		$fieldValue = \App\Purifier::encodeHtml(\App\Json::encode($fieldValue));
		return "<div class=\"tpl-Detail-Field-MultiImage c-multi-image js-multi-image\">
	<div name=\"{$this->getName()}\" data-value=\"{$fieldValue}\" data-fieldinfo='{$fieldInfo}' class=\"js-multi-image__values\" data-js=\"value\"></div>
	<div class=\"d-inline js-multi-image__result\" data-js=\"container\" data-name=\"{$this->getName()}\"></div>
</div>";
	}

	/**
	 * Get IMG element.
	 *
	 * @param array  $image
	 * @param string $class
	 * @param mixed  $getBase
	 *
	 * @return string
	 */
	public function getImg(array $image, string $class = '', $getBase = false): string
	{
		$mime = $image['type'];
		$content = \App\Api::getInstance()->setCustomHeaders(['Accept' => $mime])->call('Files', $image['postData'], 'put');
		$base = base64_encode($content);
		return $getBase ? $base : "<img class=\"{$class}\" src=\"data:{$mime};base64,{$base}\"/>";
	}

	/**
	 * Provide a filter in the file select dialog box.
	 *
	 * @return string
	 */
	public function getAcceptFormats(): string
	{
		$formats = [];
		foreach ($this->get('formats') as $format) {
			$formats[] = "image/{$format}";
		}
		return $formats ? implode(',', $formats) : 'image/*';
	}

	/** {@inheritdoc} */
	public function setApiData(\App\Request $request, \App\Api $api)
	{
		$fieldName = $this->getName();
		if ($request->has($fieldName)) {
			$values = $request->getRaw($fieldName);
			$values = $values ? \App\Json::decode($values) : [];
			$fieldNameTemp = "{$fieldName}_temp";
			$files = isset($_FILES[$fieldNameTemp]) ? self::flattenFiles($_FILES[$fieldNameTemp]) : [];
			foreach ($values as $index => &$value) {
				if (!empty($value['key'])) {
					continue;
				}
				$name = $value['name'];
				$file = $files[$name] ?? [];
				if (!empty($file['name']) && $file['name'] === $name && isset($file['error']) && $file['size'] > 0) {
					$value['key'] = hash('sha1', $index);
					$value['baseContent'] = base64_encode(file_get_contents($file['tmp_name']));
					unset($files[$name]);
				} else {
					unset($values[$index]);
				}
			}
			$api->setDataBody([$this->getName() => \App\Json::encode($values)]);
		}
		return $this;
	}

	/**
	 * flatten an array of files.
	 *
	 * @param array $array
	 *
	 * @return array
	 */
	public static function flattenFiles(array $array): array
	{
		$result = [];
		foreach ($array as $name => $item) {
			if (\is_array($item)) {
				foreach ($item as $key => $value) {
					$result[$key][$name] = $value;
				}
			} else {
				$result[0][$name] = $item;
			}
		}
		$names = array_column($result, 'name');
		return array_combine($names, $result);
	}
}
