<?php

namespace Palasthotel\Grid\WordPress;

use Palasthotel\Grid\Endpoint;

class Ajax extends Endpoint {

	/**
	 * Grid elements are rendered as they are stored. People who may not post
	 * unfiltered HTML get the same treatment as in posts: markup is filtered
	 * with wp_kses_post(), urls, link targets and styles are checked.
	 *
	 * @return bool
	 */
	private function must_filter_input() {
		return ! current_user_can( 'unfiltered_html' );
	}

	/**
	 * @param mixed $value
	 *
	 * @return mixed
	 */
	private function filter_value( $value ) {
		if ( is_string( $value ) ) {
			return ( false !== strpos( $value, '<' ) ) ? wp_kses_post( $value ) : $value;
		}
		if ( is_array( $value ) ) {
			foreach ( $value as $key => $item ) {
				$value[ $key ] = $this->filter_value( $item );
			}
			return $value;
		}
		if ( is_object( $value ) ) {
			foreach ( get_object_vars( $value ) as $key => $item ) {
				$value->{$key} = $this->filter_value( $item );
			}
		}
		return $value;
	}

	/**
	 * Filters the fields of a box or container the editor sends.
	 *
	 * @param mixed $data
	 * @param array $styles list of array( 'slug' => ..., 'title' => ... ) that may be used
	 *
	 * @return mixed
	 */
	private function filter_element_data( $data, $styles ) {
		if ( ! $this->must_filter_input() || ! is_object( $data ) ) {
			return $data;
		}
		foreach ( get_object_vars( $data ) as $key => $value ) {
			if ( ! is_string( $value ) ) {
				if ( 'content' === $key ) {
					$data->content = $this->filter_value( $value );
				} elseif ( 'style' === $key ) {
					$data->style = null;
				}
				continue;
			}
			switch ( $key ) {
				case 'titleurl':
				case 'readmoreurl':
					$data->{$key} = esc_url_raw( $value );
					break;
				case 'titleurltarget':
				case 'readmoreurltarget':
					$data->{$key} = preg_replace( '/[^A-Za-z0-9_-]/', '', $value );
					break;
				case 'style':
					$data->style = in_array( $value, wp_list_pluck( $styles, 'slug' ), true ) ? $value : null;
					break;
				default:
					$data->{$key} = $this->filter_value( $value );
			}
		}
		return $data;
	}

	public function CreateBox( $gridid, $containerid, $slotid, $idx, $boxtype, $content ) {
		if ( $this->must_filter_input() ) {
			$content = $this->filter_value( $content );
		}
		return parent::CreateBox( $gridid, $containerid, $slotid, $idx, $boxtype, $content );
	}

	public function updateContainer( $gridid, $containerid, $containerdata ) {
		$containerdata = $this->filter_element_data( $containerdata, $this->storage->fetchContainerStyles() );
		return parent::updateContainer( $gridid, $containerid, $containerdata );
	}

	public function updateSlotStyle( $gridid, $containerid, $slotid, $style ) {
		if ( $this->must_filter_input() && null !== $style && ! in_array( $style, wp_list_pluck( $this->storage->fetchSlotStyles(), 'slug' ), true ) ) {
			$style = null;
		}
		return parent::updateSlotStyle( $gridid, $containerid, $slotid, $style );
	}

	public function reuseBox( $gridid, $containerid, $slotid, $idx, $reusetitle ) {
		if ( $this->must_filter_input() && is_string( $reusetitle ) ) {
			$reusetitle = sanitize_text_field( $reusetitle );
		}
		return parent::reuseBox( $gridid, $containerid, $slotid, $idx, $reusetitle );
	}

	public function reuseContainer( $gridid, $containerid, $title ) {
		if ( $this->must_filter_input() && is_string( $title ) ) {
			$title = sanitize_text_field( $title );
		}
		return parent::reuseContainer( $gridid, $containerid, $title );
	}

	public function Rights()
	{
		$privs = \grid_wp_get_privs();
		$privileges = array();
		foreach ( $privs as $role => $privs ) {
			if ( current_user_can( $role ) ) {
				foreach ( $privs as $key => $val ) {
					if ( $val ) {
						if ( ! in_array( $key, $privileges ) ) {
							$privileges[] = $key;
						}
					}
				}
			}
		}
		return $privileges;
	}

	public function publishDraft($gridid)
	{
		$result=parent::publishDraft($gridid);
		if($result)
		{
			$nid=grid_wp_get_postid_by_grid($gridid);
			do_action('grid_published',$nid);
		}
		return $result;
	}
	public function getMetaTypesAndSearchCriteria($grid_id){
		$result=parent::getMetaTypesAndSearchCriteria($grid_id);
		$post_id=NULL;
		if(strncmp("container:",$grid_id,strlen("container:"))==0)
		{
			$post_id=NULL;
		}
		else if(strncmp("box:",$grid_id,strlen("box:"))==0)
		{
			$post_id=NULL;
		}
		else
		{
			$post_id=grid_wp_get_postid_by_grid($grid_id);
		}
		$result=apply_filters('grid_metaboxes',$result,$grid_id,$post_id);
		return $result;
	}

	public function Search($grid_id,$metatype,$searchstring,$criteria)
	{
		$result=parent::Search($grid_id,$metatype,$searchstring,$criteria);
		if(strncmp("container:",$grid_id,strlen("container:"))==0)
		{
			$post_id=NULL;
		}
		else if(strncmp("box:",$grid_id,strlen("box:"))==0)
		{
			$post_id=NULL;
		}
		else
		{
			$post_id=grid_wp_get_postid_by_grid($grid_id);
		}
		$result=apply_filters('grid_boxes_search',$result,$grid_id,$post_id);
		return $result;
	}

	public function getContainerTypes($grid_id)
	{
		$result=parent::getContainerTypes($grid_id);
		if(strncmp("container:",$grid_id,strlen("container:"))==0)
		{
			$post_id=NULL;
		}
		else if(strncmp("box:",$grid_id,strlen("box:"))==0)
		{
			$post_id=NULL;
		}
		else
		{
			$post_id=grid_wp_get_postid_by_grid($grid_id);
		}
		$result=apply_filters('grid_containers',$result,$grid_id,$post_id);
		return $result;
	}

	public function getReusableContainers($grid_id)
	{
		$result=parent::getReusableContainers($grid_id);
		$result=apply_filters('grid_reusable_containers',$result,$grid_id,grid_wp_get_postid_by_grid($grid_id));
		return $result;
	}

	public function UpdateBox($gridid,$containerid,$slotid,$idx,$boxdata)
	{
		$boxdata=$this->filter_element_data($boxdata,$this->storage->fetchBoxStyles());
		$result=parent::UpdateBox($gridid,$containerid,$slotid,$idx,$boxdata);
		if($result!=FALSE)
		{
			$grid=$this->storage->loadGrid($gridid);
			foreach($grid->container as $container)
			{
				if($container->containerid==$containerid)
				{
					foreach($container->slots as $slot)
					{
						if($slot->slotid==$slotid)
						{
							if(isset($slot->boxes[$idx]))
							{
								//we found a box.
								$box=$slot->boxes[$idx];
								$box=apply_filters('grid_persist_box',$box);
								if(is_array($box) && count($box)>0 && $box[0]!==NULL)
								{
									$box=$box[0];
									$slot->boxes[$idx]=$box;
									$box->persist();
								}
								else
								{
									$box=$slot->boxes[$idx];
								}
								return $this->encodeBox($box);
							}
							return FALSE;
						}
					}
				}
			}
		}
	}

}