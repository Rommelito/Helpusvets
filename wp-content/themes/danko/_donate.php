<?php
/*

Template Name: Donate

*/
get_header();

?>
<div class="wrapper">
 <div class="donate-page left">

                <div class="donate-text left">
                   	<?php
					/* Run the loop to output the page.
					 * If you want to overload this in a child theme then include a file
					 * called loop-page.php and that will be used instead.
					 */
					//get_template_part( 'loop', 'page' );

					//$current_page_id = get_ID_by_slug($page->post_name);

					 wp_reset_query();
						if ( have_posts() ) : while ( have_posts() ) : the_post();


						the_content();
						 endwhile;
						else:
						endif;
					wp_reset_query();
					?>
                </div><!--/donate-text-->
<?php  $currency  = get_option(THEME_NAME.'_currency');  ?>
                   
                <div class="donate-content left">
                    <div class="donate-form">
                        <p>Enter an Amount (<?php echo $currency; ?>)</p>
                            <form method="post" action="" name="paypalform">
                                <input type="text" onfocus="if(value==defaultValue)value=''" onblur="if(value=='')value=defaultValue" value="" name="non_paid_enter"  id="non_paid_enter" />
                                    <div class="form-button">
                                        <a href="javascript:document.forms['paypalform'].submit();">
                                            <div class="red">
                                                <div class="red-left"></div>
                                                <div class="red-center">Donate Now</div>
                                                <div class="red-right"></div>
                                            </div>
                                        </a>
                                    </div><!--/form-button-->
                            </form>
                    </div>
                </div>

                <div class="donate-text-down left">After pressing Donate now button you will be redirected to the PayPal payment page</div>

            </div><!--/donate-page-->

</div><!-- wrapper -->

<?php get_footer(); ?>