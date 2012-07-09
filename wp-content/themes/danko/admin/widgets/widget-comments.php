<?php
/*---------------------------------------------------------------------------------*/
/* Comments widget */
/*---------------------------------------------------------------------------------*/

class App_comments extends WP_Widget {

   function App_comments() {
  	   $widget_ops = array('description' => 'The Recent Comments Widget displays recent comments titles and their summaries in the sidebar. You can customize the number of comments to display.' );
       parent::WP_Widget(false, $name = __(THEME_NAME.' - Recent Comments', THEME_NAME), $widget_ops);
   }


   function widget($args, $instance) {        
		extract( $args );
        $com_title = $instance['com_title']; if ($com_title == '') $com_title = 'Recent Comments';
		$com_number = $instance['com_number']; if ($com_number == '') $com_number = 5;
		echo $before_widget;
		echo $before_title; ?>
		<?php echo $com_title; ?>
     	<?php echo $after_title; 
     	$exclude = array((int) get_option(THEME_NAME.'_info_category'),(int) get_option(THEME_NAME.'_slider_category'));
     	
     	
     	$args=array(
  'category__not_in' => $exclude,
  'showposts' => $com_number,
  'nopaging' => 0,
  'post_status' => 'publish',
  'ignore_sticky_posts' => 1
);
$my_query = null;

     	?>




<?php
wp_reset_query();
$recent_comments = get_comments( array(
    'number'    => $com_number,
    'status'    => 'approve'
) );

foreach($recent_comments as $comment) :
$pID = $comment->comment_post_ID ;
$permalink = get_permalink($pID);
    ?>
	 	<div class="app_recent_comm">

                                                            <div class="app_recent_img">
                                                                <a class="widget_h2" href="<?php echo $permalink; ?>"><?php echo get_avatar($comment,$size='50',$default='<path_to_url>' ); ?></a>
                                                            </div>
	
                                                                <div class="app_recent_box ">
                                                                        <span class="app_recent_title "><a href="<?php echo $permalink; ?>"><?php echo substr($comment->comment_content, 0, 40);?></a></span>
                                                                        <span class="app_recent_date"><?php echo $comment->comment_author?></span>
								</div>

                                                        </div>

<?php
endforeach;
?>


			<?php echo $after_widget; ?>
    
         <?php 
   }

   function update($new_instance, $old_instance) {                
       return $new_instance;
   }

   function form($instance) {     
       $com_title = esc_attr($instance['com_title']);
       $com_number = esc_attr($instance['com_number']);
      
	   
       ?> 
       <p>
       <label for="<?php echo $this->get_field_id('com_title'); ?>"><?php _e('Title:',THEME_NAME); ?>
       <input class="widefat" id="<?php echo $this->get_field_id('com_title'); ?>" name="<?php echo $this->get_field_name('com_title'); ?>" type="text" value="<?php echo $com_title; ?>" />
       </label>
       </p>     
       <p>
       <label for="<?php echo $this->get_field_id('com_number'); ?>"><?php _e('Number of comments:',THEME_NAME); ?>
       <input class="widefat" id="<?php echo $this->get_field_id('com_number'); ?>" name="<?php echo $this->get_field_name('com_number'); ?>" type="text" value="<?php echo $com_number; ?>" />
       </label>
       </p>
       <p>
       	Slideshow category and Info category are excluded from Recent Comments.
       </p>
       
       <?php 
   }

} 
register_widget('App_comments');
?>