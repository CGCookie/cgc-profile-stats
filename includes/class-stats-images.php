<?php

class CGC_Profile_Stats_Images extends CGC_Profile_Stats_Base {

	private function init() {
		$this->type = 'images';
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

		$args  = wp_parse_args( $args, $defaults );

		$query = new WP_Query( $args );

		return $query->post_count;

	}

}