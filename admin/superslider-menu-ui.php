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
				'delete_options' => 'off'
				);
				
			update_option('ssMenu_options', $ssmOldOptions);
				
			echo '<div id="message" class="updated fade"><p><strong>' . __( 'SuperSlider-Menu Default Options reloaded.', 'superslider-menu' ) . '</strong></p></div>';
			
		}
		elseif (isset($_POST['action']) && $_POST['action'] == 'update' ) {
			
			check_admin_referer('ssm_options'); // check the nonce
					// If we've updated settings, show a message
			echo '<div id="message" class="updated fade"><p><strong>' . __( 'SuperSlider-Menu Options saved.', 'superslider-menu' ) . '</strong></p></div>';
			
			$ssmNewOptions = array(			
				'holder'		=> $_POST['op_holder'],
				'toggler'		=> $_POST['op_toggler'],
				'content'		=> $_POST['op_content'],
				'toglink'		=> $_POST['op_toglink'],				
				'load_moo'		=> $_POST['op_load_moo'],
				'css_load'		=> $_POST['op_css_load'],
				'css_theme'		=> $_POST['op_css_theme'],
				'add_mouse'		=> $_POST['op_add_mouse'],
				'always_hide' => isset($_POST['op_always_hide']) ? $_POST["op_always_hide"] : "",
				
				'opacity'		=> $_POST['op_opacity'],
				'trans_time'	=> $_POST['op_trans_time'],
				'trans_type'		=> $_POST['op_trans_type'],
				'trans_typeinout'	=> $_POST['op_transtypeinout'],
				'nav_follow'		=> $_POST['op_navfollow'],
				'nav_followspeed'	=> $_POST['op_navfollowspeed'],
				
				'user_objects' => isset($_POST['user_objects']) ? $_POST["user_objects"] : "",
				
				'linkTitle' 	=> $_POST['op_linkTitle'],
				'linkText' 		=> $_POST['op_linkText'],
				'delete_options' => isset($_POST['op_delete_options']) ? $_POST["op_delete_options"] : ""
			);
			
		update_option('ssMenu_options', $ssmNewOptions);
	
		}elseif (isset($_POST['proaction']) && $_POST['proaction'] == 'updatepro' ) {
			
			check_admin_referer('ssPro_options'); // check the nonce
					// If we've updated settings, show a message
			echo '<div id="message" class="updated fade"><p><strong>' . __( 'superslider Pro Options saved.', 'superslider-menu' ) . '</strong></p></div>';
			
			
			$ssPro_newOptions = array(				
				'pro_code' => isset($_POST['op_pro_code']) ? $_POST["op_pro_code"] : ""
				);
			update_option('ssPro_options', $ssPro_newOptions);
	
		}

	$ssPro_newOptions = get_option('ssPro_options'); 
	$ispro = '';
	if($ssPro_newOptions['pro_code'] == "We are all beautiful creative people")$ispro = true;

	$ssmNewOptions = get_option('ssMenu_options');   

	/**
	*	Let's get some variables for multiple instances
	*/
    //$trans_type = esc_attr(get_option('ssm_trans_type'));
    
    $checked = ' checked="checked"';
    $selected = ' selected="selected"';
	$site = get_option('siteurl');
	$plugin_name = 'superslider-menu';
?>

<div class="wrap">
<div class="ss_column1">

<form name="ssm_options" method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
<!-- possible auto save options : action="options.php" , bellow, update-options as nonce -->
<?php if ( function_exists('wp_nonce_field') )
		wp_nonce_field('ssm_options'); echo "\n"; ?>
		
<div style="">
<a href="http://superslider.daivmowbray.com/">
<img src="<?php echo WP_CONTENT_URL ?>/plugins/superslider-menu/admin/img/logo_superslider.png" style="margin-bottom: -15px;padding: 20px 20px 0px 20px;" alt="SuperSlider Logo" width="52" height="52" border="0" /></a>
  <h2 style="display:inline; position: relative;">SuperSlider-Menu Options</h2>
 </div><br style="clear:both;" />
 
 <script type="text/javascript">
// <![CDATA[
jQuery(document).ready(function ($) {

	$(function() {
        $( "#ssslider" ).tabs({ active: 1 });
    });
});	
// ]]>
</script>
 
