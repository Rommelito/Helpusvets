<?php get_header();
?>

    <!------ CONTENT ------>
    <div class="content">
        <div class="wrapper">

          
 <div class="content-wrap-left left">
     

					<?php
                                        $posts = query_posts($query_string . "&page_id=$post->ID");
					if ( have_posts() ) : while ( have_posts() ) : the_post();
					$data = get_post_meta( $post->ID, GD_THEME, true );
					$imagedata = simplexml_load_string(get_the_post_thumbnail());
					$title = the_title('','',FALSE);
					$lenght = strlen($title);
					 if ($title<>substr($title,0,95)) {
                                        $dots = "...";
                                        }else {
                                            $dots = "";
                                        }

					 $post_img = "";
                                        if (has_post_thumbnail()){
                                                      $imagedata = simplexml_load_string(get_the_post_thumbnail());
                                                      if(!empty($imagedata)){
                                                        $post_img = $imagedata->attributes()->src;
                                                      }
                                                        } ?>
                                            <?php
                                                    $comments = get_comments("post_id=$post->ID");

                                                            $num_of_comments = 0;
                                                            foreach((get_the_category()) as $category) {
                                                                    $post_category = $category->cat_name;
                                                                    $post_category_id = $category->cat_ID;
                                                                    $cat_slug=get_cat_slug($post_category_id);
                                                            }

                                                            foreach($comments as $comm) :
                                                                    $num_of_comments++;

                                                            endforeach;
                                                            $written = $post->post_author;
                                                            $user = get_user_by('id',$written);
                                                            $written = $user->nickname;
                                            ?>
					

                   <div class="donate-text left">
                                
                       <div class="blog-content-single left">
                           <div class="blog-title-date left">
                               <div class="blog-title left"><?php echo substr($title,0,90).$dots; ?></div>
                           </div><!--/comment-start-title-->
                           
                           <div class="blog-images-text-single left"> 
                           <?php if($post_img !== "") { ?>
                                 <div class="blog-images left">
                                    <a href="<?php print $post_img;?>" class="pirobox" title="<?php the_title(); ?>" rel="single"><img class="slider_img_holder" id="<?php echo $postslug?>"  src="<?php echo get_template_directory_uri()."/script/timthumb.php?src=".$post_img."&w=248&h=138&zc=1&q=100"?>" /></a>
                                 </div>  <?php } ?>
                                 <?php the_content();?>
                           </div>
                      
                       </div><!--/donate-text-->
                  
                    </div><!--/donate-text-->
 
                                                <?php endwhile;?>
                                                <?php else: ?>
                                                <?php endif; ?>
                                                <br /><br /><br />


                                                <?php
                                wp_reset_query();
                                if ( comments_open() ) : ?>

                                        <span class="comment-start"><?php comments_popup( 'No comments yet', '1 Comment', '% Comments', 'comments-link', 'Comments are off for this post'); ?></span>

                                <?php endif; ?>
                                <?php comments_template(); // Get wp-comments.php template ?></div><!--/content-wrap-left-->

                            <div id="sidebar" class="left">
                                <?php get_sidebar(); ?>
                            </div>

<?php get_footer(); ?>