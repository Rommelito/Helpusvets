<?php if (!session_id())    session_start();
/** * @package WordPress * @subpackage Danko */
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head>	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	<title><?php if(!empty($data['seo_title'])) { echo $data['seo_title']; } else { wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); }?></title>	<meta name="keywords" content="<?php if(!empty($data['seo_keywords'])) { echo $data['seo_keywords'];} ?>" />	<meta name="description" content="<?php if(!empty($data['seo_description'])) { echo $data['seo_description']; } else { bloginfo('description'); }?>" />	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />	<link rel="stylesheet" href="<?php echo get_template_directory_uri().'/script/pirobox/css/demo5/style.css';?>" type="text/css" media="screen" />	<link rel="stylesheet" href="<?php echo get_template_directory_uri().'/script/tabs/ui-lightness/jquery-ui-1.8.16.custom.css';?>" type="text/css" media="screen" />
	<link rel="stylesheet" media="screen" href="<?php echo get_template_directory_uri() . "/script/superfish/superfish.css"; ?>" type="text/css"/>	<link rel="stylesheet" media="screen" href="<?php echo get_template_directory_uri() . "/script/pirobox/css/demo5/style.css"; ?>" type="text/css"/>	<link rel="stylesheet" href="<?php echo get_template_directory_uri()."/script/BeautifulNavigation/css/style.css" ?>" type="text/css" media="screen"/>	<link rel="stylesheet" href="<?php echo get_template_directory_uri()."/script/hover-img/css/mosaic.css" ?>" type="text/css" media="screen" />
<?php
$ua = $_SERVER["HTTP_USER_AGENT"];
// Macintosh$mac = strpos($ua, 'Macintosh') ? true : false;

// Windows
$win = strpos($ua, 'Windows') ? true : false;

        $browser =  $_SERVER['HTTP_USER_AGENT'];
if(!empty($win)) {
        if($win == Windows) {
	
		?>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri().'/browsers/ffwin.css';?>" type="text/css" />
		<?php            
      
                if(strpos($browser,'Chrome')){
		?>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri().'/browsers/chromewin.css';?>" type="text/css" />
		<?php
	}
            }
                }

	if(strpos($browser,'Chrome')){
		?>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri().'/browsers/chrome.css';?>" type="text/css" />
		<?php
	}

        if(strpos($browser,'Safari')){
		?>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri().'/browsers/safari.css';?>" type="text/css" />
		<?php
	}
	if(strpos($browser,'MSIE')){
		?>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri().'/browsers/ie.css';?>" type="text/css" />
		<?php
	}

        if(strpos($browser,'MSIE 8')){
		?>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri().'/browsers/ie8.css';?>" type="text/css" />
		<?php
	}

	if(strpos($browser,'pera')){ ?>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri().'/browsers/opera.css';?>" type="text/css" />
	<?php
	}

        
?>
	<!-- Favicon -->
	<?php $favicon = get_option(THEME_NAME.'_custom_favicon'); if(empty($favicon)) { $favicon = get_template_directory_uri()."/images/favicon.png"; }?>
	<link rel="shortcut icon" href="<?php echo $favicon;?>" />

<?php 
	wp_deregister_script('jquery');    wp_register_script('jquery', 'http://ajax.microsoft.com/ajax/jQuery/jquery-1.5.1.min.js');    wp_enqueue_script('jquery');    wp_enqueue_script('bgpos', get_template_directory_uri().'/script/BeautifulNavigation/jquery.bgpos.js' );    wp_enqueue_script('superfish', get_template_directory_uri().'/script/superfish/superfish.js' );    wp_enqueue_script('ajaxpager', get_template_directory_uri() . '/script/quickpager/quickpager.jquery.js');    wp_enqueue_script('pirobox', get_template_directory_uri().'/script/pirobox/js/pirobox.js' );    wp_enqueue_script('contact', get_template_directory_uri().'/script/contact/contact.js' );    wp_enqueue_script('easing', get_template_directory_uri().'/script/easing/jquery.easing.1.3.js' );    wp_enqueue_script('mosaic', get_template_directory_uri().'/script/hover-img/js/mosaic.1.0.1.js' );    wp_enqueue_script('my-commons', get_template_directory_uri().'/script/common.js' );
    if (is_singular())        wp_enqueue_script("comment-reply");
    
    ?>

        <?php wp_head();
                remove_filter ('the_content',  'wpautop');
                remove_filter ('comment_text', 'wpautop');
                remove_filter('the_content', 'wptexturize');
                remove_filter('the_excerpt', 'wptexturize');
                remove_filter('comment_text', 'wptexturize');
                $twitter = get_option(THEME_NAME.'_footer_twitter');
        ?>
                <?php if ( is_front_page() ) {  ?>

        <style type="text/css">
            .nav ul li a:hover {
                background:none !important;
                    }
</style>
        <?php  } ?>


</head>
       
<body <?php $class='body'; body_class( $class ); ?>>




