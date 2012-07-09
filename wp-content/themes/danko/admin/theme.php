<?php session_start();
// Hook for adding admin menus
	add_action('admin_menu', 'add_pages');
	//$setupnames = update_option(THEME_NAME.'-setup-names','');
	// action function for above hook
	function add_pages() {
            add_menu_page( THEME_NAME, THEME_NAME, 'manage_options',THEME_NAME.'-theme', 'theme_panel');
		
                add_submenu_page(THEME_NAME.'-theme',  __(THEME_NAME.' Transactions','admin-menu'), __(THEME_NAME.' Transactions','admin-menu'), 'manage_options', THEME_NAME.'-transaction', 'theme_transaction' );
	}

	//Adding Icon to wordpress menu
	function insert_jquery(){ ?>
		<div id="panel-widget">
			<script type="text/javascript">
				jQuery(document).ready(function(){
				jQuery('#menu-appearance .wp-submenu ul li a').each(function(){
					var href = (jQuery(this).attr('href'));
					if(href == 'themes.php?page=tk-<?php echo THEME_NAME;?>-theme'){
						var old = jQuery(this).html();
						jQuery(this).html('<img src="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" style="position:relative;top:4px;left:0px">'+old);
					}

					if(href == 'themes.php?page=tk-<?php echo THEME_NAME;?>-style'){
						var old = jQuery(this).html();
						jQuery(this).html('<img src="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" style="position:relative;top:4px;left:0px">'+old);
					}
				});
				});
			</script>
		</div>
	  <script type="text/javascript">
	  var shortcode = document.getElementById("panel-widget");
	</script>
		<?php
	}
	add_action('admin_footer','insert_jquery');



/*-------ADMIN START---------*/


