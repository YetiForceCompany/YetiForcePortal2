<?php

class Core_Script extends Core_BaseModel {

	/**
	 * Function to get the src attribute value
	 * @return <String>
	 */
	public function getSrc() {
		$src = $this->get('src');
		if (empty($src)) {
			$src = $this->get('linkurl');
		}
		return $src;
	}

}
