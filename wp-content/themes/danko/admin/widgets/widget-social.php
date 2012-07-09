<?php
/*---------------------------------------------------------------------------------*/
/* Recent widget */
/*---------------------------------------------------------------------------------*/

class App_Social extends WP_Widget {

   function App_Social() {
  	   $widget_ops = array('description' => 'The Social Icons displays links to pages that are linked to..' );
       parent::WP_Widget(false, $name = __(THEME_NAME.' - Subscribe & Follow', THEME_NAME), $widget_ops);
   }




   function widget($args, $instance) {        
		extract( $args );
                $title = $instance['title']; if ($title == '') $title = 'Subscribe & Follow';
                $facebook = $instance['facebook']; if ($facebook == '') $facebook = '';
                $twitter = $instance['twitter']; if ($twitter == '') $twitter = '';
                $rss = $instance['rss']; if ($rss == '') $rss = '';
                $googleplus = $instance['googleplus']; if ($googleplus == '') $googleplus = '';
			
		
		echo $before_title; ?>
		
     	<?php echo $after_title; ?>
     
     	<div class="sidebar_widget_holder">
		 <div id="subscribe-follow">
                     <div class="social-top">
                        <h3>
                               <?php echo $title; ?>
                        </h3>
                     </div>
      <div class="social-middle">
                      <?php if (!empty($facebook)) {  ?>
                            <div class="subscribe-follow-icons left">
                              <a href="<?php echo 'http://facebook.com/'.$facebook?>">
                               <div class="subscribe-follow-images left"><img src="<?php echo get_template_directory_uri(); ?>/style/img/subscribe-follow-images3.png" alt="img" title="img" /></div>
                                <div class="subscribe-follow-text">
                                    Connect on facebook
                                </div>
                              </a>
                            </div>
                        <?php } ?>
                    
              
                 
                           <div class="subscribe-follow-icons left">
                             <?php if(!empty ($rss)){$echo_this = $rss;}else{$echo_this = get_bloginfo('rss2_url');} ?>
                               <a href="<?php echo $echo_this?>">  <div class="subscribe-follow-images left"><img src="<?php echo get_template_directory_uri(); ?>/style/img/subscribe-follow-images1.png" alt="img" title="img" /></div>
                                <div class="subscribe-follow-text">
                                    Connect on Rss
                                </div></a>
                            </div>
                        
                     <?php if (!empty($googleplus)) {  ?>
                        <div class="subscribe-follow-icons left">
                         <a href="<?php echo 'https://plus.google.com/'.$googleplus?>">
                            <div class="subscribe-follow-images left"><img src="<?php echo get_template_directory_uri(); ?>/style/img/subscribe-follow-images4.png" alt="img" title="img" /></div>
                            <div class="subscribe-follow-text">
                              Connect on Google Plus
                            </div>
                         </a>
                        </div>
                    <?php } ?>

              
                        <?php if (!empty($twitter)) {  ?>
                            <div class="subscribe-follow-icons left">
                                <a href="<?php echo 'http://twitter.com/'.$twitter?>"> <div class="subscribe-follow-images left"><img src="<?php echo get_template_directory_uri(); ?>/style/img/subscribe-follow-images2.png" alt="img" title="img" /></div>
                                <div class="subscribe-follow-text">
                                   Connect on twitter
                                </div></a>
                            </div>
                        <?php } ?>

                       
                       
                        <div class="both"></div>
                        </div><!-- social middle -->

                        <div class="social-bottom"></div>
			</div>
					
			
			
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
        if(isset($instance['facebook'])){
       $facebook = esc_attr($instance['facebook']);
   	}else{
   		$facebook = "";
   	}
         if(isset($instance['rss'])){
       $rss = esc_attr($instance['rss']);
   	}else{
   		$rss = "";
   	}
         if(isset($instance['twitter'])){
       $twitter = esc_attr($instance['twitter']);
   	}else{
   		$twitter = "";
   	}
         if(isset($instance['googleplus'])){
       $googleplus = esc_attr($instance['googleplus']);
   	}else{
   		$googleplus = "";
   	}

        
	   
       ?> 
       <p>
       <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:',THEME_NAME); ?>
       <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
       </label>
       </p>

        <p>
       <label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook link:',THEME_NAME); ?>
       <input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo $facebook; ?>" />
       </label>
       </p>

       <p>
       <label for="<?php echo $this->get_field_id('rss'); ?>"><?php _e('Rss:',THEME_NAME); ?>
       <input class="widefat" id="<?php echo $this->get_field_id('rss'); ?>" name="<?php echo $this->get_field_name('rss'); ?>" type="text" value="<?php echo $rss; ?>" />
       </label>
       </p>

       <p>
       <label for="<?php echo $this->get_field_id('googleplus'); ?>"><?php _e('Google Plus:',THEME_NAME); ?>
       <input class="widefat" id="<?php echo $this->get_field_id('googleplus'); ?>" name="<?php echo $this->get_field_name('googleplus'); ?>" type="text" value="<?php echo $googleplus; ?>" />
       </label>
       </p>

       <p>
       <label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter Link:',THEME_NAME); ?>
       <input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo $twitter; ?>" />
       </label>
       </p>

       <p>
       	Put links to your social network profiles into the text fields.
       </p>
       
       <?php 
   }

} 
register_widget('App_Social');
?>