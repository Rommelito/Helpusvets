<?php
/*---------------------------------------------------------------------------------*/
/* Recent widget */
/*---------------------------------------------------------------------------------*/

class App_Recent extends WP_Widget {

   function App_Recent() {
  	   $widget_ops = array('description' => 'The Recent Posts Widget displays recent post titles and their summaries in the sidebar. You can customize the number of posts to display.' );
       parent::WP_Widget(false, $name = __(THEME_NAME.' - Recent Posts', THEME_NAME), $widget_ops);    
   }


   function widget($args, $instance) {        
		extract( $args );
        $title = $instance['title']; if ($title == '') $title = 'Recent Posts';
		$number = $instance['number']; if ($number == '') $number = 5;
		
		echo $before_widget;
		echo $before_title; ?>
		<?php echo $title; ?>
     	<?php echo $after_title; 
     
     	
     	$args=array(
  
  'showposts' => $number,
  'nopaging' => 0,
  'post_status' => 'publish',
  'ignore_sticky_posts' => 1
);
$my_query = null;

     	?> 
     		
		<?php $the_query = new WP_Query($args);
			
		while ($the_query->have_posts()) : $the_query->the_post();
	
		$title = the_title('','',FALSE); 
		$newdots = "";
		if ($title<>substr($title,0,27)){ $newdots = "...";}else{$newdots = "";}?>
	
					
		<div class="app_recent_post">
				
			<?php
					$post_img = "";
					if (has_post_thumbnail()){
                                          $imagedata = simplexml_load_string(get_the_post_thumbnail());
                                          $post_img = $imagedata->attributes()->src;
								   	
                                                          ?>
				<div class="app_recent_img">
                                    <a href="<?php the_permalink(); ?>"><img src="<?php echo get_template_directory_uri();?>/script/timthumb.php?src=<?php print $post_img;?>&w=66&h=44&zc=1&q=100" alt="<?php echo substr($title,0,27);echo $newdots; ?>" class="app_recent_img_img" /></a>
				</div>

                    	<div class="app_recent_box">
                                    <div class="app_recent_title" id="post-<?php the_ID(); ?>">
						<a href="<?php the_permalink(); ?>" rel="bookmark" class="app_recent_title_a" title="Permanent Link to <?php echo substr($title,0,27).$newdots; ?>"><?php echo substr($title,0,27).$newdots; ?></a>
					</div>


					<div class="app_recent_date">
						Posted on <?php the_time('n');?>/<?php the_time('d');?>/<?php the_time('Y');?>
					</div>


				</div>		

				<?php }else{
                                    ?>
                    	<div class="app_recent_box_no_image">
                                    <div class="app_recent_title" id="post-<?php the_ID(); ?>">
						<a href="<?php the_permalink(); ?>" rel="bookmark" class="app_recent_title_a" title="Permanent Link to <?php echo substr($title,0,50).$newdots; ?>"><?php echo substr($title,0,75).$newdots; ?></a>
					</div>


					<div class="app_recent_date">
						Posted on <?php the_time('n');?>/<?php the_time('d');?>/<?php the_time('Y');?>
					</div>


				</div>		
                    <?php
                                } ?>
			
			</div>
					
			<?php endwhile; ?>
			
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
register_widget('App_Recent');
?>