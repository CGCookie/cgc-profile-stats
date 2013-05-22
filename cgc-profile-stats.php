<?php
/*
Plugin Name: CGC Profile Stats
Description: provides detailed stats for CGC user profiles
Version: 0.1
Author: Pippin Williamson
Author URI:  http://pippinsplugins.com
Contributors: mordauk
*/


/************************************
* TODO
* Helpers for:
* - {stat type} last month
* - {stat type} this month
* - {stat type} total all time
*
*
*
************************************/


class CGC_Profile_Stats {

	private static $instance;

	// Plugin folder path
	private $path;

	// User ID we are getting stats for
	private $user_id;

	// Image stats
	public $images;

	// Like stats
	public $likes;

	// Follower stats
	public $followers;

	// Following stats
	public $following;

	// Comment stats
	public $comments;

	// Comment on user's images stats
	public $image_comments;

	// Likes on user's images stats
	public $image_likes;

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
		$this->setup_stats();

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
			'class-stats-following.php',
			'class-stats-comments.php',
			'class-stats-image-comments.php',
			'class-stats-image-likes.php',
			'class-stats-images.php'
		);

		foreach( $includes as $file ) {
			if( file_exists( $this->path . '/includes/' . $file ) )
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

		global $user_ID;

		$this->user_id = $user_ID;

	}


	public function setup_stats() {

		$this->images          = new CGC_Profile_Stats_Images();
		$this->likes           = new CGC_Profile_Stats_Likes();
		$this->followers       = new CGC_Profile_Stats_followers();
		$this->following       = new CGC_Profile_Stats_following();
		$this->comments        = new CGC_Profile_Stats_Comments();
		$this->image_comments  = new CGC_Profile_Stats_Image_Comments();
		$this->image_likes     = new CGC_Profile_Stats_Image_Likes();
	}


}