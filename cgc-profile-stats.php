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

	// Plugin folder path
	private $path;

	private $user_id;

	// Image stats
	public $images;

	// Like stats
	public $likes;

	// Follower stats
	public $followers;

	// Comment stats
	public $comments;

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
			'class-stats-images.php'
		);

		foreach( $includes as $file ) {
			include $this->path . '/includes/' . $file;
		}

	}


	/**
	 * Setup each of our stat types
	 *
	 * @since 1.0
	 *
	 * @access private
	 * @return void
	 */
	private function init() {

		$this->user_id = get_current_user_id();

		$this->images    = new CGC_Profile_Stats_Images( $this->user_id );
		$this->likes     = new CGC_Profile_Stats_Likes( $this->user_id );
		$this->followers = new CGC_Profile_Stats_followers( $this->user_id );
		$this->comments  = new CGC_Profile_Stats_Comments( $this->user_id );

	}


}

$cgc_profile_stats = new CGC_Profile_Stats();