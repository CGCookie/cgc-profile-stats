<?php

class CGC_Profile_Stats_Likes extends CGC_Profile_Stats_Base {

	private function init() {
		$this->type = 'likes';
	}

	public function get_data( $user_id = 0 ) {
		return $this->query( array( 'author' => $user_id ) );
	}

	private function query( $args = array() ) {

		$defaults = array(
			'author'    => 0,
			'post_type' => 'images',
			'nopaging'  => true,
			'fields'    => 'ids',
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false
		);

		$args   = wp_parse_args( $args, $defaults );

		$images = get_posts( $args );

		$likes  = 0;

		if( $images ) :
			foreach( $images as $image ) :
				$count = get_post_meta( $image, '_cgc_love_count', true );
				if( is_int( $count ) )
					$likes += $count;
			endforeach;
		endif;

		return $likes;

	}

}