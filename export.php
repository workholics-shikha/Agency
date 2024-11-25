<?php include_once("include/header.php");

$adminId = $_SESSION['adminId'];
$permissions = $prbsl->get_var("SELECT permissions FROM userdetail WHERE id='$adminId'");
$userPermissions = array();
if (!empty($permissions)) {
  $userPermissions = unserialize($permissions);
}

if (!array_key_exists("export_data", $userPermissions)) {
  echo '<script>window.location.href="' . admin_url() . 'index.php";</script>';
}


$error = false;
$msg = '';
$condtion = "";


if (isset($_POST['submit'])) {

  include_once('db.php');

  include_once("include/function.php");

  header('Content-type: "text/xml"; charset="utf8"');

  header('Content-Disposition: attachment; filename="agency.xml"');

  global $prbsl;

  $startdate = $_POST['startdate'];

  $enddate = $_POST['enddate'];



  if (!empty($startdate) and !empty($enddate)) {

    $condtion .= "(airdate between '" . $startdate . "' and '" . $enddate . "') and ";
  }



  if (!empty($_POST['theater'])) {

    $condtion .= "(theater_name like '%" . $_POST['theater'] . "%') and ";
  }



  $a2 = $prbsl->get_row("select * from `ad` where `id`='" . $_POST['a_id'] . "'");

  $rono = $a2['rono'];



  $condtion .= " rono='" . $rono . "' and status='1'";



  if (isset($_SESSION["cur_user"])) {

    if (!isset($_SESSION)) {

      session_start();
    }

    $email = $_SESSION['email'];

    $sql = "SELECT id FROM `userdetail` WHERE `name`='$email'";

    $userId = 0;

    $array = array('type' => "filedownload", 'startdate' => $startdate, 'enddate' => $enddate, "datetime" => date("Y-m-d H:i:s"), 'ip_address' => $_SERVER['REMOTE_ADDR'], 'user' => $userId);



    $prbsl->insert("reprot_download_log", $array);
  }







  if (isset($userId)) {

    $condtion .= " and user='" . $userId . "'";
  }



  $contents = '';

  $contents .= '<?xml version="1.0"?>';

  $contents .= '<davplogs>';

  //print_r($prbsl);

  $sql2 = "SELECT thcode,airdate,starttime,showtype,show1,showing,duration FROM `maintable` WHERE $condtion ORDER BY id ASC LIMIT 50000";

  // echo $sql2; die;

  //   $getdata = $prbsl->get_results($sql2);

  $result = mysqli_query($conn, $sql2);

  //print_r($result);

  //die();
  //print_r($result);die;
  if (mysqli_num_rows($result) > 0) {

    //print_r($result);

    //die();

    // output data of each row

    while ($value = mysqli_fetch_assoc($result)) {

      //print_r($value);

      $contents .= '<logdata>';

      $contents .= '<thcode>' . $value['thcode'] . '</thcode>';

      $contents .= '<aireddate>' . date("d/m/Y", strtotime($value['airdate'])) . '</aireddate>';

      $contents .= '<airedtime>' . $value['starttime'] . '</airedtime>';

      $contents .= '<showtype>' . $value['showtype'] . '</showtype>';

      $contents .= '<show>' . $value['show1'] . '</show>';

      $contents .= '<showins>' . $value['showing'] . '</showins>';

      $contents .= '<duration>' . $value['duration'] . '</duration>';

      $contents .= '</logdata>';
    }
  } else {

    $msg = "\t\t\t Data not found";
  }

  $contents .= "</davplogs>";

  $contents .= "</xml>";

  echo $contents;

  die;
}



