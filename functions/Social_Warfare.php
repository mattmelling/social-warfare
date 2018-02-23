<?php

/**
 * A class of functions used to load the plugin files and functions
 *
 * This is the class that brings the entire plugin to life. It is used to instatiate
 * all other classes throughout the plugin.
 *
 * @package   SocialWarfare\Utilities
 * @copyright Copyright (c) 2018, Warfare Plugins, LLC
 * @license   GPL-3.0+
 * @since     2.4.0 | 19 FEB 2018 | Created
 *
 * @TODO: Convert this entire file into the Social_Warfare class. This class will load
 * 		 all of the plugins classes and functions and fire the plugin into life. Other
 * 		 Addons will then extend this class to addon and fire up their functionalities.
 *
 * 		 We will change the name of the /functions/ folder to /lib/ and this file and
 * 		 class will reside in the root of that directory.
 *
 * 		 We will create a method for loading each set of classes. One for the frontend
 * 		 output, one for admin classes, one for utility classes, etc.
 *
 *       We're not going to act on this until we have refactored everything in the
 *       swp_initiate_plugin (the stuff being deferred to the plugins_loaded hook)
 *       and moved all of those require_once's outside of that deferment.
 *
 *       We will go aheed and docblock each instantiation of a class in this file as
 *       this file will then essentially serve as a table of contents for the entire
 *       plugin.
 *
 *       In the example below, the instantiate_classes() method is the last to be called,
 *       and it needs to be, obviously, but I want it to be the first method defined
 *       as that's the one that will serve as the plugin table of contents with it's
 *       dockblocks.
 *
 */
class Social_Warfare {


	/**
	 * The magic method used to instantiate this class.
	 *
	 * This method will load all of the classes using the "require_once" command. It
	 * will then instantiate them all one by one.
	 *
	 * @since  2.4.0
	 * @param  none
	 * @return none
	 * @access public
	 *
	 */
	public function __construct() {

		$this->load_classes();
		$this->instantiate_classes();

		if( true === is_admin() ){
			$this->instantiate_admin_classes();
		}

	}


	/**
	 * The method used to instantiate all non-admin-only classes.
	 *
	 * This method will instantiate every class throughout the plugin except for those
	 * classes that are only used in the admin area.
	 *
	 * @since  2.4.0
	 * @param  none
	 * @return none
	 * @access public
	 *
	 */
	private final function instantiate_classes() {


		/**
		 * The Localization Class
		 *
		 * Instantiates the class that will load the plugin translations. 
		 *
		 */
		new SWP_Localization();


		/**
		 * The Script Class
		 *
		 * Instantiates the class that will enqueue all of the styles and scripts used
		 * throughout the plugin both frontend, and admin.
		 *
		 */
		new SWP_Script();


		/**
		 * The Shortcode Class
		 *
		 * Instantiate the class that will process all instances of the [social_warfare]
		 * shortcode used in posts and pages, and consequently convert those shortcodes
		 * into sets of share buttons.
		 *
		 */
		new SWP_Shortcode();


		/**
		 * The Header Output Class
		 *
		 * Instantiate the class that processes the values and creates the HTML output
		 * required in the <head> section of a website. This includes our font css, open
		 * graph meta tags, and Twitter cards.
		 *
		 */
		new SWP_Header_Output();


		/**
		 * The Display Class
		 *
		 * Instantiates the class that is used to queue up or hook the buttons generator
		 * into WordPress' the_content() hook which allows us to append our buttons to it.
		 *
		 */
		new SWP_Display();


		/**
		 * The Compatibility Class
		 *
		 * Instantiate the class that provides solutions to very specific incompatibilities
		 * with certain other plugins.
		 *
		 */
		new SWP_Compatibility();


		/**
		 * The Widget Class
		 *
		 * Instantiate the class that registers and output the "Popular Posts" widget. If other
		 * widgets are added later, this class will fire those up as well.
		 *
		 */
		new SWP_Widget();

	}


	/**
	 * This method will load up all of the admin-only classes.
	 *
	 * @since  2.4.0
	 * @param  none
	 * @return none
	 * @access public
	 *
	 */
	private final function instantiate_admin_classes() {


		/**
		 * The Shortcode Generator
		 *
		 * Instantiate the class that creates the shortcode generator on the post editor
		 * which allows users to generate the [social_warfare] shortcodes by simply pointing
		 * clicking, and filling in a few fill in the blanks.
		 *
		 */
		new SWP_Shortcode_Generator();


		/**
		 * The "Social Shares" column in the posts view.
		 *
		 * Instantiate the class that creates the column in the posts view of the WordPress
		 * admin area. This column allows you to see how many times each post has been shared.
		 * It also allows you to sort the column in ascending or descending order.
		 *
		 */
		new SWP_Column();


		/**
		 * The The Settings Link
		 *
		 * Instantiates the class that addes links to the plugin listing on the plugins page
		 * of the WordPress admin area. This will link to the Social Warfare options page.
		 *
		 */
		new SWP_Settings_Link();


		/**
		 * The User Profile Fields
		 *
		 * Instantiates the class that adds our custom fields to the user profile area of the
		 * WordPress backend. This allows users to set a Twitter username and Facebook author
		 * URL on a per-user basis. If set, this will override these same settings from the
		 * options page on any posts authored by that user.
		 *
		 */
		new SWP_User_Profile();

	}


