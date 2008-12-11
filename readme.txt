=== SuperSlider Menu ===
Contributors: twincascos
Plugin URI: http://wp-superslider.com/
Tags: menu, categories, sidebar, widget, mootools
Requires at least: 2.6
Tested up to: 2.7
Stable tag: 0.4

This Animated menu plugin uses Javascript to dynamically expand or collapsable categories and posts.

== Description ==

This is your Animated menu plugin that uses Mootools 1.2 javascript to form a multi-level collapsable menu widget in your sidebar for your categories and posts. Automatic opener upon page change. Highly configurable, theme based design, css based animations.

It is parcially based off of the Collapsing Categories Plugin by Robert Felty.


== Installation ==

 - Unpackage contents to wp-content/plugins/ so that the files are in a superslider-menu directory. 
 - Activate the plugin, 
 - Configure plugin under > settings > SuperSlider-menu
 - Go to Design > Widgets , and drag over the superslider-menu Widget, configure widget.
 - (optional) move plugin sub folder plugin-data to your wp-content folder,
	under  > settings > SuperSlider-menu > option group, File Storage - Loading Options
	select "Load css from plugin-data folder, see side note. (Recommended)".


== OPTIONS AND CONFIGURATIONS ==

Available under > settings > SuperSlider-menu

	* theme files to use for menu.
	* menu accordion to work with click or mouseover
	* allow close all tabs
	* opacity transition
	* transition speed
	* transition type
	* tooltips on categories on or off
	* Vertical mouse tracer on or off
	* *  Mouse tracer location, right or left of menu (moved to css control)
	* Mouse tracer reaction speed.
	* to load or not Mootools.js
	* css files storage loaction

	*Advanced options
	* disable built in menu structure
	* user defined objects, holder, toggler, content, and toglink.


Available in the widget options pane:

	* Show post counts in Category links
	* Order of Categories
	* Order of posts
	* Show Rss link as text or image
	* Show pages as well as posts
	* Sort by category name or category id
	* Sort in ascending or descending order

== Themes ==

Create your own graphic and animation theme based on one of these provided

	* Available themes
		* default
		* blue
		* black
		* custom

== To Do ==

	* Enqueue javascript files
	* although sub categories are indented, sub sub cats are not yet.
	* extended post list needs a max height limit, with a hover scroll for the list
	* fix known bugs:
				- the "don't show posts" option dismounts the data list
				- show pages as well as categories fails
				- cookied togglers open fails in some usage situations.
				

== Report Bugs Request / Options / Functions ==

* for now please use the comments system at http://wp-superslider.com
	

== Frequently Asked Questions ==

=  The folding doesn't work at all =
	
	You may have a javascript conflict with jquery or mootools, which may be added to 
	your theme header by your theme or another plugin. Try disabling mootools
	in the file superslider.php

=  How do I change the style of the collapsing categories lists? =
  
  I recommend that you move the folder plugin-data to your wp-content folder
  if you already have a plugin-data folder there, just move the superslider folder.
  remember to change the css location option in the settings page for this plugin.
  Or edit directly: 
  wp-content/plugins/superslider-menu/plugin-data/superslider/ssmenu/custom.css.
  Alternatively, you can copy those rules into your WordPress themes, style file. 
  Then remember to change the css location option in the settings page for this plugin.
  

= The stylesheet doesn't seem to be having any effect? =
 
  Check this url in your browser:
  http://yourblogaddress/wp-content/plugins/superslider-menu/plugin-data/superslider/ssmenu/custom.css
  If you don't see a plaintext file with css style rules, there may be
  something wrong with your .htaccess file (mod_rewrite). If you don't know
  how to fix this, you can copy the style rules there into your themes style
  file.

= How do I use different graphics and symbols for collapsing and expanding? =

You can upload your own images to
http://yourblogaddress/wp-content/plugins/superslider-menu/plugin-data/superslider/ssmenu/img_custom

= I can't get including or excluding to work = 

Make sure you specify category names, not ids.

== Screenshots ==

1. a few expanded categories with blue theme, showing nested categories and posts
2. plugin settings screen 
3. widget options screen

== Demo ==

This plugin is in use here at 
	* <http://wp-superslider.com>
	*<http://portfolio.daivmowbray.com>

== CAVEAT ==

Currently this plugin relies on Javascript to expand and collapse the links.
If a user's browser doesn't support javascript the list of cats and posts will display normally.

== HISTORY ==

* 0.4 (2008/11/20)
	* Fixed bug - opacity on tooltips now works.
	* Moved option - Mouse tracer location, right or left of menu to css control.

* 0.3 (2008/11/19)
	* Fixed bug - activeID is NULL when on non menu page.

* 0.2 (2008/11/19)
	* Added mootools / css powered animated tooltips on categories
	* Added Option
		* tooltips on categories  on / off

* 0.1.6 (2008/11/11)

	* Added settings screen for plugin.
	* Added Options
		* theme files to use for menu.
		* menu accordion to work with click or mouseover
		* allow close all tabs
		* opacity transition
		* transition speed
		* transition type
		* Vertical mouse tracer on or off
		* Mouse tracer location, right or left of menu
		* Mouse tracer reaction speed.
		* to load or not Mootools.js
		* css files storage loaction

		*Advanced options
		* disable built in menu structure
		* user defined objects, holder, toggler, content, and toglink.
	* Added theme system for menu.
	* Rebuilt html rendering file superslider-menu-list.php
	* Moved superslider-menu-ui.php into folder admin.
	* Added Reload default options to settings screen
	* Added settings link to wordpress plugin page
	* Added Set your widget link to settings page


* 0.1.2beta (2008/10/24)

	* Added mouse tracer - follower and option to deactivate it.
	* Added clicked link memory to identify and deactivate the active page link.
	* Added transition to css class for the accordion toggler.
	* Added toggler open memory (via cookie) for page changes.
	* Moved all java script into file superslider_menu.js


* 0.1.0beta (2008/10/15)

    * Changed name from Collapsing categories to Superslider-menu
    * Changed author from Robert Felty to Daiv Mowbray
    * Switched javascript from jquery to Mootools 1.2
    * switched html from unordered list to data list
    * Changed fold down icon to css based rather than image.
    * remove options:
    			- fold down icon type
    			- to animate or not
    			- expanding to show Cats and posts or just cats.
    			- auto expand these categories
    			- Category name as link to cat or not.
    * other...

---------------------------------------------------------------------------