function theme_panel() { 



      //
//      START DEFINING ELEMENTS FOR ADMINISTRATION
//


$admin_form = array(

        'Main'=>array(


                'Logo' => array(

                        'label' => 'Logo',

                        'name' => THEME_NAME.'_custom_logo',

                        'type' => 'file',

                        'description' => 'Upload Your logo or paste logo url',

                        'default' => get_template_directory_uri().'/images/logo.png'

                ),

             


                'Favicon' => array(

                        'label' => 'Favicon',

                        'name' => THEME_NAME.'_custom_favicon',

                        'type' => 'file',

                        'description' => 'Upload Your favicon or paste favicon url (16x16px)',

                        'default' => get_template_directory_uri().'/images/favicon.ico'

                ),



             'LatestActionsImage' => array(

                        'label' => 'Latest Actions Image',

                        'name' => THEME_NAME.'_latest_image',

                        'type' => 'file',

                        'description' => 'Upload Your favicon or paste favicon url (16x16px)',

                        'default' => get_template_directory_uri().'/style/img/home-images-right.png'

                ),

                'Footer' => array(

                        'label' => 'Footer Copyright Text',

                        'name' => THEME_NAME.'_footer_copyright',

                        'type' => 'text',

                        'description' => 'Insert Your Copyright text',

                        'default' => 'Copyright Information Goes Here 2010. All Rights Reserved. Designed by  Themes Kingdom'

                ),

                'Twitter' => array(

                        'label' => 'Twitter',

                        'name' => THEME_NAME.'_twitter',

                        'type' => 'text',

                        'description' => 'Insert account name. Example: "themeskingdom" (If you leave field empty the twitter icon will be removed)',

                        'default' => ''

                ),

                'Facebook' => array(

                        'label' => 'Facebook',

                        'name' => THEME_NAME.'_facebook',

                        'type' => 'text',

                        'description' => 'Insert account name. Example: "themeskingdom" (If you leave field empty facebook icon will be removed)',

                        'default' => ''

                ),

                'RSSFeed' => array(

                        'label' => 'Rss Feed',

                        'name' => THEME_NAME.'_rss_feed',

                        'type' => 'text',

                        'description' => 'Insert url of your RSS Feed, if you leave field empty default WordPress RSS will be used',

                        'default' => ''

                ),

                'Googleplus' => array(

                        'label' => 'Google +',

                        'name' => THEME_NAME.'_google_plus',

                        'type' => 'text',

                        'description' => 'Insert account name. Example: "themeskingdom" (If you leave field empty Google+ icon will be removed)',

                        'default' => ''

                ),
                        
        ),


        'Front'=>array(

                'Slideshow_options' => array(

                        'label' => 'Slider Category',

                        'name' => THEME_NAME.'_front_slider_category',

                        'type' => 'dropdown',

                        'description' => 'Edit Your homepage slideshow options'

                ),

            
             
          
        ),


        'Blog'=>array(

                    'Blog Categories' => array(

                        'label' => 'Blog Category',

                        'name' => THEME_NAME.'_blog_post_category',

                        'type' => 'multicheck',

                        'description' => 'You can select which categories to display on blog page',

                ),

                 'Show latest actions in footer' => array(

                        'label' => 'Hide or show latest actions',

                        'name' => THEME_NAME.'_hide_latest',

                        'type' => 'singlecheck',

                        'description' => 'Show or hide latest action',

                ),

             

        ),

        'OurActions'=>array(


                'Actions Categories' => array(

                        'label' => 'Our Actions Category',

                        'name' => THEME_NAME.'_our_actions_category',

                        'type' => 'multicheck',

                        'description' => 'You can select which categories to display on actions page'

                ),

              'NumberofPosts' => array(

                        'label' => 'Number of Actions',

                        'name' => THEME_NAME.'_our_actions_number',

                        'type' => 'text',

                        'description' => 'You can select how many actions do you wish to display on actions page'
               
                )

         

        ),

        'Contact'=>array(

                'Subject error' => array(

                        'label' => 'Subject error message:',

                        'name' => THEME_NAME.'_subject_error_msg',

                        'type' => 'text',

                        'description' => 'Edit error and success messages for contact form',

                        'default' => 'Please insert message subject!'

                ),

                'Name error' => array(

                        'label' => 'Name error message:',

                        'name' => THEME_NAME.'_name_error_msg',

                        'type' => 'text',

                        'description' => 'Edit error and success messages for contact form',

                        'default' => 'Please insert your name!'

                ),

                'E-mail error' => array(

                        'label' => 'E-mail error message:',

                        'name' => THEME_NAME.'_email_error_msg',

                        'type' => 'text',

                        'description' => 'Edit error and success messages for contact form',

                        'default' => 'Please insert your e-mail!'

                ),

                'Message error' => array(

                        'label' => 'Message error message:',

                        'name' => THEME_NAME.'_message_error_msg',

                        'type' => 'text',

                        'description' => 'Edit error and success messages for contact form',

                        'default' => 'Please insert your message!'

                ),

                'Successfull mail send:' => array(

                        'label' => 'Message on successfull mail send:',

                        'name' => THEME_NAME.'_mail_success_msg',

                        'type' => 'text',

                        'description' => 'Edit error and success messages for contact form',

                        'default' => 'Message sent!'

                ),

                'Unsuccessfull mail send:' => array(

                        'label' => 'Message on unsuccessfull mail send:',

                        'name' => THEME_NAME.'_mail_error_msg',

                        'type' => 'text',

                        'description' => 'Edit error and success messages for contact form',

                        'default' => 'Some error occured!'

                ),

            

 ),

        'StoreSettings'=>array(


                'PayPal Email' => array(

                        'label' => 'PayPal Email',

                        'name' => THEME_NAME.'_paypal_email',

                        'type' => 'text',

                        'description' => 'Please enter your PayPal email address.',

                        'default' => ''

                ),


                'PayPal Sandbox' => array(

                        'label' => 'PayPal Sandbox',

                        'name' => THEME_NAME.'_paypal_sandbox',

                        'type' => 'singlecheck',

                        'description' => 'Enable PayPal Sanbox',

                        'default' => ''

                ),

                    
                'Currency' => array(

                        'label' => 'Currency',

                        'name' => THEME_NAME.'_currency',

                        'type' => 'customdropdown',

                        'description' => 'Select the currency that your product will be sold in.'

                ),



                'Return URL' => array(

                        'label' => 'Return URL',

                        'name' => THEME_NAME.'_return_url',

                        'type' => 'text',

                        'description' => 'Page URL on your site where buyer will be returned after payment.'

                ),

                'Email Message' => array(

                        'label' => 'Email Message',

                        'name' => THEME_NAME.'_email_message',

                        'type' => 'textarea',

                        'description' => 'Email this to your buyer after the payment.',

						'default' => 'Hello [FIRST_NAME] [LAST_NAME],'."\n\n"."\n"."\n".'Your transaction ID is [TRANSACTION_ID]'."\n".'Kind Regards!'

                ),

        ),
     
);


//
//      END DEFINING ELEMENTS FOR ADMINISTRATION
//

      

//
//      START UPDATING ELEMENTS IN ADMINISTRATION
//



if(isset($_POST['admin_submit'])) {

    foreach ($admin_form as $admin_panel) {

        foreach($admin_panel as $admin_option ) {

            foreach ($admin_option as $admin_option_name => $admin_option_value){

                if($admin_option_name == 'name'){

                    $posted_item = is_array($_POST[$admin_option_value]);
                     if ($posted_item == false){
                         $escaped_option = esc_html($_POST[$admin_option_value]);
                         update_option($admin_option_value, $escaped_option);
                     }else{
                         update_option($admin_option_value, $_POST[$admin_option_value]);
                     }

                        
                }

            }

        }

    }

}


//
//      END UPDATING ELEMENTS IN ADMINISTRATION
//

?>



<!-- Header for administration-->

            <div id="header">

                <div class="icon-option"></div>

                <div class="theme-name">

                    <?php echo THEME_NAME?>
                    
                </div>

                <div class="theme-version"><?php echo THEME_VERSION?></div>

                <div class="clear-both"></div>

            </div><!-- close #header-->



<!-- For for admin settings-->

<form action="<?php echo get_page_url(); ?>" method="POST" enctype="multipart/form-data">

    <div class="admin-panel">



        <div class='left-side' >

            <?php

            foreach ($admin_form as $panel_name => $panel_options) {

                if (isset($panel_name)) { ?>

                        <label class='admin-nav' rev='<?php echo $panel_name?>'><?php echo $panel_name ?></label>

                        <script type="text/javascript">

                            jQuery(document).ready(function() {

                                // Border cleaner
                                    jQuery('.<?php echo $panel_name?> .option-section:last').attr('style', 'border-bottom:none');

                            });
                            
                        </script>

             <?php  } } ?>

        </div><!-- close .left-side-->



        <div class='right-side' >

            <?php

            foreach ($admin_form as $panel_name => $panel_options) { ?>

            <div class="<?php echo $panel_name.' hide mainspan'?>">

                <h2><?php echo $panel_name ?></h2>

                    <?php



                        //
                      //      Checking option type START
                    //



                    foreach ($panel_options as $input_name => $input_type) {



                        //      if is input type text

                        if ($input_type['type']  == 'text') {

                            $value = get_option($input_type['name']);

                            $value = stripslashes($value);

                            if($value == ""){

                                $value = $input_type['default'];

                            }

                            ?>

                <div class="option-section">

                    <label class="option-title"><?php echo $input_type['label']?></label>

                    <div class="option-holder">

                        <input type="text" name="<?php echo $input_type['name']?>" class="input-text" value="<?php echo $value;  ?>">

                        <label class="option-description"><?php echo $input_type['description']?></label>

                    </div>

                </div>

                            <?php   }



                        //      if is input type dropdown


                        if ($input_type['type']  == 'dropdown') { ?>

                <div class="option-section">

                    <label class="option-title"><?php echo $input_type['label']?></label>

                    <div class="option-holder">



                   <?php
				$cat = get_option($input_type['name']);
 				$selected_category = $cat;
				$args = array(
				    'show_option_all'    => '',
				    'show_option_none'   => '',
				    'orderby'            => 'ID',
				    'order'              => 'ASC',
				    'show_last_update'   => 0,
				    'show_count'         => 0,
				    'hide_empty'         => 1,
				    'child_of'           => 0,
				    'exclude'            => '',
				    'echo'               => 1,
				    'selected'           => $selected_category,
				    'hierarchical'       => 0,
				    'name'               => $input_type['name'],
				    'id'                 => 'option_dropdown',
				    'class'              => 'postform',
				    'depth'              => 0,
				    'tab_index'          => 0,
				    'taxonomy'           => 'category',
				    'hide_if_empty'      => false );
				     wp_dropdown_categories( $args );
				?>

                        <label class="option-description"><?php echo $input_type['description']?></label>

                    </div>

                </div>

                            <?php     }



                        //      if is input type textarea

                        if ($input_type['type']  == 'textarea') { 
                            
                            $value = get_option($input_type['name']);
                            
                            $value = stripslashes($value);

                            if($value == "") {
                                
                                $value = $input_type['default'];
                                
                            }
                            
                            ?>

                <div class="option-section">

                    <label class="option-title"><?php echo $input_type['label']?></label>

                    <div class="option-holder">

                        <textarea type='text' name='<?php echo $input_type['name'] ?>' class='admin-textarea'><?php echo $value?></textarea>

                        <label class='option-description'><?php echo $input_type['description'] ?></label>

                    </div>

                </div>

                            <?php     }



                        //      if is input type file

                        if ($input_type['type']  == 'file') { ?>



                <div class=" option-section">

                    <label class="option-title"><?php echo $input_type['label']?></label>

                    <div class="upload-section-holder">

                        <div class="left_content">

					<?php

						$file_value = get_option($input_type['name']); if(empty($file_value)) {$file_value = $input_type['default'];}
					?>

					<input type="text" value="<?php echo $file_value;?>" name="<?php echo $input_type['name'];?>"  class="postbox small input-text"/>

					<span id="<?php echo $input_type['name'];?>" class="button upload gd_upload logoupload show">Upload Image</span>

					<span class="button gd_remove" id="remove_<?php echo $input_type['name'];?>">Remove Image</span>

					<div class="gd_image_preview_holder">

						<img src="<?php echo $file_value;?>"/>

					</div>

			</div> <!--close content-->

                    </div>
                    
                                        <label class='option-description'><?php echo $input_type['description']?></label>


                </div> <!--close content-->

                            <?php   }


                            
                        //      if is input type checkbox single

                        if ($input_type['type']  == 'singlecheck') {

                            $singlecheck = get_option($input_type['name']);

                        ?>

                <div class="option-section">

                    <label class="option-title"><?php echo $input_type['label']?></label>

                    <div class="option-holder">

                        <input class ="admin_single_checkbox" type="checkbox" value="1" name="<?php echo $input_type['name']?>" <?php if($singlecheck == '1') {echo ' checked '; } ?> >

                        <label class="option-description"><?php echo $input_type['description']?></label>

                    </div>

                </div>

                            <?php   }



                        //      if is input type checkbox multi

                        if ($input_type['type']  == 'multicheck') { ?>

                <div class="option-section">

                    <label class="option-title"><?php echo $input_type['label']?></label>

                    <div class="option-holder">

                        <div class="option-cat-holder">
                            
                                    <?php

                                    $categories = get_categories('orderby=name');

                                    $cheked_category = get_option($input_type['name']);
                                    
                                    foreach ($categories as $category_list ) { 

                                        ?>

                                <input class="gd_super_check" type="checkbox" value="<?php echo $category_list->cat_ID;?>" name="<?php echo $input_type['name']."[]"?>"

                               <?php

                               if(!empty($cheked_category)){

                                   foreach ($cheked_category as $checked_one){

                                       if($checked_one == $category_list->cat_ID) { echo "checked"; }

                                   }
                                   
                               }
                               ?> >

                               <div class="category-name"><?php echo $category_list->cat_name;?></div> <?php  } ?>

                        </div>

                        <label class="option-description"><?php echo $input_type['description']?></label>

                    </div>

                </div>
                            <?php   }

 //      if is input type custom dropdown


                       if ($input_type['type']  == 'customdropdown') { ?>
                  <?php
               $currency = get_option($input_type['name']);
               $selected_category = $currency;?>
               <div class="option-section">

                   <label class="option-title"><?php echo $input_type['label']?></label>

                   <div class="option-holder">

                       <select id="option_dropdown" class="postform" name="<?php echo $input_type['name']?>">
                            <option class="level-0" <?php if ($selected_category == 'AUD')  { echo 'selected'; } ?> value="AUD">Australian Dollar (A $) AUD</option>
                            <option class="level-0" <?php if ($selected_category == 'CAD')  { echo 'selected'; } ?> value="CAD">Canadian Dollar (C $) CAD</option>
                            <option class="level-0" <?php if ($selected_category == 'EUR')  { echo 'selected'; } ?> value="EUR">Euro (€) EUR</option>
                            <option class="level-0" <?php if ($selected_category == 'GBP')  { echo 'selected'; } ?> value="GBP">British Pound (£) GBP</option>
                            <option class="level-0" <?php if ($selected_category == 'JPY')  { echo 'selected'; } ?> value="JPY">Japanese Yen (¥) JPY</option>
                            <option class="level-0" <?php if ($selected_category == 'USD')  { echo 'selected'; } ?> value="USD">U.S. Dollar ($)	USD</option>
                            <option class="level-0" <?php if ($selected_category == 'NZD')  { echo 'selected'; } ?> value="NZD">New Zealand Dollar ($) NZD</option>
                            <option class="level-0" <?php if ($selected_category == 'CHF')  { echo 'selected'; } ?> value="CHF">Swiss Franc	CHF</option>
                            <option class="level-0" <?php if ($selected_category == 'HKD')  { echo 'selected'; } ?> value="HKD">Hong Kong Dollar ($) HKD</option>
                            <option class="level-0" <?php if ($selected_category == 'SGD')  { echo 'selected'; } ?> value="SGD">Singapore Dollar ($) SGD</option>
                            <option class="level-0" <?php if ($selected_category == 'SEK')  { echo 'selected'; } ?> value="SEK">Swedish Krona SEK</option>
                            <option class="level-0" <?php if ($selected_category == 'DKK')  { echo 'selected'; } ?> value="DKK">Danish Krone DKK</option>
                            <option class="level-0" <?php if ($selected_category == 'PLN')  { echo 'selected'; } ?> value="PLN">Polish Zloty PLN</option>
                            <option class="level-0" <?php if ($selected_category == 'NOK')  { echo 'selected'; } ?> value="NOK">Norwegian Krone	NOK</option>
                            <option class="level-0" <?php if ($selected_category == 'HUF')  { echo 'selected'; } ?> value="HUF">Hungarian Forint HUF</option>
                            <option class="level-0" <?php if ($selected_category == 'CZK')  { echo 'selected'; } ?> value="CZK">Czech Koruna CZK</option>
                            <option class="level-0" <?php if ($selected_category == 'ILS')  { echo 'selected'; } ?> value="ILS">Israeli New Shekel ILS</option>
                            <option class="level-0" <?php if ($selected_category == 'MXN')  { echo 'selected'; } ?> value="MXN">Mexican Peso MXN</option>
                            <option class="level-0" <?php if ($selected_category == 'BRL')  { echo 'selected'; } ?> value="BRL">Brazilian Real BRL</option>
                            <option class="level-0" <?php if ($selected_category == 'MYR')  { echo 'selected'; } ?> value="MYR">Malaysian Ringgit MYR</option>
                            <option class="level-0" <?php if ($selected_category == 'PHP')  { echo 'selected'; } ?> value="PHP">Philippine Peso	PHP</option>
                            <option class="level-0" <?php if ($selected_category == 'TWD')  { echo 'selected'; } ?> value="TWD">New Taiwan Dollar TWD</option>
                            <option class="level-0" <?php if ($selected_category == 'THB')  { echo 'selected'; } ?> value="THB">Thai Baht THB</option>
                            <option class="level-0" <?php if ($selected_category == 'TRY')  { echo 'selected'; } ?> value="TRY">Turkish Lira TRY</option>
                       </select>

                       <label class="option-description"><?php echo $input_type['description']?></label>

                   </div>

               </div>

                           <?php     }

                        //      if is input type stylechanger

                        if ($input_type['type']  == 'stylechanger') { 
                            
                            $selected_style = get_option($input_type['name']);
                            
                            ?>

                <div class="option-section">

                    <label class="option-title"><?php echo $input_type['label']?></label>

                                <?php foreach ($input_type['styles'] as $styleobject) { ?>

                        <div class="one-style">

                                    <input type="radio" name="<?php echo $input_type['name']; ?>" value="<?php echo $styleobject; ?>"  class="style-radio" <?php if($selected_style == $styleobject){echo 'checked';}?> >

                                    <div class="style-preview" style="background-image:url(<?php echo get_template_directory_uri()?>/stylechanger/<?php echo $styleobject?>.png);background-color:<?php echo $styleobject?>;"></div>

                        </div>

                                <?php } ?>

                    <label class="option-description"><?php echo $input_type['description']?></label>

                </div>

                            <?php   }



                        //      if is input type stylechanger

                        if ($input_type['type']  == 'colorpicker') {?>
                
                    <script type="text/javascript">
                        jQuery(document).ready(function() {
                            jQuery('#<?php echo $input_type['name']?>_colorpicker').farbtastic('#<?php echo $input_type['name']?>_color');
                        })
                    </script>
                
                <div class="option-section">

                    <label class="option-title"><?php echo $input_type['label']?></label>

                    <?php $item_color = get_option($input_type['name']);

                                        
                                if($item_color=="") {

                                    $item_color='#000';  } ?>

                    <form><input type="text" id="<?php echo $input_type['name']?>_color" name="<?php echo $input_type['name']?>" value="<?php echo $item_color?>" class="picker-text"/></form>

                    <div id="<?php echo $input_type['name']?>_colorpicker" class="picker-box"></div>

                    <label class="option-description" rev="picker_on"><?php echo $input_type['description']?></label>

                </div>

                <?php

                        }

                    } ?>

                            </div>


             <?php    }

                ?>


        </div>

        <input type="submit" value="Save" name="admin_submit" class="submitbutton"/>

    </div>

</form>

<?php }

function theme_transaction(){
include(TEMPLATEPATH."/admin/transactions.php");
}?>