<?php

	
	// Text limiter 
	function textLimit($text, $length = 180) {
    if((mb_strlen($text) > $length)) {
        $whitespaceposition = mb_strpos($text, ' ', $length) - 1;
        if($whitespaceposition > 0) {
            $chars = count_chars(mb_substr($text, 0, ($whitespaceposition + 1)), 1);
            if ($chars[ord('<')] > $chars[ord('>')]) {
                $whitespaceposition = mb_strpos($text, ">", $whitespaceposition) - 1;
            }
            $text = mb_substr($text, 0, ($whitespaceposition + 1));
        }
        // close unclosed html tags
        if(preg_match_all("|(<([\w]+)[^>]*>)|", $text, $aBuffer)) {
            if(!empty($aBuffer[1])) {
                preg_match_all("|</([a-zA-Z]+)>|", $text, $aBuffer2);
                if(count($aBuffer[2]) != count($aBuffer2[1])) {
                    $closing_tags = array_diff($aBuffer[2], $aBuffer2[1]);
                    $closing_tags = array_reverse($closing_tags);
                    foreach($closing_tags as $tag) {
                            $text .= '</'.$tag.'>';
                    }
                }
            }
        }

    }
    return $text.' ...';
} 

/*truncate_post(400); */
 function truncate_post($amount, $echo_out=true) {

	$truncate = get_the_content(); 
	$truncate = apply_filters('the_content', $truncate);
	$truncate = preg_replace('@<script[^>]*?>.*?</script>@si', '', $truncate);
	$truncate = preg_replace('@<style[^>]*?>.*?</style>@si', '', $truncate);
	$truncate = strip_tags($truncate);
	if(mb_strlen($truncate) > $amount){
		$dots = "...";
	}else{
		$dots = "";
	}
	$truncate = substr($truncate, 0, strrpos(substr($truncate, 0, $amount), ' '));
	
	if ($echo_out) echo $truncate, $dots;
	else return ($truncate.$dots);
}

// Limit string to word limit
function string_limit_words($string, $word_limit)
		{
		  $words = explode(' ', $string, ($word_limit + 1));
		  if(count($words) > $word_limit){
		  array_pop($words);
		  $dots = "..";
		  }else{
		  	$dots = "";
		  }
		  return (implode(' ', $words)).$dots;
		}	
		
// Current Page
	function curPageURL() {
	 $pageURL = 'http';
	 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	 $pageURL .= "://";
	 if ($_SERVER["SERVER_PORT"] != "80") {
	  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	 } else {
	  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	 }
	 return $pageURL;
	}
	
	
	
	
	
?>