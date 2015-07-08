<?php

class Core_Script extends Core_BaseModel
{

	protected static $types = [
		'css' => ['type' => 'text/css', 'rel' => 'stylesheet'],
		'js' => ['type' => 'text/javascript'],
	];

	/**
	 * Function to get the src attribute value
	 * @return <String>
	 */
	public function getSrc()
	{
		$src = $this->get('src');
		if (empty($src)) {
			$src = $this->get('linkurl');
		}
		return $src;
	}

	public function getRel()
	{
		$type = $this->get('type');
		$script = self::$types;
		return $script[$type]['rel'];
	}
}
