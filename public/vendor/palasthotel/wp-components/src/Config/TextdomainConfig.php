<?php


namespace Palasthotel\WordPress\Config;


/**
 * @property string domain
 * @property string languages
 */
class TextdomainConfig {
	public function __construct(string $domain, string $relativePathToLangFolder) {
		$this->domain = $domain;
		$this->languages = $relativePathToLangFolder;
	}
}