<?php
// Add javascript to generate a quicktag button. If the quicktag bar
// isn't available, instead put a link below the posting field entry.
function pluggy_quicktag_like_button() {
  // Only add the javascript to post.php, post-new.php, page-new.php, or
  // bookmarklet.php pages
  if (strpos($_SERVER['REQUEST_URI'], 'post.php') ||
      strpos($_SERVER['REQUEST_URI'], 'post-new.php') ||
      strpos($_SERVER['REQUEST_URI'], 'page-new.php') ||
      strpos($_SERVER['REQUEST_URI'], 'bookmarklet.php')) {
    // Print out the HTML/Javascript to add the button
?>
<style type="text/css">
#pluggy_link{margin-bottom:10px; display:none;}
</style>
<div id="pluggy_link">
[a href="#" onclick="return pluggy_open('tinymce=true')"]Pluggy![/a]
</div>
<div id="panel">
<style type="text/css">
.formlabel{
width:100px;
text-align:right;
float:left;
}
.close{cursor:pointer;padding:0 3px;width:10px!important;}
.column3action span input{float:left;}
.column4action span input{float:left;}
.column5action span input{float:left;}
.ed_div{padding:0 0 3px 0;z-index:999;}
#ed_toolbar input, #ed_reply_toolbar input{
padding-top:3px!important;
padding-bottom:3px!important;
}


</style>

<div class="addbuttonaction actionspan" style="display:none;position:absolute;top:200px;left:300px;width:auto!important;">
<div class="actionhelper"></div>
<span style="float:left;height: 200px;width: 450px !important;">
<h1>Button</h1>
<div style="float:left;width:200px!important;">
<label class='formlabel'>Button URL:</label><br/><input type="text" name="buttonurl"><br/>
<label class='formlabel'>Left Margin:</label><br/><input type="text" name="buttonleftmargin"><br/>
<label class='formlabel'>Align:</label><br/><select name="buttonalign" class="buttonalign" style="width: 200px!important;height:24px!important;"><option value="left">Left<option value="right">Right</select><br/>
</div >
<div  style="float:left;width:200px!important;margin-left:20px!important">
<label class='formlabel'>Value:</label><br/><input type="text" name="buttonvalue"><br/>
<label class='formlabel'>Color:</label><br/>
<select name="colorofbutton" class="colorofbutton" style="height: 24px;width: 200px !important;">
	<option value="default">Default
        <option value="yellow">Yellow
        <option value="brown">Brown
        <option value="green">Green
</select>
</div >
<div class="previewbutton" style="width:377px!important;float:left;">
	<div class="thepreviewbutton" style="width:76px!important;height:30px!important;margin:64px 0 0 166px;"></div>
</div>
<script type="text/javascript">
	jQuery('.colorofbutton').change(function(){
		var color = jQuery(this).val();

		jQuery('.thepreviewbutton').css('background-image','url(<?php echo get_template_directory_uri().'/admin/style/img/button-'; ?>'+color+'.png)').css('background-position','left top').css('display','block');
	});
	jQuery('.thepreviewbutton').hover(function(){
		jQuery(this).css('background-position','left bottom');
	},function(){
		jQuery(this).css('background-position','left top');
	});
</script>
</span>
<div class="actionheader"><input type="button" class="close actionbutton" value=""><input type="button" class="resetbutton actionbutton" value="Reset"><input type="button" class="buttonsubmit actionbutton" value="ADD"><p class="actiontitle">Add Button</p></div>
</div>

<div class="column1action actionspan" style="display:none;position:absolute;top:200px;left:300px;width: 500px;">
<div class="actionhelper"></div>
<span style="float:left;width: 480px;">
<h1>Fullwidth</h1>
<label class='formlabel'>Cell Title:</label><br/><input type="text" name="celltitlehere1two1"><br/>
<label class='formlabel'>Cell Title Link:</label><br/><input type="text" name="celltitlelinkhere1two1"><br/>
<label class='formlabel'>Cell Text:</label><br/><textarea name="celltexthere1two" class="celltexthere1two1"></textarea><br/><br/>
</span>
<div class="actionheader"><input type="button" class="close actionbutton" value=""><input type="button" class="resetbutton actionbutton" value="Reset"><input type="button" class="column1submit actionbutton" value="ADD"><p class="actiontitle">Add Fullwidth</p></div>

</div>

<div class="column2action actionspan" style="display:none;position:absolute;top:200px;left:300px;width: 500px;">
<div class="actionhelper"></div>
<span style="float:left;width: 229px;">
<h1>Left Half</h1>
<label class='formlabel'>Cell Title:</label><br/><input type="text" name="celltitlehere1two"><br/>
<label class='formlabel'>Cell Title Link:</label><br/><input type="text" name="celltitlelinkhere1two"><br/>
<label class='formlabel'>Cell Text:</label><br/><textarea name="celltexthere1two" class="celltexthere1two"></textarea><br/><br/>
</span>
<span style="float:left;width: 229px;border-right:0px;">
<h1>Right Half</h1>
<label class='formlabel'>Cell Title:</label><br/><input type="text" name="celltitlehere2two"><br/>
<label class='formlabel'>Cell Title Link:</label><br/><input type="text" name="celltitlelinkhere2two"><br/>
<label class='formlabel'>Cell Text:</label><br/><textarea name="celltexthere2two" class="celltexthere2two"></textarea><br/><br/>
</span>
<div class="actionheader"><input type="button" class="close actionbutton" value=""><input type="button" class="resetbutton actionbutton" value="Reset"><input type="button" class="column2submit actionbutton" value="ADD"><p class="actiontitle">Add 2 Columns</p></div>

</div>

<div class="column3action actionspan" style="display:none;position:absolute;top:200px;left:300px;">
<div class="actionhelper"></div>
<span style="float:left;">
<h1>First cell</h1>
<label class='formlabel'>Cell Title:</label><br/><input type="text" name="celltitlehere1"><br/>
<label class='formlabel'>Cell Title Link:</label><br/><input type="text" name="celltitlelinkhere1"><br/>
<label class='formlabel'>Cell Text:</label><br/><textarea name="celltexthere1" class="celltexthere1"></textarea><br/><br/>
</span>
<span style="float:left;">
<h1>Second cell</h1>
<label class='formlabel'>Cell Title:</label><br/><input type="text" name="celltitlehere2"><br/>
<label class='formlabel'>Cell Title Link:</label><br/><input type="text" name="celltitlelinkhere2"><br/>
<label class='formlabel'>Cell Text:</label><br/><textarea name="celltexthere2" class="celltexthere2"></textarea><br/><br/>
</span>
<span style="float:left;" class="last">
<h1>Third cell</h1>
<label class='formlabel'>Cell Title:</label><br/><input type="text" name="celltitlehere3"><br/>
<label class='formlabel'>Cell Title Link:</label><br/><input type="text" name="celltitlelinkhere3"><br/>
<label class='formlabel'>Cell Text:</label><br/><textarea name="celltexthere3" class="celltexthere3"></textarea><br/><br/>
</span>
<div class="actionheader"><input type="button" class="close actionbutton" value=""><input type="button" class="resetbutton actionbutton" value="Reset"><input type="button" class="column3submit actionbutton" value="ADD"><p class="actiontitle">Add 3 Columns</p></div>

</div>


    <div class="column4action actionspan" style="display:none;position:absolute;top:200px;left:300px;">
<div class="actionhelper"></div>
<span style="float:left;">
<h1>First cell</h1>
<label class='formlabel'>Cell Title:</label><br/><input type="text" name="celltitlehere1four"><br/>
<label class='formlabel'>Cell Title Link:</label><br/><input type="text" name="celltitlelinkhere1four"><br/>
<label class='formlabel'>Cell Text:</label><br/><textarea name="celltexthere1four" class="celltexthere1four"></textarea><br/><br/>
</span>
<span style="float:left;">
<h1>Second cell</h1>
<label class='formlabel'>Cell Title:</label><br/><input type="text" name="celltitlehere2four"><br/>
<label class='formlabel'>Cell Title Link:</label><br/><input type="text" name="celltitlelinkhere2four"><br/>

<label class='formlabel'>Cell Text:</label><br/><textarea name="celltexthere2four" class="celltexthere2four"></textarea><br/><br/>
</span>
<span style="float:left;">
<h1>Third cell</h1>
<label class='formlabel'>Cell Title:</label><br/><input type="text" name="celltitlehere3four"><br/>
<label class='formlabel'>Cell Title Link:</label><br/><input type="text" name="celltitlelinkhere3four"><br/>
<label class='formlabel'>Cell Text:</label><br/><textarea name="celltexthere3four" class="celltexthere3four"></textarea><br/><br/>
</span>
<span style="float:left;" class="last">
<h1>Fourth cell</h1>
<label class='formlabel'>Cell Title:</label><br/><input type="text" name="celltitlehere4four"><br/>
<label class='formlabel'>Cell Title Link:</label><br/><input type="text" name="celltitlelinkhere4four"><br/>
<label class='formlabel'>Cell Text:</label><br/><textarea name="celltexthere4four" class="celltexthere4four"></textarea><br/><br/>
</span>
<div class="actionheader"><input type="button" class="close actionbutton" value=""><input type="button" class="resetbutton actionbutton" value="Reset"><input type="button" class="column4submit actionbutton" value="ADD"><p class="actiontitle">Add 4 Columns</p></div>
</div>



<div class="h1h2action actionspan" style="display:none;position:absolute;top:200px;left:300px;width: 600px;">
<div class="actionhelper"></div>
<span style="float:left;width:580px;">
<label class='formlabel'>Heading text:</label><br/><input type="text" name="headingtext"><br/>
<label class='formlabel'>Heading type:</label><br/><select name="headingtype"><option value="h1">H1<option value="h2">H2<option value="h3">H3<option value="h4">H4<option value="h5">H5</select><br/>


</span>
<div class="actionheader"><input type="button" class="close actionbutton" value=""><input type="button" class="resetbutton actionbutton" value="Reset"><input type="button" class="h1h2submit actionbutton" value="ADD"><p class="actiontitle">Add H1 - H2 - H3 - H4 - H5</p></div>

</div>


<div class="calltoaction actionspan" style="display:none;position:absolute;top:200px;left:300px;width:700px;height: 300px;">
<div class="actionhelper"></div>
<label class="formlabel">Call To Action Text:</label>
<textarea name="calltoaction" class="calltoactiontext" style="margin: 2% 0 0 2% !important;width: 96% !important;height:100px;"></textarea><br/><br/>
<label class='formlabel' >Call To Action Url:</label><br/><input type="text" name="calltoactionurl" style="margin: 2% 0 0 2% !important;width: 96% !important;"><br/>
<label class='formlabel' >Button Text::</label><br/><input type="text" name="buttontext" style="margin: 2% 0 0 2% !important;width: 96% !important;"><br/>
<div class="actionheader"><input type="button" class="close actionbutton" value=""><input type="button" class="resetbutton actionbutton" value="Reset" ><input type="button" class="calltoactionsubmit actionbutton" value="ADD"><p class="actiontitle">Add Call To Action</p></div>
</div>


<script type="text/javascript">

jQuery(function($){
jQuery.fn.center = function () {
    this.css("position","absolute");
    this.css("top", ( jQuery(window).height() - this.height() ) / 2+jQuery(window).scrollTop() + "px");
    this.css("left", ( jQuery(window).width() - this.width() ) / 2 + "px");
    return this;
}
});

jQuery.fn.extend({
insertAtCaret: function(myValue){
  return this.each(function(i) {
    if (document.selection) {
      this.focus();
      sel = document.selection.createRange();
      sel.text = myValue;
      this.focus();
    }
    else if (this.selectionStart || this.selectionStart == '0') {
      var startPos = this.selectionStart;
      var endPos = this.selectionEnd;
      var scrollTop = this.scrollTop;
      this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
      this.focus();
      this.selectionStart = startPos + myValue.length;
      this.selectionEnd = startPos + myValue.length;
      this.scrollTop = scrollTop;
    } else {
      this.value += myValue;
      this.focus();
    }
  })
}
});

jQuery(function($){
	jQuery('.resetbutton').live('click',function(){
		jQuery('input[type=text]','#panel').val('');
		jQuery('textarea','#panel').val('');
                jQuery('.appendtip').empty();
                jQuery('.listtext').empty();
		jQuery("#oneinlist").val('');

	});
	jQuery('.column1action').center();
	jQuery('.column2action').center();
	jQuery('.column3action').center();
        jQuery('.h1h2action').center();
	jQuery('.addbuttonaction').center();
	jQuery('.quoteaction').center();
	jQuery('.calltoaction').center();
});

jQuery(document).ready(function($) {

	jQuery('.thepreviewbutton').css('background-image','url(<?php echo get_template_directory_uri().'/admin/style/img/button-default.png)'?>').css('background-position','left top').css('display','block');

	jQuery('.close').click(function(){
		jQuery('.actionspan').css('display','none');
	})

	//Buttons
	jQuery('.addbutton').click(function(){
		jQuery('.actionhelper').hide();
		jQuery('.addbuttonaction').css('display','block');
	});


	jQuery('.buttonsubmit').click(function(){

		var buttonurl = jQuery('input[type=text][name=buttonurl]').val();
		var buttonleftmargin = jQuery('input[type=text][name=buttonleftmargin]').val();
		var buttonalign = jQuery('.buttonalign').val();
		var buttonvalue = jQuery('input[type=text][name=buttonvalue]').val();
		var buttoncolor = jQuery('.colorofbutton').val();

		if(buttonvalue !== "" && buttonurl !== ""){


		var insert = '[button url="'+buttonurl+'" ';
		if(buttoncolor !== ""){
			insert = insert + ' color="'+buttoncolor+'" ';
		}
		if(buttonalign !== ""){
			insert = insert + ' align="'+buttonalign+'" ';
		}
		if(buttonleftmargin !== ""){
			insert = insert + ' margin="'+buttonleftmargin+'" ';
		}
		insert = insert + ' color="'+buttoncolor+"'";
		insert = insert + ']'+buttonvalue+'[/button]';

		jQuery('#content').insertAtCaret(insert);
		jQuery('.addbuttonaction').css('display','none');
		}else{
			jQuery('.actionhelper','.addbuttonaction').empty().append('You need to insert Button Url and Button Value').slideDown();
		}
	});

	// Break
	jQuery('.break').click(function(){
		jQuery('#content').insertAtCaret('\n[break]\n');
	});
        jQuery('.separator').click(function(){
            jQuery('#content').insertAtCaret('\n[separator]\n');
        });
	jQuery('.line').click(function(){
		jQuery('#content').insertAtCaret('\n[line]\n');
	});


	// H1 H2 H3
        jQuery('.addh1h2').click(function(){
		jQuery('.actionhelper').hide();
		jQuery('.h1h2action').css('display','block');
	});

             jQuery('.h1h2submit').click(function(){

		var text = jQuery('input[type=text][name=headingtext]').val();
		var type = jQuery('select[name=headingtype]').attr("selected", true).val();

		if(text !== ""){

		var insert = '[heading type="'+type+'" ]'+text+'[/heading]';


		jQuery('#content').insertAtCaret(insert);
		jQuery('.h1h2action').css('display','none');
		}else{

			jQuery('.actionhelper','.h1h2action').empty().append('You need to insert heading text').slideDown();
		}
	});

	//Quote

	jQuery('.addquote').click(function(){
		jQuery('.actionhelper').hide();
		jQuery('.quoteaction').css('display','block');
	});

	jQuery('.quotesubmit').click(function(){
		var text = jQuery('.quotedtext').val();
		insert = '[quote]'+text+'[/quote]';
		jQuery('#content').insertAtCaret(insert);
		jQuery('.actionspan').css('display','none');

	});


        	//CALL TO ACTION

	jQuery('.addcalltoaction').click(function(){
		jQuery('.actionhelper').hide();
		jQuery('.calltoaction').css('display','block');
	});

	jQuery('.calltoactionsubmit').click(function(){
                var text = jQuery('.calltoactiontext').val();
                var calltoactionurl = jQuery('input[type=text][name=calltoactionurl]').val();
                var buttontext = jQuery('input[type=text][name=buttontext]').val();
                if(calltoactionurl !== ""){
                    insert = '[calltoaction' + ' link="'+calltoactionurl+'" buttontext="'+buttontext+'"]'+text+'[/calltoaction]';
                }
                else{
                    insert = '[calltoaction]'+text+'[/calltoaction]';
                }
                jQuery('#content').insertAtCaret(insert);
                jQuery('.actionspan').css('display','none');

	});


	//column 1
    jQuery('.column1').click(function(){
    	jQuery('.actionhelper').hide();
		 jQuery('.column1action').css('display','block');

	});

	jQuery('.column1submit').click(function(){
		var celltitlehere1 = jQuery('input[type=text][name=celltitlehere1two1]').val();
		var celltitlelinkhere1 = jQuery('input[type=text][name=celltitlelinkhere1two1]').val();
		var celltexthere1 = jQuery('.celltexthere1two1').val();

		var insert = '[fullwidth]\n';
		if(celltitlehere1 !== ""){
			insert = insert + '[titles]\n [cell_title ';

			if(celltitlelinkhere1 !== ""){
				insert = insert + ' link="'+celltitlelinkhere1+'"';
			}

			insert = insert + ']'+celltitlehere1+' [/cell_title]\n';
		}

		if(celltitlehere1 !== ""){
			insert = insert + "\n[/titles]";
		}
		if(celltexthere1 !== ""){
			insert = insert + '\n[cell_text]'+celltexthere1+' [/cell_text]\n'
		}
		insert = insert + '\n[/fullwidth]\n';



	jQuery('#content').insertAtCaret(insert);
	jQuery('.column1action').css('display','none');


	});

	// column 2
	jQuery('.column2').click(function(){
    	jQuery('.actionhelper').hide();
		 jQuery('.column2action').css('display','block');

	});
	jQuery('.column2submit').click(function(){
		var celltitlehere1 = jQuery('input[type=text][name=celltitlehere1two]').val();
		var celltitlehere2 = jQuery('input[type=text][name=celltitlehere2two]').val();
		var celltitlelinkhere1 = jQuery('input[type=text][name=celltitlelinkhere1two]').val();
		var celltitlelinkhere2 = jQuery('input[type=text][name=celltitlelinkhere2two]').val();
		var celltexthere1 = jQuery('.celltexthere1two').val();
		var celltexthere2 = jQuery('.celltexthere2two').val();

		var insert = '[two-columns]\n [onehalf]\n';

		if(celltitlehere1 !== ""){
			insert = insert + '[titles]\n [cell_title ';

			if(celltitlelinkhere1 !== ""){
				insert = insert + ' link="'+celltitlelinkhere1+'"';
			}

			insert = insert + ']'+celltitlehere1+' [/cell_title]\n';

			insert = insert + "\n[/titles]";
                }
		if(celltexthere1 !== ""){
			insert = insert + '\n[cell_text]'+celltexthere1+' [/cell_text]\n'
		}
		insert = insert + '\n[/onehalf]\n\r\n[onehalf_last]\n';

		if(celltitlehere2 !== ""){
			insert = insert + '[titles]\n [cell_title ';

			if(celltitlelinkhere2 !== ""){
				insert = insert + ' link="'+celltitlelinkhere2+'"';
			}

			insert = insert + ']'+celltitlehere2+' [/cell_title]\n';

			insert = insert + "\n[/titles]";
                }
		if(celltexthere2 !== ""){
			insert = insert + '\n[cell_text]'+celltexthere2+' [/cell_text]\n ';
		}
		insert = insert + '\n[/onehalf_last]\n\r [/two-columns]\n\r ';




	jQuery('#content').insertAtCaret(insert);
	jQuery('.column2action').css('display','none');


	});

	//Column 3
    jQuery('.column3').click(function(){
    	jQuery('.actionhelper').hide();
		 jQuery('.column3action').css('display','block');

	});
	jQuery('.column3submit').click(function(){

		var celltitlehere1 = jQuery('input[type=text][name=celltitlehere1]').val();
		var celltitlehere2 = jQuery('input[type=text][name=celltitlehere2]').val();
		var celltitlehere3 = jQuery('input[type=text][name=celltitlehere3]').val();
		var celltitlelinkhere1 = jQuery('input[type=text][name=celltitlelinkhere1]').val();
		var celltitlelinkhere2 = jQuery('input[type=text][name=celltitlelinkhere2]').val();
		var celltitlelinkhere3 = jQuery('input[type=text][name=celltitlelinkhere3]').val();
		var celltexthere1 = jQuery('.celltexthere1').val();
		var celltexthere2 = jQuery('.celltexthere2').val();
		var celltexthere3 = jQuery('.celltexthere3').val();

		var insert = '[three-columns]\n [one_cell]\n';

		if(celltitlehere1 !== ""){
			insert = insert + '[titles]\n [cell_title ';

			if(celltitlelinkhere1 !== ""){
				insert = insert + ' link="'+celltitlelinkhere1+'"';
			}

			insert = insert + ']'+celltitlehere1+' [/cell_title]\n';

			insert = insert + "\n[/titles]";
                }
		if(celltexthere1 !== ""){
			insert = insert + '\n[cell_text]'+celltexthere1+' [/cell_text]\n'
		}
		insert = insert + '\n[/one_cell]\n\r\n[one_cell]\n';

	
		if(celltitlehere2 !== ""){
			insert = insert + '[titles]\n [cell_title ';

			if(celltitlelinkhere2 !== ""){
				insert = insert + ' link="'+celltitlelinkhere2+'"';
			}

			insert = insert + ']'+celltitlehere2+' [/cell_title]\n';

			insert = insert + "\n[/titles]";
                }
		if(celltexthere2 !== ""){
			insert = insert + '\n[cell_text]'+celltexthere2+' [/cell_text]\n ';
		}
		insert = insert + '\n[/one_cell]\n\r \n[one_cell_last]\n';

		if(celltitlehere3 !== ""){
			insert = insert + '[titles]\n [cell_title ';

			if(celltitlelinkhere3 !== ""){
			insert = insert + ' link="'+celltitlelinkhere3+'"';
			}

			insert = insert + ']'+celltitlehere3+' [/cell_title]\n';

			insert = insert + "\n[/titles]";
                }
		if(celltexthere3 !== ""){
			insert = insert + '\n[cell_text]'+celltexthere3+' [/cell_text]\n';
		}
		insert = insert + '[/one_cell_last]\n\r [/three-columns]\n\r';


	jQuery('#content').insertAtCaret(insert);
	jQuery('.column3action').css('display','none');


	});
//Column 4
	jQuery('.column4').click(function(){
		jQuery('.actionhelper').hide();
		 jQuery('.column4action').css('display','block');
	});

	jQuery('.column4submit').click(function(){
		var cellimagehere1 = jQuery('input[type=text][name=cellimagehere1four]').val();
		var cellimagehere2 = jQuery('input[type=text][name=cellimagehere2four]').val();
		var cellimagehere3 = jQuery('input[type=text][name=cellimagehere3four]').val();
		var cellimagehere4 = jQuery('input[type=text][name=cellimagehere4four]').val();

		var celltitlehere1 = jQuery('input[type=text][name=celltitlehere1four]').val();
		var celltitlehere2 = jQuery('input[type=text][name=celltitlehere2four]').val();
		var celltitlehere3 = jQuery('input[type=text][name=celltitlehere3four]').val();
		var celltitlehere4 = jQuery('input[type=text][name=celltitlehere4four]').val();
		var celltitlelinkhere1 = jQuery('input[type=text][name=celltitlelinkhere1four]').val();
		var celltitlelinkhere2 = jQuery('input[type=text][name=celltitlelinkhere2four]').val();
		var celltitlelinkhere3 = jQuery('input[type=text][name=celltitlelinkhere3four]').val();
		var celltitlelinkhere4 = jQuery('input[type=text][name=celltitlelinkhere4four]').val();
		var cellundertitlehere1 = jQuery('input[type=text][name=cellundertitlehere1four]').val();
		var cellundertitlehere2 = jQuery('input[type=text][name=cellundertitlehere2four]').val();
		var cellundertitlehere3 = jQuery('input[type=text][name=cellundertitlehere3four]').val();
		var cellundertitlehere4 = jQuery('input[type=text][name=cellundertitlehere4four]').val();
		var celltexthere1 = jQuery('.celltexthere1four').val();
		var celltexthere2 = jQuery('.celltexthere2four').val();
		var celltexthere3 = jQuery('.celltexthere3four').val();
		var celltexthere4 = jQuery('.celltexthere4four').val();

		var insert = '[four-columns]\n [one_cell]\n';





                if(celltitlehere1 !== ""){
			insert = insert + '[titles]\n [cell_title ';

			if(celltitlelinkhere1 !== ""){
				insert = insert + ' link="'+celltitlelinkhere1+'"';
			}

			insert = insert + ']'+celltitlehere1+' [/cell_title]\n';

			insert = insert + "\n[/titles]";
                }
		if(celltexthere1 !== ""){
			insert = insert + '\n[cell_text]'+celltexthere1+' [/cell_text]\n'
		}
		insert = insert + '\n[/one_cell]\n\r\n[one_cell]\n';


               if(celltitlehere2 !== ""){
			insert = insert + '[titles]\n [cell_title ';

			if(celltitlelinkhere2 !== ""){
				insert = insert + ' link="'+celltitlelinkhere2+'"';
			}

			insert = insert + ']'+celltitlehere2+' [/cell_title]\n';

			insert = insert + "\n[/titles]";
                }
		if(celltexthere2 !== ""){
			insert = insert + '\n[cell_text]'+celltexthere2+' [/cell_text]\n ';
		}
		insert = insert + '\n[/one_cell]\n\r\n[one_cell]\n';

                

if(celltitlehere3 !== ""){
			insert = insert + '[titles]\n [cell_title ';

			if(celltitlelinkhere3 !== ""){
			insert = insert + ' link="'+celltitlelinkhere3+'"';
			}

			insert = insert + ']'+celltitlehere3+' [/cell_title]\n';

			insert = insert + "\n[/titles]";
                }
		if(celltexthere3 !== ""){
			insert = insert + '\n[cell_text]'+celltexthere3+' [/cell_text]\n';
		}
		insert = insert + '\n[/one_cell]\n\r\n[one_cell_last]\n';




		if(celltitlehere4 !== ""){
			insert = insert + '[titles]\n [cell_title ';

			if(celltitlelinkhere4 !== ""){
			insert = insert + ' link="'+celltitlelinkhere4+'"';
			}

			insert = insert + ']'+celltitlehere4+' [/cell_title]\n';

			insert = insert + "\n[/titles]";
                }
		if(celltexthere4 !== ""){
			insert = insert + '\n[cell_text]'+celltexthere4+' [/cell_text]\n';
		}
		insert = insert + '[/one_cell_last]\n\r [/four-columns]\n\r';


	jQuery('#content').insertAtCaret(insert);
	jQuery('.column4action').css('display','none');

	});

});

