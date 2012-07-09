<?php


// Separator Shortcode
	function showseparator() {
		
    	return '<span class="break shortcode-break"></span><br/><br/>';	
	}
	add_shortcode('separator', 'showseparator');


// Break Shortcode
	function showbreak() {
            return '<div class="clear-both break"></div>';	
	}
	add_shortcode('break', 'showbreak');


// Quote Shortcode
	function showQuote($atts, $content = null){
		return '<div class="quote-content"><div class="quote-center"><img title="images" alt="images" src="'.get_template_directory_uri().'/style/img/img-quote.png"><span>'.do_shortcode($content).'</span></div></div>';
	}
	add_shortcode('quote','showQuote');




// Call To Action Shortcode
        function showCallToAction($atts, $content = null){
         extract(shortcode_atts(array(
				'link' => '',
				'buttontext' => ''
		), $atts));
			return '<div class="about-box"><div class="about-content">'.do_shortcode($content).'</div><a href="'.$link.'"><div class="shortcode-button-default button-right"><div class="button-default-left"></div><div class="button-default-center margin-correction">'.$buttontext.'</div><div class="button-default-right"></div></a></div></div>';

	}
	add_shortcode('calltoaction','showCallToAction');
	

// Full Width Shortcode
	function showfullwidth($atts,$content = null){
		return '<div id="fullwidth-box">'.do_shortcode($content).'</div>';		
	}
	add_shortcode('fullwidth','showfullwidth');

        //4 columns shortcode

        function showfourcolumns($atts, $content = null ) {

    	return '<div id="four-columns">'.do_shortcode($content).'</div>';
	}
	add_shortcode('four-columns', 'showfourcolumns');


// 3 Columns Shortcode
	function showthreecolumns($atts, $content = null ) {
		
    	return '<div id="three-columns">'.do_shortcode($content).'</div>';	
	}
	add_shortcode('three-columns', 'showthreecolumns');	


// 2 Columns Shortcode
	function showtwocolumns($atts, $content = null ) {
		
    	return '<div id="two-columns">'.do_shortcode($content).'</div>';	
	}
	add_shortcode('two-columns', 'showtwocolumns');	

        
// One Cell For Columns Shortcode
	function showonecell($atts, $content = null ) {
	    return '<div class="one_cell">'.do_shortcode($content).'</div>';	
	}
	
	add_shortcode('one_cell', 'showonecell');	

        
// Last Cell For Columns Shortcode
	function showonecelllast($atts, $content = null ) {
	    return '<div class="one_cell" style="margin: 0pt!important;">'.do_shortcode($content).'</div>';	
	}
	
	add_shortcode('one_cell_last', 'showonecelllast');	


// Image For Columns Shortcode
	function cellimage($atts, $content = null ) {
		$template_directory = get_template_directory_uri();
		extract(shortcode_atts(array(
				'title' => ''
		), $atts));
	    return '<div class="cell_image_front">
		<a title="'.$title.'" rel="single" class="pirobox first last" href="'.do_shortcode($content).'"><img title="'.$title.'" alt="_" src="'.$template_directory.'/script/timthumb.php?src='.do_shortcode($content).'&w=36&h=36&zc=0&q=100"></a>
		</div>';

	}
	add_shortcode('cell_image', 'cellimage');

// Text For Columns Shortcode
	function celltextshortcode($atts, $content = null ) {
	    return '<div class="cell_text">'.do_shortcode($content).'</div>';	
	}
	add_shortcode('cell_text', 'celltextshortcode');

	
// Title For Columns Shortcode
	function showtitles($atts,$content = null){
		return '<div class="titles">'.do_shortcode($content).'</div>';
	}
	add_shortcode('titles', 'showtitles');
	
	
// Cell Title For Columns Shortcode
	function celltitle($atts,$content = null){
		extract(shortcode_atts(array(
				'link' => ''
		), $atts));
		if($link <> ""){
			return '<div class="cell_title"><h2><a href="'.$link.'">'.do_shortcode($content).'</a></h2></div>';
		}else{
			return '<div class="cell_title"><h2>'.do_shortcode($content).'</h2></div>';
		}
	}
	add_shortcode('cell_title', 'celltitle');
	
	
// Cell Subtitle For Columns Shortcode
	function cellsubtitle($atts,$content = null){
		return '<div class="cell_subtitle"><h5>'.do_shortcode($content).'</h5></div>';
	}
	add_shortcode('cell_subtitle', 'cellsubtitle');
	