	/**
	 * The method is used to include all of the files needed.
	 *
	 * @since  2.4.0
	 * @param  none
	 * @return none
	 * @access public
	 *
	 */
	private final function load_classes() {

		// Require WordPress' core plugin class.
		require_once ABSPATH . 'wp-admin/includes/plugin.php';

		// Classes used for each social network. (These will be migrated up from below after being refactored).

		// Frontend Output: Classes used to process the output to the Frontend.
		require_once SWP_PLUGIN_DIR . '/functions/frontend-output/SWP_Script.php';
		require_once SWP_PLUGIN_DIR . '/functions/frontend-output/SWP_Shortcode.php';
		require_once SWP_PLUGIN_DIR . '/functions/frontend-output/SWP_Header_Output.php';
		require_once SWP_PLUGIN_DIR . '/functions/frontend-output/SWP_Display.php';

		// Utilities: Classes used to perform misc functions throughout the plugin.
		require_once SWP_PLUGIN_DIR . '/functions/utilities/SWP_Compatibility.php';
		require_once SWP_PLUGIN_DIR . '/functions/utilities/SWP_CURL.php';
		require_once SWP_PLUGIN_DIR . '/functions/utilities/SWP_Plugin_Updater.php';
		require_once SWP_PLUGIN_DIR . '/functions/utilities/SWP_Permalink.php';
		require_once SWP_PLUGIN_DIR . '/functions/utilities/SWP_Localization.php';

		// Widgets: Classes used to register and create Social Warfare widgets.
		require_once SWP_PLUGIN_DIR . '/functions/widgets/SWP_Widget.php';
		require_once SWP_PLUGIN_DIR . '/functions/widgets/SWP_Popular_Posts_Widget.php';

		// Admin: Classes used to power of some functionality in the admin area.
		require_once SWP_PLUGIN_DIR . '/functions/admin/SWP_User_Profile.php';
		require_once SWP_PLUGIN_DIR . '/functions/admin/SWP_Shortcode_Generator.php';
		require_once SWP_PLUGIN_DIR . '/functions/admin/SWP_Settings_Link.php';
	    require_once SWP_PLUGIN_DIR . '/functions/admin/SWP_Column.php';

	}

}


/*******************************************************************************
 *
 *
 * WARNING! WARNING! WARNING! WARNING! WARNING! WARNING! WARNING! WARNING!
 *
 * EVERY FILE BELOW THIS POINT NEEDS TO BE REFACTORED. IT'S "REQUIRE_ONCE" THEN
 * NEEDS TO BE MIGRATED INTO THE CLASS ABOVE.
 *
 *
 * *****************************************************************************/


add_action( 'plugins_loaded' , 'swp_initiate_plugin' , 20 );
function swp_initiate_plugin() {

	// All of these files need refactored and then migrated into the functions above
	require_once SWP_PLUGIN_DIR . '/functions/utilities/url_processing.php';
	require_once SWP_PLUGIN_DIR . '/functions/admin/options-fetch.php';
	require_once SWP_PLUGIN_DIR . '/functions/admin/options-array.php';
	require_once SWP_PLUGIN_DIR . '/functions/click-to-tweet/clickToTweet.php';
	require_once SWP_PLUGIN_DIR . '/functions/frontend-output/buttons-standard.php';
	require_once SWP_PLUGIN_DIR . '/functions/frontend-output/buttons-floating.php';
	require_once SWP_PLUGIN_DIR . '/functions/utilities/share-count-function.php';
	require_once SWP_PLUGIN_DIR . '/functions/utilities/share-cache.php';
}



// TODO: These files need refactored into classes and to the appropriate sections above.
require_once SWP_PLUGIN_DIR . '/functions/social-networks/googlePlus.php';
require_once SWP_PLUGIN_DIR . '/functions/social-networks/twitter.php';
require_once SWP_PLUGIN_DIR . '/functions/social-networks/facebook.php';
require_once SWP_PLUGIN_DIR . '/functions/social-networks/linkedIn.php';
require_once SWP_PLUGIN_DIR . '/functions/social-networks/pinterest.php';
require_once SWP_PLUGIN_DIR . '/functions/social-networks/stumbleupon.php';
require_once SWP_PLUGIN_DIR . '/functions/utilities/utility.php';
require_once SWP_PLUGIN_DIR . '/functions/admin/registration.php';

/**
 * Include the plugin's admin files.
 *
 */
if ( is_admin() ) {
	require_once SWP_PLUGIN_DIR . '/functions/admin/swp_system_checker.php';
	require_once SWP_PLUGIN_DIR . '/functions/admin/options-page.php';
}