</script>

<input type="button" class="break tkbutton" value="Add Break">
<input type="button" class="separator tkbutton" value="Add Separator">
<input type="button" class="column1 tkbutton" value="Add Fullwidth">
<input type="button" class="column2 tkbutton" value="Add 2 columns">
<input type="button" class="column3 tkbutton" value="Add 3 columns">
<input type="button" class="column4 tkbutton" value="Add 4 columns">
<input type="button" class="addh1h2 tkbutton" value="Add H1 - H2 - H3 - H4 - H5">
<input type="button" class="addbutton tkbutton" value="Button">


</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
window.setTimeout(function(){
//<![CDATA[

var pluggy_toolbar = document.getElementById("ed_toolbar");


if (pluggy_toolbar) {

  var theDiv = document.createElement('div');
  theDiv.type = 'div';
  theDiv.value = 'Pluggy';

  theDiv.className = 'ed_div';
  theDiv.title = '<?php echo THEME_NAME;?> panel';
  theDiv.id = 'ed_div';
  pluggy_toolbar.appendChild(theDiv);

  var shortcode = document.getElementById("panel");

  theDiv.appendChild(shortcode);

}else {
  var pluggyLink = document.getElementById("pluggy_link");
  var pingBack = document.getElementById("pingback");
  if (pingBack == null)
    var pingBack = document.getElementById("post_pingback");
  if (pingBack == null) {
    var pingBack = document.getElementById("savepage");
    pingBack = pingBack.parentNode;
  }
  pingBack.parentNode.insertBefore(pluggyLink, pingBack);
  pluggyLink.style.display = 'none';
}


// Insert myValue into an editor window
function insertHtml(myValue) {
        if(window.tinyMCE)
                window.opener.tinyMCE.execCommand("mceInsertContent",true,myValue);
        else
                insertAtCursor(window.opener.document.post.content, myValue);
        window.close();
}

// Insert text into the WP regular editor window
function insertAtCursor(myField, myValue) {
        //IE support
        if (document.selection && !window.opera) {
                myField.focus();
                sel = window.opener.document.selection.createRange();
                sel.text = myValue;
        }
        //MOZILLA/NETSCAPE/OPERA support
        else if (myField.selectionStart || myField.selectionStart == '0') {
                var startPos = myField.selectionStart;
                var endPos = myField.selectionEnd;
                myField.value = myField.value.substring(0, startPos)
                + myValue
                + myField.value.substring(endPos, myField.value.length);
        } else {
                myField.value += myValue;
        }
}

function selectedText(input){

var startPos = input.selectionStart;
var endPos = input.selectionEnd;
var doc = document.selection;

if(doc && doc.createRange().text.length != 0){
alert(doc.createRange().text);
}else if (!doc && input.value.substring(startPos,endPos).length != 0){
alert(input.value.substring(startPos,endPos))
}
}




//]]>
},1000);

})
</script>
<?php
    }
}

// Add the javascript-generating footer to all admin pages
add_filter('admin_footer', 'pluggy_quicktag_like_button');