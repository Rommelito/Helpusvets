<ul id="comment-start">
    <?php wp_list_comments('type=comment&callback=mytheme_comment'); ?>
</ul>
<br />

<div id="respond" class="respond-style form-comment">

    <!--COMMNET FORM-->

    <div class="cancel-comment-reply">
        <small><?php cancel_comment_reply_link(); ?></small>
    </div> <!-- end cancel-comment-reply div -->

    <?php if ( get_option('comment_registration') && !$user_ID ) : ?>
    <p class="comment-p-style"><?php _e('You must be',THEME_NAME)?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>"><?php _e('logged in',THEME_NAME) ?></a> <?php _e('to post a comment.',THEME_NAME) ?></p>
    <?php else : ?>
    <div class="form-holder">
        <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform contact-form" >
                <?php if ( $user_ID ) : ?>

            <div class="comment-form-left margintop15" >
                <p><?php  _e('Logged in as',THEME_NAME) ?> <a  href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account"><?php _e('Log out &raquo;',THEME_NAME) ?></a></p>
            </div>
                <?php else : ?>

            <span class="title-border-content"><h2>Leave a comment</h2><div class="title-border"></div></span>
            <div class="form-input">

                <div class="bg-input left" style="margin-top: 25px;">
                    <span><label for="author">Name and Surname:</label></span>
                    <input type="text" spellcheck="false" name="author" id="contactname" value="" class="contact_input_text" tabindex="1" />
                </div>

                 <div class="bg-input left"><span><label for="email">E-mail Address:</label></span>
                    <input type="text" spellcheck="false" name="email" id="email" value="" class="contact_input_text" tabindex="2" />
                </div>

           
            </div>

                <?php endif; ?>
                                <!--<p><small><strong>XHTML:</strong> You can use these tags: <code><?php echo allowed_tags(); ?></code></small></p>-->

            <div class="form-textarea">
              <div class="bg-input left"><span>Message:</span>
                    <textarea name="comment" spellcheck="false" id="message" class="input comment-textarea" tabindex="4"></textarea>
                </div>
            </div>

            <div class="clear-both"></div>

            <div class="form-single-button">


                   <div class="red">
                                        <div class="red-left"></div>
                                        <div class="red-center"> <input type="submit" class="blog-send-button" name="submit-comment"  value="Send" /></div>
                                        <div class="red-right"></div>
                                    </div>
                  </div>
            <div class="clear-both"></div>
                <?php comment_id_fields(); ?>
                <?php do_action('comment_form', $post->ID);
                ?>
        </form>
        <div class="clear-both"></div>
    </div><!--form holder -->
    <?php endif; // If registration required and not logged in ?>
    <!-- This is jQuery for form fields -->
    <script type="text/javascript">
        jQuery(document).ready(function() {

            jQuery('input[type="text"]').last().css('margin','0');
            jQuery('input[type="text"]').addClass("idleField");
            jQuery('input[type="text"]').focus(function() {
                jQuery(this).removeClass("idleField").addClass("focusField");
                if (this.value == this.defaultValue){
                    this.value = '';
                }
                if(this.value != this.defaultValue){
                    this.select();
                }
            });
            jQuery('input[type="text"]').blur(function() {
                jQuery(this).removeClass("focusField").addClass("idleField");
                if (jQuery.trim(this.value) == ''){
                    this.value = (this.defaultValue ? this.defaultValue : '');
                }
            });
            jQuery('textarea').addClass("idleField");
            jQuery('textarea').focus(function() {
                jQuery(this).removeClass("idleField").addClass("focusField");
                if (this.value == this.defaultValue){
                    this.value = '';
                }
                if(this.value != this.defaultValue){
                    this.select();
                }
            });
            jQuery('textarea').blur(function() {
                jQuery(this).removeClass("focusField").addClass("idleField");
                if (jQuery.trim(this.value) == ''){
                    this.value = (this.defaultValue ? this.defaultValue : '');
                }
            });
        });
    </script>
    <!-- end of script -->
</div> <!-- end respond div -->
<br/><br/><br/>