if (isset($_POST['downloadxls']) && $_POST['downloadxls'] != '') {



  include_once("include/function.php");

  global $prbsl;

  $startdate = $_POST['startdate'];

  $enddate = $_POST['enddate'];

  if (!empty($startdate) and !empty($enddate)) {

    $condtion .= "(airdate between '" . $startdate . "' and '" . $enddate . "') and ";
  }



  if (!empty($_POST['theater'])) {

    $condtion .= "(theater_name like '%" . $_POST['theater'] . "%') and ";
  }


  $a2 = $prbsl->get_row("select * from `ad` where `id`='" . $_POST['a_id'] . "'");

  $rono = $a2['rono'];

  if ($a2['spot'] == 1) {

    $spot = "Preshow";
  } else if ($a2['spot'] == 2) {

    $spot = "Postshow";
  } else if ($a2['spot'] == 3) {

    $spot = "Interval";
  } else {

    $spot = "";
  }

  $condtion .= " rono='" . $rono . "' and status='1'";


  if (isset($_SESSION["cur_user"])) {



    if (!isset($_SESSION)) {

      session_start();
    }

    $email = $_SESSION['email'];



    $sql = "SELECT id FROM `userdetail` WHERE `name`='$email'";

    $userId = 0;

    $array = array('type' => "filedownload", 'startdate' => $startdate, 'enddate' => $enddate, "datetime" => date("Y-m-d H:i:s"), 'ip_address' => $_SERVER['REMOTE_ADDR'], 'user' => $userId);

    $prbsl->insert("reprot_download_log", $array);
  }





  if (isset($userId)) {

    $condtion .= "  or user='" . $userId . "'";
  }


  $contents = "client Name \t Ro No \t Title \t Invoice No \t Date \t Period From \t Period To \t Agency Name \t Duration: \t Spot \n";

  $contents .= $a2['clientname'] . "\t" . $a2["rono"] . "\t" . $a2["family"] . " " . " \t" . $a2["invoiceno"] . " \t" . date("d-m-Y", strtotime($a2["date"])) . " \t" . date("d-m-Y", strtotime($a2["periodfrom"])) . " \t" . date("d-m-Y", strtotime($a2["periodto"])) . "\t" . $a2["agencyname"] . " \t" . $a2["duration"] . " sec \t" . $spot . " \n \n";



  $contents .= "\n Theater name\t Region\t District\t Seating\t Thcode\t Airdate \t Strat Time \t End Time \t Show Type \t Show1 \t Showing \t Duration \t Caption \t Language \n";



  $sql = "SELECT * FROM `maintable` WHERE $condtion ORDER BY id ASC LIMIT 100000";

  $getdata = $prbsl->get_results($sql);

  if (!empty($getdata)) {

    foreach ($getdata as $value) {

      $contents .= $value->theater_name . "\t" . $value->region . "\t" . $value->district . "\t" . $value->seating . "\t" . $value->thcode . "\t" . date("d-m-Y", strtotime($value->airdate)) . "\t" . $value->starttime . "\t" . $value->endtime . "\t" . $value->showtype . "\t" . $value->show1 . "\t" . $value->showing . "\t" . $value->duration . "\t" . $value->caption . "\t" . $value->language . "\n";
      // echo $contents;
    }
    //echo $contents;
    //die();
  } else {
    $contents  .= "\t\t\t Data not found";
  }
  header('Content-type: "text/xml"; charset="utf8"');
  header('Content-Disposition: attachment; filename="agency.xls"');
  //debug($contents);
  echo $contents;
  die;
}



if (isset($_POST['downloadpdf2'])) {



  include_once("include/function.php");





  global $prbsl;




  require('fpdf/fpdf.php');

  $pdf = new FPDF();

  $pdf->AddPage();

  $pdf->SetFont('Arial', 'B', 10);

  $pdf->Ln();

  $pdf->SetFont('times', 'B', 10);

  $pdf->Cell(25, 7, "Stud ID");

  $pdf->Cell(30, 7, "Student Name");

  $pdf->Cell(40, 7, "Address");

  $pdf->Ln();

  $pdf->Ln();

  $sql = "SELECT * FROM ad WHERE `id`='" . $_POST['a_id'] . "'";

  $result = $prbsl->get_results($sql);

  foreach ($result as $rows) {

    $studid = $rows->clientname;

    $name = $rows->rono;

    $address = $rows->family;

    $pdf->Cell(25, 7, $studid);

    $pdf->Cell(30, 7, $name);

    $pdf->Cell(40, 7, $address);

    $pdf->Ln();
  }

  $pdf->Output();
}



