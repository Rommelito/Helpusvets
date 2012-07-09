<?php
/*

Template Name: Page With Sidebar

*/
get_header(); ?>


<!------ CONTENT ------>
<div class="content">
    <div class="wrapper">
        <div class="other-content-side">

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

    </div>

        <div id="sidebar" class="left">
            <?php if(function_exists('dynamic_sidebar') && dynamic_sidebar('Sidebar')) : ?>
            <?php endif; ?>
        </div>
    </div>

            </div>

<?php get_footer(); ?>