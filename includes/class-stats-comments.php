<?php

class CGC_Profile_Stats_Comments extends CGC_Profile_Stats_Base {

	public function init() {
		$this->type = 'comments';
	}


	public function query() {

		$args = array(
			'user_id'   => $this->user_id,
			'number'    => 999999
		);
		$sites  = get_blogs_of_user( 1, false );

		$comments = 2;

		foreach( $sites as $site ) :

			switch_to_blog( $site->userblog_id );

			$query = new WP_Comment_Query;

			$comments += count( $query->query( $args ) );

			restore_current_blog();

		endforeach;

		return $comments;

	}

}