<div id="ssslider" class="ui-tabs">
    <ul id="ssnav" class="ui-tabs-nav">
        <li <?php if ($this->base_over_ride != "on") { 
  		 echo '';
  		} else {
  		echo 'style="display:none;"';
  		}?>	class="ui-state-default" ><a href="#fragment-1"><span>Appearance</span></a></li>
        <li class="ui-tabs-selected"><a href="#fragment-2"><span>Animation</span></a></li>
        <li class="ui-state-default"><a href="#fragment-3"><span>Mouse Tracer</span></a></li>
        <li class="ui-state-default"><a href="#fragment-4"><span>Advanced</span></a></li>
        <li <?php if ($this->base_over_ride != "on") { 
  		 echo '';
  		} else {
  		echo 'style="display:none;"';
  		}?>	class="ss-state-default" ><a href="#fragment-5"><span>File storage</span></a></li>
  		
    </ul>
    
    <div id="fragment-1" class="ss-tabs-panel">
 	<div <?php if ($this->base_over_ride != "on") { 
  		 echo '';
  		} else {
  		echo 'style="display:none;"';
  		}?>	
	>
	<h3 class="title">Menu Appearance</h3>

<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- Theme options start -->  	
		<legend><b><?php _e(' Themes',$plugin_name); ?>:</b></legend>
	<table width="100%" cellpadding="10" align="center">
	<tr>
		<td width="25%" align="center" valign="top"><img src="<?php echo WP_CONTENT_URL ?>/plugins/superslider-menu/admin/img/default.png" alt="default" border="0" width="110" height="25" /></td>
		<td width="25%" align="center" valign="top"><img src="<?php echo WP_CONTENT_URL ?>/plugins/superslider-menu/admin/img/blue.png" alt="blue" border="0" width="110" height="25" /></td>
		<td width="25%" align="center" valign="top"><img src="<?php echo WP_CONTENT_URL ?>/plugins/superslider-menu/admin/img/black.png" alt="black" border="0" width="110" height="25" /></td>
		<td width="25%" align="center" valign="top"><img src="<?php echo WP_CONTENT_URL ?>/plugins/superslider-menu/admin/img/custom.png" alt="custom" border="0" width="110" height="25" /></td>
	</tr>
	<tr>
		<td><label for="op_css_theme1">
			 <input type="radio"  name="op_css_theme" id="op_css_theme1"
			 <?php if($ssmNewOptions['css_theme'] == "default") echo $checked; ?> value="default" />
			</label>
		</td>
		<td> <label for="op_css_theme2">
			 <input type="radio"  name="op_css_theme" id="op_css_theme2"
			 <?php if($ssmNewOptions['css_theme'] == "blue") echo $checked; ?> value="blue" />
			 </label>
  		</td>
		<td><label for="op_css_theme3">
			 <input type="radio"  name="op_css_theme" id="op_css_theme3"
			 <?php if($ssmNewOptions['css_theme'] == "black") echo $checked; ?> value="black" />
			 </label>
  		</td>
		<td> <label for="op_css_theme4">
			 <input type="radio"  name="op_css_theme" id="op_css_theme4"
			 <?php if($ssmNewOptions['css_theme'] == "custom") echo $checked; ?> value="custom" />
			</label>
     </td>
	</tr>
	</table>

  </fieldset>
  </div>
</div><!-- close frag 1 -->   

