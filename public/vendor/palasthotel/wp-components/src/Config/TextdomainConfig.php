<?php


namespace Palasthotel\WordPress\Config;


/**
 * @property string domain
 * @property string languages
 */
class TextdomainConfig {

	public function __construct(string $domain, string $__file__inPluginBaseDir, string $relativeLanguagesPath) {
		$this->domain = $domain;
		$this->languages = dirname( plugin_basename( $__file__inPluginBaseDir ) ) . "/" . $relativeLanguagesPath;
	}
}