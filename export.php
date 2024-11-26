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

<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script> -->

<script>
  $(function() {

    $(".datepicker").datepicker({
      format: "yyyy-mm-dd",
      todayHighlight: true
    });

  });
</script>

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

          </div>

          <!-- /.panel-heading -->

          <div class="panel-body">

            <?php

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

                    <!-- <select name="theater" class="form-control" id="theater">
                      <option value="">Select Theater</option>
                      <option value="Cinepolis">Cinepolis</option>
                      <option value="FUN Cinemas">FUN Cinemas</option>
                    </select> -->

                    <select class="form-control" id="theater" name="t_id" required>
                      <option value="">Select Theater Name</option>
                      <?php $sql1 = "select * from `theater` order by `id` desc";

                      $row1 = $prbsl->get_results($sql1);
                      foreach ($row1 as $row) {
                      ?>
                        <option value="<?php echo $row->thcode; ?>"><?php echo $row->company . " " . $row->district . " " . $row->name . " ( " . $row->thcode . " )"; ?></option>
                      <?php } ?>
                    </select>

                  </div>

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

                  <div class="col-md-1">
                    <input type="button" value="Bulk Delete" class="btn btn-danger" id="bulkDeleteButton" style="display:none;">
                  </div>

                </div>

              </form>

            </div>

            <!-- ====Table==== -->

            <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
            <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

            <!-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css"> -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

            <style>
              .paginate_button next,
              #dataTable_next {
                display: none;
              }

              .toBeHidden {
                display: none;
              }
            </style>

            <!-- /.row -->
            <section class="content" style="display:none;" id="filterTable">
              <div class="row">
                <div class="col-md-12">
                  <div id="responseMessage"> </div>
                  <div class="panel panel-default">

                    <!-- <div class="panel-heading"> Report Data <a class="pull-right" target="_blank" href="bulk-entry.php">Add Report</i> </a> </div> -->
                    <div class="panel-heading"> <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addReportModal">
                      Add Report
                    </button></div>

                    <div class="box-body">

                      <div class="table-responsive">

                        <form id="editForm">
                          <table class="table table-bordered" id="dataTable"> </table>

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

<script src="<?= admin_url() ?>js/myJsFile.js"></script> <!-- / Shikha's JS file -->

<script>
  // function myFunction() {

  //   ExcelPackage excel = new ExcelPackage();

  //   var file = get_file();

  //   //long code which writes the content of file to excel taking time

  //   using(var memoryStream = new MemoryStream())

  //   {

  //     Response.ContentType = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";

  //     Response.AddHeader("content-disposition", "attachment;  filename=file.xlsx");

  //     excel.SaveAs(memoryStream);

  //     memoryStream.WriteTo(Response.OutputStream);

  //     Response.Flush();

  //     Response.End();

  //   }

  // }
</script>

<!-- Add report Modal  -->

<!-- Button to Trigger Modal -->
<!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->


<!-- Modal Structure -->
<div class="modal fade" id="addReportModal" tabindex="-1" role="dialog" aria-labelledby="addReportModalLabel" aria-hidden="true" style="background: #0000002e !important;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="addReportModalLabel">Add Report</h4>
      </div>
      <div class="modal-body">
        <!-- Form Content -->
        <form method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>From Date:</label>
                <input type="text" name="fromDate" placeholder="From Date" class="form-control datepicker" id="datepicker" autocomplete="off" readonly required>
              </div>
             
              <div class="form-group">
                <label>Ads Name (Ro No.)</label>
                <select class="form-control" name="a_id" required id="a_id">
                  <option value="">Select Ad and Ro No</option>
                  <!-- Dynamic Options -->
                  <?php $sql1 = "select * from `ad` WHERE status='1' order by `id` ASC";
                        $rows1 = $prbsl->get_results($sql1); foreach ($rows1 as $rows): ?>
                    <option value="<?php //echo $rows->id; ?>">
                      <?php echo $rows->clientname . " " . $rows->title . " ( " . $rows->rono . " )"; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label>Theater Name:</label>
                <select class="form-control" id="t_id" name="t_id" required>
                  <option value="">Select Theater Name</option>
                  <!-- Dynamic Options -->
                  <?php $sql2 = "select * from `theater` order by `id` desc";
                        $row2 = $prbsl->get_results($sql2); foreach ($row2 as $row): ?>
                    <option value="<?php  echo $row->thcode; ?>">
                      <?php echo $row->company . " " . $row->district . " " . $row->name . " ( " . $row->thcode . " )"; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Language:</label>
                <select class="form-control" id="language" name="language" required>
                  <option value="">Select Language</option>
                  <option value="Hindi">Hindi</option>
                      <option value="English">English</option>
                      <option value="Punjabi">Punjabi</option>
                      <option value="Bengali">Bengali</option>
                      <option value="Gujrati">Gujrati</option>
                      <option value="Marathi">Marathi</option>
                      <option value="Telgu">Telgu</option>
                      <option value="Tamil">Tamil</option>
                      <option value="Assamese">Assamese</option>
                      <option value="Kannada">Kannada</option>
                      <option value="Malyalam">Malyalam</option>
                  <!-- Other options -->
                </select>
              </div>
              <div class="form-group">
                <label>Caption:</label>
                <input type="text" class="form-control" value="" name="title" required>
              </div>
              <div class="form-group">
                <label>Start Time (15:20:30)<?= date("H:i:s") ?> </label>
                <input type="text" class="form-control" name="starttime" value="" placeholder="H:M:S">
              </div>
              <div class="form-group">
                <label>Show Type:</label>
                <select class="form-control" name="showtype" required>
                <option value="">Select Showtype </option>
                      <option value="PST_1">PST_1</option>
                      <option value="PST_2">PST_2</option>
                      <option value="NPST_1">NPST_1</option>
                      <option value="NPST_2">NPST_2</option>
                  <!-- Other options -->
                </select>
              </div>

              <div class="form-group">
                <label> Show (select number of show of the day)</label>
                <select class="form-control" name="show1" required>
                <option value=""> Select Show </option>
                      <option value="PST_1">PST_1</option>
                      <option value="PST_2">PST_2</option>
                      <option value="NPST_1">NPST_1</option>
                      <option value="NPST_2">NPST_2</option>
                  <!-- Other options -->
                </select>
              </div>

              <div class="form-group">
                <label> Showing</label>
                <select class="form-control" name="showing" required>
                <option value=""> Select Showing </option>
                <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                  <!-- Other options -->
                </select>
              </div>

              <div class="form-group">
                <label>Movie Time:</label>
                <input type="text" class="form-control" name="movietime" value="" placeholder="H:M:S">
              </div>
            </div>
          </div>

          <div class="text-center">
            <input type="hidden" value="entry" name="action">
            <button type="submit" name="save" class="btn btn-primary">Save</button>
            <button type="reset" name="reset" class="btn btn-default">Reset</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Add report Modal End -->

<?php include_once("include/footer.php"); ?>