/*
	Agurchand's Simple jQuery Validation Script
	Script provided by blog.theonlytutorials.com
	Author: agurchand
*/

$(document).ready(function(){
	
	/*	Enter all your id in the following pattern in the requiredfields
			{
				"yourid" : "custom error message",
				"yourid2" : "custom error message"
			}
		
		NOTE: to validate email your id should have the word email. 
			  It can be anything "email" or "myemail" or "officeemail", "personalemail"
	*/
	
	// your form id
	var formid = "myform";
	var requiredfields = 	{	"name" : "Please enter your name", 
								"email": "Please enter your email",
								"message" : "Please fill the message box"
							};
	
	//give your submit button id
	$( "#submitbtn" ).click( function( e ) {	
		
		//begin validation loop through all required fields
		$.each( requiredfields, function( inputid, errormsg ){
			
			thisinput = $( '#'+inputid );
			
			if ( ( thisinput.val() == "" ) || ( thisinput.val() == errormsg ) ) {
			
				thisinput.addClass( "requiredfield" );
				thisinput.val( errormsg );
			
			} else {
			
				//validating email
				email = thisinput.val();
				if( inputid.indexOf( "email" ) != -1 ){
				
					if( !validateEmail( email ) ){
						thisinput.addClass( "requiredfield" );
						thisinput.val( "Please enter a valid email" );
						return false;
					}
					
				}
				thisinput.removeClass( "requiredfield" );
			}
			
			//check if a checkbox or a radio button is selected
			if( thisinput.attr( 'type' ) == 'checkbox' || thisinput.attr( 'type' ) == 'radio' ){
			
				thisinput.removeClass( "requiredfield" );
				
				if( !$( thisinput ).prop( 'checked' ) ){

					//show alert if checkbox or radio button not selected
					//you can use a error div msg instead of alert.
					//eg. $('errorshowingdiv').text(errormsg);

					alert( errormsg );
					
					thisinput.addClass( "requiredfield" );
					return false;
					
				}
			}							
		
		});
		
		//if all the fields validated submit the form
		if( $( '.requiredfield' ).length == 0 ){
			formid.submit();
		}
		e.preventDefault();
	});
	
	function validateEmail( email ) { 
		var reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return reg.test( email );
	} 

	$( "input,textarea" ).focus( function() {
	
		if ( $( this ).hasClass( "requiredfield" ) ) {
		
			 $( this ).val( "" );
			 $( this ).removeClass( "requiredfield" );
			 
		}
		
	});
	
});	

