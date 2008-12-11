<?php
/*
Copyright 2008 daiv Mowbray

This file is part of SuperSlider-Menu

Fancy Categories is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

SuperSlider-Menu is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Fancy Categories; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
	/**
   * Should you be doing this?
   */ 	
   
	if ( !current_user_can('manage_options') ) {
		// Apparently not.
		die( __( 'ACCESS DENIED: Your don\'t have permission to do this.', 'superslider-menu' ) );
		}
		if (isset($_POST['set_defaults']))  {
			check_admin_referer('ssm_options');
			$ssmOldOptions = array(
				"load_moo" => "on",
				"css_load" => "default",
				"css_theme" => "default",
				"user_objects" => "off",
				"holder" => "#ssMenuHolder",
				"toggler" => " dt span.show_",
				"content" => " dd.showme_",
				"toglink" => " dt a",
				"add_mouse" => "on",
				"alwayshide" => "on",
				"opacity" => "on",
				"trans_time" => "1250",
				"trans_type" => "quad",
				"trans_typeinout" => "in:out",
				"tooltips" => "on",			
				"nav_follow" => "on",
				"nav_followside" => "right",
				"nav_followspeed" => "700"
			);
			update_option($this->AdminOptionsName, $ssmOldOptions);
				
			echo '<div id="message" class="updated fade"><p><strong>' . __( 'SuperSlider-Menu Default Options reloaded.', 'superslider-menu' ) . '</strong></p></div>';
			
		}
		elseif ($_POST['action'] == 'update' ) {
			
			check_admin_referer('ssm_options'); // check the nonce
					// If we've updated settings, show a message
			echo '<div id="message" class="updated fade"><p><strong>' . __( 'SuperSlider-Menu Options saved.', 'superslider-menu' ) . '</strong></p></div>';
			
			$ssmNewOptions = array(
				'user_objects'	=> $_POST['op_user_objects'],
				'holder'		=> $_POST['op_holder'],
				'toggler'		=> $_POST['op_toggler'],
				'content'		=> $_POST['op_content'],
				'toglink'		=> $_POST['op_toglink'],				
				'load_moo'		=> $_POST['op_load_moo'],
				'css_load'		=> $_POST['op_css_load'],
				'css_theme'		=> $_POST["op_css_theme"],
				'add_mouse'		=> $_POST["op_add_mouse"],
				'alwayshide'	=> $_POST["op_alwayshide"],
				'opacity'		=> $_POST["op_opacity"],
				'trans_time'	=> $_POST["op_trans_time"],
				'trans_type'		=> $_POST["op_trans_type"],
				'trans_typeinout'	=> $_POST["op_transtypeinout"],
				'tooltips'			=> $_POST["op_tooltips"],
				'nav_follow'		=> $_POST["op_navfollow"],
				'nav_followside'	=> $_POST["op_navfollowside"],
				'nav_followspeed'	=> $_POST["op_navfollowspeed"]
			);	

		update_option($this->AdminOptionsName, $ssmNewOptions);

		}	

		$ssmNewOptions = get_option($this->AdminOptionsName);   

	/**
	*	Let's get some variables for multiple instances
	*/
    $trans_type = attribute_escape(get_option('ssm_trans_type'));
    $checked = ' checked="checked"';
    $selected = ' selected="selected"';
	$site = get_settings('siteurl'); 
?>

<div class="wrap">
<form name="ssm_options" method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
<!-- possible auto save options : action="options.php" , bellow, update-options as nonce -->
<?php if ( function_exists('wp_nonce_field') )
		wp_nonce_field('ssm_options'); echo "\n"; ?>
		
