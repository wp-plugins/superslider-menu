<?php
/*
Plugin Name: SuperSlider-Menu
Plugin URI: http://superslider.daivmowbray.com/superslider-menu
Author URI: http://superslider.daivmowbray.com
Description: Animated Fold down category Navigation List uses Mootools 1.4.5 javascript to expand and collapse categories, show subcategories and posts that belong to the category. 
Author: Daiv Mowbray
Version: 2.3
Tags: animation, animated, sidebar, widget, categories, mootools 1.4.5, mootools, menu, slider, navigate

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
	var $js_path;
	var $css_path;
	var $css_theme = '';
	var $ssmOpOut;
	var $menu_id;
	var $defaultOptions;
	var $ssModOpOut;
	var $ssBaseOpOut;
	var $OptionsName = 'ssMenu_options';
	
	static $add_ssmenu_script;
	
	
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
	function ssMenu() {
	   
	   ssMenu::superslider_menu();
	   
	}		
		/**
		* PHP 5 Constructor
		*/		
	function __construct(){
		
		self::superslider_menu();
	
	}// end construct
	
		/**
		* Retrieves the options from the database.
		* @return array
		*/			
	function set_default_options() {
		$defaultOptions = array(
				"load_moo" => "on",
				"css_load" => "default",
				"css_theme" => "default",
				"user_objects" => "off",
				"holder" => "#ssMenuHolder",
				"toggler" => " div span.show_",
				"content" => " div.showme_",
				"toglink" => " div .catlink",
				"add_mouse" => "off",
				"always_hide" => "off",
				"opacity" => "on",
				"trans_time" => "1200",
				"trans_type" => "quad",
				"trans_typeinout" => "in:out",
				"nav_follow" => "on",
				"nav_followspeed" => "700",
				"linkTitle" => "title",
				"linkText" => "rel",
				'delete_options' => 'off');//end ops
		
		$getOptions = get_option('ssMenu_options');
		if (!empty($getOptions)) {
			foreach ($getOptions as $key => $option) {
				$defaultOptions[$key] = $option;
			}
		}
		update_option('ssMenu_options', $defaultOptions);
		return $defaultOptions;
		
	}

		/**
		* Saves the admin options to the database.
		*/
	function save_default_menu_options(){
		
		update_option('ssMenu_options', $this->defaultOptions);
	}

		/**
		* Load admin options page
		*/
	function ssmenu_ui() {

		include_once 'admin/superslider-menu-ui.php';		
	}

		/**
		* Initialize the admin panel, Add the plugin options page, loading it in from superslider-menu-ui.php
		*/
	function ssmenu_setup_optionspage() {

		if( function_exists('add_options_page') && current_user_can('manage_options') ) {
			
			$plugin_page = add_options_page(__('SuperSlider Menu'),__('SuperSlider-Menu'), 'manage_options', 'superslider-menu', array(&$this, 'ssmenu_ui'));
						
			add_filter('plugin_action_links_' . plugin_basename(__FILE__), array(&$this, 'filter_plugin_menu'), 10, 2 );
			add_action('admin_print_scripts-'.$plugin_page , array(&$this,'ss_admin_style'));
			add_action('admin_print_scripts-'.$plugin_page, array(&$this,'ss_admin_script'));	
		}
	}
		
	function ss_admin_style(){           
            wp_enqueue_style( 'superslider_admin');
            wp_enqueue_style( 'superslider_admin_tool');    	
	}	
	function ss_admin_script(){
            wp_enqueue_script( 'jquery' );
            wp_enqueue_script( 'jquery-ui-core');
            wp_enqueue_script( 'jquery-ui-tabs');
            //wp_enqueue_script( 'jquery-dimensions' );
            wp_enqueue_script( 'jquery-tooltip' );
            wp_enqueue_script( 'superslider-admin-tool' );
	}
		/**
		* Add link to options page from plugin list.
		*/
	function filter_plugin_menu($links, $file) {
      static $this_plugin;
      if( ! $this_plugin ) $this_plugin = plugin_basename(__FILE__);

        if( $file == $this_plugin ){
            $settings_link = '<a href="admin.php?page=superslider-menu">'.__('Settings').'</a>';
            array_unshift( $links, $settings_link ); //  before other links
        }
        return $links;
	}
  
	function ssmenu_add_mootools(){
		
		extract($this->ssmOpOut);
	
	    if ( !is_admin() ) {				
            if (function_exists('wp_enqueue_script')) {
                if ($load_moo == 'on') {
                	wp_enqueue_script('moocore');		
					wp_enqueue_script('moomore');
                 }
            }	
		}
	}
	
	function ssmenu_add_js(){
	   
	   if ($this->ssmOpOut['nav_follow'] == 'on') {
          wp_print_scripts('navfollow');         
       }
	   
	   wp_print_scripts('ssmenu');  
	
	}
	
		/**
		* register and Add js and css script into head 
		*/
	function ssmenu_add_css(){

    	wp_enqueue_style('ssMenu_style');
    	
	}	
	
	
    /**
    * Write and load the accordion code 
    */
	function ssmenu_starter() {
		
	   if ( ! self::$add_ssmenu_script )
		return;
		
		$op = get_option('ssMenu_options');
		extract($op);
		
		$transType = $trans_type.':'.$trans_typeinout;
        global $menu_id;		

		$ssmStarter = '"'.$menu_id.'", "'.$holder.$menu_id.'","'.$toggler.'","'.$content.'","'.$toglink.'","'.$add_mouse.'","'.$always_hide.'","'.$opacity.'","'.$trans_time.'","'.$transType.'","'.$nav_follow.'","'.$nav_followspeed.'"';

		echo "\t"."<script type=\"text/javascript\">\n";
		echo "// <![CDATA[\n";
		echo "window.addEvent('domready', function() {
				var ssmenu".$menu_id." = new superslidermenu(".$ssmStarter.");";
		echo "});\n";
		echo "\t"."// ]]>\n</script>\n";

		}
		
		/**
		* 
		*/		
	function ssmenu_init() {
  		
  		//load default options into data base
        $this->defaultOptions = $this->set_default_options();
        $this->set_menu_paths();
        
        $this->ssmOpOut = get_option('ssMenu_options');

        // lets see if the base plugin is here and get its options
        if (class_exists('ssBase')) {
                $this->ssBaseOpOut = get_option('ssBase_options');
                $this->base_over_ride = $this->ssBaseOpOut['ss_global_over_ride'];	
            }else{
            $this->base_over_ride = 'off';
        }
		
		extract($this->ssmOpOut);
		
		if ( (class_exists('ssBase')) && ($this->ssBaseOpOut['ss_global_over_ride']) ) { extract($this->ssBaseOpOut); }

		$url = get_option('siteurl');
		
		$this->js_path = WP_CONTENT_URL . '/plugins/'. plugin_basename(dirname(__FILE__)) . '/js/';

    	$admin_js_path = WP_CONTENT_URL . '/plugins/'. plugin_basename(dirname(__FILE__)) . '/admin/js/';
        
        wp_register_script( 'moocore', $this->js_path.'mootools-core-1.4.5-full-compat-yc.js', NULL, '1.4.5');        
        wp_register_script( 'moomore', $this->js_path. 'mootools-more-1.4.0.1.js', array( 'moocore' ), '1.4.0.1');      
        wp_register_script( 'ssmenu', $this->js_path. 'superslider-menu-min.js', array( 'moomore' ), '2', true);
        wp_register_script( 'navfollow', $this->js_path. 'nav-follow.js', array( 'ssmenu' ), '2', true);

  		wp_register_script( 'jquery-dimensions', $admin_js_path.'jquery.dimensions.min.js', array( 'jquery-ui-core' ), '2', false);
  		wp_register_script( 'jquery-tooltip', $admin_js_path.'jquery.tooltip.min.js', array( 'jquery-ui-core' ), '2', false);
        wp_register_script( 'superslider-admin-tool', $admin_js_path.'superslider-admin-tool.js', array( 'jquery-tooltip' ), '2', false);
		
		$cssAdminPath = WP_PLUGIN_URL.'/superslider-menu/admin/'; 
            
        wp_register_style('superslider_admin', $cssAdminPath.'ss_admin_style.css');
        wp_register_style('superslider_admin_tool', $cssAdminPath.'ss_admin_tool.css');
                        
        if ($css_load == 'default'){
            $this->cssPath = WP_PLUGIN_URL.'/superslider-menu/plugin-data/superslider/ssMenu/'.$css_theme.'/'.$css_theme.'.css';
            
        }elseif ($css_load == 'pluginData') {
            $this->cssPath = WP_CONTENT_URL.'/plugin-data/superslider/ssMenu/'.$css_theme.'/'.$css_theme.'.css';
        
        }elseif ($css_load == 'theme') { 
         $this->cssPath = get_stylesheet_directory_uri().'/plugin-data/superslider/ssMenu/'.$css_theme.'/'.$css_theme.'.css';  
  
        }elseif ($css_load == 'off') {
            $this->cssPath = '';
        }
    	
    	wp_register_style('ssMenu_style', $this->cssPath);
			
	}
		
	function superslider_menu() {
		
		$this->myname = get_class($this);

		register_activation_hook(__FILE__, array(&$this,'ssmenu_init')); //http://codex.wordpress.org/Function_Reference/register_activation_hook
		register_deactivation_hook( __FILE__, array(&$this,'options_deactivation')); //http://codex.wordpress.org/Function_Reference/register_deactivation_hook
				
		add_action('init', array(&$this,'ssmenu_init')); 		
		add_action('admin_menu', array(&$this,'ssmenu_setup_optionspage')); // start the backside options page
		add_action('plugins_loaded',array(&$this,'setup_widgets'));	
	
	}
	
		/**
		* Removes user set options from data base upon deactivation
		*/
	function options_deactivation() {
	 if($this->ssmOpOut['delete_options'] == true){
		delete_option('ssMenu_options');
		delete_option('ssMenu_widget_options');
       }
	}
	
		/**
		* 
		*/
	function foldcats($number) {
	
		ssm_list_categories($number);
		
	}
	
	function setup_widgets() {	
        
        add_action('wp_footer', array(&$this, 'ssmenu_add_js'));   
		add_action('wp_print_styles', array(&$this,'ssmenu_add_css'));
		add_action('wp_print_scripts', array(&$this,'ssmenu_add_mootools')); //this loads the mootools scripts.
		
		include('superslider-menu-list.php');
		include('superslider-menu-widget.php');

	}

}	//end class
} //End if Class ssMenu

/**
*instantiate the class
*/	
if (class_exists('ssMenu')) {
	$myssMenu = new ssMenu();
}

?>