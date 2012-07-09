<?php
function my_function_admin_bar(){ return false; }
add_filter( 'show_admin_bar' , 'my_function_admin_bar');

//Define constants:
define('GD_FUNCTIONS', TEMPLATEPATH . '/admin/');
define('GD_WIDGETS', TEMPLATEPATH . '/admin/widgets/');
define('SCRIPTS', get_template_directory_uri() . '/script/');
define('GD_THEME_DIR', get_template_directory_uri());
define('AJAX_FUNCTIONS', get_template_directory_uri().'/lib/');
define('GD_MAINMENU_NAME', 'general-options');
define('THEME_NAME','Danko');
define('THEME_VERSION','v.1.0.');
define('GD_THEME', THEME_NAME);
define('GD_SHORT', THEME_NAME.'_');
define('GD_THEME_VERSION', '1.0');
define('GD_SITE_URL', get_site_url());
update_option('THEME_NAME',THEME_NAME);
update_option('THEME_VERSION',THEME_VERSION);


	require_once (GD_FUNCTIONS . 'functions.php');
	//Load admin specific files:
	if (is_admin()) :
		require_once (GD_FUNCTIONS . 'functions/meta-functions.php');
		require_once (GD_FUNCTIONS . 'functions/ajax-image.php');
		require_once (GD_FUNCTIONS . 'functions/admin-helper.php');
		require_once (GD_FUNCTIONS . 'functions/adding_menu.php');
		require_once (GD_FUNCTIONS . 'functions/helpers.php');
		require_once (GD_FUNCTIONS . 'theme.php');
        endif;

	//Register sidebar
	require_once (GD_FUNCTIONS . 'functions/register_sidebar.php');

        //Load widgets:
	
	require_once (GD_WIDGETS . 'widget-recent.php');
	require_once (GD_WIDGETS . 'widget-comments.php');
	require_once (GD_WIDGETS . 'widget-social.php');
	require_once (GD_WIDGETS . 'widget-recent-actions.php');

	//Load helpers:
	require_once (GD_FUNCTIONS . 'functions/helpers.php');
	require_once (GD_FUNCTIONS . 'functions/shortcodes.php');


	register_nav_menus( array(
		'primary' => __( 'Left Navigation', 'WDS' ),
		'secondary' => __('Right Navigation', 'WDS')
		 ));  


	remove_filter( 'the_content', 'wpautop' );


	add_theme_support( 'post-thumbnails', array( 'post' ) );
	add_theme_support( 'automatic-feed-links' );



//PayPal notification
if(@$_GET['paypal'] == '1'){
	paypal_notification();
}
if(@$_GET['download-file'] != ''){
    download_file();
}

function paypal_notification(){
global $wpdb;
$sandbox = $_POST['test_ipn'];

foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}

// assign posted variables to local variables
$txn_id = $_POST['txn_id'];
$item_name = $_POST['item_name'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$payer_email = $_POST['payer_email'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$custom = $_POST['custom'];
$payment_date = $_POST['payment_date'];
$test_ipn = $_POST['test_ipn'];


$todayDate = date("Y-m-d H:i:s");
$date = strtotime(date("Y-m-d H:i:s", strtotime($todayDate)) . " +".$valid_days." day");
$valid_link_date = date('Y-m-d H:i:s',$date);

$table_name = $wpdb->prefix . "paypal_transactions";
$wpdb->query('INSERT INTO '.$table_name.'
    (txn_id, payment_date, payment_status, mc_currency, mc_gross, first_name, last_name, payer_email, custom, downloaded, valid_date, test_ipn)
    VALUES ("'.$txn_id.'",
            "'.$payment_date.'",
            "'.$payment_status.'",
            "'.$payment_currency.'",
             '.$payment_amount.',
            "'.$first_name.'",
            "'.$last_name.'",
            "'.$payer_email.'",
            "'.$custom.'",
             "0",
            "'.$valid_link_date.'",
            "'.$test_ipn.'"
)');



$message = get_option(THEME_NAME.'_email_message');
$mail_template_from = array('[FIRST_NAME]','[LAST_NAME]','[TRANSACTION_ID]');
$mail_template_to = array($first_name, $last_name, $txn_id);

$message = str_replace($mail_template_from, $mail_template_to, $message);

$email_headers = 'From: '.get_option('blogname').' <'.get_option('admin_email').'>' . "\r\n";
wp_mail( $payer_email, 'Thank You', $message, $email_headers);

//mail('marko.ic@gmail.com', 'Download link', $message, $email_headers);
// check the payment_status is Completed
// check that txn_id has not been previously processed
// check that receiver_email is your Primary PayPal email
// check that payment_amount/payment_currency are correct
// process payment
//}
//}
}

function download_file(){
global $wpdb;
//echo $_GET['download-file'];
$table_name = $wpdb->prefix . "paypal_transactions";
$querystr = "SELECT * FROM " . $table_name . " WHERE custom = '".mysql_real_escape_string(@$_GET['download-file'])."' AND test_ipn = '".get_option(THEME_NAME.'_paypal_sandbox')."' AND valid_date >= NOW()";
$result = $wpdb->get_results($querystr,ARRAY_A);
$id = @$result[0]['id'];
    if($id != ''){

        $updateDownloads = "UPDATE " . $wpdb->prefix . "paypal_transactions SET downloaded = (downloaded + 1) WHERE custom = '".mysql_real_escape_string(@$_GET['download-file'])."'";
        $wpdb->query( $updateDownloads );

        $download_url = get_option(THEME_NAME.'_file_path');        
	header('Content-Type: application/octet-stream');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Expires: 0');
	$result = wp_remote_get($download_url);
	echo $result['body'];
	die();
    }
}
?>
<?php
if ( is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {
    danko_install();
}
function danko_install() {
   global $wpdb;
   $table_name = $wpdb->prefix . "paypal_transactions";
   $sql = "CREATE TABLE IF NOT EXISTS " . $table_name . " (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID',
  `txn_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL COMMENT 'PayPal transaction ID',
  `payment_date` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Payment date received by PayPal',
  `payment_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `mc_currency` varchar(5) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Currency (EUR, USD, etc.)',
  `mc_gross` float NOT NULL COMMENT 'Product gross price',
  `first_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Payer first name',
  `last_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Payer last name',
  `payer_email` text COLLATE utf8_unicode_ci NOT NULL,
  `custom` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Security code',
  `downloaded` int(11) NOT NULL COMMENT 'How many times payer downloaded product',
  `valid_date` datetime NOT NULL COMMENT 'Validation date of link sent to payer',
  `test_ipn` tinyint(4) NOT NULL COMMENT 'Is it Sendbox? 1 = (test purchase), 0 = no (real purchase)',
  PRIMARY KEY (`id`)
) CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;";

   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   if(dbDelta($sql)){
       //TABLE CREATED!
   }else{
       //TABLE ISN'T CREATED
   }
}

add_action('wp_head', 'paypal_redirect');

function paypal_redirect(){

    if(isset($_POST['non_paid_enter'])){
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
                        $paypal_redirect  .= '&business='.$paypal_email.'&no_shipping=1&no_note=1&currency_code='.$currency.'&charset=UTF-8&return='.urlencode($return).'&notify_url='.urlencode($notify_url).'&rm=2&custom='.$custom_secret.'&amount='.$_POST['non_paid_enter'];


                        echo '
                            <script type="text/javascript">
<!--
window.location = "'.$paypal_redirect.'"
//-->
</script>';
    }
}
?>