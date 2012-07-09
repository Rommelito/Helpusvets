<?php
/*

Template Name: Blog

*/
get_header();
?>

    <!------ CONTENT ------>
    <div class="content">
        <div class="wrapper">

            
             <div class="other-content">

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
            
            
            <div class="content-wrap-left left">
            <?php

            wp_reset_query();          
            $blog_category = get_option(THEME_NAME.'_blog_post_category');
            $categories = get_categories('orderby=name');
            $include_category = null;
            $slug = get_page_link();
            $allcat = implode(',', $blog_category);
   
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 0;
            $args=array('cat'=>$allcat, 'post_status' => 'publish','paged' => $paged,'posts_per_page' => get_option('posts_per_page'),'ignore_sticky_posts'=> 1);

            //The Query
            query_posts($args);

            //The Loop
            if ( have_posts() ) : while ( have_posts() ) : the_post();
                    $post_img = "";
                    if (has_post_thumbnail()) {
                        $imagedata = simplexml_load_string(get_the_post_thumbnail());
                        if(!empty($imagedata)) {
                            $post_img = $imagedata->attributes()->src;
                        }
                    }
                    $title = the_title('','',FALSE);

                    if ($title<>substr($title,0,60)) {
                        $dots = "...";
                    }else {
                        $dots = "";
                    }?>


                    <?php
                    $comments = get_comments("post_id=$post->ID");

                    $num_of_comments = 0;
                    foreach((get_the_category()) as $category) {
                        $post_category = $category->cat_name;
                     }

                    foreach($comments as $comm) :
                        $num_of_comments++;
                    endforeach;
                   
                    ?>
                    <?php if($post_img !== "") { ?>


                  <div class="blog-content left">
                    <div class="blog-title-date left">
                        <div class="blog-title left"><a href="<?php echo  get_permalink(); ?>"><?php echo substr($title,0,60).$dots; ?></a></div>
                        <span><?php the_time('F j, Y'); ?> | <a href="<?php echo get_permalink(); ?>"> <?php if ($num_of_comments == 0) {
                                            echo ' 0';
                                        }else {
                                            echo ' '.$num_of_comments;
                                        } ?> comments</a></span>
                    </div><!--/comment-start-title-->
                    <div class="blog-images left app_recent_img"><a class="" href="<?php echo  get_permalink(); ?>"><img src="<?php echo get_template_directory_uri();?>/script/timthumb.php?src=<?php print $post_img;?>&w=248&h=138&zc=1&q=100" alt="_" title="<?php the_title();?>" /></a></div>
                    <div class="blog-images-text left"><?php truncate_post(480) ?></div>
                </div><!--/donate-text-->

                        <?php }else { ?>

                  <div class="blog-content left">
                    <div class="blog-title-date left">
                        <div class="blog-title left"><a href="<?php echo get_permalink(); ?>"><?php echo substr($title,0,60).$dots; ?></a></div>
                        <span><?php echo  the_time('F j, Y'); ?> | <?php if ($num_of_comments == 0) {
                                            echo '0';
                                        }else {
                                            echo $num_of_comments;
                                        } ?> comments</span>
                    </div><!--/comment-start-title-->
                    <div class="blog-actions-text left"><?php truncate_post(480) ?></div>
                </div><!--/donate-text-->


                        <?php }  ?>

                <?php endwhile;?>
                <?php
                //activate pagination
                tk_pagination(1,5,5,$slug); ?>
            <?php else: ?>
            <?php endif; ?>
      </div><!--/content-wrap-left-->
            <?php comments_template(); // Get wp-comments.php template ?>
       
        <div id="sidebar" class="left">
            <?php
            wp_reset_query();
            if(function_exists('dynamic_sidebar') && dynamic_sidebar('Sidebar')) : ?>
            <?php endif; ?>
        </div>


       </div><!--/wrapper-->
    </div><!--/content-->
    
<?php get_footer(); ?>