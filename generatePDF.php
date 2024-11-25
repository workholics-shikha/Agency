<?php
 include_once("include/function.php");
      global $prbsl;
include('MPDF57/mpdf.php');

$name 	= $_POST['name'];
$email 	= $_POST['email'];
$msg 	= $_POST['message'];

$a2 =$prbsl->get_row("select * from `ad` where `id`='".$_POST['a_id']."'");
        $rono=$a2['rono'];
        $cc=$a2['clientname'];
        $cc1=$a2["family"];
        $cc2=$a2["invoiceno"];
        $cc3=date("m-d-Y",strtotime($a2["date"]));
        $cc4=date("m-d-Y",strtotime($a2["periodfrom"]));
        $cc5=date("m-d-Y",strtotime($a2["periodto"]));
        $cc6=$a2["agencyname"];
        $cc7=$a2["duration"];
        if($a2['spot']==1){
          $spot="Preshow";
        }else if($a2['spot']==2){
          $spot="Postshow";
        }else if($a2['spot']==3){
          $spot="Interval";
        }else{
          $spot="";
        } 
       


      
   //$sql= "SELECT * FROM `maintable` "; 
 

       // $getdata=$prbsl->get_results($sql);
        


$html .= "<html>

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

<div style='text-align:center;'>Report Data</div><br>
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
<td width='15%'>Language</td>
</tr>
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



$mpdf=new mPDF();
$mpdf->WriteHTML($html);
$mpdf->SetDisplayMode('fullpage');

$mpdf->Output();

?>