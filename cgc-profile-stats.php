<?php
/*
Plugin Name: CGC Profile Stats
Description: provides detailed stats for CGC user profiles
Version: 0.1
Author: Pippin Williamson
Author URI:  http://pippinsplugins.com
Contributors: mordauk
*/

class CGC_Profile_Stats {

	private static $instance;

	private $path;

	/**
	 * Get active object instance
	 *
	 * @since 1.0
	 *
	 * @access public
	 * @static
	 * @return object
	 */
	public static function get_instance() {

		if ( ! self::$instance )
			self::$instance = new CGC_Profile_Stats();

		return self::$instance;
	}

	/**
	 * Class constructor.  Includes constants, includes and init method.
	 *
	 * @since 1.0
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {

		$this->path = dirname( __FILE__ );

		$this->includes();
		$this->init();

	}


	/**
	 * Run action and filter hooks.
	 *
	 * @since 1.0
	 *
	 * @access private
	 * @return void
	 */
	private function init() {



	}


	/**
	 * Include extra files
	 *
	 * @since 1.0
	 *
	 * @access private
	 * @return void
	 */
	private function includes() {

		$includes = array(
			'class-stats-base.php',
			'class-stats-likes.php',
			'class-stats-followers.php',
			'class-stats-comments.php',
			'class-stats-images.php',
		);

		foreach( $includes as $file ) {
			include $this->path . 'includes/' . $file;
		}

	}


}

$cgc_profile_stats = new CGC_Profile_Stats();