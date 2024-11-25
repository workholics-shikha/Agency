<?php 
$DbHost = "localhost";
$DbUser = "desired_agency";
$DbPass = "workspace@11";  
$DbName = "desired_agency";                
$con = mysql_connect($DbHost,$DbUser,$DbPass);  
if(isset($_POST["submit"]))
{
$file = $_FILES['file']['tmp_name'];
$handle = fopen($file, "r");
$i = 0;
while(($file_data = fgetcsv($handle, 1000, ",")) !== false)
{	
 $name = $file_data[0];
 $course = $file_data[1];
 
$sql = mysql_query("INSERT INTO `students` (name, course) VALUES ('".$name."','".$course."')");
$i = $i + 1;
	
}
//echo $sql;
if($sql)
{
echo "You database has imported successfully. You have inserted ". $c ." records";
}
else
{
echo "Sorry!";
}
 
}
 
?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Convert EXCEL File to MYSQL Table</title>
</head>
<body>
<form method="post" action="" enctype="multipart/form-data">
Upload Excel File : <input type="file" name="file" /><br />
<input type="submit" name="submit" value="Upload" />
</form>	
</body>
</html>