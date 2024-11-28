
<?php include_once("include/header.php"); ?>
<?php  $conn = new mysqli("localhost", "root", "", "desiantiques_agency");
 
// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$adminId = $_SESSION['adminId'];
$permissions = $prbsl->get_var("SELECT permissions FROM userdetail WHERE id='$adminId'");
$userPermissions = array();
if (!empty($permissions)) {
  $userPermissions = unserialize($permissions);
}

if (!array_key_exists("bulk_entry", $userPermissions)) {
  echo '<script>window.location.href="' . admin_url() . 'index.php";</script>';
}

// if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'entry') {
   
  $t_id      = $_POST['t_id'];

  $language  = $_POST['language'];

  $a_id      = $_POST['a_id'];
  $movietime = date("H:i:s", strtotime($_POST['movietime']));
   
  $a1        = $prbsl->get_row("select * from `theater` where `thcode`='" . $t_id . "' ");
 
  $theatername = $a1['name'];

  $region   = $a1['region'];
  $district = $a1['district'];
  $seating  = $a1['seating'];
  $thcode   = $a1['thcode'];
  $a2       = $prbsl->get_row("select * from `ad` where `id`='" . $a_id . "'");

  $title     = $a2['title'];
  $duration  = $a2['duration'];
  $rono      = $a2['rono'];
  $fromTime  = strtotime($_POST['fromDate']);
  $toTime    = strtotime($_POST['toDate']);
  $fromDate  = date("Y-m-d", $fromTime);
  $toDate    = date("Y-m-d", $toTime);
  $totalDays = floor(($toTime - $fromTime) / (60 * 60 * 24));

  for ($j = 0; $j <= $totalDays; $j++) {

    $starttime  = $_POST['starttime'];

    $endtime    = date("H:i:s", strtotime($starttime) + $duration);

    $airdate    = date("Y-m-d", strtotime("$fromDate + $j days"));

    $movietime  = date("H:i:s", strtotime($_POST['movietime']));

    $show1      = $_POST['show1'] + 1;

    for ($i = 1; $i < $show1; $i++) {

      $showtype   = $_POST['showtype'];
      $showing    = $_POST['showing'];
      $title      = $_POST['title'];
      $email      = $_SESSION['email'];

      // ========== Modify Start Time function start

      // Convert to DateTime object
      $starttimee = new DateTime($starttime);

      // Extract the current minutes and seconds
      $currentMinutes = (int)$starttimee->format('i');
      $currentSeconds = (int)$starttimee->format('s');

      // Define ranges based on the current minutes and seconds
      $minRangeStart  = max(0, $currentMinutes - 10); // Ensure it doesn't go below 0
      $minRangeEnd    = min(59, $currentMinutes + 10); // Ensure it doesn't go above 59

      $secRangeStart  = max(0, $currentSeconds - 10); // Ensure it doesn't go below 0
      $secRangeEnd    = min(59, $currentSeconds + 10); // Ensure it doesn't go above 59;

      // Generate random adjustments within the defined ranges
      $randomMinutes  = rand($minRangeStart, $minRangeEnd);
      $randomSeconds  = rand($secRangeStart, $secRangeEnd);

      // Update the time with random adjustments
      $starttimee->setTime(
        (int)$starttimee->format('H'), // Keep the hour unchanged
        $randomMinutes,               // Updated minutes
        $randomSeconds                // Updated seconds
      );

      // Get the modified time in H:i:s format
      $modifiedTime = $starttimee->format("H:i:s");

      // ========== Modify Start Time function end

      $sql = $prbsl->insert('maintable', array('theater_name' => $theatername, 'region' => $region, 'district' => $district, 'seating' => $seating, 'thcode' => $thcode, 'airdate' => $airdate, 'starttime' => $modifiedTime, 'endtime' => $endtime, 'showtype' => $showtype, 'showing' => $showing, 'duration' => $duration, 'caption' => $title, 'user' => $email, 'status' => 1, 'rono' => $rono, 'language' => $language, 'movietime' => $movietime, 'show1' => $i, 'a_id' => $a_id));

      $str_time     = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $endtime);
      sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
      $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
      $starttime    = date("H:i:s", strtotime($movietime) + $time_seconds);
      $endtime      = date("H:i:s", strtotime($starttime) + $duration);
 
    }
  }

  if ($sql == true) {
    echo '<p class="alert alert-success">Data Successfuly  Added</p>';
  } else {
    echo '<p class="alert alert-danger">"Try Again"</p>';
  }
// }
?>