<div id="fragment-2" class="ss-tabs-panel">
	<h3 class="title">Accordion animations</h3>

		<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- Accordion options start -->
   <legend><b><?php _e('Accordion Options',$plugin_name); ?>:</b></legend>
   <ul style="list-style-type: none;">
    <li>
    	<label for="op_add_mouseoff">
    		<input type="radio" 
    		<?php if($ssmNewOptions['add_mouse'] == "off") echo $checked; ?> name="op_add_mouse" id="op_add_mouseoff" value="off"/> 
    		<?php _e('Click to Activate the Accordion Togglers (default).',$plugin_name); ?>
    		</label>
    		<br />
    	<label for="op_add_mouseon">
     		<input type="radio"
     		<?php if($ssmNewOptions['add_mouse'] == "on") echo $checked; ?>  name="op_add_mouse" id="op_add_mouseon" value="on" />
     		<?php _e('MouseOver to Activate the Accordion Togglers.',$plugin_name); ?>
     		</label>
     		</input>

	</li>
	<hr />
    <li>
    	<label for="op_always_hide">
    		<input type="checkbox"
    		<?php if($ssmNewOptions['always_hide'] == "on") echo $checked; ?> name="op_always_hide" id="op_always_hide" /> 
    		<?php _e('Enable close all tabs, deselect will force one top level item to always be open.',$plugin_name); ?></label>
    </li>
    <li>
    	<label for="op_opacity">
    		<input type="checkbox"
    		<?php if($ssmNewOptions['opacity'] == "on") echo $checked; ?> name="op_opacity" id="op_opacity"/>
    		<?php _e('Apply transition to opacity as well as height.',$plugin_name); ?></label>
    </li>
    <li>
     <label for="op_trans_time"><?php _e('Accordion transition time'); ?>:
     <input type="text" name="op_trans_time" id="op_trans_time" size="6" maxlength="6"
     value="<?php echo ($ssmNewOptions['trans_time']); ?>"/></label> 
     <small><?php _e(' In milliseconds, ie: 1000 = 1 second',$plugin_name); ?></small>
     </li>
     <li>
     <label for="op_trans_type"><?php _e('Accordion transition type',$plugin_name); ?>:   </label>  
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
    <label for="op_transtypeinout"><?php _e('Accordion transition action.',$plugin_name); ?></label>
    <select name="op_transtypeinout" id="op_transtypeinout">
     <option <?php if($ssmNewOptions['trans_typeinout'] == "in") echo $selected; ?> id="in" value='in'> in</option>
     <option <?php if($ssmNewOptions['trans_typeinout'] == "out") echo $selected; ?> id="out" value='out'> out</option>
     <option <?php if($ssmNewOptions['trans_typeinout'] == "in:out") echo $selected; ?> id="inout" value='in:out'> in:out</option>     
    </select>
    <small><?php _e('IN is the begginning of transition. OUT is the end of transition.',$plugin_name); ?></small>
     </li><!-- //'quad:in:out'sine:out, elastic:out, bounce:out, expo:out, circ:out, quad:out, cubic:out, linear:out, -->
    </ul>
  </fieldset>

</div><!-- close frag 2 -->   

 

<div id="fragment-3" class="ss-tabs-panel">
	<h3 class="title">Mouse Tracer</h3>
	
		 <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- Mouse follower options start -->
   <legend><b><?php _e('Mouse Tracer',$plugin_name); ?>:</b></legend>
   <ul style="list-style-type: none;">
    <li>
    	<label for="op_navfollow"><input type="checkbox" 
    	<?php if($ssmNewOptions['nav_follow'] == "on") echo $checked; ?> name="op_navfollow" id="op_navfollow"/>
    	<?php _e('Activate the Vertical Mouse Tracer.',$plugin_name); ?></label>
    </li>
    <li>
     <label for="op_navfollowspeed"><?php _e('Tracer Reaction speed',$plugin_name); ?>:
     <input type="text" name="op_navfollowspeed" id="op_navfollowspeed" size="6" maxlength="6" 
     value="<?php echo ($ssmNewOptions['nav_followspeed']); ?>"/></label> 
     <small><?php _e('In milliseconds, ie: 1000 = 1 second',$plugin_name); ?></small>
     </li>
   </ul>
  </fieldset>
   <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- Link title options start -->
   <legend><b><?php _e('Link title Options',$plugin_name); ?>:</b></legend>
   <ul style="list-style-type: none;">
   
     <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
     <label for="op_linkTitle"><?php _e('Link title, use ',$plugin_name); ?></label>
    <select name="op_linkTitle" id="op_linkTitle">
     <option <?php if($ssmNewOptions['linkTitle'] == "title") echo $selected; ?> id="titletitle" value='title'> title</option>
     <option <?php if($ssmNewOptions['linkTitle'] == "href") echo $selected; ?> id="titlehref" value='href'> href</option>
     <option <?php if($ssmNewOptions['linkTitle'] == "rel") echo $selected; ?> id="titlerel" value='rel'> rel</option>     
    </select>
    <small><?php _e('for the link title, also used for tooltip title.',$plugin_name); ?></small>
    </li>
    
    <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
     <label for="op_linkText"><?php _e('Link text, use',$plugin_name); ?></label>
    <select name="op_linkText" id="op_linkText">
     <option <?php if($ssmNewOptions['linkText'] == "title") echo $selected; ?> id="texttitle" value='title'> title</option>
     <option <?php if($ssmNewOptions['linkText'] == "href") echo $selected; ?> id="texthref" value='href'> href</option>
     <option <?php if($ssmNewOptions['linkText'] == "rel") echo $selected; ?> id="textrel" value='rel'> rel</option>     
    </select>
    <small><?php _e('for the link title, also used for tooltip text.',$plugin_name); ?></small>
    </li>
    
   </ul>
  </fieldset>