if (isset($_POST['downloadpdf1'])) {

  include_once("include/function.php");

  global $prbsl;

  $startdate = $_POST['startdate'];

  $enddate = $_POST['enddate'];



  if (!empty($startdate) and !empty($enddate)) {



    $condtion .= "(airdate between '" . $startdate . "' and '" . $enddate . "') and ";
  }

  if (!empty($_POST['theater'])) {



    $condtion .= "(theater_name like '%" . $_POST['theater'] . "%') and ";
  }



  $a2 = $prbsl->get_row("select * from `ad` where `id`='" . $_POST['a_id'] . "'");

  $rono = $a2['rono'];

  if ($a2['spot'] == 1) {

    $spot = "Preshow";
  } else if ($a2['spot'] == 2) {

    $spot = "Postshow";
  } else if ($a2['spot'] == 3) {

    $spot = "Interval";
  } else {

    $spot = "";
  }

  $condtion .= " rono='" . $rono . "' and status='1'";

  if (isset($_SESSION["cur_user"])) {



    if (!isset($_SESSION)) {

      session_start();
    }

    $email = $_SESSION['email'];

    $sql = "SELECT id FROM `userdetail` WHERE `name`='$email'";

    $userId = 0;

    $array = array('type' => "filedownload", 'startdate' => $startdate, 'enddate' => $enddate, "datetime" => date("Y-m-d H:i:s"), 'ip_address' => $_SERVER['REMOTE_ADDR'], 'user' => $userId);

    $prbsl->insert("reprot_download_log", $array);
  }





  if (isset($userId)) {



    $condtion .= "  and user='" . $userId . "'";
  }





  $contents = "client Name \t Ro No \t Title \t Invoice No \t Date \t Period From \t Period To \t Agency Name \t Duration: \t Spot \n";



  $contents .= $a2['clientname'] . "\t" . $a2["rono"] . "\t" . $a2["family"] . " " . " \t" . $a2["invoiceno"] . " \t" . date("m-d-Y", strtotime($a2["date"])) . " \t" . date("m-d-Y", strtotime($a2["periodfrom"])) . " \t" . date("m-d-Y", strtotime($a2["periodto"])) . "\t" . $a2["agencyname"] . " \t" . $a2["duration"] . " sec \t" . $spot . " \n \n";



  $contents .= "\n Theater name\t Region\t District\t Seating\t Thcode\t Airdate \t Strat Time \t End Time \t Show Type \t Show1 \t Showing \t Duration \t Caption \t Language \n";



  $sql = "SELECT * FROM `maintable` WHERE $condtion ";





  $getdata = $prbsl->get_results($sql);





  if ($getdata) {



    foreach ($getdata as $value) {



      $contents .= $value->theater_name . "\t" . $value->region . "\t" . $value->district . "\t" . $value->seating . "\t" . $value->thcode . "\t" . date("m-d-Y", strtotime($value->airdate)) . "\t" . $value->starttime . "\t" . $value->endtime . "\t" . $value->showtype . "\t" . $value->show1 . "\t" . $value->showing . "\t" . $value->duration . "\t" . $value->caption . "\t" . $value->language . "\n";
    }
  } else {



    $contents  .= "\t\t\t Data not found";
  }





  header('Content-type: "text/xml"; charset="utf8"');

  header('Content-Disposition: attachment; filename="agency.pdf"');

  //debug($contents);

  echo $contents;

  die;
}

