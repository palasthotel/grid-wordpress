<?php
/**
 * @author Palasthotel <rezeption@palasthotel.de>
 * @copyright Copyright (c) 2014, Palasthotel
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2
 * @package Palasthotel\Grid-WordPress
 */

use Palasthotel\Grid\WordPress\Plugin;

/**
* Media-Box is considered as static content
*/
class grid_search_form_box extends grid_static_base_box {

	public function __construct() {
		parent::__construct();
		$this->content->submit_label = __("Search", Plugin::DOMAIN);
		$this->content->placeholder = "";
	}

	/**
	* Sets box type
	*
	* @return string
	*/
	public function type() {
		return 'search_form';
	}

	public function contentStructure() {
		$cs = parent::contentStructure();
		return array_merge(
			$cs,
			[
				[
					"key" => "submit_label",
					"type" => "text",
					"label" => "Submit button label",
				],
				[
					"key" => "placeholder",
					"type" => "text",
					"label" => "Placeholder text",
				]
			]
		);
	}
}