</div><!-- close frag3 -->

<div id="fragment-4" class="ss-tabs-panel">
	<h3 class="title">Advanced</h3>
				<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- Toggle objects options start -->  
   <legend><b><?php _e('Object Options - Advanced usage',$plugin_name); ?>:</b></legend>
   <ul style="list-style-type: none;">
    <li>
    	<label for="op_user_objects"><input type="checkbox" 
    	<?php if($ssmNewOptions['user_objects'] == "on") echo $checked; ?> name="op_user_objects" id="op_user_objects" />
    	<?php _e('Use a different object structure.',$plugin_name); ?></label> 
    	
	</li>
	<li>
     <label for="op_holder"><?php _e('Object holder to use',$plugin_name); ?>:
     <input type="text" name="op_holder" id="op_holder" size="20" maxlength="50"
     value="<?php echo ($ssmNewOptions['holder']); ?>"></input></label>
     <br /><small><?php _e(' Default is #ssMenuList ',$plugin_name); ?></small>
     </li>
    <li>
     <label for="op_toggler"><?php _e('Toggler to use',$plugin_name); ?>:
     <input type="text" name="op_toggler" id="op_toggler" size="20" maxlength="50"
     value="<?php echo ($ssmNewOptions['toggler']); ?>"></input></label>
     <br /><small><?php _e(' Default is  div span.show_ ',$plugin_name); ?></small>
     </li>
    <li>
     <label for="op_content"><?php _e('Content to use',$plugin_name); ?>:
     <input type="text" name="op_content" id="op_content" size="20" maxlength="50"
     value="<?php echo ($ssmNewOptions['content']); ?>"></input></label>
     <br /><small><?php _e(' Default is  div.showme_ ',$plugin_name); ?></small>
     </li>
     <li>
     <label for="op_toglink"><?php _e('Toglink to use',$plugin_name); ?>:
     <input type="text" name="op_toglink" id="op_toglink" size="20" maxlength="50"
     value="<?php echo ($ssmNewOptions['toglink']); ?>"></input></label>
     <br /><small><?php _e(' Default is  div .catlink ',$plugin_name); ?></small>
     </li>
   </ul>
  </fieldset>

  <h3><?php _e(' Use with caution ',$plugin_name); ?></h3><p><?php _e('Selecting this option will disable the SuperSlider widgets. You can then add your own objects to apply the accordion animation effects to. You will need to create your own corresponding css objects.',$plugin_name); ?></p>
    
</div><!-- close frag 4 -->

<div id="fragment-5" class="ss-tabs-panel">
	
	<div
