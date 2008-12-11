<?php
/*
SuperSlider-Menu version: 0.1.0
Copyright 2008 Daiv Mowbray

This work is largely based on the Collapsing Categories plugin by Robert Felty
(http://blog.robfelty.com/plugins/collapsing-categories/), 
which was also distributed under the GPLv2. See the
CHANGELOG file for more information.

This file is part of SuperSlider-Menu

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

function add_feedlink($feed,$cat) {
		
		if ($feed=='text') 
		
		{
			$rssLink= '<a class="menuRss" href="' . get_category_feed_link($cat->term_id) .'">&nbsp;(RSS)</a>';
					
		} elseif ($feed=='image') {
		
			$rssLink= '<a class="menuRss" href="' . get_category_feed_link($cat->term_id) .'">&nbsp;<img src="' .get_settings(siteurl) .
				'/wp-content/plugins/superslider-menu/img/rss_out.png" alt="rss" /></a>';
				
		} else {
		
			$rssLink='';
		}
		
		return $rssLink;
}



function get_ssmsub_cat($cat, $categories, $parents, $posts, $subCatCount,$subCatPostCount,$number) 
		{ 
		
		global $options;
		
		extract($options[$number]);
	 
		$subCatPosts=array();
		
		$link2='';
	  

  
	  if (in_array($cat->term_id, $parents)) {
		
		foreach ($categories as $cat2) {
		  
		  $subCatLink2=''; // clear info from subCatLink2
		  
		  if ($cat->term_id==$cat2->parent) {
			// check to see if there are more subcategories under this one
			
			$subCatPostCount=$subCatPostCount+$cat2->count;
			
			if (!in_array($cat2->term_id, $parents)) {
				  $subCatCount = 0;
				
				/* $mycatid = ($cat2->term_id);
				 echo "This is my cat id ".$mycatid." to here.";
				 if (child_of($mycatid)){
					echo "I am child of cat ".$mycatid." to here.";
				 }*/
				 
					if ($linkToCat=='yes') 
					{
						$link2 = "<span class='catlink'><!-- catlink1 --><a href='".get_category_link($cat2->term_id)."' class='tool' ";
						
								$link2 .= 'title="'. 
									  sprintf(__("View all posts filed under %s"), 
									  wp_specialchars($cat2->name)) . '"';
						
								if ( empty($cat2->description) ) 
								{
								  $link2 .= 'rel="&nbsp;"';
								
								} else {
								  
								  $link2 .= 'rel="' . 
									  wp_specialchars(apply_filters('description', 
									  $cat2->description,$cat2)) . '"';
								}
								
						$link2 .= '>';
						$link2 .= apply_filters('list_cats', $cat2->name, $cat2).
							'</a></span>';
						 
						 
								if ($showPosts=='yes') 
								{
									
									$subCatLinks.=( 
										"<dt class='ssmToggleBar ".$cat2->slug."' >".
										"<span class='subsym show_2'>&nbsp;</span>" );
								
								} else {
									
									$subCatLinks.=( "<!-- this is dd-1 --><dd class='ssMenuPost name1'>" );
								}
						
					} else {
							$link2 = "<span><!-- catlink2 --><a href='".get_category_link($cat2->term_id)."' class='tool' ";
								
								$link2 .= 'title="'. 
									  sprintf(__("View all posts filed under %s"), 
									  wp_specialchars($cat2->name)) . '"';
									  
								if ( empty($cat2->description) ) 
								{
								  
								  $link2 .= 'rel="&nbsp;"';
									  
								} else {
								  
								  $link2 .= 'rel="' . 
									  wp_specialchars(apply_filters('description', 
									  $cat2->description,$cat2)) . '"';
								}
								
							$link2 .= '>';
							
							$link2 .= apply_filters('list_cats', $cat2->name, $cat2).
								'</a></span></dt><!--this ends dt-1 -->';
				
								if ($showPosts=='yes') 
								{
									  
									$link2 = apply_filters('list_cats', $cat2->name, $cat2) . "</dt><!--this ends dt-2 -->";
									$subCatLinks.= "<dt class='ssmToggleBar ".$cat2->slug."' >" . "<span class='subsym show_2'>&nbsp;</span></dt><!--this ends dt-3 -->";
								} else {
								
									$subCatLinks.=( "<dt class='ssMenuPost".$cat2->slug."'>" );
								
								}
						}
		   
       
       } else {
          list ($subCatLink2, $subCatCount,$subCatPostCount,$subCatPosts)= 
              get_ssmsub_cat($cat2, $categories, $parents, $posts, $subCatCount,
              $subCatPostCount, $number);
         
          $subCatCount=1;
          
          if ($linkToCat=='yes') {
            
              $subCatLinks.=( 
                  "<dt class='ssmToggleBar ".$cat2->slug."' >".
                  "<span class='subsym show_2'>&nbsp;</span>" );
        
                $link2 = "<a href='".get_category_link($cat2->term_id)."' class='tool' ";
                
                	$link2 .= 'title="'. 
						  sprintf(__("View all posts filed under %s"), 
						  wp_specialchars($cat2->name)) . '"';
						  
                if ( empty($cat2->description) ) 
                {
					  $link2 .= 'rel="&nbsp;"';
                } else {
                  
                  $link2 .= 'rel="' . 
                      wp_specialchars(apply_filters('description', 
                      $cat2->description,$cat2)) . '"';
                }
                
                $link2 .= '>';
                $link2 .= apply_filters('list_cats', $cat2->name, $cat2).'</a>';
                
          } else {
          
				if ($showPosts=='yes') {
				
				  $link2 = apply_filters('list_cats', $cat2->name,
					  $cat2).'</dt><!--this ends dt-5 -->';
				  $subCatLinks.=
					  "<dt class='ssmToggleBar ".$cat2->slug."' >".
					  "<span class='subsym  show_2'>&nbsp;</span>";
				} else {
				
				  $subCatLinks.=
					  "<dt class='ssmToggleBar ".$cat2->slug."' >".
					  "<span class='subsym show_2'>&nbsp;</span>";
				  $link2 = apply_filters('list_cats', $cat2->name,
					  $cat2).'</dt><!--this ends dt-6 -->';
				  
				}
          }
        
        }
        

        if( $showPostCount=='yes') {
        
			  list ($subCatLink3, $subCatCount2,$subCatPostCount2,$subCatPosts2)=
				  get_ssmsub_cat($cat2, $categories, $parents, $posts,0,0,$number);
			  
			  $theCount = $subCatPostCount2 + $cat2->count;
			  
			  $rssLink = add_feedlink($catfeed,$cat2);
			  
			  $link2 .= ' ('.$theCount.')'.$rssLink.'</dt><!--this is dt-7 -->';
			  //add the rss link and move dt close bellow 
			  
        }
        
        $subCatLinks.= $link2 ;
        
        if (($subCatCount>0) || ($showPosts=='yes')) {
         
         $subCatLinks.="\n<!-- this is dd-2 --><dd class='showme_2' >\n";//<dl>
        
        }
          if ($showPosts=='yes') {
            
            foreach ($posts as $post2) {
              
              if ($post2->term_id == $cat2->term_id) {
                
                array_push($subCatPosts, $post2->id);
                $date=preg_replace("/-/", '/', $post2->date);
                $name=$post2->post_name;
                $subCatLinks.= "<span class='ssMenuPost sublink'><!-- link 6 --><a href='".get_permalink($post2->id)."'>" .  strip_tags($post2->post_title) . "</a></span>\n";

              }
            }
          }
        // add in additional subcategory information
        
        $subCatLinks.="$subCatLink2";
        // close <dl><!-- this is dl-1 --> and <!-- this is dd-3 --><dd> before starting a new category
        
        if (($subCatCount>0) || ($showPosts=='yes')) {
        
			$subCatLinks.= "</dd><!-- ending subcategory dd -->\n";
        
        }
        // $subCatLinks.= "         </dl> <!-- ending subcategory dl-->\n";
      }
    }
  }
  return array($subCatLinks,$subCatCount,$subCatPostCount,$subCatPosts);
}

