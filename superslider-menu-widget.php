<?php

	function ss_menu_widget($args, $widget_args=1) {

	  extract($args, EXTR_SKIP);
	  
	  if ( is_numeric($widget_args) )
	    $widget_args = array( 'number' => $widget_args );
	  $widget_args = wp_parse_args( $widget_args, array( 'number' => -1 ) );
	  extract($widget_args, EXTR_SKIP);
	
	  $options = get_option('ssMenu_widget_options');
	  if ( !isset($options[$number]) )
	    return;
	
	  $title = ($options[$number]['title'] != "") ? $options[$number]['title'] : ""; 
	
	  if ( !empty( $title ) ){ echo $before_widget . $before_title . $title . $after_title;}
	       
	    if(method_exists('ssMenu','foldcats')) {
//echo'about to make a widget';
	        ssMenu::foldcats($number);
	       } else {
	        echo "<ul>\n";
	        wp_list_cats('sort_column=name&optioncount=1&hierarchical=0');
	        echo "</ul>\n";
	       }
	
	    echo $after_widget;
	  }
	

	function ss_menu_widget_init() {
		
		if ( !$options = get_option('ssMenu_widget_options') )
		    $options = array();
		  $control_ops = array('width' => 400, 'height' => 400, 'id_base' => 'ss_menu');
			$widget_ops = array('classname' => 'ss_menu', 'description' =>
		  __('Animated expanding category menu to show subcategories and/or posts'));
		  $name = __('SuperSlider Menu');
		  $id = false;
		  
		foreach ( array_keys($options) as $o ) 
		{// Old widgets can have null values for some reason
			if ( !isset($options[$o]['title']) || !isset($options[$o]['title']) )
	      continue;
			$id = "ss_menu-$o"; // Never never never translate an id
			wp_register_sidebar_widget($id, $name, 'ss_menu_widget', $widget_ops, array( 'number' => $o ));
			wp_register_widget_control($id, $name, 'ss_menu_widgetControl', $control_ops, array( 'number' => $o ));
	//echo 'register_sidebar_widget is here';
		}
		
		  // If there are none, we register the widget's existance with a generic template
		  if ( !$id ) 
		  {
		
		    wp_register_sidebar_widget('ss_menu-1', $name, 'ss_menu_widget', $widget_ops, array( 'number' => -1 ) );
		    wp_register_widget_control('ss_menu-1', $name, 'ss_menu_widgetControl', $control_ops, array( 'number' => -1 ) );
			
			
		    //register_sidebar_widget( 'ss_menu-1', 'ss_menu_widget' );
		    //register_widget_control( 'ss_menu-1', 'ss_menu_widgetControl' );

		  }
		
	}

	// Run our code later in case this loads prior to any required plugins.
	if (method_exists('ssMenu','foldcats')) {
		//add_action('plugins_loaded', 'ss_menu_widget_init');
		ss_menu_widget_init();
	} else {
//echo'can not find foldcats';
		$fname = basename(__FILE__);
		$current = get_settings('active_plugins');
		array_splice($current, array_search($fname, $current), 1 ); // Array-fu!
		update_option('active_plugins', $current);
		do_action('deactivate_' . trim($fname));
		header('Location: ' . get_settings('siteurl') . '/wp-admin/plugins.php?deactivate=true');
		exit;
	}

	function ss_menu_widgetControl($widget_args) {
		
	  global $wp_registered_widgets;
	  static $updated = false;
	
	  if ( is_numeric($widget_args) )
	    $widget_args = array( 'number' => $widget_args );
	  $widget_args = wp_parse_args( $widget_args, array( 'number' => -1 ) );
	  extract( $widget_args, EXTR_SKIP );
	
	  $options = get_option('ssMenu_widget_options');
	  if ( !is_array($options) )
	    $options = array();
	
	  if ( !$updated && !empty($_POST['sidebar']) ) {
	    $sidebar = (string) $_POST['sidebar'];
	
	    $sidebars_widgets = wp_get_sidebars_widgets();
	    if ( isset($sidebars_widgets[$sidebar]) )
	      $this_sidebar =& $sidebars_widgets[$sidebar];
	    else
	      $this_sidebar = array();
	
	    foreach ( $this_sidebar as $_widget_id ) {
	      if ( 'ss_menu_widget' == $wp_registered_widgets[$_widget_id]['callback'] && isset($wp_registered_widgets[$_widget_id]['params'][0]['number']) ) {
	        $widget_number = $wp_registered_widgets[$_widget_id]['params'][0]['number'];
	        if ( !in_array( "ss_menu-$widget_number", $_POST['widget-id'] ) ) // the widget has been removed.
	          unset($options[$widget_number]);
	      }
	    }
	
	    foreach ( (array) $_POST['ss_menu'] as $widget_number => $ss_menu ) {
	      if ( !isset($ss_menu['title']) && isset($options[$widget_number]) ) // user clicked cancel
	        continue;
	      $title = strip_tags(stripslashes($ss_menu['title']));
	      $catSortOrder= 'ASC' ;
	      if($ss_menu['catSortOrder'] == 'DESC') {
	        $catSortOrder= 'DESC' ;
	      }
	      $showPosts= 'yes' ;
	      if($ss_menu['showPosts'] == 'no') {
	        $showPosts= 'no' ;
	      }
	     /**/ 
	      $linkToCat= 'yes' ;
	      if($ss_menu['linkToCat'] == 'no') {
	        $linkToCat= 'no' ;
	      }
	      $showPostCount= 'no' ;
	      if( isset($ss_menu['showPostCount'])) {
	        $showPostCount= 'yes' ;
	      }
	      $showPages= 'no' ;
	      if( isset($ss_menu['showPages'])) {
	        $showPages= 'yes' ;
	      }
	      if($ss_menu['catSort'] == 'catName') {
	        $catSort= 'catName' ;
	      } elseif ($ss_menu['catSort'] == 'catId') {
	        $catSort= 'catId' ;
	      } elseif ($ss_menu['catSort'] == 'catSlug') {
	        $catSort= 'catSlug' ;
	      } elseif ($ss_menu['catSort'] == 'catOrder') {
	        $catSort= 'catOrder' ;
	      } elseif ($ss_menu['catSort'] == 'catCount') {
	        $catSort= 'catCount' ;
	      } elseif ($ss_menu['catSort'] == '') {
	        $catSort= '' ;
	        $catSortOrder= '' ;
	      }
	      $postSortOrder= 'ASC' ;
	      if($ss_menu['postSortOrder'] == 'DESC') {
	        $postSortOrder= 'DESC' ;
	      }
	      if($ss_menu['postSort'] == 'postTitle') {
	        $postSort= 'postTitle' ;
	      } elseif ($ss_menu['postSort'] == 'postId') {
	        $postSort= 'postId' ;
	      } elseif ($ss_menu['postSort'] == 'postComment') {
	        $postSort= 'postComment' ;
	      } elseif ($ss_menu['postSort'] == 'postDate') {
	        $postSort= 'postDate' ;
	      } elseif ($ss_menu['postSort'] == '') {
	        $postSort= '' ;
	        $postSortOrder= '' ;
	      }
	     
	      $catfeed= $ss_menu['catfeed'];
	      $inExclude= 'include' ;
	      if($ss_menu['inExclude'] == 'exclude') {
	        $inExclude= 'exclude' ;
	      }
	     
	      $inExcludeCats=addslashes($ss_menu['inExcludeCats']);
	      
	      $options[$widget_number] = compact( 'title','showPostCount','catSort',
	          'catSortOrder','expand','inExclude', 'showPosts',
	          'inExcludeCats','postSort','postSortOrder','showPages', 
	          'catfeed','linkToCat' );
	    }
	
	    update_option('ssMenu_widget_options', $options);
	    $updated = true;
	  }
	
	 if ( -1 == $number ) {
	    /* default options go here */
	    $title = 'SuperSlider-Menu';
	    $showPostCount = 'yes';
	    $catSort = 'catName';
	    $catSortOrder = 'ASC';
	    $postSort = 'postTitle';
	    $postSortOrder = 'ASC';
	    $number = '%i%';
	    $inExclude='include';
	    $inExcludeCats='';
	    $showPosts='yes';
	    $linkToCat='yes';
	    $showPages='no';
	    $catfeed='none';
	  } else {
	    $title = attribute_escape($options[$number]['title']);
	    $showPostCount = $options[$number]['showPostCount'];
	    $inExcludeCats = $options[$number]['inExcludeCats'];
	    $inExclude = $options[$number]['inExclude'];
	    $catSort = $options[$number]['catSort'];
	    $catSortOrder = $options[$number]['catSortOrder'];
	    $postSort = $options[$number]['postSort'];
	    $postSortOrder = $options[$number]['postSortOrder'];;
	    $showPosts = $options[$number]['showPosts'];
	    $showPages = $options[$number]['showPages'];
	    $linkToCat = $options[$number]['linkToCat'];
	    $catfeed = $options[$number]['catfeed'];
	  }

    // Here is our little form segment.

    echo '<p style="text-align:left;"><label for="ss_menu-title-'.$number.'">' . __('Title:') . '<input class="widefat" style="width: 200px;" id="ss_menu-title-'.$number.'" name="ss_menu['.$number.'][title]" type="text" value="'.$title.'" /></label></p>';
  ?>
	
	<p>This is control<br />
		<input type="checkbox" name="ss_menu[<?php echo $number ?>][showPostCount]" 
	<?php if ($showPostCount=='yes')  echo 'checked'; ?>
		id="ss_menu-showPostCount-
	<?php echo $number ?>
		">
		</input>
		<label for="ss_menuShowPostCount">
			Show Post Count 
		</label>
		<input type="checkbox" name="ss_menu[<?php echo $number ?>][showPages]" 
	<?php if ($showPages=='yes')  echo 'checked'; ?>
		id="ss_menu-showPages-
	<?php echo $number ?>
		">
		</input>
		<label for="ss_menuShowPages">
			Show Pages as well as posts 
		</label>
	</p>
	<p>
		Sort Categories by:
		<br />
		<select name="ss_menu[<?php echo $number ?>][catSort]">
			<option 
	<?php if($catSort=='catName') echo 'selected'; ?>
			id="sortName" value='catName'> category name
			</option>
			<option 
	<?php if($catSort=='catId') echo 'selected'; ?>
			id="sortId" value='catId'> category id
			</option>
			<option 
	<?php if($catSort=='catSlug') echo 'selected'; ?>
			id="sortSlug" value='catSlug'> category Slug
			</option>
			<option 
	<?php if($catSort=='catOrder') echo 'selected'; ?>
			id="sortOrder" value='catOrder'> category (term) Order
			</option>
			<option 
	<?php if($catSort=='catCount') echo 'selected'; ?>
			id="sortCount" value='catCount'> category Count
			</option>
		</select>
		<input type="radio" name="ss_menu[<?php echo $number ?>][catSortOrder]" 
	<?php if($catSortOrder=='ASC') echo 'checked'; ?>
		id="ss_menu-catSortASC-
	<?php echo $number ?>
		" value='ASC'>
		</input>
		<label for="ss_menuCatSortASC">
			Ascending
		</label>
		<input type="radio" name="ss_menu[<?php echo $number ?>][catSortOrder]" 
	<?php if($catSortOrder=='DESC') echo 'checked'; ?>
		id="ss_menu-catSortDESC-
	<?php echo $number ?>
		" value='DESC'>
		</input>
		<label for="ss_menuCatSortDESC">
			Descending
		</label>
	</p>
	<p>
		Sort Posts by:
		<br />
		<select name="ss_menu[<?php echo $number ?>][postSort]">
			<option 
	<?php if($postSort=='postTitle') echo 'selected'; ?>
			id="sortPostTitle-
	<?php echo $number ?>
			" value='postTitle'>Post Title
			</option>
			<option 
	<?php if($postSort=='postId') echo 'selected'; ?>
			id="sortPostId-
	<?php echo $number ?>
			" value='postId'>Post id
			</option>
			<option 
	<?php if($postSort=='postDate') echo 'selected'; ?>
			id="sortPostDate-
	<?php echo $number ?>
			" value='postDate'>Post Date
			</option>
			<option 
	<?php if($postSort=='postComment') echo 'selected'; ?>
			id="sortComment-
	<?php echo $number ?>
			" value='postComment'>Post Comment Count
			</option>
		</select>
		<input type="radio" name="ss_menu[<?php echo $number ?>][postSortOrder]" 
	<?php if($postSortOrder=='ASC') echo 'checked'; ?>
		id="postSortASC" value='ASC'>
		</input>
		<label for="postPostASC">
			Ascending
		</label>
		<input type="radio" name="ss_menu[<?php echo $number ?>][postSortOrder]" 
	<?php if($postSortOrder=='DESC') echo 'checked'; ?>
		id="postPostDESC" value='DESC'>
		</input>
		<label for="postPostDESC">
			Descending
		</label>
	</p>
	<p>Expanding shows:<br />
     <input type="radio" name="ss_menu[<?php echo $number ?>][showPosts]" 
     <?php if($showPosts=='yes') echo 'checked'; ?> id="showPostsYes" value='yes'></input> <label for="showPostsYes">Sub-categories and Posts</label>
     <input type="radio" name="ss_menu[<?php echo $number ?>][showPosts]"
     <?php if($showPosts=='no') echo 'checked'; ?> id="showPostsNo" value='no'></input> <label for="showPostsNO">Just Sub-categories</label>
    </p>


	<p>
	<select name="ss_menu[<?php echo $number ?>][inExclude]">
		<option 
<?php if($inExclude=='include') echo 'selected'; ?>
		id="inExcludeInclude-
<?php echo $number ?>
		" value='include'>Include
		</option>
		<option 
<?php if($inExclude=='exclude') echo 'selected'; ?>
		id="inExcludeExclude-
<?php echo $number ?>
		" value='exclude'>Exclude
		</option>
	</select>
	these categories (separated by commas):
	<br />
	<input type="text" name="ss_menu[<?php echo $number ?>][inExcludeCats]" value="<?php echo $inExcludeCats ?>" id="ss_menu-inExcludeCats-<?php echo $number ?>">
	</input>
<p>
	Include RSS link <input type="radio" name="ss_menu[<?php echo $number ?>][catfeed]" 
<?php if($catfeed=='none') echo 'checked'; ?>
	id="ss_menu-catfeedNone-
<?php echo $number ?>
	" value='none'>
	</input>
	<label for="ss_menu-catfeedNone">
		None
	</label>
	<input type="radio" name="ss_menu[<?php echo $number ?>][catfeed]" 
<?php if($catfeed=='text') echo 'checked'; ?>
	id="ss_menu-catfeedText-
<?php echo $number ?>
	" value='text'>
	</input>
	<label for="ss_menu-catfeedYes">
		text (RSS)
	</label>
	<input type="radio" name="ss_menu[<?php echo $number ?>][catfeed]" 
<?php if($catfeed=='image') echo 'checked'; ?>
	id="ss_menu-catfeedImage-
<?php echo $number ?>
	" value='image'>
	</input>
	<label for="catfeedImage">
		image 
		<img src='../wp-includes/images/rss.png' />
	</label>
</p>
</p>
<?php
    echo '<input type="hidden" id="ss_menu-submit-'.$number.'" name="ss_menu['.$number.'][submit]" value="1" />';
	}
?>
