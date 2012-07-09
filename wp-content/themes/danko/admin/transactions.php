<?php
/*
 * PAYPAL TRANSACTIONS
 */
?>
<?php
global $wpdb;
 $querystr = "SELECT * FROM " . $wpdb->prefix . "paypal_transactions ORDER BY id DESC";
 $pageposts = $wpdb->get_results($querystr, OBJECT);
 $rows_total_count = count($pageposts);
 $rows_limit = 20;
 $page = @$_GET['transactions_page'];
 
 if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $rows_total_count)) {
      $page = 1;
 } 
 
 $total_pages = ceil($rows_total_count / $rows_limit);
 $set_limit = $page * $rows_limit - ($rows_limit);
 
 $querystr = "SELECT * FROM " . $wpdb->prefix . "paypal_transactions ORDER BY id DESC LIMIT ".$set_limit.",".$rows_limit;
 $pageposts = $wpdb ->get_results($querystr, OBJECT);
 //print_r($pageposts);
 ?>
<div class="wrap">
<h2>Transactions</h2>


<table class="widefat">
<thead>
    <tr>
        <th>Transaction ID</th>
        <th>Payment Date</th>
        <th>Payment Status</th>
        <th>Currency</th>
        <th>Amount (Gross)</th>
        <th>Payer</th>              
    </tr>
</thead>
<tfoot>
    <tr>
        <th>Transaction ID</th>
        <th>Payment Date</th>
        <th>Payment Status</th>
        <th>Currency</th>
        <th>Amount (Gross)</th>
        <th>Payer</th>     
    </tr>
</tfoot>
<tbody>
<?php 
@$post_count = 0;
foreach ($pageposts as $post){
    
echo '<tr>
     <td>'.$post->txn_id.'</td>
     <td>'.$post->payment_date.'</td>
     <td>'.$post->payment_status.'</td>
     <td>'.$post->mc_currency.'</a></td>
     <td>'.$post->mc_gross.'</td>
     <td>'.$post->first_name.' '.$post->last_name.' ('.$post->payer_email.')'.'</td>
   </tr>';
$post_count++;
} 
if($post_count == 0){
    echo '<tr>
<td>No transactions yet.</td>        
</tr>';
}
?>
</tbody>
</table>

<div class="tablenav bottom">

		<div class="alignleft actions">
		</div>
		<div class="alignleft actions">
		</div>
<div class="tablenav-pages"><span class="displaying-num"><?php echo $rows_total_count;?> items</span>
<span class="pagination-links">
    <a href="<?php echo get_option('siteurl').'/wp-admin/admin.php?page=Appos-transaction&transactions_page=1'?>" title="Go to the first page" class="first-page <?php if($page==1){echo "disabled";}?>">«</a>
    <a href="<?php echo get_option('siteurl').'/wp-admin/admin.php?page=Appos-transaction&transactions_page='.($page-1);?>" title="Go to the previous page" class="prev-page <?php if($page==1){echo "disabled";}?>"><</a>
    
<span class="paging-input"><?php echo $page;?> of <span class="total-pages"><?php echo $total_pages;?></span></span>

<a href="<?php echo get_option('siteurl').'/wp-admin/admin.php?page=Appos-transaction&transactions_page='.($page+1);?>" title="Go to the next page" class="next-page <?php if($page==$total_pages){echo "disabled";}?>">></a>
<a href="<?php echo get_option('siteurl').'/wp-admin/admin.php?page=Appos-transaction&transactions_page='.$total_pages;?>" title="Go to the last page" class="last-page <?php if($page==$total_pages){echo "disabled";}?>">»</a></span></div>
		<br class="clear">
	</div>
</div>