[![Latest Stable Version](https://poser.pugx.org/yetiforce/yetiforce-portal/v/stable)](https://packagist.org/packages/yetiforce/yetiforce-portal)
![release date](https://img.shields.io/github/release-date/YetiForceCompany/YetiForcePortal2)
![PHP Version](https://img.shields.io/packagist/php-v/yetiforce/yetiforce-portal)
[![GitHub contributors](https://img.shields.io/github/contributors/YetiForceCompany/YetiForcePortal2.svg)](https://GitHub.com/YetiForceCompany/YetiForcePortal2/graphs/contributors/)
[![Crowdin](https://d322cqt584bo4o.cloudfront.net/yetiforceportal2/localized.svg)](https://crowdin.com/project/yetiforceportal2)
[![SymfonyInsight](https://insight.symfony.com/projects/3a5cf4ef-0d39-4141-91cc-8b9584cba5a9/mini.svg)](https://insight.symfony.com/projects/3a5cf4ef-0d39-4141-91cc-8b9584cba5a9)
[![Scrutinizer](https://scrutinizer-ci.com/g/YetiForceCompany/YetiForcePortal2/badges/quality-score.png?b=developer)](https://scrutinizer-ci.com/g/YetiForceCompany/YetiForcePortal2/)
[![Percentage of issues still open](http://isitmaintained.com/badge/open/YetiForceCompany/YetiForcePortal2.svg)](http://isitmaintained.com/project/YetiForceCompany/YetiForcePortal2 'Percentage of issues still open')
[![Depfu](https://badges.depfu.com/badges/4affeca7559c22dbeba7653979a51d29/status.svg)](https://depfu.com)
[![SecurityHeaders.io](https://img.shields.io/security-headers?url=https%3A%2F%2Fgitdevportal.yetiforce.com/)](https://securityheaders.io/?q=https://gitdevportal.yetiforce.com/)
[![Snyk - Known Vulnerabilities](https://snyk.io/test/github/YetiForceCompany/YetiForcePortal2/badge.svg)](https://snyk.io/test/github/YetiForceCompany/YetiForcePortal2)
[![sonarcloud.io status alert](https://sonarcloud.io/api/project_badges/measure?project=YetiForceCompany_YetiForcePortal2&metric=alert_status)](https://sonarcloud.io/dashboard?id=YetiForceCompany_YetiForcePortal2)
[![sonarcloud.io bugs](https://sonarcloud.io/api/project_badges/measure?project=YetiForceCompany_YetiForcePortal2&metric=bugs)](https://sonarcloud.io/dashboard?id=YetiForceCompany_YetiForcePortal2)
[![sonarcloud.io sqale](https://sonarcloud.io/api/project_badges/measure?project=YetiForceCompany_YetiForcePortal2&metric=sqale_rating)](https://sonarcloud.io/dashboard?id=YetiForceCompany_YetiForcePortal2)
[![sonarcloud.io security](https://sonarcloud.io/api/project_badges/measure?project=YetiForceCompany_YetiForcePortal2&metric=security_rating)](https://sonarcloud.io/dashboard?id=YetiForceCompany_YetiForcePortal2)
[![sonarcloud.io vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=YetiForceCompany_YetiForcePortal2&metric=vulnerabilities)](https://sonarcloud.io/dashboard?id=YetiForceCompany_YetiForcePortal2)

[![SymfonyInsight](https://insight.symfony.com/projects/3a5cf4ef-0d39-4141-91cc-8b9584cba5a9/big.png)](https://insight.symfony.com/projects/3a5cf4ef-0d39-4141-91cc-8b9584cba5a9)
<a href="https://crowdin.com/project/yetiforceportal2" rel="nofollow">
<img width="20%" src="https://support.crowdin.com/assets/badges/localization-at-transparent@1x.svg" alt="crowdin Localization Management Platform">
</a>

The Customer Portal complements YetiForce CRM and is the most effective communication tool for your customers. It’s easy to use and delivers many new functions. You can reduce operating expenses by providing support 24 hours a day. YetiForce Portal delivers also greater customer experiences as your clients can see all relevant information and the current status of their tickets in one place.

## Where else can you find YetiForce?

- [Sourceforge](https://sourceforge.net/projects/yetiforce/)
- [Packagist](https://packagist.org/packages/yetiforce/yetiforce-portal)
- [Development version](https://download.yetiforce.com/portal2-developer.zip) - full package (yarn + composer)

## 🍱 Web server requirements

The requirements are the same for the server and for CRM https://yetiforce.com/en/knowledge-base/documentation/implementer-documentation/item/web-server-requirements

## 🍱 Installation

1. Put files on web server
2. Point web server document root to public_html directory
3. Run:

- yarn install --modules-folder "./public_html/libraries" --ignore-optional
- composer install

4. Activation of Webservice/API services (CRM file `config/Api.php`)

```php
/** List of active services. Available: dav, webservice */
public static $enabledServices = [ 'webservice'];
```

5. Add applications and API users

- My home page / Software configuration / Integration / Web service - Applications
- My home page / Software configuration / Integration / Web service - Users

4. Adjust configuration

## 💻 Demo

- https://gitdeveloper.yetiforce.com/portal/
- https://gitdevportal.yetiforce.com/

## 🏳️ Customer Portal Languages

Languages package https://github.com/YetiForceCompany/YetiForcePortal2Languages

## 🐛 Debug

### CRM `config\Debug.php`

```php
/** [WebServices/API] Show exception messages in response body */
public static $apiShowExceptionMessages = true;

/** [WebServices/API] Show exception reason phrase in response header */
public static $apiShowExceptionReasonPhrase = true;

/** [WebServices/API] Show exception backtrace in response body */
public static $apiShowExceptionBacktrace = true;

/** [WebServices/API] Log to file only exception errors in the logs */
public static $apiLogException = true;

/** [WebServices/API] Log to file all communications data (request + response) */
public static $apiLogAllRequests = true;
```

Log files

- cache/logs/webserviceErrors.log
- cache/logs/webserviceDebug.log

### Portal `config\Config.php`

```php
/** @var bool Enable api debug. */
public static $debugApi = true;

/** @var bool Display main debug console. */
public static $debugConsole = true;

/** @var bool Show detailed information about error exceptions */
public static $displayDetailsException = true;

/** @var bool Show path tracking for error exceptions. */
public static $displayTrackingException = true;

/** @var bool Enable saving all API logs to file. */
public static $apiAllLogs = true;

/** @var bool Enable saving error API logs to file. */
public static $apiErrorLogs = true;
```

Log files

- cache/logs/api.log
- cache/logs/system.log

## 👥 Contributors

This project exists thanks to all the people who contribute. [[Contribute](CONTRIBUTING.md)].
<a href="https://github.com/YetiForceCompany/YetiForcePortal2/graphs/contributors">
<img src="https://contrib.rocks/image?repo=YetiForceCompany/YetiForcePortal2" />
</a>
