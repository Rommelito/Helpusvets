<?php 

	$key = GD_THEME;


	$meta_boxes_page = array(
		      	
		"title" => array(
		"name" => "seo_title",
		"title" => "SEO title?",
		"type" => "text",
		"description" => "Page title"),
	
		"description" => array(
		"name" => "seo_description",
		"title" => "Page description",
		"type" => "text",
		"description" => "Set page description"),
		
		"keywords" => array(
		"name" => "seo_keywords",
		"title" => "Page keywords",
		"type" => "text",
		"description" => "Set page keywords"),

                "headline" => array(
		"name" => "page_headline",
		"title" => "Page headline",
		"type" => "text",
		"description" => "Set page headline"),

		"headline_link" => array(
		"name" => "page_headline_link",
		"title" => "Page headline link",
		"type" => "text",
		"description" => "Set link for page headline"),
				
	);
	
	
	
	$meta_boxes_post = array(
	

		"title" => array(
		"name" => "seo_title",
		"title" => "SEO title?",
		"type" => "text",
		"description" => "Page title"),
	
		"description" => array(
		"name" => "seo_description",
		"title" => "Page description",
		"type" => "text",
		"description" => "Set page description"),
		
		"keywords" => array(
		"name" => "seo_keywords",
		"title" => "Page keywords",
		"type" => "text",
		"description" => "Set page keywords"),

                "headline" => array(
		"name" => "page_headline",
		"title" => "Post headline",
		"type" => "text",
		"description" => "Set post headline"),
	
	);




	//add meta box
	function create_meta_box() {
		global $key;
	
		if( function_exists( 'add_meta_box' ) ) {
			add_meta_box( 'meta-boxes-post', ucfirst( $key ) . ' Options', 'display_meta_box_post', 'post', 'normal', 'high' );
			
			add_meta_box( 'meta-boxes-page', ucfirst( $key ) . ' Options', 'display_meta_box_page', 'page', 'normal', 'high' ); 
		}
	
	}
	 
	 

	function display_meta_box_post(){
		global $meta_boxes_post;
		display_meta_box($meta_boxes_post);
	}
	
	
	function display_meta_box_page(){
		global $meta_boxes_page;
		display_meta_box($meta_boxes_page);
	}
	

	
	
	function display_meta_box($meta_boxes) {
		global $post, $key; ?>
	
		<div class="form-wrap">
	
			<?php wp_nonce_field( plugin_basename( __FILE__ ), $key . '_wpnonce', false, true );
		
				foreach($meta_boxes as $meta_box) {
				
					$data = get_post_meta($post->ID, $key, true); ?>
			
					<div class="form-field form-required">
					<label for="<?php echo $meta_box[ 'name' ]; ?>"><strong><?php echo $meta_box[ 'title' ]; ?></strong></label>
					
					<?php if($meta_box['type']=="text") :?>
						<?php if(isset($data[$meta_box['name']])){ $val = $data[$meta_box['name']];}else{$val = "";} ?>
						<input id="<?php echo $meta_box[ 'id' ]; ?>" type="text" name="<?php echo $meta_box[ 'name' ]; ?>" value="<?php echo htmlspecialchars( $val ); ?>" />
					<?php endif; ?>
					
					<?php if($meta_box['type']=="textarea") :?>
					<?php if(isset($data[$meta_box['name']])){ $val = $data[$meta_box['name']];}else{$val = "";} ?>
						<textarea name="<?php echo $meta_box[ 'name' ]; ?>" ><?php echo htmlspecialchars( $val ); ?></textarea>
					<?php endif; ?>
					
					<?php if($meta_box['type']=="checkbox") :?>
					
						<br/>
						Show<input style="float:left;width:10px;" type="checkbox" name="<?php echo $meta_box[ 'name' ]; ?>" value="1" <?php if(isset($data[$meta_box['name']])){if ($data[$meta_box['name']] == 1){ echo ' checked="checked" ';} }?> >
					<?php endif; ?>
					
					<?php if($meta_box['type'] == "select") : ?>
					   
						<select name="<?php echo $meta_box['name']; ?>" id="<?php echo $meta_box['name']; ?>" >  
						<option>Sidebar</option>
					   <?php
						$opt = get_option(THEME_NAME.'_sidebar');
						$opt = unserialize($opt);
					   foreach ($opt as $option) {  
					        echo'<option';  
					      if(isset($data[$meta_box['name']])){
					       if ( $data[$meta_box['name']] == $option) {  
					           echo ' selected="selected"';  
					        } elseif ($option == $value['std']) {  
					           echo ' selected="selected"';  
					       }  }
					     
					       echo '>'.$option.'</option>';  
					   }  
					   echo '</select>';  
					   
					 endif; ?>
				
			<p><?php echo $meta_box[ 'description' ]; ?></p>
		</div>
		
		
		<?php } ?>
		
		</div>
	<?php
	}





	//save postmeta
	function save_meta_box( $post_id ) {
		
		global $post, $meta_boxes_post, $meta_boxes_post_images, $meta_boxes_post_room, $meta_boxes_page, $key;
		
			foreach( $meta_boxes_post as $meta_box ) {
				if(isset($_POST[ $meta_box[ 'name' ]])){
					$data[ $meta_box[ 'name' ] ] = $_POST[ $meta_box[ 'name' ] ];
				}
			}
			
							
			foreach($meta_boxes_page as $meta_box) {
				if(isset($_POST[ $meta_box[ 'name' ]])){
				$data[ $meta_box[ 'name' ] ] = $_POST[ $meta_box[ 'name' ] ];
				}
			}
			if(isset($_POST[ $key . '_wpnonce' ])){$wpnonce = $_POST[ $key . '_wpnonce' ];}else{$wpnonce="";}
			if ( !wp_verify_nonce( $wpnonce, plugin_basename(__FILE__) ) )
			return $post_id;
		
			if ( !current_user_can( 'edit_post', $post_id ))
			return $post_id;
		
			update_post_meta( $post_id, $key, $data );
			
		}
		
		
		add_action('admin_menu', 'create_meta_box');
		add_action('save_post', 'save_meta_box');
?>