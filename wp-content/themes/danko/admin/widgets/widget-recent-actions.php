<?php
/*---------------------------------------------------------------------------------*/
/* Recent widget */
/*---------------------------------------------------------------------------------*/

class App_Recent_Actions extends WP_Widget {

   function App_Recent_Actions() {
  	   $widget_ops = array('description' => 'The Recent Posts Widget displays recent post titles and their summaries in the sidebar. You can customize the number of posts to display.' );
       parent::WP_Widget(false, $name = __(THEME_NAME.' - Recent Actions', THEME_NAME), $widget_ops);
   }


   function widget($args, $instance) {        
		extract( $args );
        $title = $instance['title']; if ($title == '') $title = 'Recent Actions';
		$number = $instance['number']; if ($number == '') $number = 5;
		
		echo $before_widget;
		echo $before_title; ?>
		<?php echo $title; ?>
                <?php echo $after_title;?> 
            <?php
		$blog_category = get_option(THEME_NAME.'_our_actions_category');
                $categories = get_categories('orderby=name');
                $include_category = null;
                $slug = get_page_link();
                $allcat = implode(',', $blog_category);

            $paged = (get_query_var('paged')) ? get_query_var('paged') : 0;
            $args=array('cat'=>$allcat, 'post_status' => 'publish', 'order'=> 'ASC', 'showposts' => $number, 'ignore_sticky_posts'=> 1, 'meta_key'=>'_thumbnail_id');

            //The Query
            query_posts($args);
            $i=1;
            //The Loop
           
            if ( have_posts() ) : while ( have_posts() ) : the_post();
            
                    $post_img = "";
                    if (has_post_thumbnail()) {
                        $imagedata = simplexml_load_string(get_the_post_thumbnail());
                        if(!empty($imagedata)) {
                            $post_img = $imagedata->attributes()->src;
                        }
                    
                    }

                     if($i % 3 == 0) {
                     $lastclass = "lastclass";
                        }
                        else {
                            $lastclass = "";
                        }
                    ?>
	
			<?php
                            $post_img = "";
                            if (has_post_thumbnail()){
                              $imagedata = simplexml_load_string(get_the_post_thumbnail());
                              $post_img = $imagedata->attributes()->src;
								   	
                         ?>



				<div class="recent-actions-img left <?php echo $lastclass; ?>">
                                    <a href="<?php the_permalink(); ?>"><img src="<?php echo get_template_directory_uri();?>/script/timthumb.php?src=<?php print $post_img;?>&w=65&h=61&zc=1&q=100" alt="<?php echo substr($title,0,27);?>" class="app_recent_img_img" /></a>
				</div>

                
                                <?php $i++;  ?>
				<?php } ?>
			
			
					
			<?php endwhile; ?>
			 <?php else: ?>
            <?php endif; ?>
			<?php echo $after_widget; ?>
    
         <?php 
   }

   function update($new_instance, $old_instance) {                
       return $new_instance;
   }

   function form($instance) {  
   	if(isset($instance['title'])){   
       $title = esc_attr($instance['title']);
   	}else{
   		$title = "";
   	}
   	if(isset($instance['number'])){
       $number = esc_attr($instance['number']);
   	}else{
   		$number = "";
   	}
	   
       ?> 
       <p>
       <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:',THEME_NAME); ?>
       <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
       </label>
       </p>     
       <p>
       <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts:',THEME_NAME); ?>
       <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
       </label>
       </p>
       <p>
       	Slideshow category and Info category are excluded from Recent posts.
       </p>

       <?php 
   }

}
register_widget('App_Recent_Actions');
?>