if (isset($_POST['downloadpdf'])) {

  include_once("include/function.php");

  global $prbsl;

  include('MPDF57/mpdf.php');

  $startdate = $_POST['startdate'];

  $enddate = $_POST['enddate'];

  if (!empty($startdate) and !empty($enddate)) {

    $condtion .= "(airdate between '" . $startdate . "' and '" . $enddate . "') and ";
  }

  if (!empty($_POST['theater'])) {

    $condtion .= "(theater_name like '%" . $_POST['theater'] . "%') and ";
  }

  $a2 = $prbsl->get_row("select * from `ad` where `id`='" . $_POST['a_id'] . "'");

  $rono = $a2['rono'];

  $cc = $a2['clientname'];

  $cc1 = $a2["family"];

  $cc2 = $a2["invoiceno"];

  $cc3 = date("m-d-Y", strtotime($a2["date"]));

  $cc4 = date("m-d-Y", strtotime($a2["periodfrom"]));

  $cc5 = date("m-d-Y", strtotime($a2["periodto"]));

  $cc6 = $a2["agencyname"];

  $cc7 = $a2["duration"];

  if ($a2['spot'] == 1) {

    $spot = "Preshow";
  } else if ($a2['spot'] == 2) {

    $spot = "Postshow";
  } else if ($a2['spot'] == 3) {

    $spot = "Interval";
  } else {

    $spot = "";
  }

  $condtion .= " rono='" . $rono . "' and status='1'";

  if (isset($_SESSION["cur_user"])) {



    if (!isset($_SESSION)) {

      session_start();
    }

    $email = $_SESSION['email'];

    $sql = "SELECT id FROM `userdetail` WHERE `name`='$email'";

    $userId = 0;

    $array = array('type' => "filedownload", 'startdate' => $startdate, 'enddate' => $enddate, "datetime" => date("Y-m-d H:i:s"), 'ip_address' => $_SERVER['REMOTE_ADDR'], 'user' => $userId);

    $prbsl->insert("reprot_download_log", $array);
  }


  if (isset($userId)) {

    $condtion .= "  and user='" . $userId . "'";
  }


  $sql        = "SELECT * FROM `maintable` WHERE $condtion ";

  $getdata   = $prbsl->get_results($sql);



  $html .= "

<html>

<head>

<style>

body {font-family: sans-serif;

    font-size: 10pt;

}

td { vertical-align: top; 

    border-left: 0.6mm solid #000000;

    border-right: 0.6mm solid #000000;

	align: center;

}

table thead td { background-color: #EEEEEE;

    text-align: center;

    border: 0.6mm solid #000000;

}

td.lastrow {

    background-color: #FFFFFF;

    border: 0mm none #000000;

    border-bottom: 0.6mm solid #000000;

    border-left: 0.6mm solid #000000;

	border-right: 0.6mm solid #000000;

}



</style>

</head>

<body>



<!--mpdf

<htmlpagefooter name='myfooter'>

<div style='border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; '>

Page {PAGENO} of {nb}

</div>

</htmlpagefooter>



<sethtmlpageheader name='myheader' value='on' show-this-page='1' />

<sethtmlpagefooter name='myfooter' value='on' />

mpdf-->



<div style='text-align:center;'>HTML Form to PDF - Blog.theonlytutorials.com</div><br>

<table class='items' width='100%' style='font-size: 9pt; border-collapse: collapse;' cellpadding='8'>

<thead>

<tr>

<td width='15%'>Client Name</td>

<td width='15%'>Ro No</td>

<td width='15%'>Title</td>

<td width='15%'>Invoice No</td>

<td width='15%'>Date</td>

<td width='15%'>Period From</td>

<td width='15%'>Period To</td>

<td width='15%'>Agency Name</td>

<td width='15%'>Duration</td>

<td width='15%'>Spot</td>

</tr>

</thead>

<tbody>

<tr><td class='lastrow'>$cc</td>

<td class='lastrow'>$rono</td>

<td class='lastrow'>$cc1</td>

<td class='lastrow'>$cc2</td>

<td class='lastrow'>$cc3</td>

<td class='lastrow'>$cc4</td>

<td class='lastrow'>$cc5</td>

<td class='lastrow'>$cc6</td>

<td class='lastrow'>$cc7</td>

<td class='lastrow'>$spot</td></tr>

</tbody>

</table><br>

<table class='items' width='100%' style='font-size: 9pt; border-collapse: collapse;' cellpadding='8'>

<thead>

<tr>

<td width='15%'>Theater name</td>

<td width='15%'>Region</td>

<td width='15%'>District</td>

<td width='15%'>Seating</td>

<td width='15%'>Thcode</td>

<td width='15%'>Airdate</td>

<td width='15%'>Strat Time</td>

<td width='15%'>End Time</td>

<td width='15%'>Show Type</td>

<td width='15%'>Show1</td>

<td width='15%'>Showing</td>

<td width='15%'>Duration</td>

<td width='15%'>Caption</td>

<td width='1

        

</thead>

<tbody>

<tr><td class='lastrow'>$name</td>

<td class='lastrow'>$email</td>

<td class='lastrow'>$msg</td>

<td class='lastrow'>$name</td>

<td class='lastrow'>$email</td>

<td class='lastrow'>$msg</td>

<td class='lastrow'>$name</td>

<td class='lastrow'>$email</td>

<td class='lastrow'>$msg</td>

<td class='lastrow'>$name</td>

<td class='lastrow'>$email</td>

<td class='lastrow'>$msg</td>

<td class='lastrow'>$name</td>

<td class='lastrow'>$email</td>

</tr>

</tbody>

</table>

</body>

</html>

";


  $mpdf = new mPDF();

  $mpdf->WriteHTML($html);

  $mpdf->SetDisplayMode('fullpage');

  $mpdf->Output();
}