<div style="">
<a href="http://wp-superslider.com/">
<img src="<?php echo $site ?>/wp-content/plugins/superslider-menu/admin/img/logo_superslider.png" style="margin-bottom: -15px;padding: 20px 20px 0px 20px;" alt="SuperSlider Logo" width="52" height="52" border="0" /></a>
  <h2 style="display:inline; position: relative;">SuperSlider-Menu Options</h2>
 </div><br style="clear:both;" />
 <table class="form-table">
	<tr>
		<td width="70%" valign="top">
				<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- Theme options start -->  
   <legend><b><?php _e('Menu Appearance',$ssm_domain); ?>:</b></legend>
    <optgroup label="op_css_theme">
     <label for="op_css_theme1">
     <input type="radio" name="op_css_theme" id="op_css_theme1"
     <?php if($ssmNewOptions['css_theme'] == "default") echo $checked; ?> value="default" /></input>
     <!--<div style="display:inline;font-size:1.2em;color:#000;font-weight: bold; text-align:center; padding: 0px 0px 4px 0px;height: 25px;width: 120px; background: url(<?php echo $site ?>/wp-content/plugins/superslider-menu/admin/img/default.png) no-repeat;">
     <?php _e('Default',$ssm_domain); ?></div> -->
     <img src="<?php echo $site ?>/wp-content/plugins/superslider-menu/admin/img/default.png" alt="default" border="0" width="110" height="25" /></label>
    

      <label for="op_css_theme2">
     <input type="radio" name="op_css_theme" id="op_css_theme2"
     <?php if($ssmNewOptions['css_theme'] == "blue") echo $checked; ?> value="blue" /></input>
     <img src="<?php echo $site ?>/wp-content/plugins/superslider-menu/admin/img/blue.png" alt="blue" border="0" width="110" height="25" /></label>
     
      <label for="op_css_theme3">
     <input type="radio" name="op_css_theme" id="op_css_theme3"
     <?php if($ssmNewOptions['css_theme'] == "black") echo $checked; ?> value="black" /></input>
     <img src="<?php echo $site ?>/wp-content/plugins/superslider-menu/admin/img/black.png" alt="black" border="0" width="110" height="25" /></label>
     
      <label for="op_css_theme4">
     <input type="radio" name="op_css_theme" id="op_css_theme4"
     <?php if($ssmNewOptions['css_theme'] == "custom") echo $checked; ?> value="custom" /></input>
     <img src="<?php echo $site ?>/wp-content/plugins/superslider-menu/admin/img/custom.png" alt="custom" border="0" width="110" height="25" /></label>
     
     
     <br /><small><?php _e(' Choose a theme for your menu. To add your own. Select "custom". ',$ssm_domain); ?></small>
    </optgroup>
  </fieldset>
  </td>
		<td width="30%" valign="top">
		<p class="submit">
		<input type="submit" id="update" class="button-primary" value="<?php _e('Update options',$ssm_domain); ?> &raquo;" />
		</p>
		<p ><a class="button" href="<?php echo $site ?>/wp-admin/widgets.php"><?php _e('Set up your SuperSlider-Menu Widget',$ssm_domain); ?> &raquo; </a>
 
		</p>
		</td>
	</tr>
	
	<!--<tr>
		<td>
			
		</td>
		<td></td>
	</tr>-->
	<tr>
		<td>
		<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- Accordion options start -->
   <legend><b><?php _e('Accordion Options',$ssm_domain); ?>:</b></legend>
   <ul style="list-style-type: none;">
    <li>
    <optgroup label="op_add_mouse">
    	<label for="op_add_mouseon">
    		<input type="radio" 
    		<?php if($ssmNewOptions['add_mouse'] == "on") echo $checked; ?> name="op_add_mouse" id="op_add_mouseon" value="on"/> 
    		<?php _e('Click to Activate the Accordion Togglers (default).',$ssm_domain); ?>
    		</label>
    		<br />
    	<label for="op_add_mouseoff">
     		<input type="radio"
     		<?php if($ssmNewOptions['add_mouse'] == "off") echo $checked; ?>  name="op_add_mouse" id="op_add_mouseoff" value="off" />
     		<?php _e('MouseOver to Activate the Accordion Togglers.',$ssm_domain); ?>
     		</label>
     		</input>
     </optgroup>
	</li>
	<hr />
    <li>
    	<label for="op_alwayshide">
    		<input type="checkbox"
    		<?php if($ssmNewOptions['alwayshide'] == "on") echo $checked; ?> name="op_alwayshide" id="op_alwayshide" /> 
    		<?php _e('Allow close all tabs, disactivate to force one top level item to always be open.',$ssm_domain); ?></label>
    </li>
    <li>
    	<label for="op_opacity">
    		<input type="checkbox"
    		<?php if($ssmNewOptions['opacity'] == "on") echo $checked; ?> name="op_opacity" id="op_opacity"/>
    		<?php _e('Apply transition to opacity as well as height.',$ssm_domain); ?></label>
    </li>
    <li>
     <label for="op_trans_time"><?php _e('Accordion transition time'); ?>:
     <input type="text" name="op_trans_time" id="op_trans_time" size="6" maxlength="6"
     value="<?php echo ($ssmNewOptions['trans_time']); ?>"/></label> 
     <small><?php _e(' In milliseconds, ie: 1000 = 1 second',$ssm_domain); ?></small>
     </li>
     <li>
     <label for="op_trans_type"><?php _e('Accordion transition type',$ssm_domain); ?>:   </label>  
     <select name="op_trans_type" id="op_trans_type">
     <option <?php if($ssmNewOptions['trans_type'] == "sine") echo $selected; ?> id="sine" value='sine'> sine</option>
     <option <?php if($ssmNewOptions['trans_type'] == "elastic") echo $selected; ?> id="elastic" value='elastic'> elastic</option>
     <option <?php if($ssmNewOptions['trans_type'] == "bounce") echo $selected; ?> id="bounce" value='bounce'> bounce</option>
     <option <?php if($ssmNewOptions['trans_type'] == "expo") echo $selected; ?> id="expo" value='expo'> expo</option>
     <option <?php if($ssmNewOptions['trans_type'] == "circ") echo $selected; ?> id="circ" value='circ'> circ</option>
     <option <?php if($ssmNewOptions['trans_type'] == "quad") echo $selected; ?> id="quad" value='quad'> quad</option>
     <option <?php if($ssmNewOptions['trans_type'] == "cubic") echo $selected; ?> id="cubic" value='cubic'> cubic</option>
     <option <?php if($ssmNewOptions['trans_type'] == "linear") echo $selected; ?> id="linear" value='linear'> linear</option>
    </select><br />
    <label for="op_transtypeinout"><?php _e('Accordion transition action.',$ssm_domain); ?></label>
    <select name="op_transtypeinout" id="op_transtypeinout">
     <option <?php if($ssmNewOptions['trans_typeinout'] == "in") echo $selected; ?> id="in" value='in'> in</option>
     <option <?php if($ssmNewOptions['trans_typeinout'] == "out") echo $selected; ?> id="out" value='out'> out</option>
     <option <?php if($ssmNewOptions['trans_typeinout'] == "in:out") echo $selected; ?> id="inout" value='in:out'> in:out</option>     
    </select>
    <small><?php _e('IN is the begginning of transition. OUT is the end of transition.',$ssm_domain); ?></small>
     </li><!-- //'quad:in:out'sine:out, elastic:out, bounce:out, expo:out, circ:out, quad:out, cubic:out, linear:out, -->
    </ul>
  </fieldset>
  </td>
		<td></td>
	</tr>
	
	<tr>
		<td>
    <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- ToolTip options start -->
   <legend><b><?php _e('ToolTip Options',$ssm_domain); ?>:</b></legend>
   <ul style="list-style-type: none;">
    <li><optgroup label="op_tooltips">
    
    	<label for="op_tooltipson">
    	<input type="radio"  name="op_tooltips" id="op_tooltipson"
    	<?php if($ssmNewOptions['tooltips'] == "on") echo $checked; ?> value="on" /></input>
    	<?php _e('Tooltips turned on.'); ?> </label>
		<br />
		<label for="op_tooltipsoff">
    	<input type="radio"  name="op_tooltips" id="op_tooltipsoff"
    	<?php if($ssmNewOptions['tooltips'] == "off") echo $checked; ?> value="off" /></input>
    	<?php _e('Tooltips turned off.'); ?> </label>
    	
	</optgroup>
	</li>
	<li>


	</li>
   </ul>
  </fieldset>
		</td>
		<td><?php _e('To edit the animation, graphics and placement of the tooltip, open the css file and edit the classes starting with .customTip. for further control you will need to edit the file superslider-menu.php, starting at line 270, or search for myTips.',$ssm_domain); ?></td>
	</tr>
	
	<tr>
		<td>
		 <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- Mouse follower options start -->
   <legend><b><?php _e('Mouse Tracer',$ssm_domain); ?>:</b></legend>
   <ul style="list-style-type: none;">
    <li>
    	<label for="op_navfollow"><input type="checkbox" 
    	<?php if($ssmNewOptions['nav_follow'] == "on") echo $checked; ?> name="op_navfollow" id="op_navfollow"/>
    	<?php _e('Activate the Vertical Mouse Tracer.',$ssm_domain); ?></label>
    </li>
    <!--<li><optgroup label="nav_followside">
    
		<label for="op_navfollowleft">
    	<input type="radio"  name="op_navfollowside" id="op_navfollowleft"
    	<?php if($ssmNewOptions['nav_followside'] == "left") echo $checked; ?> value="left" /></input>
    	<?php _e('Tracer travels on the left side of menu.'); ?> </label>
    	
    	<label for="op_navfollowright">
    	<input type="radio"  name="op_navfollowside" id="op_navfollowright"
    	<?php if($ssmNewOptions['nav_followside'] == "right") echo $checked; ?> value="right" /></input>
    	<?php _e('Tracer travels on the right side of menu.'); ?> </label>
    	
	</optgroup>-->
	</li>
    <li>
     <label for="op_navfollowspeed"><?php _e('Tracer Reaction speed',$ssm_domain); ?>:
     <input type="text" name="op_navfollowspeed" id="op_navfollowspeed" size="6" maxlength="6" 
     value="<?php echo ($ssmNewOptions['nav_followspeed']); ?>"/></label> 
     <small><?php _e('In milliseconds, ie: 1000 = 1 second',$ssm_domain); ?></small>
     </li>
   </ul>
  </fieldset>
		</td>
		<td><p><?php _e('To control which side of the menu your Tracer slides, and the width of it\'s area (you may have edited the image to be larger), edit the css id #navArrow',$ssm_domain); ?></p></td>
	</tr>
	<tr>
		<td>
			<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- Header files options start -->
   			<legend><b><?php _e('File Storage - Loading Options'); ?>:</b></legend>
  		 <ul style="list-style-type: none;">
    <li>
    	<label for="op_load_moo">
    	<input type="checkbox" 
    	<?php if($ssmNewOptions['load_moo'] == "on") echo $checked; ?> name="op_load_moo" id="op_load_moo" />
    	<?php _e('Load Mootools 1.2 into your theme header.',$ssm_domain); ?></label>
    	<hr />
	</li>
    <li><optgroup label="op_css_load">
    	<label for="op_css_load1">
    	<input type="radio" name="op_css_load" id="op_css_load1"
    	<?php if($ssmNewOptions['css_load'] == "default") echo $checked; ?> value="default" />
    	<?php _e('Load css from default location. SuperSlider-Menu plugin folder.',$ssm_domain); ?></label><br />
    	<label for="op_css_load2"><input type="radio" name="op_css_load"  id="op_css_load2"
    	<?php if($ssmNewOptions['css_load'] == "pluginData") echo $checked; ?> value="pluginData" />
    	<?php _e('Load css from plugin-data folder, see side note. (Recommended)',$ssm_domain); ?></label><br />
    	<label for="op_css_load3"><input type="radio" name="op_css_load"  id="op_css_load3"
    	<?php if($ssmNewOptions['css_load'] == "off") echo $checked; ?> value="off" />
    	<?php _e('Don\'t load css, manually add to your theme css file.',$ssm_domain); ?></label>
    	</optgroup>
    </li>
    </ul>
     </fieldset>
     </td>
		<td><p><?php _e('If your theme or any other plugin loads the mootools 1.2 javascript framework into your file header, you can disactivate it here.',$ssm_domain); ?></p><hr /><p><?php _e('Via ftp, move the folder named plugin-data from this plugin folder into your wp-content folder. This is recomended to avoid over writing any changes you make to the css files when you update this plugin.',$ssm_domain); ?></p></td>
	</tr>
	<tr>
		<td>
			<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- Toggle objects options start -->  
   <legend><b><?php _e('Object Options - Advanced usage',$ssm_domain); ?>:</b></legend>
   <ul style="list-style-type: none;">
    <li>
    	<label for="op_user_objects"><input type="checkbox" 
    	<?php if($ssmNewOptions['user_objects'] == "on") echo $checked; ?> name="op_user_objects" id="op_user_objects" />
    	<?php _e('Use a different object structure.',$ssm_domain); ?></label> 
    	
	</li>
	<li>
     <label for="op_holder"><?php _e('Object holder to use',$ssm_domain); ?>:
     <input type="text" name="op_holder" id="op_holder" size="20" maxlength="50"
     value="<?php echo ($ssmNewOptions['holder']); ?>"></input></label>
     <br /><small><?php _e(' Default is #ssMenuList ',$ssm_domain); ?></small>
     </li>
    <li>
     <label for="op_toggler"><?php _e('Toggler to use',$ssm_domain); ?>:
     <input type="text" name="op_toggler" id="op_toggler" size="20" maxlength="50"
     value="<?php echo ($ssmNewOptions['toggler']); ?>"></input></label>
     <br /><small><?php _e(' Default is  dt span.show_ ',$ssm_domain); ?></small>
     </li>
    <li>
     <label for="op_content"><?php _e('Content to use',$ssm_domain); ?>:
     <input type="text" name="op_content" id="op_content" size="20" maxlength="50"
     value="<?php echo ($ssmNewOptions['content']); ?>"></input></label>
     <br /><small><?php _e(' Default is  dd.showme_ ',$ssm_domain); ?></small>
     </li>
     <li>
     <label for="op_toglink"><?php _e('Toglink to use',$ssm_domain); ?>:
     <input type="text" name="op_toglink" id="op_toglink" size="20" maxlength="50"
     value="<?php echo ($ssmNewOptions['toglink']); ?>"></input></label>
     <br /><small><?php _e(' Default is  dt a ',$ssm_domain); ?></small>
     </li>
   </ul>
  </fieldset>
		</td>
		<td><h3><?php _e(' Use with caution ',$ssm_domain); ?></h3><p><?php _e('Selecting this option will disable the SuperSlider widgets. You can then add your own objects to apply the accordion animation effects to. You will need to create your own corresponding css objects.',$ssm_domain); ?></p>
		<h4><?php _e(' For example: the default WordPress sidebar',$ssm_domain); ?></h4>
		<ul>
		<li>#sidebar</li>
		<li> ul li h2.widgettitle</li>
		<li> ul li ul</li>
		<li> ul li h2.a</li>
		</ul>
		</td>
	</tr>
  
</table>
<p class="submit">
		<input type="submit" name="set_defaults" value="<?php _e('Reload Default Options',$ssm_domain); ?> &raquo;" />
		<input type="submit" id="update" class="button-primary" value="<?php _e('Update options',$ssm_domain); ?> &raquo;" />
		<input type="hidden" name="action" id="action" value="update" />
 	</p>
 </form
</div>
<?php
	echo "";
?>