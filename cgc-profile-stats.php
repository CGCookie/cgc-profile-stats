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
			'class-stats-images.php',
		);

		foreach( $includes as $file ) {
			include $this->path . 'includes/' . $file;
		}

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

		$this->images    = new CGC_Profile_Stats_Images;
		$this->likes     = new CGC_Profile_Stats_Likes;
		$this->followers = new CGC_Profile_Stats_followers;
		$this->comments  = new CGC_Profile_Stats_Comments;

	}


}

$cgc_profile_stats = new CGC_Profile_Stats();