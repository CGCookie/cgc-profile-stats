<?php

// User's likes
class CGC_Profile_Stats_Likes extends CGC_Profile_Stats_Base {

	public function init() {
		$this->type = 'likes';
	}


	public function query() {

		$sites  = get_blogs_of_user( 1, false );

		$likes  = 0;

		foreach( $sites as $site ) :

			switch_to_blog( $site->userblog_id );

			$loves = 0;
			if( function_exists( 'cgc_get_users_loved_posts' ) )
				$loves = count( cgc_get_users_loved_posts( $this->user_id ) );

			$likes += $loves;

			restore_current_blog();

		endforeach;

		return $likes;

	}

}