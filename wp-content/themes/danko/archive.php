<?php 
get_header();
?>
<?php
					$slug = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
					if ($_SERVER["SERVER_PORT"] != "80")
					{
					    $slug .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
					}
					else
					{
					    $slug .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
					}

					if(!strpos($slug,'page')){
						$_SESSION['slug'] = $slug;
					}?>


    <div class="content">
        <div class="wrapper">
            <div class="content-wrap-left left">

		
					<?php 
                                        wp_reset_query();
                                        $slug = get_page_url();
                                        $pageslug = explode('page/',$slug);
                                        $pageslug = $pageslug[0];
							//The Loop
                                        $cellnum = 0;
								if ( have_posts() ) : while ( have_posts() ) : the_post(); 
								 		$data = get_post_meta( $post->ID, GD_THEME, true );
												 $post_img = "";
									if (has_post_thumbnail()){
										      $imagedata = simplexml_load_string(get_the_post_thumbnail());
										      if(!empty($imagedata)){
										      	$post_img = $imagedata->attributes()->src;
										      }
										   	}
											$title = the_title('','',FALSE);
											if ($title<>substr($title,0,40)){ $dots = "...";}else{$dots = "";}
											$cellnum++;
									?>

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

                                                                             	<?php if($post_img !== "") { ?>

                <div class="blog-content left">
                    <div class="blog-title-date left">
                        <div class="blog-title left"><a href="<?php get_permalink(); ?>"><?php the_title(); ?></a></div>
                        <span><?php the_time('F j, Y'); ?> | <?php if ($num_of_comments == 0) {
                            echo '0';
                        }else {
                            echo $num_of_comments;
                        } ?> Comments</span>
                    </div><!--/comment-start-title-->
                    <div class="blog-images left"><a href="<?php get_permalink(); ?>"><img src="<?php echo get_template_directory_uri();?>/script/timthumb.php?src=<?php print $post_img;?>&w=248&h=138&zc=1&q=100" alt="_" title="<?php the_title();?>" /></a></div>
                    <div class="blog-images-text left"><?php truncate_post(480) ?></div>
                </div><!--/donate-text-->


                        <?php }else {
                        ?>
                <div class="blog-content left">
                    <div class="blog-title-date left">
                        <div class="blog-title left"><a href="<?php get_permalink(); ?>"><?php the_title(); ?></a></div>
                        <span><?php echo  the_time('F j, Y'); ?> | <?php if ($num_of_comments == 0) {
                                    echo '0';
                                }else {
                                    echo $num_of_comments;
                                } ?> Comments</span>
                    </div><!--/comment-start-title-->
                    <div class="blog-actions-text left"><?php truncate_post(480) ?></div>
                </div><!--/donate-text-->
								
                                <?php } endwhile;?>
                                    <?php

                                        //activate pagination
                                        tk_pagination(1,5,5,$_SESSION['slug']); ?>

                                <?php else: ?>
                                <?php endif;?>
                 </div><!--/content-wrap-left-->
						<?php	//Reset Query
							wp_reset_query(); ?>
		
        <div id="sidebar" class="left">
            <?php if(function_exists('dynamic_sidebar') && dynamic_sidebar('Sidebar')) : ?>
            <?php endif; ?>
        </div>
                 
    </div><!--/wrapper-->
</div><!--/content-->

                     

<?php get_footer(); ?>