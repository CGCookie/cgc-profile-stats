<?php

class CGC_Profile_Stats_Base {


	// User ID we are getting stats for
	private $user_id;

	// Type of stat
	private $type;

	// The user stats for $type
	private $stats;


	function __construct( $user_id = 0 ) {
		$this->init();
		$this->user_id = $user_id;
		$this->stats   = $this->get_stats();

	}

	private function init() {

		$this->type = 'base';

	}


	public function get_stats() {

		$this->stats = get_user_meta( $this->user_id, 'cgc_profile_stats', true );

		// Check if stats need to be refreshed
		if( ! isset( $stats['modified'] ) || $stats['modified'] < strtotime( '-1 day' ) ) {
			$this->stats = $this->refresh_stats();
		}

		return $this->stats;
	}


	private function refresh_stats() {

		$this->stats['modified'] = time();

		$year =  date( 'Y' ) ;

		if( ! isset( $this->stats['years'] ) )
			$this->stats['years'] = array();

		if( ! isset( $this->stats['years'][ $year ] ) )
			$this->stats['years'][ $year ] = array();

		$this->stats['years'][ $year ][ date( 'n' ) ] = $this->query();
		$this->stats['total'] = $this->get_total();

		update_user_meta( $this->user_id, 'cgc_profile_stats', $this->stats );

	}

	// Query to get stats for current month. Overwritten by subclasses
	private function query() {
		return 0;
	}


	// Calculate the total stats over time
	private function get_total() {
		return 0;
		// Get the last year on record
		$year  = end( $this->stats['years'] );

		// Get the last month on record
		$month = end( $year );

		// The total is the last month we have on record
		return $this->stats['years'][ $year ][ $month ];
	}

}