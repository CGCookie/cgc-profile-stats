<?php

class CGC_Profile_Stats_Following extends CGC_Profile_Stats_Base {

	public function init() {
		$this->type = 'following';
	}

	public function query() {

		if( function_exists( 'cgc_get_following_count' ) )
			return cgc_get_following_count( $this->user_id );
		else
			return 0;
	}

}