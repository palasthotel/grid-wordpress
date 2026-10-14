<?php
/**
 * @author Palasthotel <rezeption@palasthotel.de>
 * @copyright Copyright (c) 2014, Palasthotel
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2
 * @package Palasthotel\Grid
 */
 
/**
* Video-Box is considered a static content
*/
class grid_video_box extends grid_static_base_box
{
	/**
	* Sets box type
	*
	* @return string
	*/
	public function type() {
		return "video";
	}

	/**
	* Class contructor
	*
	* Initializes editor widgets for backend
	*/
	public function __construct() {
		parent::__construct();
		$this->content->url='';
		$this->content->title = 0;
		$this->content->related=0;
		$this->content->html='';
	}

	/**
	* Box renders its menu label and renders its content in here.
	*
	* @param boolean $editmode
	*
	* @return string
	*/
	public function build($editmode) {
		if($editmode) {
			return $this->content;
		}
		else {
			return $this->content->html;
		}
	}
	
	/**
	* Determines editor widgets used in backend
	*
	* @return array
	*/
	public function contentStructure() {
		return array(
			array(
				'key'=>'url',
				'label'=>__( 'Video-URL', 'grid' ),
				'type'=>'text',
			),
			array(
				'key'=>'title',
				'label' => __( 'Display title', 'grid' ),
				'type'=>'checkbox',
			),
			array(
				'key'=>'related',
				'label'=>__( 'Display related videos at the end (YouTube)', 'grid' ),
				'type'=>'checkbox',
			),
			array(
				'key'=>'html',
				'type'=>'hidden',
			),
		);
	}

	/**
	* Persists function
	*
	* @return mixed
	*/
	public function persist()
	{
		// the embed code always comes from the video platform, never from the request
		$this->content->html = '';
		if(isset($this->content->url) && !empty($this->content->url))
		{
			// OK, we have an url, we need to do our oembed vodoo.
			$result=wp_parse_url($this->content->url);
			$host = ( is_array( $result ) && isset( $result['host'] ) ) ? $result['host'] : '';
			if(preg_match("/\w*?\.youtube\./um", $host))
			{
				$url_show_info = "&showinfo=";
				if($this->content->title){
					$url_show_info.="1";
				} else {
					$url_show_info.="0";
				}
				$url_related = "&rel=";
				if($this->content->related){
					$url_related.="1";
				} else {
					$url_related.="0";
				}
				$url="https://www.youtube.com/oembed?url=".urlencode($this->content->url)."&format=json";
				$html=$this->fetch_oembed_html($url);
				$html=str_replace("src=\"http://", "src=\"https://", $html);
				// Prevents flash bug in Firefox (no playback on click)
				$html=str_replace('feature=oembed', 'feature=oembed&wmode=transparent&html5=1'.$url_related.$url_show_info, $html);
				$this->content->html=$html;
			}
			else if(preg_match("/youtu\.be/um", $host) ) {
				$url_show_info = "&showinfo=";
				if($this->content->title){
					$url_show_info.="1";
				} else {
					$url_show_info.="0";
				}
				$url_related = "&rel=";
				if($this->content->related){
					$url_related.="1";
				} else {
					$url_related.="0";
				}
				$url = $this->content->url;
				if(strpos($url, "?") !== false){
					$url = explode("?",$url);
					$url = $url[0];
				}
				
				$parts = explode("/", $url);
				$url="https://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=".urlencode(end($parts))."&format=json";
				$html=$this->fetch_oembed_html($url);
				$html=str_replace("src=\"http://", "src=\"https://", $html);
				// Prevents flash bug in Firefox (no playback on click)
				$html=str_replace('feature=oembed', 'feature=oembed&wmode=transparent&html5=1'.$url_related.$url_show_info, $html);
				$this->content->html=$html;
			}
			else if(preg_match("/(\w*?\.)?vimeo\./um", $host))
			{
				$url_need_title = "&title=";
				$url_need_byline = "&byline=";
				$url_need_portrait = "&portrait=";
				if($this->content->title){
					$url_need_title.="true";
					$url_need_byline.="true";
					$url_need_portrait.="true";
				} else {
					$url_need_title.="false";
					$url_need_byline.="false";
					$url_need_portrait.="false";
				}

				$url="https://vimeo.com/api/oembed.json?url=".urlencode($this->content->url).$url_need_title.$url_need_byline.$url_need_portrait;
				$this->content->html=$this->fetch_oembed_html($url);
			}
			else $this->content->html=esc_html( $host );
		}
		return parent::persist();
	}

	/**
	 * Asks the video platform's oEmbed endpoint for the embed code.
	 *
	 * @param string $url oEmbed request url
	 *
	 * @return string the embed html, empty if the request failed
	 */
	private function fetch_oembed_html( $url ) {
		$response = wp_safe_remote_get( $url );
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
			return '';
		}
		$data = json_decode( wp_remote_retrieve_body( $response ) );
		return ( is_object( $data ) && isset( $data->html ) && is_string( $data->html ) ) ? $data->html : '';
	}
}