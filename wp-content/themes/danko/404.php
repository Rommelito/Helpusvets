<?php

get_header(); ?>

    <!------ TITLE HOME ------>

    <div class="page-404 left">

                <h1>404</h1>
                <h2>Looks like the page you we’re looking <br /> for doesn’t exist. Sorry about that.</h2>

                <p>Check the web address for typos or visit the home page.</p>

                <div class="button-404">
                    <a href="index.php">
                        <div class="red">
                            <div class="red-left"></div>
                            <div class="red-center"><a href="<?php echo home_url(); ?>">Home Page</a></div>
                            <div class="red-right"></div>
                        </div>
                    </a>
                </div><!--/form-button-->
            </div><!--/page-404-->

<?php get_footer(); ?>