<div id="container">

    <!------ HEADER ------>
    <div class="header">

        <div class="top-tape left"></div>
        	<div class="wrapper">


                        <?php $logo = get_option(THEME_NAME.'_custom_logo');
        if(empty($logo)) {
            $logo = get_template_directory_uri()."/images/logo.png";
        }?>

                    <div class="nav left">
                        <?php wp_nav_menu( array('menu_class' => 'sf-menu',  'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
                    </div><!--/nav-->


                     <a href="<?php echo home_url(); ?>">
                         <div class="logo left" style="background-image: url(<?php echo $logo;?>)"></div>
                     </a>


                    <div class="nav right navright">
                        <?php wp_nav_menu( array(  'menu_class' => 'sf-menu', 'theme_location' => 'secondary' ) ); ?>
                    </div>

<?php if ( is_front_page() ) {  ?>
    <script type="text/javascript">
        $(document).ready(function(){
    jQuery('.menu-header .sf-menu .current-menu-item').addClass('current-menu-home');
    jQuery('.menu-header .sf-menu li').removeClass('current-menu-item');
   
        });
    </script>
    
    
    <?php  } else {  ?>
                    <div class="border-header2 left"></div>
                     <div class="home-money-button left">

     <?php
          global $wpdb;
          $querystr = "SELECT SUM(mc_gross) FROM " . $wpdb->prefix . "paypal_transactions";
          $pageposts = $wpdb->get_results($querystr, ARRAY_A);
          $transaction_sum = $pageposts[0] ["SUM(mc_gross)"];
          $transaction_sum = round($transaction_sum,0);
          $transaction_sum_str =(string)$transaction_sum;
          $transaction_array = str_split($transaction_sum_str);
      ?>

            <div class="home-money-button left">

               <div class="home-money left">
                    <ul>
                        <li class="home-money-one">You’ve Helped Raise…</li>
                        <li>$<div class="home-money-border left"></div></li>



                        <?php
                        $transactionlenght = strlen($transaction_sum_str);
                           if ($transactionlenght == 1) { ?>
                              <li>0<div class="home-money-border left"></div></li>
                              <li>0<div class="home-money-border left"></div></li>
                              <li>0<div class="home-money-border left"></div></li>
                              <li>0<div class="home-money-border left"></div></li>
                              <li>0<div class="home-money-border left"></div></li>
                       <?php  }

							elseif ($transactionlenght == 2) { ?>
                              <li>0<div class="home-money-border left"></div></li>                                
                              <li>0<div class="home-money-border left"></div></li>
                              <li>0<div class="home-money-border left"></div></li>
                              <li>0<div class="home-money-border left"></div></li>
                       <?php  } 

							elseif ($transactionlenght == 3) { ?>
                              <li>0<div class="home-money-border left"></div></li>
                              <li>0<div class="home-money-border left"></div></li>
                              <li>0<div class="home-money-border left"></div></li>                            
                       <?php  }

							elseif ($transactionlenght == 4) { ?>
                              <li>0<div class="home-money-border left"></div></li>
                              <li>0<div class="home-money-border left"></div></li>
                       <?php  }
							  
							elseif ($transactionlenght == 5) { ?>
                              <li>0<div class="home-money-border left"></div></li>
                       <?php  } 
                             else { ?>

                       <?php  } ?>

                        <?php foreach ($transaction_array as $transaction) {  ?>
                        <li><?php if(empty($transaction)){ echo "0"; } else { echo $transaction;} ?><div class="home-money-border left"></div></li>
                        <?php } ?>

                    </ul>
                </div><!--/home-money-->
     <?php
                        $paypal_redirect   = '';
                        $paypal_email 	   = get_option(THEME_NAME.'_paypal_email');
                        $currency 		   = get_option(THEME_NAME.'_currency');
                        $notify_url 	   = home_url().'/?paypal=1';
                        $return 		   = get_option(THEME_NAME.'_return_url');
                        $product_cost      = get_option(THEME_NAME.'_product_cost');
                        $product_name      = get_option(THEME_NAME.'_product_name');
                        $item_number       = '';
                        $subscription_key  = urlencode(strtolower(md5(uniqid())));
                        $item_name         = urlencode(''.$product_name.'');
                        $sandbox 		   = get_option(THEME_NAME.'_paypal_sandbox');

                        if($sandbox == '1'){
                            $sendbox_addon = 'sandbox.';
                        }else{
                            $sendbox_addon = '';
                        }

                        $custom_secret = md5(date('Y-m-d H:i:s').''.rand(1,10).''.rand(1,100).''.rand(1,1000).''.rand(1,10000));

                        $paypal_redirect  .= 'https://www.'.$sendbox_addon.'paypal.com/webscr?cmd=_xclick';
                        $paypal_redirect  .= '&business='.$paypal_email.'&item_name='.$item_name.'&no_shipping=1&no_note=1&item_number='.$subscription_key.'&currency_code='.$currency.'&charset=UTF-8&return='.urlencode($return).'&notify_url='.urlencode($notify_url).'&rm=2&custom='.$custom_secret.'&amount='.$product_cost;

				   ?>

                <div class="home-button left red">
                    <a href="<?php echo $paypal_redirect; ?>">Donate</a>
                </div>

            </div><!--/home-money-button-->

              <div class="border-header left"></div>
<?php } ?>

              </div><!--/wrapper-->
         </div><!--/header-->