?>



<?php include_once("include/header.php");

global $prbsl;

?>

<script>
  $(function() {

    $(".datepicker").datepicker({
      format: "yyyy-mm-dd",
      todayHighlight: true
    });

  });
</script>

<?php // include_once("include/side_menu.php");
?>


<div class="content-wrapper">

  <div class="row">

    <div class="col-lg-12">

      <h1 class="page-header">Export</h1>

    </div>

    <!-- /.col-lg-12 -->

  </div>

  <!-- /.row -->

  <section class="content">

    <div class="row">

      <div class="col-lg-12">

        <div class="panel panel-default">

          <div class="panel-heading">

            Export Data

            <!--     <a class="pull-right" href="entryform.php">Add Report</i></a> -->

          </div>

          <!-- /.panel-heading -->

          <div class="panel-body">

            <?php

            /*if(!$error && $msg !=''){

                            echo '<div class="alert alert-success">'.$msg.'</div>';

                          }*/

            if ($error && $msg != '') {

              echo '<div class="alert alert-danger">' . $msg . '</div>';
            }

            ?>

            <div class="row">

              <form method="post">

                <div class="col-md-12">

                  <div class="form-group">

                    <label>Ro No.</label>

                    <select class="form-control" name="a_id" required id="a_id">

                      <?php
                      // $sql2 = $prbsl->get_results("select * from `ad` order by `id` desc");
                      $sql2 = $prbsl->get_results("select * from `ad` WHERE status='1' order by `id` ASC");

                      echo '<option value="">Select Ro No.</option>';

                      foreach ($sql2 as $rows) {

                      ?>

                        <option value="<?php echo $rows->id; ?>" <?php if (isset($entrydata['caption']) && $entrydata['caption'] == $row['title']) {
                                                                    echo "selected";
                                                                  } ?>>
                          <?php // echo $rows->title . " ( " . $rows->rono . " )"; 
                          ?>
                          <?php echo $rows->clientname . " " . $rows->title . " ( " . $rows->rono . " )"; ?>
                        </option>

                      <?php } ?>

                    </select>

                  </div>

                  <div class="form-group">

                    <label>Theater</label>

                    <select name="theater" class="form-control" id="theater">

                      <option value="">Select Theater</option>

                      <option value="Cinepolis">Cinepolis</option>

                      <option value="FUN Cinemas">FUN Cinemas</option>

                    </select>

                  </div>

                  <div class="col-md-1"></div>

                  <div class="col-md-3">

                    <input type="text" name="startdate" placeholder="Start Date" class="form-control datepicker" autocomplete="off" id="start_date">

                  </div>

                  <div class="col-md-3">

                    <input type="text" name="enddate" placeholder="End Date" class="form-control datepicker" autocomplete="off" id="end_date">

                  </div>

                  <div class="col-md-5">

                    <input type="button" value="Show Data" class="btn btn-info" id="filterButton">

                    <input type="submit" name="submit" value="Download XML" class="btn btn-info" onclick="myFunction">

                    <input type="submit" name="downloadxls" value="Download XLS" class="btn btn-primary">

                  </div>

                </div>

              </form>

            </div>

            <!-- ====Table==== -->

            <!-- /.row -->
            <section class="content" style="display:none;" id="filterTable">
              <div class="row">
                <div class="col-md-12">
                  <div id="responseMessage"> </div>
                  <div class="panel panel-default">
                    <!-- <button onclick="exportTableToExcel()">Export to Excel</button> -->
                    <div class="panel-heading"> Report Data <a class="pull-right" target="_blank" href="bulk-entry.php">Add Report</i> </a> </div>
                    <!-- /.panel-heading -->
                    <div class="box-body">

                      <div class="table-responsive">

                        <form id="editForm">
                          <table class="table table-bordered" id="dataTable">
                            <tr>
                              <th>No</th>
                              <th>Theater Name</th>
                              <th>Thcode</th>
                              <th>Ads Name</th>
                              <th>Airdate</th>
                              <th>Start Time</th>
                              <th>End Time</th>
                              <th>Region</th>
                              <th>District</th>
                              <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="dataTableTbody">
                            </tbody>

                          </table>
                          <button type="submit" class="btn btn-success">Save Changes</button>
                        </form>
                      </div>
                      <!-- /.table-responsive -->

                    </div>
                    <!-- /.panel-body -->
                  </div>
                  <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
              </div>
            </section>
            <!-- /.row -->

            <!-- ====Table==== -->

          </div>

          <!-- /.panel-body -->

        </div>

        <!-- /.panel -->

      </div>

      <!-- /.col-lg-12 -->

    </div>

  </section>

  <!-- /.row -->