function ssm_list_categories($number) {

		global $wpdb,$options, $autoExpand;
		
		$options=get_option('ssMenu_widget_options');
		
		extract($options[$number]);
		
		$inExclusions = array();
		
				if ( !empty($inExclude) && !empty($inExcludeCats) ) 
				{
				   $exterms = preg_split('/[,]+/',$inExcludeCats);
						if ($inExclude=='include') 
						{
							$in='IN';
						
						} else {
						
							$in='NOT IN';
						
						}
						if ( count($exterms) ) 
						{
							
							foreach ( $exterms as $exterm ) 
							{
								if (empty($inExclusions))
									$inExclusions = "'" . sanitize_title($exterm) . "'";
								else
									$inExclusions .= ", '" . sanitize_title($exterm) . "' ";
							}
						}
				}
				
				if ( empty($inExclusions) ) 
				{
					$inExcludeQuery = "''";
					
				} else {
				
					$inExcludeQuery ="AND $wpdb->terms.name $in ($inExclusions)";
				}

			$isPage='';
			
				if ($showPages=='no')
				{
					$isPage="AND $wpdb->posts.post_type='post'";
				}
				if ($catSort!='') {
					if ($catSort=='catName') 
					{
					$catSortColumn="ORDER BY $wpdb->terms.name";
					
					} elseif ($catSort=='catId') 
					{
					  $catSortColumn="ORDER BY $wpdb->terms.term_id";
					  
					} elseif ($catSort=='catSlug') 
					{
					  $catSortColumn="ORDER BY $wpdb->terms.slug";
					  
					} elseif ($catSort=='catOrder') 
					{
					  $catSortColumn="ORDER BY $wpdb->terms.term_order";
					  
					} elseif ($catSort=='catCount') 
					{
					  $catSortColumn="ORDER BY $wpdb->term_taxonomy.count";
					}
			  	} 
				if ($postSort!='') {
					if ($postSort=='postDate') 
					{
					  $postSortColumn="ORDER BY $wpdb->posts.post_date";
					
					} elseif ($postSort=='postId') 
					{
					  $postSortColumn="ORDER BY $wpdb->posts.id";
					  
					} elseif ($postSort=='postTitle') 
					{
					  $postSortColumn="ORDER BY $wpdb->posts.post_title";
					  
					} elseif ($postSort=='postComment') 
					{
					  $postSortColumn="ORDER BY $wpdb->posts.comment_count";
					}
				} 
				
				if ($defaultExpand!='') 
				{
					$autoExpand = preg_split('/,\s*/',$defaultExpand);
			
				} else {
			  
					$autoExpand = array();
			
				}

 	 echo "\n<div id='ssMenuHolder'><dl id='ssMenuList'><!-- this is dl-1 -->\n";

		$catquery = "SELECT $wpdb->term_taxonomy.count as 'count',
			$wpdb->terms.term_id, $wpdb->terms.name, $wpdb->terms.slug,
			$wpdb->term_taxonomy.parent, $wpdb->term_taxonomy.description FROM
			$wpdb->terms, $wpdb->term_taxonomy WHERE $wpdb->terms.term_id =
			$wpdb->term_taxonomy.term_id AND $wpdb->terms.name != 'Blogroll' AND
			$wpdb->term_taxonomy.taxonomy = 'category' $inExcludeQuery $catSortColumn
			$catSortOrder";
		$postquery = "SELECT $wpdb->terms.term_id, $wpdb->terms.name,
			$wpdb->terms.slug, $wpdb->term_taxonomy.count, $wpdb->posts.id,
			$wpdb->posts.post_title, $wpdb->posts.post_name,
			date($wpdb->posts.post_date) as 'date' FROM $wpdb->posts, $wpdb->terms,
			$wpdb->term_taxonomy, $wpdb->term_relationships  WHERE $wpdb->posts.id =
			$wpdb->term_relationships.object_id AND $wpdb->posts.post_status='publish'
			AND $wpdb->terms.term_id = $wpdb->term_taxonomy.term_id AND
			$wpdb->term_relationships.term_taxonomy_id =
			$wpdb->term_taxonomy.term_taxonomy_id AND $wpdb->term_taxonomy.taxonomy =
			'category' $isPage $postSortColumn $postSortOrder";
				/* changing to use only one query 
				 * don't forget to exclude pages if so desired
				 */
			  
			  $categories = $wpdb->get_results($catquery);
			  
			  $posts= $wpdb->get_results($postquery); 
			  
			  $parents=array();
			  
			  foreach ($categories as $cat) 
			  {
					if ($cat->parent!=0) 
					{
					  array_push($parents, $cat->parent);
					
					}
			  }
			  
			  /*
			  echo "<pre>";
			  echo "$postquery\n";
			  print_r($posts);
			  echo "$catquery\n";
			  echo "</pre>";
			  */
  
  foreach( $categories as $cat ) {
    if ($cat->parent==0) 
    {
			//$lastCat= $cat->term_id;

			$rssLink=add_feedlink($catfeed,$cat);
			$subCatPostCount=0;
			$subCatCount=0;
			
			list ($subCatLinks, $subCatCount,$subCatPostCount, $subCatPosts)=
			get_ssmsub_cat($cat, $categories, $parents, $posts, 
			$subCatCount,$subCatPostCount,$number);
        
			$theCount=$cat->count+$subCatPostCount;
        
        if ($theCount>0) 
        {
      
				  /*
				  echo "subCatPostCount is " .$subCatPostCount."<br />" ;
				  echo "subpostcount is " .$subCatCount."<br />" ;
				  $smcplus = ($smcplus+1);
				  echo "smcplus is " .$smcplus."<br />" ;
				  $smartcount = "smc".$smcplus."<br />";
				  echo "smartcount is " .$smartcount."<br />" ;*/
          

				if ($linkToCat=='yes') 
				{
					$link = "<a href='".get_category_link($cat->term_id)."' class='tool' ";
						
							$link .= 'title="'. sprintf(__("View all entries filed under %s"), wp_specialchars($cat->name)) . '"';
								
						if ( empty($cat->description) ) 
						{
							$link .= 'rel="&nbsp;"';
						} else {
							
							$link .= 'rel="' . wp_specialchars(apply_filters('description',$cat->description,$cat)) . '"';
						}
					
					$link .= '>';
					$link .= apply_filters('list_cats', $cat->name, $cat).'</a>';
						
						if ($showPosts=='yes' || $subCatPostCount>0) 
						{
						  print( "<dt class='ssmToggleBar ".$cat2->slug."'> ".
						  "<span class='subsym show_1'>&nbsp;</span>" );
						}
						
				} else {
				
					print( "<dt class='ssmToggleBar ".$cat2->slug."'><span class='subsym show_1'>&nbsp;</span>" );
				}
				
        } else {
			
				if ($showPosts=='yes') 
				{
					$link = apply_filters('list_cats', $cat->name, $cat) . '';
					  print( "<dt class='ssmToggleBar ".$cat->slug."'>".
						  "<dt class='ssMenu'> ".                  
						  "<span class='show_1 subsym'>&nbsp;</span>");
				} else {
				
				// don't include the triangles if posts are not shown and there
				// are no more subcategories
						if ($subCatPostCount>0) 
						{
							  $link = apply_filters('list_cats', $cat->name, $cat).'';
								print( "<dt class='ssmToggleBar ".$cat->slug."'>".
									"<span class='show_1 subsym'>&nbsp;</span>");
						} else {
							
							$link = "<span class='catlink'><!-- link 8 --><a href='".get_category_link($cat->term_id)."' class='tool'";
							 
							 	$link .= 'title="'. 
											sprintf(__("View all entries filed under %s"),
											wp_specialchars($cat->name)) . '">';
											
								 if ( empty($cat->description) ) 
								 {
										$link .= 'rel="&nbsp;" ';
								  } else {
								  
										$link .= 'rel="' . wp_specialchars(apply_filters(
											'description',$cat->description,$cat)) . '"';
								  }
							  
							  $link .= '>';
							  $link .= apply_filters('list_cats', $cat->name, $cat).'</a></span>';
							  print( "<dt class='ssMenu'>" );
						} 
			   
				}
        }
     
			if( $showPostCount=='yes') 
			{        
					$link .= ' (' . $theCount.')'.$rssLink.'</dt><!--this is dt-8 -->';
			
			} else {
				
					$link .= ''.$rssLink.'</dt><!--this is dt-9 -->';
			}
			
		print( $link );
        
			if (($subCatPostCount>0) || ($showPosts=='yes')) 
			{
					print( "\n<!-- this is dd-4 --><dd class=\"showme_1 ".$cat->name." \">\n" );
			}
        
		echo "<dl><!-- this is dl-2 -->";
        
		echo $subCatLinks;
       
       // Now print out the post info
			if( ! empty($posts) ) {
          
				  if ($showPosts=='yes') 
				  {
					
					foreach ($posts as $post) {
							
							if (($post->term_id == $cat->term_id) && (!in_array($post->id, $subCatPosts))) 
							{
								$date=preg_replace("/-/", '/', $post->date);
								
								$name=$post->post_name;
								
								echo "          <span class='ssMenuPost sublink'><!-- link 9 --><a href='".
									get_permalink($post->id)."'>" .  
									strip_tags($post->post_title) . "</a></span>\n";
							}
					}
            
			}
			
			if ($subCatCount=1) 
			{
				echo "</dl><!-- this is dl-2 --><!-- ending second level with sub cats -->\n ";
			}
			
			if ($subCatPostCount>0 || $showPosts=='yes') 
			{
				echo "</dd><!-- ending first level category -->\n";
			}
        
        // echo "      </dl> <!-- ending category dl-->\n";//this should only  write if it's a new level
        }
      } // end if theCount>0
    }
      echo "</dl></div><!-- this is dl-1 -->\n";
 }
?>