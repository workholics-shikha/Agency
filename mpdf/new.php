<html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="simpleValidation.js"></script>
</head>
<style>
	input[type="text"]{border:none; border: 1px solid black; width: 182px;}
	.requiredfield{color:red;}
	.error{color:red;}
</style>
<body>

<center><h2>
Demo of HTML form to Dynamic PDF Generator - blog.theonlytutorials.com<br>
Script can be download from this link <a href="http://blog.theonlytutorials.com/html-form-pdf-file-php-mpdf/">Go to the Download page</a></h2>
</center>
<form id="myform" method="post" action="generatePDF.php">	
	<table border="0" align="center">
	  <tr><td>Name:</td><td><input type="text" name="name" id="name"  /></td></tr>
	  <tr><td>Email:</td><td><input type="text" name="email" id="email"  /></td></tr>
	  <tr><td>Message:</td><td><textarea name="message" id="message"></textarea></td></tr>
	  <tr><td></td><td><input type="submit" id="submitbtn" /></td></tr>
	</table>
</form>
</body>
</html>