</div>

<!-- /#page-wrapper -->

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

 <!-- Include the necessary libraries -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
  
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
 
<script type="module">
  
  $(document).ready(function() {

    // Trigger the filter when the button is clicked
    $("#filterButton").click(function() {
      var start_date = $("#start_date").val();
      var end_date = $("#end_date").val();
      var theater = document.getElementById("theater").value;
      var a_id = document.getElementById("a_id").value;

      // Make an AJAX request to fetch filtered data
      $.ajax({
        url: 'filter_data.php',
        type: 'GET',
        data: {
          start_date: start_date,
          end_date: end_date,
          theater: theater,
          a_id:a_id
        },
        success: function(response) {
          // Update the table with the new filtered data
          $('#filterTable').css('display', 'block');
          $("#dataTableTbody").html(response);
        }
      });
    });

    $("#editForm").on("submit", function(event) {
      event.preventDefault(); // Prevent default form submission

      $.ajax({
        url: "save_bulk_edit.php",
        type: "POST",
        data: $(this).serialize(),
        success: function(response) {

          $("#responseMessage").html('<p class="alert alert-success">Records updated successfully!</p>');
          $("#filterButton").click();

          // Remove the message after 3 seconds (3000 ms)
          setTimeout(function() {
            $("#responseMessage").fadeOut("slow", function() {
              $(this).html("").show(); // Clear and reset for future messages
            });
          }, 3000);

        },
        error: function() {
          $("#responseMessage").html("<span style='color:red;'>Failed to save the record.</span>");
        }
      });
    });

  });
</script>

<script>
  
// Export to CSV
function exportTableToCSV() {
    var table = document.getElementById("dataTable");
    var rows = table.rows;
    var csv = [];

    // Loop through each row
    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        var cols = row.cells;
        var rowData = [];

        // Loop through each column
        for (var j = 0; j < cols.length; j++) {
            rowData.push(cols[j].innerText);
        }

        csv.push(rowData.join(","));
    }

    // Download CSV file
    var csvContent = csv.join("\n");
    var hiddenElement = document.createElement('a');
    hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csvContent);
    hiddenElement.target = '_blank';
    hiddenElement.download = 'table_data.csv';
    hiddenElement.click();
}

// Export to Excel
function exportTableToExcel() {
    var table = document.getElementById("dataTable");

    // Convert the table to a worksheet
    var wb = XLSX.utils.table_to_book(table, {sheet: "Sheet1"});
    
    // Export the table to an Excel file
    XLSX.writeFile(wb, 'table_data.xlsx');
}
 
</script>
 

<script>
  function myFunction()

  {

    ExcelPackage excel = new ExcelPackage();

    var file = get_file();

    //long code which writes the content of file to excel taking time

    using(var memoryStream = new MemoryStream())

    {

      Response.ContentType = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";

      Response.AddHeader("content-disposition", "attachment;  filename=file.xlsx");

      excel.SaveAs(memoryStream);

      memoryStream.WriteTo(Response.OutputStream);

      Response.Flush();

      Response.End();

    }
  }
</script>
<?php include_once("include/footer.php"); ?>