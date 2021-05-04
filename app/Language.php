<?php
/**
 * Language controller class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace App;

class Language
{
	/**
	 * Language files format.
	 */
	const FORMAT = 'json';

	//Contains module language translations
	protected static $languageContainer = [];
	protected static $modules = false;

	/**
	 * Functions that gets translated string.
	 *
	 * @param string $key             - string which need to be translated
	 * @param string $module          - module scope in which the translation need to be check
	 * @param string $currentLanguage
	 *
	 * @return string - translated string
	 */
	public static function translate(string $key, string $module = 'Basic', string $currentLanguage = ''): string
	{
		if (empty($currentLanguage)) {
			$currentLanguage = static::getLanguage();
		}
		//decoding for Start Date & Time and End Date & Time
		if (!is_array($key)) {
			$key = html_entity_decode($key);
		}
		$translatedString = static::getLanguageTranslatedString($currentLanguage, $key, $module);
		// label not found in users language pack, then check in the default language pack(config.inc.php)
		if (null === $translatedString) {
			$defaultLanguage = Config::get('language');
			if (!empty($defaultLanguage) && 0 !== strcasecmp($defaultLanguage, $currentLanguage)) {
				$translatedString = static::getLanguageTranslatedString($defaultLanguage, $key, $module);
			}
		}

		// If translation is not found then return label
		if (null === $translatedString) {
			$translatedString = $key;
		}
		return $translatedString;
	}

	/**
	 * Function that returns current language.
	 *
	 * @return string
	 */
	public static function getLanguage()
	{
		$userInstance = User::getUser();
		$language = '';
		if ($userInstance && $userInstance->has('language') && !empty($userInstance->get('language'))) {
			$language = $userInstance->get('language');
		} else {
			$language = Config::get('language');
		}
		return $language;
	}

	/**
	 * Function returns language specific translated string.
	 *
	 * @param string $language - en_us etc
	 * @param string $key      - label
	 * @param string $module   - module name
	 *
	 * @return string translated string or null if translation not found
	 */
	public static function getLanguageTranslatedString(string $language, string $key, string $module = 'Basic')
	{
		$moduleStrings = self::getModuleStringsFromFile($language, $module);
		if (!empty($moduleStrings['php'][$key])) {
			return stripslashes($moduleStrings['php'][$key]);
		}

		$commonStrings = self::getModuleStringsFromFile($language);
		if (!empty($commonStrings['php'][$key])) {
			return stripslashes($commonStrings['php'][$key]);
		}
		return null;
	}

	public static function getModuleStringsFromFile(string $language, string $module = 'Basic')
	{
		if (empty(self::$languageContainer[$language][$module])) {
			static::loadLanguageFile($language, $module);
		}
		if (isset(self::$languageContainer[$language][$module])) {
			return self::$languageContainer[$language][$module];
		}
		return [];
	}

	/**
	 * Load language file from JSON.
	 *
	 * @param string $language
	 * @param string $moduleName
	 *
	 * @return void
	 */
	public static function loadLanguageFile(string $language, string $moduleName = 'Basic')
	{
		if (!isset(static::$languageContainer[$language][$moduleName])) {
			static::$languageContainer[$language][$moduleName] = [];
			$file = \DIRECTORY_SEPARATOR . 'languages' . \DIRECTORY_SEPARATOR . $language . \DIRECTORY_SEPARATOR . $moduleName . '.' . static::FORMAT;
			$langFile = ROOT_DIRECTORY . $file;
			if (file_exists($langFile)) {
				static::$languageContainer[$language][$moduleName] = Json::decode(file_get_contents($langFile), true) ?? [];
				Cache::save('LanguageFiles', $language . $moduleName, static::$languageContainer[$language][$moduleName], Cache::LONG);
			}
		} elseif (Cache::has('LanguageFiles', $language . $moduleName)) {
			static::$languageContainer[$language][$moduleName] = Cache::get('LanguageFiles', $language . $moduleName);
		}
	}

	/**
	 * Functions that gets translated string for Client side.
	 *
	 * @param <String> $key      - string which need to be translated
	 * @param <String> $module   - module scope in which the translation need to be check
	 * @param mixed    $language
	 *
	 * @return <String> - translated string
	 */
	public static function jstranslate($language, $key, $module = 'Basic')
	{
		$moduleStrings = self::getModuleStringsFromFile($language, $module);
		if (!empty($moduleStrings['js'][$key])) {
			return $moduleStrings['js'][$key];
		}

		$commonStrings = self::getModuleStringsFromFile($language);
		if (!empty($commonStrings['js'][$key])) {
			return $commonStrings['js'][$key];
		}
		return $key;
	}

	/**
	 * Function to returns all language information.
	 *
	 * @return string[]
	 */
	public static function getAllLanguages()
	{
		return Config::$languages;
	}

	/**
	 * Function that returns current language short name.
	 *
	 * @return <String> -
	 */
	public static function getShortLanguageName()
	{
		$language = self::getLanguage();
		return substr($language, 0, 2);
	}

	/**
	 * Function returns module strings.
	 *
	 * @param <String> $module - module Name
	 * @param  <String> languageStrings or jsLanguageStrings
	 * @param mixed $type
	 *
	 * @return <Array>
	 */
	public static function export($module, $type = 'php')
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

	public static function translateModule($module)
	{
		if (!self::$modules) {
			$userInstance = User::getUser();
			self::$modules = $userInstance->getModulesList();
		}
		return isset(self::$modules[$module]) ? self::$modules[$module] : $module;
	}
}
