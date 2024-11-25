<?php 
include('include/confige.php');
$servername = "localhost";
$username = "desired_agency";
$password = "workspace@11";
$dbname = "desired_agency";

// Create connection

$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} 
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

// Include Spout library 
require_once 'spout-2.4.3/src/Spout/Autoloader/autoload.php';

// check file name is not empty
if (!empty($_FILES['file']['name'])) {
     
    // Get File extension eg. 'xlsx' to check file is excel sheet
    $pathinfo = pathinfo($_FILES["file"]["name"]);
    
    // check file has extension xlsx, xls and also check 
    // file is not empty
   if (($pathinfo['extension'] == 'xlsx' || $pathinfo['extension'] == 'xls') 
           && $_FILES['file']['size'] > 0 ) {
        
        // Temporary file name
        $inputFileName = $_FILES['file']['tmp_name']; 
   
        // Read excel file by using ReadFactory object.
        $reader = ReaderFactory::create(Type::XLSX);

        // Open file
        $reader->open($inputFileName);
        $count = 1;
        $rows = array(); 
        
        // Number of sheet in excel file
        foreach ($reader->getSheetIterator() as $sheet) {
            
            // Number of Rows in Excel sheet
            foreach ($sheet->getRowIterator() as $row) {

                // It reads data after header. In the my excel sheet, 
                // header is in the first row. 
                if ($count > 1) { 

                    // Data of excel sheet
                    $data['name'] = $row[0];
                    $data['email'] = $row[1];
                    $data['phone'] = $row[2];
                    $data['city'] = $row[3];
                    
                    // Push all data into array to be insert as 
                    // batch into MySql database.  
                    array_push($rows, $data);
                }
                $count++;
            }

            // Print All data
			
            // Now, here we can insert all data into database table.

        }    
		
		
        // Close excel file
        $reader->close();

    } else {

        echo "Please Select Valid Excel File";
    }

} else {

    echo "Please Select Excel File";
    
}
?>