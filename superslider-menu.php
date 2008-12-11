<?php
/*
Plugin Name: SuperSlider-Menu
Plugin URI: http://wp-superslider.com/superslider-menu
Description: Animated Navigation List uses Mootools 1.2 javascript to expand and collapse categories, show subcategories and posts that belong to the category. 
Author: Daiv Mowbray
Version: 0.4
Author URI: http://wp-superslider.com
Tags: animation, animated, sidebar, widget, categories, mootools 1.2, mootools, menu, slider

Copyright 2008

       SuperSlider-Menu is free software; you can redistribute it and/or
    modify it under the terms of the GNU General Public License as published by 
    the Free Software Foundation; either version 2 of the License, or (at your
    option) any later version.

    SuperSlider-Menu is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Collapsing Categories; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (!class_exists("ssMenu")) {
	class ssMenu {
		
		/**
		* @var string   The name of this class.
		*/
	var $my_name;
	
	
	// Pre-2.6 compatibility
	function set_menu_paths()
	{
		if ( !defined( 'WP_CONTENT_URL' ) )
			define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
		if ( !defined( 'WP_CONTENT_DIR' ) )
			define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
		if ( !defined( 'WP_PLUGIN_URL' ) )
			define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
		if ( !defined( 'WP_PLUGIN_DIR' ) )
			define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );
		if ( !defined( 'WP_LANG_DIR') )
			define( 'WP_LANG_DIR', WP_CONTENT_DIR . '/languages' );

	}
		/**
		* PHP 4 Compatible Constructor
		*/
	function ssmenu(){$this->__construct();}
		
		/**
		* PHP 5 Constructor
		*/		
	function __construct(){
		
		self::superslider_menu();
	
	}// end construct
		
		/**
		 * language switcher
		 */
	function language_switcher(){
		global $ssm_domain, $ssMenu_is_setup;

  				if($ssMenu_is_setup) {
     				return;
  				} 
  			// define some language related variables
		$ssm_domain = 'superslider-menu';
  			$ss_menu_locale = get_locale();
		$ss_menu_mofile = WP_LANG_DIR."/superslider_menu-".$ss_menu_locale.".mo";
  				//load the language
  			load_plugin_textdomain($ssm_domain, $ss_menu_mofile);
  			$plugin_text_loaded = true; // language is loaded
	}// end language switcher
	
			/**
		* Retrieves the options from the database.
		* @return array
		*/			
	function set_default_admin_options() {
		$defaultAdminOptions = array(
				"load_moo" => "on",
				"css_load" => "default",
				"css_theme" => "default",//end header ops 
				"user_objects" => "off",
				"holder" => "#ssMenuHolder",
				"toggler" => " dt span.show_",
				"content" => " dd.showme_",
				"toglink" => " dt a",
				"add_mouse" => "on",
				"alwayshide" => "on",
				"opacity" => "on",
				"trans_time" => "1250",
				"trans_type" => "quad",//end Accord ops 
				"trans_typeinout" => "in:out",
				"tooltips" => "on",
				"nav_follow" => "on",
				"nav_followside" => "right",
				"nav_followspeed" => "700");//end Follower ops
		
		$defaultOptions = get_option($this->AdminOptionsName);
		if (!empty($defaultOptions)) {
			foreach ($defaultOptions as $key => $option) {
				$defaultAdminOptions[$key] = $option;
			}
		}
		update_option($this->AdminOptionsName, $defaultAdminOptions);
		return $defaultAdminOptions;
		
	}

		/**
		* Saves the admin options to the database.
		*/
	function save_default_menu_options(){
		update_option($this->AdminOptionsName, $this->defaultAdminOptions);
	}

		/**
		* Load admin options page
		*/
	function ssmenu_ui() {
		//language_switcher();

		include_once 'admin/superslider-menu-ui.php';
		
	}

		/**
		* Initialize the admin panel, Add the plugin options page, loading it in from superslider-menu-ui.php
		*/
	function ssmenu_setup_optionspage() 
	{
		//language_switcher();
		/*global $ssMenu;
		if (!isset($ssMenu)) {
			return;
		}*/
		if( function_exists('add_options_page') ) {
			if( current_user_can('manage_options') ) {
			add_options_page(__('SuperSlider Menu'),__('ss-Menu'), 8, 'superslider-menu', array(&$this, 'ssmenu_ui'));
			add_filter('plugin_action_links', array(&$this, 'filter_plugin_menu'), 10, 2 );
			//this should print plugin info into admin footer
			//add_action('in_admin_footer', array(&$this, 'ssmenu_admin_footer'), 9 );
			}					
		}
	}
	function ssmenu_admin_footer() 
	{
		$plugin_data = get_plugin_data( __FILE__ );
		printf('%1$s plugin | Version %2$s | by %3$s<br />', $plugin_data['Title'], $plugin_data['Version'], $plugin_data['Author']);
	}

		/**
		* Add link to options page from plugin list.
		*/
	function filter_plugin_menu($links, $file) {
				 static $this_plugin;
 					if( ! $this_plugin ) $this_plugin = plugin_basename(__FILE__);

				if( $file == $this_plugin ){
					$settings_link = '<a href="options-general.php?page=superslider-menu">'.__('Settings').'</a>';
 					array_unshift( $links, $settings_link ); //  before other links
			}
 				return $links;
	}
  
   			/**
   			 * plughin settings link for WP 2.7
   			 *add_action('plugin_action_links_' . plugin_basename(__FILE__), 'filter_plugin_actions');
			function filter_plugin_actions($links) {
  				$settings_link = '<a href="options-general.php?page=myplugin">'.__('Settings').'</a>';
				array_unshift( $links, $settings_link ); // before other links
			return $links;
			}
   			 */
	function ssmenu_add_javascript(){
		$js_path = WP_CONTENT_URL . '/plugins/'. plugin_basename(dirname(__FILE__)) . '/js/';
		
		$ssmOpOut = get_option($this->AdminOptionsName);

		$loadMoo = ($ssmOpOut['load_moo']);	
		$navFollow = ($ssmOpOut['nav_follow']);
		$tooltips = ($ssmOpOut['tooltips']);
		
		echo "\t<!-- The following js is part of the SuperSlider-menu plugin available at http://wp-superslider.com/ -->\n";
	if (!is_admin())
			{				
				if (function_exists('wp_enqueue_script')) {
					if ($loadMoo == 'on'){
					//echo $js_path;
						//echo 'not admin navFollow on';
						//wp_enqueue_scrip('moocore', $js_path.'mootools-1.2-core.js');		
						//wp_enqueue_scrip('moomore', $js_path.'mootools-1.2-more.js', array('moocore'));
						echo "\t".'<script src="'.$js_path.'mootools-1.2-core.js" type="text/javascript"></script> '."\n";
						echo "\t".'<script src="'.$js_path.'mootools-1.2-more.js" type="text/javascript"></script> '."\n";
					};
					
					if ($navFollow == 'on'){
						echo "\t".'<script src="'.$js_path.'nav_follow.js" type="text/javascript"></script> '."\n";
						//wp_enqueue_script('nav_follow', $js_path.'nav_follow.js', array('$libtitle'));
					};
					//wp_enqueue_scrip('superslider_menu', $js_path.'superslider_menu.js', array($libtitle));
					echo "\t".'<script src="'.$js_path.'superslider_menu.js" type="text/javascript"></script> '."\n";						
				}	
			}
	}
		/**
		* register and Add js and css script into head 
		*/
	function ssmenu_add_css(){
		$ssmOpOut = get_option($this->AdminOptionsName);
		$cssLoad = ($ssmOpOut['css_load']);
		$cssTheme = ($ssmOpOut['css_theme']);	
		
		$url = get_settings('siteurl');

		echo "\t<!-- The following css is part of the SuperSlider-menu plugin available at http://wp-superslider.com/ -->\n";

    		if ($cssLoad == 'default'){
    			$cssPath = WP_PLUGIN_URL.'/superslider-menu/plugin-data/superslider/ssmenu/'.$cssTheme.'.css';
    			echo "\t"."<link rel='stylesheet' rev='stylesheet' href='".$cssPath."' media='screen' />\n";
    		}elseif ($cssLoad == 'pluginData') {
    			$cssPath = WP_CONTENT_URL.'/plugin-data/superslider/ssmenu/'.$cssTheme.'.css';
    			echo "\t"."<link rel='stylesheet' rev='stylesheet' href='".$cssPath."' media='screen' />\n";
    		}elseif ($cssLoad == 'off') {
    			$cssPath = '';
    		}

    		
	}	// end function ssmenu_add_css
	
			/**
		* Write and load the accordion code 
		*/
	function ssmenu_set_head() {
		$ssmOpOut = get_option($this->AdminOptionsName);
		
		$holder = $ssmOpOut['holder'];
		$toggler = $ssmOpOut['toggler'];
		$content = $ssmOpOut['content'];
		$toglink = $ssmOpOut['toglink'];
		$addMouse = $ssmOpOut['add_mouse '];		// on or off, activate toggler on mouse over -on on mouseclick-off.
		$alwaysHide = $ssmOpOut['alwayshide'];		// If set to on, it will be possible to close all displayable elements. Otherwise, one will remain open at all time.
		$opacity = $ssmOpOut['opacity'];			// set transition of opacity to on or off, fades the slider in and out as it slides.
		
		$transTime = $ssmOpOut['trans_time'];		// set the speed of the transition (milliseconds). 	
		$transType = $ssmOpOut['trans_type'];	// set the transition type, available: 
		$transTypeInOut = $ssmOpOut['trans_typeinout'];
		$transType = $transType.':'.$transTypeInOut;
		
		$tooltips = $ssmOpOut['tooltips'];
		
		$follow = $ssmOpOut['nav_follow'];		// set to 'follow' for on, and 'nofollow' for off.
		$fside = $ssmOpOut['nav_followside'];
		$fspeed = $ssmOpOut['nav_followspeed'];
		$float = '33';	
		/**/
		if ($tooltips == 'on'){
			$addTooltips = "				
				var myTips = new Tips($$('.tool'), {
								className: 'tipClosed',
								showDelay : 350,
								hideDelay : 80,
								offsets: {'x': -290, 'y': 0},
								fixed: 'true',
								timeOut: 900,
								maxTitleChars: 50,
								maxOpacity: .9,
					initialize:function(){
						this.fxopen = new Fx.Morph(this.tip, {
								duration: 750,
								transition: Fx.Transitions.Sine.easeInOut});
						this.fxclose = new Fx.Morph(this.tip, {
								duration: 250,
								transition: Fx.Transitions.Sine.easeInOut});
					},
					onShow: function(tip) {
						tip.fade(.8);
						this.fxopen.start('.customTip');	
					},
					onHide: function(tip) {
						tip.fade(0);
						this.fxclose.start('.tipClosed');
					}
				});";
		}else{
			$addTooltips = '';
		} 
		$ssmOpOut = ' "'.$holder.'","'.$toggler.'","'.$content.'","'.$toglink.'","'.$addMouse.'","'.$alwaysHide.'","'.$opacity.'","'.$transTime.'","'.$transType.'","'.$follow.'","'.$fside.'","'.$fspeed.'","'.$float.'"';
		echo "\t"."<script type=\"text/javascript\">\n";
		echo "// <![CDATA[\n";

		echo "window.addEvent('domready', function() {
				superslidermenu(".$ssmOpOut.");
				".$addTooltips."
				});\n";
		echo "\t"."// ]]>\n</script>\n";

		}
		
		/**
		* 
		*/		
	function ssmenu_init() {
		//language_switcher();
  				//load default options into data base
  			$this->defaultAdminOptions = $this->set_default_admin_options();
			$this->set_menu_paths();
	}// end ssmenu_init
	

	
	function superslider_menu()
	{
		
		$this->myname = get_class($this);
		$this->AdminOptionsName = 'ssMenu_options';
		//$plugin_text_loaded = false; // language is not loaded
		register_activation_hook(__FILE__, array(&$this,'ssmenu_init')); //http://codex.wordpress.org/Function_Reference/register_activation_hook
		register_deactivation_hook( __FILE__, array(&$this,'options_deactivation')); //http://codex.wordpress.org/Function_Reference/register_deactivation_hook
				
		add_action('init', array(&$this,'ssmenu_init')); 
		add_action('admin_menu', array(&$this,'ssmenu_setup_optionspage')); // start the backside options page
		add_action('plugins_loaded',array(&$this,'setup_widgets'));	
		$ssMenu_is_setup = 'true';
	
	}
	
		/**
		* Removes user set options from data base upon deactivation
		*/
	function options_deactivation(){
		delete_option($this->AdminOptionsName);
		delete_option(ssMenu_widget_options);
	}
	
		/**
		* 
		*/
	function foldcats($number) 
	{

		ssm_list_categories($number);		
	}
	function setup_widgets() 
	{	
		
		add_action('wp_head', array(&$this,'ssmenu_add_css'));
		add_action('wp_print_scripts', array(&$this,'ssmenu_add_javascript')); //this loads the mootools scripts.
		add_action('wp_head', array(&$this,'ssmenu_set_head')); //this writes the menu script into head.
		include('superslider-menu-list.php');
		include('superslider-menu-widget.php');
	}

}	//end class
} //End if Class ssMenu

/**
*instantiate the class
*/	
if (class_exists('ssMenu')) {
	$ssMenu = new ssMenu();
}

?>