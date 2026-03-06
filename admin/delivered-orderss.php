
<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{

date_default_timezone_set('Asia/Kolkata');// change according timezone
$currentTime = date( 'd-m-Y h:i:s A', time () );


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin| Delivered Report</title>
	<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link type="text/css" href="css/theme.css" rel="stylesheet">
	<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
	
	<script type="text/javascript"> 
function PRINT(){ 
win=window.open('../report.php?st=Delivered','win','width=1000, height=400, menubar=0, scrollbars=1, resizable=0, location=0, toolbar=0, status=0'); } 

</script>

	<script language="javascript" type="text/javascript">
var popUpWin=0;
function popUpWindow(URLStr, left, top, width, height)
{
 if(popUpWin)
{
if(!popUpWin.closed) popUpWin.close();
}
popUpWin = open(URLStr,'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+600+',height='+600+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
}

</script>
</head>
<body>
<?php include('include/header.php');?>

<div class="wrapper">
<div class="container">
<div class="row">
<?php include('include/sidebar.php');?>				
<div class="span9">
<div class="content">

<div class="module">
<div class="module-head">
<h3>Delivered Report</h3>
</div>
<div class="module-body table">
<?php if(isset($_GET['del']))
{?>
<div class="alert alert-error">
<button type="button" class="close" data-dismiss="alert">×</button>
<strong>Oh snap!</strong> 	<?php echo htmlentities($_SESSION['delmsg']);?><?php echo htmlentities($_SESSION['delmsg']="");?>
</div>
<?php } ?>

<br />

<form action="" method="post">
<table><tr>
<td><b><small>Masukkan Tanggal Pencarian
<td width='1'>:
<td><input type='date' name='tgl1' value=''>
<td width='2'><b><small>s/d
<td><input type='date' name='tgl2' value=''>
<td><td><input type='submit' name='Cari' value='Cari'>
</table>
</form>
<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display table-responsive">
<thead>
<tr>
<th>#</th>
<th> Name</th>
<th width="50">Email /Contact no</th>
<th>Shipping Address</th>
<th>Product </th>
<th>Qty </th>
<th>Amount </th>
<th>Order Date</th>
</tr>
</thead>

<tbody>
<?php 

function WKT2($sekarang){
	if ($sekarang == "0000-00-00") {
		$sekarang = date("Y-m-d");
	}

	$tanggal = substr($sekarang, 8, 2) + 0;
	$bulan = substr($sekarang, 5, 2);
	$tahun = substr($sekarang, 0, 4);

	$judul_bln = array(1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
	$wk = $tanggal . " " . $judul_bln[(int)$bulan] . " " . $tahun;
	return $wk;
}

$f1="00:00:00";
$from=date('Y-m-d')." ".$f1;
$t1="23:59:59";
$to=date('Y-m-d')." ".$t1;
$gab="List data ".WKT2(date('Y-m-d'));
if(isset($_POST["Cari"])){
$T1=$_POST["tgl1"];
$T2=$_POST["tgl2"];

$f1="00:00:00";
$from=$T1." ".$f1;
$t1="23:59:59";
$to=$T2." ".$t1;
	$gab="List data ".WKT2($T1)." s/d ".WKT2($T2);
}

$status='Delivered';
// $sql="select users.name as username,users.email as useremail,users.contactno as usercontact,users.shippingAddress as shippingaddress,users.shippingCity as shippingcity,users.shippingState as shippingstate,users.shippingPincode as shippingpincode,products.productName as productname,products.shippingCharge as shippingcharge,orders.quantity as quantity,orders.orderDate as orderdate,products.productPrice as productprice,orders.id as id  from orders join users on  orders.userId=users.id join products on products.id=orders.productId where orders.	orderStatus!='$status' or orders.orderStatus is null and orders.orderDate Between '$from' and '$to'";
$sql="SELECT users.name as username,
             users.email as useremail,
             users.contactno as usercontact,
             users.shippingAddress as shippingaddress,
             users.shippingCity as shippingcity,
             users.shippingState as shippingstate,
             users.shippingPincode as shippingpincode,
             products.productName as productname,
             products.shippingCharge as shippingcharge,
             orders.quantity as quantity,
             orders.orderDate as orderdate,
             products.productPrice as productprice,
             orders.id as id
      FROM orders
      JOIN users ON orders.userId = users.id
      JOIN products ON products.id = orders.productId
      WHERE orders.orderStatus = '$status'
        AND orders.orderDate BETWEEN '$from' AND '$to'";

$query=mysqli_query($con,$sql);
$cnt=1;
$jum=0;
$tot=0;
while($row=mysqli_fetch_array($query)){
?>										
<tr>
<td><?php echo htmlentities($cnt);?></td>
<td><?php echo htmlentities($row['username']);?></td>
<td><?php echo htmlentities($row['useremail']);?>/<?php echo htmlentities($row['usercontact']);?></td>
<td><?php echo htmlentities($row['shippingaddress'].",".$row['shippingcity'].",".$row['shippingstate']."-".$row['shippingpincode']);?></td>
<td><?php echo htmlentities($row['productname']);?></td>
<td><?php echo htmlentities($row['quantity']);?></td>
<td><?php echo htmlentities($row['quantity']*$row['productprice']+$row['shippingcharge']);?></td>
<td><?php echo htmlentities($row['orderdate']);?></td>

</tr>

<?php 
$cnt=$cnt+1;  
$jum+=$row['quantity'];
$tot+=($row['quantity']*$row['productprice']+$row['shippingcharge']);

}
?>
</tbody>

<?php


function terbilang2($i){
  $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
 
  if ($i < 12) return " " . $huruf[$i];
  elseif ($i < 20) return terbilang2($i - 10) . " Belas";
  elseif ($i < 100) return terbilang2($i / 10) . " Puluh" . terbilang2($i % 10);
  elseif ($i < 200) return " Seratus" . terbilang2($i - 100);
  elseif ($i < 1000) return terbilang2($i / 100) . " Ratus" . terbilang2($i % 100);
  elseif ($i < 2000) return " Seribu" . terbilang2($i - 1000);
  elseif ($i < 1000000) return terbilang2($i / 1000) . " Ribu" . terbilang2($i % 1000);
  elseif ($i < 1000000000) return terbilang2($i / 1000000) . " Juta" . terbilang2($i % 1000000);   
}
function RP2($rupiah){
	return number_format($rupiah, "2", ",", ".");
} 


?>


</table>
</div>

<?php
$lap="<big><b><small>
Jumlah Item: $cnt (SubItem $jum) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></br>";
$lap.= "<b><i>Tagihan: ".RP2($tot)." Terbilang ".terbilang2($tot)." Ribu Rupiah; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i><br>
<i>$gab</i></small></big></b>
";
echo $lap;
$_SESSION["lap"]=$lap;
$_SESSION["sql"]=$sql;
$_SESSION["gab"]=$gab;
echo "| <a href='#'  OnClick='PRINT()'><img src='../print.png' title='cetak nota'></a>";
?>
</div>						



</div><!--/.content-->
</div><!--/.span9-->
</div>
</div><!--/.container-->
</div><!--/.wrapper-->

<?php include('include/footer.php');?>

	<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
	<script src="scripts/datatables/jquery.dataTables.js"></script>
	<script>
		$(document).ready(function() {
			$('.datatable-1').dataTable();
			$('.dataTables_paginate').addClass("btn-group datatable-pagination");
			$('.dataTables_paginate > a').wrapInner('<span />');
			$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
			$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
		} );
	</script>
</body>
<?php } ?>