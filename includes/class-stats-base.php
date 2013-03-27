<?php

class CGC_Profile_Stats_Base {

	// Cache key
	private $cache_key;

	// Cache expiration time in seconds
	private $cache_exp;

	// Type of stat
	private $type;

	function __construct() {
		$this->init();
		$this->set_cache_key();
		$this->cache_exp = 3600;
	}

	private function init() {

		$this->type      = 'base';

	}


	public function get_data( $args = array() ) {
		return $this->query( $data );
	}


	private function query( $args = array() ) {

	}


	private function set_cache_key() {

		$this->cache_key = 'cgc_profile_stats_' . $this->type;
	}


	private function get_cache() {

		return get_transient( $this->cache_key );
	}


	private function set_cache( $data = array() ) {
		set_transient( $this->cache_key, $data, $this->cache_exp );
	}

}