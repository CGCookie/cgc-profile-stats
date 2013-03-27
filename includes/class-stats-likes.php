<?php

class CGC_Profile_Stats_Likes extends CGC_Profile_Stats_Base {

	private function init() {
		$this->type = 'likes';
	}


	private function query() {

		$defaults = array(
			'author'    => $this->user_id,
			'post_type' => 'images',
			'nopaging'  => true,
			'fields'    => 'ids',
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false
		);

		$args   = wp_parse_args( $args, $defaults );

		$sites  = get_blogs_of_user( 1, false );

		$likes  = 0;

		foreach( $sites as $site ) :

			switch_to_blog( $site->userblog_id );

			$images = get_posts( $args );

			if( $images ) :
				foreach( $images as $image ) :
					$count = get_post_meta( $image, '_cgc_love_count', true );
					if( is_int( $count ) )
						$likes += $count;
				endforeach;
			endif;

			restore_current_blog();

		endforeach;

		return $likes;

	}

}