<?php

class CGC_Profile_Stats_Images extends CGC_Profile_Stats_Base {

	private function init() {
		$this->type = 'images';
	}


	private function query() {

		$args = array(
			'author'    => $this->user_id,
			'post_type' => 'images',
			'nopaging'  => true,
			'fields'    => 'ids',
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false
		);

		$sites  = get_blogs_of_user(1, false);

		$images = 0;

		foreach( $sites as $site ) :

			switch_to_blog( $site->userblog_id );

			$query = new WP_Query( $args );

			$images += $query->post_count;

			restore_current_blog();

		endforeach;

		return $images;

	}

}