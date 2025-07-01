<?php


namespace Palasthotel\Grid\WordPress\Component;

class TextdomainConfig {

    public string $domain;
    public string $languages;

	public function __construct(string $domain, string $relativeLanguagesPath) {
		$this->domain = $domain;
		$this->languages = $relativeLanguagesPath;
	}
}