// Line Shortcode
	function callline($atts,$content = null){
		
		return '<div id="horizontal-line"></div>';
		
	}
	add_shortcode('line', 'callline');

        
//******************
	function showBox($atts, $content = null ) {
		
			extract(shortcode_atts(array(
				'width' => '100',
				'align'=>'left',
		), $atts));
		
		$new_width = $width - 3;
		$new_width .= "%";
		if ($width==50) {
			$new_width = "47%;";
		}
		if ($new_width==30) {
			$new_width = "30.2%;";
		}
		
		if ($width == 100){
			$new_width = "961px";
		}
		
		
    	return '<div class="shortcode-box" id="box" style="width:'.$new_width.';">'.do_shortcode($content).'</div>';	
	}
	add_shortcode('box', 'showBox');
//***************
	
	
// Button Shortcode
	function showButton($atts, $content= null ) {
		
			extract(shortcode_atts(array(
				'url' => '',
				'margin'=>'',
				'align'=>'left',
				'color' => 'red'
		), $atts));
		
		$margin = str_replace('px','',$margin);
		if(!empty($color)) {$new_color = $color;}


		return 	'<div class="shortcode-button'.$new_color.'" style="float:'.$align.'!important;margin-left:'.$margin.'px;">
					<a href="'.$url.'"><div class="'.$new_color.'-left"></div>
						<div class="'.$new_color.'-center">
							<div class="'.$new_color.'-content">'.$content.'</div>
						</div>
					<div class="'.$new_color.'-right"></div></a>
				</div>';

	}
	add_shortcode('button', 'showButton'); 
	

// One 3rd For Column Shortcode
	function showonethird($atts, $content= null ) {
		
			extract(shortcode_atts(array(
				'url' => '',
				'color'=>'',
				'margin'=>'',
				'align'=>'left',
				'from'=>''
		), $atts));

		return '<span class="onethird '.$from.'">'.do_shortcode($content).'</span>';

	}
	add_shortcode('onethird', 'showonethird');


// One 3rd Last For Column Shortcode
	function showonethirdlast($atts, $content= null ) {
		
			extract(shortcode_atts(array(
				'url' => '',
				'color'=>'',
				'margin'=>'',
				'align'=>'left',
				'from'=>''
		), $atts));

		return '<span class="onethird last '.$from.'">'.do_shortcode($content).'</span>';

	}
	add_shortcode('onethird_last', 'showonethirdlast');

        
// Two 3rd For Column Shortcode
	function showtwothird($atts, $content= null ) {
		
			extract(shortcode_atts(array(
				'url' => '',
				'color'=>'',
				'margin'=>'',
				'align'=>'left'
		), $atts));

		return '<span class="twothird">'.do_shortcode($content).'</span>';
	}
	add_shortcode('twothird', 'showtwothird');


// Two 3rd Last For Column Shortcode
	function showtwothirdlast($atts, $content= null ) {
		
			extract(shortcode_atts(array(
				'url' => '',
				'color'=>'',
				'margin'=>'',
				'align'=>'left'
		), $atts));

		return '<span class="twothird last">'.do_shortcode($content).'</span>';

	}
	add_shortcode('twothird_last', 'showtwothirdlast'); 


// One Half For Column Shortcode
	function showonehalf($atts, $content= null ) {
		
			extract(shortcode_atts(array(
				'url' => '',
				'color'=>'',
				'margin'=>'',
				'align'=>'left'
		), $atts));

		return '<span class="onehalf">'.do_shortcode($content).'</span>';

	}
	add_shortcode('onehalf', 'showonehalf'); 


// One Half Last For Column Shortcode
	function showonehalflast($atts, $content= null ) {
		
			extract(shortcode_atts(array(
				'url' => '',
				'color'=>'',
				'margin'=>'',
				'align'=>'left'
		), $atts));

		return '<span class="onehalf last">'.do_shortcode($content).'</span>';

	}
	add_shortcode('onehalf_last', 'showonehalflast'); 


// Headings Shortcode
        function showHeading($atts,$content = null){
            extract(shortcode_atts(array(
				'type'=>'h1'
		), $atts));
            return '<'.$type.' class="heading">'.$content.'</'.$type.'>';
        }
        add_shortcode('heading','showHeading');
        

?>