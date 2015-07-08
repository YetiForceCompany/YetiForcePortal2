<?php
/* {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} */

class Core_Language
{

	//Contains module language translations
	protected static $languageContainer = [];

	/**
	 * Functions that gets translated string
	 * @param <String> $key - string which need to be translated
	 * @param <String> $module - module scope in which the translation need to be check
	 * @return <String> - translated string
	 */
	public static function translate($key, $module = '', $currentLanguage = '')
	{
		if (empty($currentLanguage)) {
			$currentLanguage = self::getLanguage();
		}
		//decoding for Start Date & Time and End Date & Time 
		if (!is_array($key))
			$key = html_entity_decode($key);
		$translatedString = self::getLanguageTranslatedString($currentLanguage, $key, $module);

		// label not found in users language pack, then check in the default language pack(config.inc.php)
		if ($translatedString === null) {
			$defaultLanguage = Config::get('language');
			if (!empty($defaultLanguage) && strcasecmp($defaultLanguage, $currentLanguage) !== 0) {
				$translatedString = self::getLanguageTranslatedString($defaultLanguage, $key, $module);
			}
		}

		// If translation is not found then return label
		if ($translatedString === null) {
			$translatedString = $key;
		}
		return $translatedString;
	}

	/**
	 * Function returns language specific translated string
	 * @param <String> $language - en_us etc
	 * @param <String> $key - label
	 * @param <String> $module - module name
	 * @return <String> translated string or null if translation not found
	 */
	public static function getLanguageTranslatedString($language, $key, $module = '')
	{
		$moduleStrings = self::getModuleStringsFromFile($language, $module);
		if (!empty($moduleStrings['phpLang'][$key])) {
			return stripslashes($moduleStrings['phpLang'][$key]);
		}

		$commonStrings = self::getModuleStringsFromFile($language);
		if (!empty($commonStrings['phpLang'][$key]))
			return stripslashes($commonStrings['phpLang'][$key]);

		return null;
	}

	/**
	 * Functions that gets translated string for Client side
	 * @param <String> $key - string which need to be translated
	 * @param <String> $module - module scope in which the translation need to be check
	 * @return <String> - translated string
	 */
	public static function jstranslate($language, $key, $module = '')
	{
		$moduleStrings = self::getModuleStringsFromFile($language, $module);
		if (!empty($moduleStrings['jsLang'][$key])) {
			return $moduleStrings['jsLang'][$key];
		}

		$commonStrings = self::getModuleStringsFromFile($language);
		if (!empty($commonStrings['jsLang'][$key]))
			return $commonStrings['jsLang'][$key];

		return $key;
	}

	public static function getModuleStringsFromFile($language, $module = 'Basic')
	{
		if (empty(self::$languageContainer[$language][$module])) {
			$file = 'language' . DIRECTORY_SEPARATOR . $language . DIRECTORY_SEPARATOR . $module . '.php';
			$phpLang = $jsLang = [];
			if (file_exists($file)) {
				require $file;
				self::$languageContainer[$language][$module]['phpLang'] = $phpLang;
				self::$languageContainer[$language][$module]['jsLang'] = $jsLang;
			}
		}
		if (isset(self::$languageContainer[$language][$module])) {
			return self::$languageContainer[$language][$module];
		}
		return [];
	}

	/**
	 * Function that returns current language
	 * @return <String> -
	 */
	public static function getLanguage()
	{
		$userInstance = Core_User::getUser();
		$language = '';
		if ($userInstance) {
			$language = $userInstance->language;
		} else {
			$language = Config::get('language');
		}
		return $language;
	}

	/**
	 * Function to returns all language information
	 * @return <Array>
	 */
	public static function getAllLanguages()
	{
		return Config::get('languages');
	}

	/**
	 * Function that returns current language short name
	 * @return <String> -
	 */
	public static function getShortLanguageName()
	{
		$language = self::getLanguage();
		return substr($language, 0, 2);
	}

	/**
	 * Function returns module strings
	 * @param <String> $module - module Name
	 * @param <String> languageStrings or jsLanguageStrings
	 * @return <Array>
	 */
	public static function export($module, $type = 'phpLang')
	{
		$language = self::getLanguage();
		$exportLangString = [];

		$moduleStrings = self::getModuleStringsFromFile($language, $module);
		if (!empty($moduleStrings[$type])) {
			$exportLangString = $moduleStrings[$type];
		}

		$commonStrings = self::getModuleStringsFromFile($language);
		if (!empty($commonStrings[$type])) {
			$exportLangString += $commonStrings[$type];
		}
		return $exportLangString;
	}
}
