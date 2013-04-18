<?php

class CGC_Profile_Stats_Likes extends CGC_Profile_Stats_Base {

	public function init() {
		$this->type = 'likes';
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

		$sites  = get_blogs_of_user( 1, false );

		$likes  = 0;

		foreach( $sites as $site ) :

			switch_to_blog( $site->userblog_id );

			$images = get_posts( $args );
			print_r( $images );
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