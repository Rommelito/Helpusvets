function validate_email(field,alerttxt)
{
with (field)
 {
 apos=value.indexOf("@");
 dotpos=value.lastIndexOf(".");
 if (apos<1||dotpos-apos<2)
   {$('#error-message').empty().append(alerttxt);return false;}
 else {return true;}
 }
}

function check_field(field,alerttxt,checktext){
   with (field)
   {
   var checkfalse = 0;
   if(field.value == ""){
   	$('#error-message').empty().append(alerttxt);
   field.focus();checkfalse=1;}

   if(field.value==checktext)
   {	
   	$('#error-message').empty().append(alerttxt);
   	field.focus();checkfalse=1;}
       
   if(checkfalse==1){return false;}else{return true;}
   
   }
   
}

function checkForm(thisform)
{
with (thisform)
 {
 var error = 0;        
   var message = document.getElementById('message');
   if(check_field(message,"Please insert your message","Message")==false){
      error = 1;
   }
   var website = document.getElementById('website');
   if(check_field(website,"Please insert your Website","Website")==false){
       error = 1;
   }
   
   if (validate_email(email,"Not a valid e-mail address!")==false)
   {email.focus();error = 1;}
   
   var contactsurname = document.getElementById('surname');
   if(check_field(contactsurname,"Please insert your Surame","Surname")==false){
       error = 1;
   }
   
   var contactname = document.getElementById('name'); 
   if(check_field(contactname,"Please insert your Name","Name")==false){
       error = 1;
   }

   if(error == 0){
   	var contactname = document.getElementById('name').value;
	var contactsurname = document.getElementById('surname').value;
	var contactemail = document.getElementById('email').value;
	var contactwebsite = document.getElementById('website').value;
	var contactmessage = document.getElementById('message').value;
	var postAjax2URL = "contact.php";
	$('#ajax2').load(postAjax2URL, {contactname:contactname, contactsurname:contactsurname, contactemail:contactemail, contactwebsite:contactwebsite, contactmessage:contactmessage},function(){
		var status = $('#ajax2').html(); $('#error-message').empty().append(status);
	}
	);
   }
   return false;
}

}