<?php if ($this->base_over_ride != "on") { 
  		 echo '';
  		} else {
  		echo 'style="display:none;"';
  		}?> 
	>    
	<h3 class="title">File Storage</h3>
    <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- Header files options start -->
   			<legend><b><?php _e('File Storage - Loading Options'); ?>:</b></legend>
  		 <ul style="list-style-type: none;">
    <li>
    	<label for="op_load_moo">
    	<input type="checkbox" 
    	<?php if($ssmNewOptions['load_moo'] == "on") echo $checked; ?> name="op_load_moo" id="op_load_moo" />
    	<?php _e('Load Mootools 1.4.5 into your theme header.',$plugin_name); ?>
    	<a href="#moo_tips_info" class="ss_tool" style="padding: 2px 8px;"> ? </a></label>
    <div id ="moo_tips_info" class="info_box" style="display:none;">
                       <h3><?php _e('field: Load Mootools info ',$plugin_name); ?></h3>
                        <?php _e(' If your theme or any other plugin loads the mootools 1.4.5 javascript framework into your file header, you can deactivate it here.',$plugin_name); ?></div> 
    	<hr />
	</li>
	
    <li>
    	<label for="op_css_load1">
    	<input type="radio" name="op_css_load" id="op_css_load1"
    	<?php if($ssmNewOptions['css_load'] == "default") echo $checked; ?> value="default" />
    	<?php _e('Load css from default location. SuperSlider-Menu plugin folder.',$plugin_name); ?></label><br />
    	<label for="op_css_load2"><input type="radio" name="op_css_load"  id="op_css_load2"
    	<?php if($ssmNewOptions['css_load'] == "pluginData") echo $checked; ?> value="pluginData" />
    	<?php _e('Load css from plugin-data folder. (Recommended)',$plugin_name); ?>
    		<a href="#css_tips_info" class="ss_tool" style="padding: 2px 8px;"> ? </a></label>
    				<div id ="css_tips_info" class="info_box" style="display:none;">
                       <h3><?php _e('field: Css Storage info ',$plugin_name); ?></h3>
                        <?php _e(' Via ftp, move the folder named plugin-data from this plugin folder into your wp-content folder. This is recomended to avoid over writing any changes you make to the css files when you update this plugin.',$plugin_name); ?>
                    </div> 
		<br />
		<label for="op_css_load3">
			<input type="radio" name="op_css_load"  id="op_css_load3"
			<?php if($ssmNewOptions['css_load'] == "theme") echo $checked; ?> value="theme" />
			<?php _e('Load the css from your theme folder, see side note.',$plugin_name); ?></label><br />
    	<label for="op_css_load4">
    		<input type="radio" name="op_css_load"  id="op_css_load4"
    	<?php if($ssmNewOptions['css_load'] == "off") echo $checked; ?> value="off" />
    	<?php _e('Don\'t load css, manually add to your theme css file.',$plugin_name); ?></label>
    	
    </li>
    </ul>
     </fieldset>

		<div>
		<p></p>
		<p>
		</p>
		</div>
	</div>
	
</div><!-- close frag 5 -->
</div><!--  close tabs -->
<p>
<label for="op_delete_options">
		      <input type="checkbox"
		      <?php if($ssmNewOptions['delete_options'] == "on") echo $checked; ?>
		      name="op_delete_options" id="op_delete_options" />
		      <?php _e('Remove options. '); ?></label>	
		 <br /><span class="setting-description"><?php _e('Select to have the plugin options removed from the data base upon deactivation.'); ?></span>
		 <br />
</p>

<p class="submit">
		<input type="submit" class="button" name="set_defaults" value="<?php _e('Reload Default Options',$plugin_name); ?> &raquo;" />
		<input type="submit" id="update" class="button-primary" value="<?php _e('Update options',$plugin_name); ?> &raquo;" />
		<input type="hidden" name="action" id="action" value="update" />
 	</p>
 </form>
</div><!-- close column1 -->


<div class="ss_column2">

