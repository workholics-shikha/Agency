<?php
// Database connection ===========
$conn = new mysqli("localhost", "root", "", "desiantiques_agency");

if (isset($_GET['id'])) {
  $id = intval($_GET['id']);

  $getData  =  $conn->query("SELECT * FROM `maintable` WHERE `id` = " . (int)$id)->fetch_assoc();

  $sql1     = "SELECT * FROM `ad` WHERE `status` = '1' ORDER BY `id` ASC";
  $result1  = $conn->query($sql1);

  if (!$result1) {
    die("Query Failed: " . $conn->error); // Output query error for debugging
  }

  $rows1   = $result1->fetch_all(MYSQLI_ASSOC);

  $sql2    = "SELECT * FROM `theater` ORDER BY `id` DESC";
  $result2 = $conn->query($sql2);

  if (!$result2) {
    die("Query Failed: " . $conn->error); // Output query error for debugging
  }

  $rows2 = $result2->fetch_all(MYSQLI_ASSOC);

  echo '<form method="post" enctype="multipart/form-data" id="editExportForm" >
 
<div class="row">
  <!-- From Date and To Date -->
  <div class="col-md-6">
    <div class="form-group">
      <label>From Date:</label>
      <input type="date" name="airdate" value="' . $getData['airdate'] . '" placeholder="From Date" class="form-control datepicker" id="datepicker" autocomplete="off" required >
    </div>
  </div>
 
</div>

<div class="row">
  <!-- Ads Name -->
  <div class="col-md-12">
    <div class="form-group">
      <label>Ads Name (Ro No.):</label>
      <select class="form-control" name="a_id" required id="a_id">
        <option value="">Select Ad and Ro No</option>';

  foreach ($rows1 as $rows):
    echo '<option value="' . $rows['id'] . '"';

    if ($rows['id'] == $getData['a_id']) {
      echo 'selected';
    }
    echo ' > 
              ' .  $rows['clientname'] . " " . $rows['title'] . " ( " . $rows['rono'] . " )" . ' </option>';
  endforeach;
  echo '</select>
    </div>
  </div>
</div>
  

<div class="row">
  
  <div class="col-md-12">
    <div class="form-group">
      <label> Theater Name: </label>
      <select class="form-control" name="thcode" required id="theaterId'.$id.'" >
        <option value="">Select Theater Name</option>';

        foreach ($rows2 as $row):
          echo '<option optVal="' . $row['name'] . '" value="' . $row['thcode'] . '"';

          if ($row['thcode'] == $getData['thcode']) {
            echo 'selected';
          }
          echo ' > ' . $row['company'] . ' ' . $row['district'] . ' ' . $row['name'] . ' ( ' . $row['thcode'] . ' )' . '
                      </option>';
        endforeach;
        echo '</select>
    </div>
  </div>
</div>

<div class="row">
  <!-- Language and Caption -->
  <div class="col-md-6">
    <div class="form-group">
      <label>Language:</label>
      <select class="form-control" id="language" name="language" required>
        <option value="">Select Language</option>
        <option value="Hindi"';
  if ($getData['language'] == "Hindi") {
    echo 'selected';
  }
  echo '>Hindi</option>
        <option value="English"';
  if ($getData['language'] == "English") {
    echo 'selected';
  }
  echo '>English</option>
        <option value="Punjabi"';
  if ($getData['language'] == "Punjabi") {
    echo 'selected';
  }
  echo '>Punjabi</option>
        <option value="Bengali"';
  if ($getData['language'] == "Bengali") {
    echo 'selected';
  }
  echo '>Bengali</option>
        <option value="Gujrati"';
  if ($getData['language'] == "Gujrati") {
    echo 'selected';
  }
  echo '>Gujrati</option>
        <option value="Marathi"';
  if ($getData['language'] == "Marathi") {
    echo 'selected';
  }
  echo '>Marathi</option>
        <option value="Telgu"';
  if ($getData['language'] == "Telgu") {
    echo 'selected';
  }
  echo '>Telgu</option>
        <option value="Tamil"';
  if ($getData['language'] == "Tamil") {
    echo 'selected';
  }
  echo '>Tamil</option>
        <option value="Assamese"';
  if ($getData['language'] == "Assamese") {
    echo 'selected';
  }
  echo '>Assamese</option>
        <option value="Kannada"';
  if ($getData['language'] == "Kannada") {
    echo 'selected';
  }
  echo '>Kannada</option>
        <option value="Malyalam"';
  if ($getData['language'] == "Malyalam") {
    echo 'selected';
  }
  echo '>Malyalam</option>
      </select>
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label>Caption:</label>
      <input type="text" class="form-control" value="' . $getData['caption'] . '" name="caption" required>
    </div>
  </div>
</div>

<div class="row">
  <!-- Start Time, Show Type, and Movie Time -->
  <div class="col-md-6">
    <div class="form-group">
      <label>Start Time (15:20:30):</label>
      <input type="time" class="form-control" name="starttime" value="' . $getData['starttime'] . '" placeholder="H:M:S">
    </div>
  </div>

 <div class="col-md-6">
    <div class="form-group">
      <label>End Time (15:20:30):</label>
      <input type="time" class="form-control" name="endtime" value="' . $getData['endtime'] . '" placeholder="H:M:S">
    </div>
  </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label>Show Type:</label>
        <select class="form-control" name="showtype" required>
          <option value=""> Select Showtype </option>
          <option value="PST_1"';
  if ($getData['showtype'] == "PST_1") {
    echo 'selected';
  }
  echo '> PST_1 </option>
                  <option value="PST_2"';
  if ($getData['showtype'] == "PST_2") {
    echo 'selected';
  }
  echo '> PST_2 </option>
                  <option value="NPST_1"';
  if ($getData['showtype'] == "NPST_1") {
    echo 'selected';
  }
  echo '> NPST_1 </option>
                  <option value="NPST_2"';
  if ($getData['showtype'] == "NPST_2") {
    echo 'selected';
  }
  echo '> NPST_2 </option>
        </select>
      </div>
    </div>

    <!-- Show and Showing -->
    <div class="col-md-6">
    <div class="form-group">
      <label>Show (Select number of shows):</label>
      <select class="form-control" name="show1" required>
      <option value="">Select Show </option>
            <option value="1"';
  if ($getData['show1'] == "1") {
    echo 'selected';
  }
  echo '>1</option>
                                    <option value="2"';
  if ($getData['show1'] == "2") {
    echo 'selected';
  }
  echo '>2</option>
                                    <option value="3"';
  if ($getData['show1'] == "3") {
    echo 'selected';
  }
  echo '>3</option>
                                    <option value="4"';
  if ($getData['show1'] == "4") {
    echo 'selected';
  }
  echo '>4</option>
                                    <option value="5"';
  if ($getData['show1'] == "5") {
    echo 'selected';
  }
  echo '>5</option>
      </select>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>Showing:</label>
      <select class="form-control" name="showing" required>
        <option value="">Select Showing</option>
         <option value="1"';
  if ($getData['showing'] == "1") {
    echo 'selected';
  }
  echo '>1</option>
                      <option value="2"';
  if ($getData['showing'] == "2") {
    echo 'selected';
  }
  echo '>2</option>
                      <option value="3"';
  if ($getData['showing'] == "3") {
    echo 'selected';
  }
  echo '>3</option>
                      <option value="4"';
  if ($getData['showing'] == "4") {
    echo 'selected';
  }
  echo '>4</option>
                      <option value="5"';
  if ($getData['showing'] == "5") {
    echo 'selected';
  }
  echo '>5</option>
      </select>
    </div>
  </div>
 
  <!-- Movie Time -->
  <div class="col-md-6">
    <div class="form-group">
      <label>Movie Time:</label>
      <input type="text" class="form-control" name="movietime" value="' . $getData['movietime'] . '" placeholder="H:M:S">
    </div>
  </div>
</div>

<div class="row">
<div class="col-md-6">
    <div class="form-group">
      <label>Region:</label>
      <input type="text" class="form-control" name="region" value="' . $getData['region'] . '" placeholder="Region">
    </div>
  </div>
 <div class="col-md-6">
    <div class="form-group">
      <label>District:</label>
      <input type="text" class="form-control" name="district" value="' . $getData['district'] . '" placeholder="District">
    </div>
  </div>
</div>
 
<div class="text-center">
   <input type="hidden" value="'.$id.'" name="id">
   <button type="button" name="update" class="btn btn-primary" id="submitExportFormBtn" form-id="' . $id . '" >Update</button>
 
</div>
</form>';  
// <button type="reset"  name="reset" class="btn btn-default" id="resetBtn" >Reset</button>
}
