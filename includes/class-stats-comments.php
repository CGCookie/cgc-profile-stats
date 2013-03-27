<?php

class CGC_Profile_Stats_Comments extends CGC_Profile_Stats_Base {

	private function init() {
		$this->type = 'comments';
	}


	private function query( $args = array() ) {

		$defaults = array(
			'user_id'   => 0,
			'number'    => 999999
		);

		$args   = wp_parse_args( $args, $defaults );

		$sites  = get_blogs_of_user( 1, false );

		$comments = 0;

		foreach( $sites as $site ) :

			switch_to_blog( $site->userblog_id );

			$query = new WP_Comment_Query;

			$comments += count( $query->query( $args ) );

			restore_current_blog();

		endforeach;

		return $comments;

	}

}