<?php

class CGC_Profile_Stats_Images extends CGC_Profile_Stats_Base {

	public function init() {
		$this->type = 'images';
	}


	public function query() {

		$sites  = get_blogs_of_user(1, false);

		$images = 0;

		foreach( $sites as $site ) :

			switch_to_blog( $site->userblog_id );

			if( function_exists( 'cgc_count_user_posts_by_type' ) )
				$images += cgc_count_user_posts_by_type( $this->user_id, 'images' );

			restore_current_blog();

		endforeach;

		return $images;

	}

}