<?php
/*

Template Name: Contact

*/
get_header(); ?>

    <!------ CONTENT ------>
    <div class="content">
        <div class="wrapper">


       <div class="donate-text left">

             <?php
                /* Run the loop to output the page.
					 * If you want to overload this in a child theme then include a file
					 * called loop-page.php and that will be used instead.
                */
                //get_template_part( 'loop', 'page' );
                wp_reset_query();
                if ( have_posts() ) : while ( have_posts() ) : the_post();
                        the_content();
                    endwhile;
                else:
                endif;
                wp_reset_query();
                ?>
       </div>

                <?php
                $subject_error_msg = get_option(THEME_NAME.'_subject_error_msg');
                $name_error_msg = get_option(THEME_NAME.'_name_error_msg');
                $email_error_msg = get_option(THEME_NAME.'_email_error_msg');
                $message_error_msg = get_option(THEME_NAME.'_message_error_msg');
                $mail_success_msg = get_option(THEME_NAME.'_mail_success_msg');
                $mail_error_msg = get_option(THEME_NAME.'_mail_error_msg');
                ?>

                <!-- Validate script -->
                <script type="text/javascript">
                    function validate_email(field,alerttxt)
                    {
                        with (field)
                        {
                            apos=value.indexOf("@");
                            dotpos=value.lastIndexOf(".");
                            if (apos<1||dotpos-apos<2)
                            {$('#contact-error').empty().append(alerttxt);return false;}
                            else {return true;}
                        }
                    }

                    function check_field(field,alerttxt,checktext){
                        with (field)
                        {
                            var checkfalse = 0;
                            if(field.value == ""){
                                $('#contact-error').empty().append(alerttxt);
                                field.focus();checkfalse=1;}

                            if(field.value==checktext)
                            {
                                $('#contact-error').empty().append(alerttxt);
                                field.focus();checkfalse=1;}

                            if(checkfalse==1){return false;}else{return true;}
                        }
                    }

                    function checkForm(thisform)
                    {
                        with (thisform)
                        {
                            var error = 0;

                            var message = document.getElementById('message');
                            if(check_field(message,"<?php echo $message_error_msg?>","Message*")==false){
                                error = 1;
                            }

                             var subject = document.getElementById('subject');
                            if(check_field(subject,"<?php echo $subject_error_msg?>","Subject*")==false){
                                error = 1;
                            }

                            var email = document.getElementById('email');
                            if (validate_email(email,"<?php echo $email_error_msg?>")==false)
                            {email.focus();error = 1;}

                            var contactname = document.getElementById('contactname');
                            if(check_field(contactname,"<?php echo $name_error_msg?>","Name*")==false){
                                error = 1;
                            }

                            

                            if(error == 0){
                                var subject = document.getElementById('subject').value;
                                var contactname = document.getElementById('contactname').value;
                                var email = document.getElementById('email').value;
                                var message = document.getElementById('message').value;

                                return true;
                            }
                            return false;
                        }
                    }
                </script>
                <!-- end of script -->

                <!--FORM-->
                <div class="clear"></div>


                <div class="contact-form">

 <div class="clear"></div>
            <div class="form-left">
               <form method="POST" id="contactform" onsubmit="return checkForm(this)" action="<?php echo get_template_directory_uri().'/sendcontact.php'?>">

                       <div class="form-div left"><span>Name and Surname:</span>
                            <input type="text" onfocus="if(value==defaultValue)value=''" onblur="if(value=='')value=defaultValue" value="" name="contactname" id="contactname" tabindex="1"/>
                        </div>

                        <div class="form-div left"><span>E-mail Address:</span>
                        
                            <input type="text" onfocus="if(value==defaultValue)value=''" onblur="if(value=='')value=defaultValue" value="" name="email" id="email" tabindex="2"/>
                        </div>

                        <div class="form-div left"><span>Subject:</span>                         
                            <input type="text" onfocus="if(value==defaultValue)value=''" onblur="if(value=='')value=defaultValue" value="" name="subject" id="subject" tabindex="3"/>
                        </div>
                        
                       
                  

                       <div class="form-div left"><span>Message:</span>
                            <textarea onfocus="if(value==defaultValue)value=''" onblur="if(value=='')value=defaultValue" name="message" id="message" tabindex="4"></textarea>
                        </div>


                    <div class="form-button">
                      <div class="red">
                        <div class="red-left"></div>
                        <div class="red-center"><input name="submit" type="submit" id="submit" class="emailsubmit"  tabindex="5" value="Send Now" onclick="return checkForm(this)" /></div>
                        <div class="red-right"></div>
                      </div>
                    </div>

                   <div class="clear"></div>

                    <input type="hidden" name="returnurl" value="<?php echo get_permalink();  ?>">
                    <div id="contact-success"><?php if(isset($_GET['sent'])) {
    $what = $_GET['sent'];
    if($what == 'success') {
        echo $mail_success_msg;
            }
        }
        ?></div>
                    <div id="contact-error"><?php if(isset($_GET['sent'])) {
                        $what = $_GET['sent'];
                        if($what == 'error') {
                            echo $mail_error_msg;
                }
            }
            ?>
                   
                </form><!--close form -->
                 </div>
         </div><!-- form-left -->



<?php get_footer(); ?>