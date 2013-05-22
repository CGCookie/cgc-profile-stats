<?php

class CGC_Profile_Stats_Image_Comments extends CGC_Profile_Stats_Base {

	public function init() {
		$this->type = 'image_comments';
	}


	public function query() {

		$args = array(
			'author'    => $this->user_id,
			'post_type' => 'images',
			'nopaging'  => true,
			'fields'    => 'ids',
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false
		);

		$sites  = get_blogs_of_user(1, false);

		$comments = 0;

		foreach( $sites as $site ) :

			switch_to_blog( $site->userblog_id );

			$images = get_posts( $args );
			if( $images ) {
				foreach( $images as $image ) {
					$comments += wp_count_comments( $image )->approved;
				}
			}
			restore_current_blog();

		endforeach;

		return $comments;

	}

}