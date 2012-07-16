<?php
/*

Template Name: Photo gallery With Sidebar

*/
get_header(); ?>


<!------ CONTENT ------>
<div class="content">
    <div class="wrapper">
        <div class="other-content-side">
        	<?php $catidforgallery = 8; include (ABSPATH . '/wp-content/plugins/featured-content-gallery/gallery.php'); ?>
		</div>

<!--        <div id="sidebar" class="left">
            <?php if(function_exists('dynamic_sidebar') && dynamic_sidebar('Sidebar')) : ?>
            <?php endif; ?> -->
	</div>
</div>

            </div>

<?php get_footer(); ?>