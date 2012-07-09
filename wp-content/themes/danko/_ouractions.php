<?php
/*

Template Name: Our Actions

*/
get_header();
?>


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
            
            
<div class="our-actions left">

                 <?php


            
                wp_reset_query();
                $current_page_id = get_ID_by_slug($post->post_name);
                $page = get_page_by_title($post->post_name);
                $meta = (get_post_meta($current_page_id,'',true));
                $blog_category = get_option(THEME_NAME.'_our_actions_category');
                  
                 $categories = get_categories('orderby=name');
                 $include_category = null;
                 $slug = get_page_link();

                 $postsnumber = get_option(THEME_NAME.'_our_actions_number');
                 
                 foreach ($blog_category as $category_list) {
                                $cat = 	$category_list.",";
                                $include_category = $include_category.$cat;
                                $cat_name = get_cat_name($category_list);}
            
                 $paged = (get_query_var('paged')) ? get_query_var('paged') : 0;
                 $args=array('cat'=>$include_category, 'post_status' => 'publish','paged' => $paged,'ignore_sticky_posts'=> 1, 'posts_per_page'=> $postsnumber);

                //The Query
                query_posts($args);
                $item_counter=1;

                //The Loop
                if ( have_posts() ) : while ( have_posts() ) : the_post();
                 $data = get_post_meta( $post->ID, GD_THEME, true );
             
                        $post_img = "";
                        if (has_post_thumbnail()) {
                            $imagedata = simplexml_load_string(get_the_post_thumbnail());
                            if(!empty($imagedata)) {
                                $post_img = $imagedata->attributes()->src;
                            }
                        }
                        $title = the_title('','',FALSE);

                        if ($title<>substr($title,0,18)) {
                            $dots = "...";
                        }else {
                            $dots = "";
                        }


                        ?>

                        <?php
                        $comments = get_comments("post_id=$post->ID");

                        $num_of_comments = 0;
                        foreach((get_the_category()) as $category) {
                            $post_category = $category->cat_name;
                        }

                        foreach($comments as $comm) :
                            $num_of_comments++;
                        endforeach;
                        $authorid = $post->post_author;
                        $author = get_userdata($authorid);
                        $written = $author->user_login;
                        ?>

                        <?php
                        if($item_counter%3 == 0) {
                            $nomargin = 'nomargin';
                        } else {
                            $nomargin = '';
                        }

                        if ( has_post_thumbnail() ) {

                        ?>


            <div class="our-actions-one left <?php echo $nomargin;?>">
                    <div class="our-actions-img left">
                        <div class="mosaic-block cover3">
                                <div class="mosaic-overlay"><img src="<?php echo get_template_directory_uri();?>/script/timthumb.php?src=<?php print $post_img;?>&w=261&h=199&zc=1&q=100"  alt="" title="<?php the_title();?>" /></div>
                                <a href="<?php echo get_permalink(); ?>"  class="mosaic-backdrop">
                                        <div class="details">
                                            <p><?php truncate_post(300) ?></p>
                                        </div>
                                </a>
                        </div>
                    </div><!--/our-actions-img-->
                    <div class="our-actions-title left"><a href="<?php echo get_permalink(); ?>"><?php echo substr($title,0,18).$dots; ?></a></div>
                    <div class="our-actions-category left">

                     <?php
                                $data['page_headline'] ;
                                $headline = $data['page_headline'];


                                 if ($headline<>substr($headline,0,34)) {
                                    $dots = "...";
                                }else {
                                    $dots = "";
                                }

                                echo substr($headline,0,34).$dots;
                                ?>
                     
                       
                    </div>
                </div><!--/our-actions-one-->

                                <?php }else{  ?>

                <div class="our-actions-one left <?php echo $nomargin;?>">
                    <div class="our-actions-img left">
                        <div class="mosaic-block cover3">                              
                                <a href="<?php echo get_permalink(); ?>" class="mosaic-backdrop">
                                        <div class="details">
                                            <p><?php truncate_post(300) ?></p>
                                        </div>
                                </a>
                        </div>
                    </div><!--/our-actions-img-->
                    <div class="our-actions-title left"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></div>
                    <div class="our-actions-category left">
                
                        <?php echo $headline; ?>
                    </div>
                </div><!--/our-actions-one-->

                                <?php } ?>

                        <?php
                        $item_counter++;
                        echo "</li>";
                    endwhile;
                    echo "</ul>";


                    ?>

                </div><!--/our-actions-->
                 <?php   tk_pagination(1,5,5,$slug);  ?>
            </div><!--/wrapper-->

    </div><!--/content-->
                <?php else: ?>
                <?php endif;
                $numpages =get_option(THEME_NAME.'_number_of_portfolios');
                ?>

                <?php comments_template(); // Get wp-comments.php template ?>
                

<?php get_footer(); ?>



