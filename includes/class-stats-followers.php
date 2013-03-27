<?php

class CGC_Profile_Stats_Followers extends CGC_Profile_Stats_Base {

	private function init() {
		$this->type = 'followers';
	}

	private function query() {

		if( function_exists( 'cgc_get_following_count' ) )
			return cgc_get_following_count( $this->user_id );
		else
			return 0;
	}

}