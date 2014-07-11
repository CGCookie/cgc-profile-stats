<?php

class CGC_Profile_Stats_Base {


	// User ID we are getting stats for
	public $user_id;

	// Type of stat
	public $type;

	// The user stats for $type
	public $stats;


	function __construct() {
		$this->init();
		$this->user_id = get_current_user_id();
		$this->stats   = $this->get_stats();

	}

	public function init() {

		$this->type = 'base';

	}


	public function get_stats() {

		$this->stats = get_user_meta( $this->user_id, 'cgc_profile_stats', true );

		if( ! is_array( $this->stats ) )
			$this->stats = array(
				$this->type => array()
			);


		// Check if stats need to be refreshed
		//if( ! isset( $stats[ $this->type ]['modified'] ) || $stats[ $this->type ]['modified'] < strtotime( '-1 day' ) ) {
		if( ! isset( $this->stats[ $this->type ]['modified'] ) || $this->stats[ $this->type ]['modified'] < strtotime( '-1 minute' ) ) {
			$this->refresh_stats();
		}	

		return $this->stats;
	}


	private function refresh_stats() {

		$this->stats[ $this->type ]['modified'] = time();

		$year =  date( 'Y' ) ;

		if( ! isset( $this->stats[ $this->type ]['years'] ) )
			$this->stats[ $this->type ]['years'] = array();

		if( ! isset( $this->stats[ $this->type ]['years'][ $year ] ) )
			$this->stats[ $this->type ]['years'][ $year ] = array();

		$this->stats[ $this->type ]['years'][ $year ][ date( 'n' ) ] = $this->query();
		$this->stats[ $this->type ]['total'] = $this->get_total();

		update_user_meta( $this->user_id, 'cgc_profile_stats', $this->stats );

	}

	// Query to get stats for current month. Overwritten by subclasses
	public function query() {
		return 0;
	}


	// Calculate the total stats over time
	public function get_total() {

		// Get the last year on record
		$years = end( $this->stats[ $this->type ]['years'] );
		$year  = key( array_slice( $this->stats[ $this->type ]['years'], -1, 1, TRUE ) );

		// Get the last month on record
		end( $years );
		$month = key( $years );

		// The total is the last month we have on record
		return $this->stats[ $this->type ]['years'][ $year ][ $month ];
	}

	// Get stats for a particular month
	public function month( $month = 1, $year = 0 ) {

		if( empty( $year ) )
			$year = date( 'Y' );

		return isset( $this->stats[ $this->type ]['years'][ $year ][ $month ] ) ? $this->stats[ $this->type ]['years'][ $year ][ $month ] : 0;
	}

	// Get total from last month
	public function last_month() {

		$year  = date( 'Y' );
		$month = date( 'n' );

		if( $month == 1 ) {
			$month = 12;
			$year--;
		} else {
			$month--;
		}

		return $this->month( $month, $year );

	}

	// Get total from this month
	public function this_month() {

		$year  = date( 'Y' );
		$month = date( 'n' );
		return $this->month( $month, $year );

	}

	// Get the growth this month
	public function change_this_month() {
		return $this->this_month() - $this->last_month();
	}

	// Get the growth last month
	public function change_last_month() {

		$year  = date( 'Y' );
		$month = date( 'n' );

		if( $month == 2 ) {
			$month = 12;
			$year--;
		} else {
			$month = $month - 2;
		}

		return $this->last_month() - $this->month( $month, $year );
	}

}