<?php if( $ispro !== true) { ?>

	<div class="ss_donate ss_admin_box"> 
		<h2><span class="promo"><?php _e('Spread the Word!', $plugin_name); ?></span></h2>
		<p><?php _e('Want to help make this plugin even better? All donations are used to improve and maintain this plugin, so donate $5, $10, $20 or $50! We\'ll both be glad you did. Thanx. ', $plugin_name); ?></p>
       <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="hosted_button_id" value="N2F3EUVHPYY5G">
            <input type="image" class="paypal_button" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
            <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
       </form>
       
       
       <p><?php _e('Better yet, if you would like to join the exclusive pro members club,', $plugin_name); ?> <a href="http://superslider.daivmowbray.com/superslider-pro/"><?php _e('learn more'); ?></a><?php _e('or upgrade now!'); ?> </p>
       <h2><span class="promo">SuperSlider Pro</span></h2>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="83HF3CEUD4976">
			<input type="image" class="paypal_button" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
		</form>

       <p><?php _e('Or if you find this plugin useful you could :'); ?></p><ul>
       	<li><a href="http://wordpress.org/extend/plugins/<?php echo $plugin_name; ?>/"><?php _e('Rate the plugin 5 stars on WordPress.org', $plugin_name); ?></a></li>
       	<li><a href="http://superslider.daivmowbray.com/superslider/<?php echo $plugin_name; ?>/"><?php _e('Blog about it &amp; link to the plugin page', $plugin_name); ?></a></li>
       	<li><a href="http://wordpress.org/support/view/plugin-reviews/<?php echo $plugin_name; ?>"><?php _e('Post a glowing review on WordPress.org, that would be really nice.', $plugin_name); ?></a></li>
       	<li><a href="http://amzn.com/w/2GUXZ71357NX9"><?php _e('or buy me a gift from my wishlist ...', $plugin_name); ?></a></li></ul>
       
    </div>
    <div class="ss_admin_box" id="sitereview">
		<h2><?php _e('Improve your Site!', $plugin_name); ?></h2>
		<p><?php _e('Don\'t know where to start? Order a ', $plugin_name); ?><a href="http://superslider.daivmowbray.com/services/website-review/#order"><?php _e('website review', $plugin_name); ?></a> from SuperSlider!
		<a href="http://superslider.daivmowbray.com/services/website-review/"> Read more ... </a></p>	
	</div>

 
	<div class="ss_admin_box" id="support">
		<h2><?php _e('Need support?', $plugin_name); ?></h2>
		<p><?php _e('If you are having problems with this plugin, please talk about them in the', $plugin_name); ?> <a href="http://wordpress.org/support/plugin/<?php echo $plugin_name; ?>/">Support forums</a>.</p>	
		</div>

 <?php 
 } else { ?>
	
		<div class="ss_donate ss_admin_box"> <h2><span class="promo">SuperSlider Pro</span></h2> </div>
	<div class="ss_admin_box" id="support">
		<h2><?php _e('Need support?', $plugin_name); ?></h2>
		<p><?php _e('If you are having problems with this plugin, please contact me directly via this contact form', $plugin_name); ?><br /><a href="http://superslider.daivmowbray.com/pro-support/">Pro Support</a>.</p>	
		</div>
<?php }?>

	<h2><?php _e('More SuperSlider Plugins', $plugin_name); ?></h2>
	<p><?php _e('There are 11 different SuperSlider plugins. All are free to use. Take a minute and learn what each one can do for you. They save you time and money, while making a better web site.', $plugin_name); ?></p>
	 <div class="ss_plugins_list
	 <?php if (class_exists('ssBase') && class_exists('ssShow') &&  class_exists('ssMenu') && class_exists('ssMenu') && class_exists('ssImage') && class_exists('ssExcerpt') && class_exists('ssMediaPop') && class_exists('perpost_code') && class_exists('ssPnext') && class_exists('ss_postsincat_widget') && class_exists('ssLogin') && class_exists('ssSlim')) { echo "all-installed" ; } ?>
	 "> 
	 
		<div class="ss_plugin <?php if (class_exists('ssBase')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider/" title="visit this plugin at WordPress.org to learn more">SuperSlider</a>	
		<a href="#ss_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="ss_tips_info" class="info_box" style="display:none;">
		<p>SuperSlider base, is a global admin plugin for all SuperSlider plugins and comes stocked full of eye candy in the form of modules.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssShow')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-show/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Show</a>
		<a href="#show_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-show&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="show_tips_info" class="info_box" style="display:none;">
		<p>SuperSlider-Show is your Animated slideshow plugin with automatic thumbnail list inclusion. This slideshow uses javascript to replace your gallery with a Slideshow. Highly configurable, theme based design, css based animations, automatic minithumbnail creation. Shortcode system on post and page screens to make each slideshow unique.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssMenu')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-menu/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Menu</a>		
		<a href="#show_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-menu&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="show_tips_info" class="info_box" style="display:none;">
		<p>SuperSlider-Show is your Animated slideshow plugin with automatic thumbnail list inclusion. This slideshow uses javascript to replace your gallery with a Slideshow. Highly configurable, theme based design, css based animations, automatic minithumbnail creation. Shortcode system on post and page screens to make each slideshow unique.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssImage')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-image/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Image</a>
		<a href="#image_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-image&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="image_tips_info" class="info_box" style="display:none;">
		<p>Take control your photos and image display. Can add a randomly selected image to any post without an image. Provides a shortcode for adding a photo or image to your post. Provides an easy way to change image properties globally. At the click of a button all post size images can be changed from thumbnail size image to medium size image or any available image size.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssExcerpt')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-excerpt/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Excerpt</a>
		<a href="#excerpt_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-excerpt&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="excerpt_tips_info" class="info_box" style="display:none;">
		<p>SuperSlider-Excerpts automatically adds thumbnails wherever you show excerpts (archive page, feed... etc). Mouseover image will then Morph its properties, (controlled with css) You can pre-define the automatic creation of excerpt sized excerpt-nails.(New image size created, upon image upload).</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssMediaPop')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-media-pop/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Media-Pop</a>	
		<a href="#media_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-media-pop&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="media_tips_info" class="info_box" style="display:none;">
		<p>Soda pop for your media. Take control of your media. Access all size versions of your uploaded image for insert. SuperSlider-Media-Pop adds numerous image enhancements to your admin panels. Displays all attached files to this post/page in post listing screen. It adds image sizes to the Upload/Insert image screen, making all image sizes available to be inserted and adding to the image link field options. Insert any image size and link to any image size.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('perpost_code')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-perpost-code/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Perpost-Code</a>
		<a href="#code_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-perpost-code&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="code_tips_info" class="info_box" style="display:none;">
		<p>Write css and javascript code directly on your post edit screen on a per post basis. Meta boxes provide a quick and easy way to enter custom code to each post. It then loads the code into your frontend theme header if the post has custom code. You may also display your custom code directly into your post with the custom_css or custom_js shortcode.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssPnext')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-previousnext-thumbs/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Previousnext-Thumbs</a>
		<a href="#pnext_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-previousnext-thumbs&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="pnext_tips_info" class="info_box" style="display:none;">
		<p>Superslider-previousnext-thumbs is a previous-next post, thumbnail navigation creator. Works specifically on the single post pages. Animated rollover controlled with css and from the plugin options page. Can create custom image sizes. Automaitcally insert before or after post content or both. Or you can manually insert into your single post theme file.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ss_postsincat_widget')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-postsincat/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Postsincat</a>
		<a href="#pinc_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-postsincat&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="pinc_tips_info" class="info_box" style="display:none;">
		<p>This widget dynamically creates a list of posts from the active category. Displaying the first image and title. It will display the first image in your post as a thumbnail,it looks first for an attached image, then an embedded image then if it finds the image, it grabs the thumbnail version. Oh, and by the way, it's an animated vertical scroller, way cool.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssLogin')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-login/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Login</a>
		<a href="#login_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-login&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="login_tips_info" class="info_box" style="display:none;">
		<p>A tabbed slide in login panel. Theme based, animated, automatic user detection.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssSlim')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://superslider.daivmowbray.com/superslider/superslider-slimbox/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Slimbox</a>
		<a href="#slim_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-slimbox&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="slim_tips_info" class="info_box" style="display:none;">
		<p>Another pop over light box. Theme based, animated, automatic linking, autoplay show built with slimbox2 , uses mootools 1.4.5 java script</p>
		</div></div>
	
		<br style="clear:both;" />
	 </div>
 <h3><?php _e('Services', $plugin_name); ?></h3>
		<p><?php _e('Custom plugins, custom themes, custom solutions: I\'ve been developing WordPress Themes and plugins for many years. If you need a custom solution or simply some help with your set up I am avaiable at reasonable rates. ', $plugin_name); ?><a href="http://www.daivmowbray.com/contact"><?php _e('Just send a note to me, Daiv Mowbray, through this contact form', $plugin_name); ?></a>.</p>

<?php  if( $ispro !== true) { ?>

	<div class="promo_code_form" style="text-align: center;">
	<form name="ssPro_options" method="post" action="<?php //echo $_SERVER['REQUEST_URI'] ?>">
	<?php if ( function_exists('wp_nonce_field') )
		wp_nonce_field('ssPro_options'); echo "\n"; 
		?>
    		<label for="op_pro_code">
               <input type="text" class="span-text" name="op_pro_code" id="op_pro_code" size="30" maxlength="200"
			 value="<?php echo ($ssPro_newOptions['pro_code']); ?>" />
               <br /> <?php _e('Enter your SuperSlider Pro code.',$plugin_name); ?></label>	
    <p class="margin-top: 5px;">
	
		<input type="submit" id="updatePro" class="button-primary" value="<?php _e('Enter',$plugin_name); ?> &raquo;" />
		<input type="hidden" name="proaction" id="proaction" value="updatepro" />
		
 	</p>
 	</form>
 	</div>
<?php  } ?> 

</div><!-- close column2   --> 
</div><!-- close wrap to here --> 

<?php
	echo "";
?>