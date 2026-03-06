<?php
define('DB_SERVER','localhost');
define('DB_USER','root');
define('DB_PASS' ,'');
define('DB_NAME', 'shopping');
$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
// Check connection
if (mysqli_connect_errno())
{
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
/*
Password admin : Test@123
Id ADMIN : admin
productStock

*/
 
function terbilang($i){
  $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
 
  if ($i < 12) return " " . $huruf[$i];
  elseif ($i < 20) return terbilang($i - 10) . " Belas";
  elseif ($i < 100) return terbilang($i / 10) . " Puluh" . terbilang($i % 10);
  elseif ($i < 200) return " Seratus" . terbilang($i - 100);
  elseif ($i < 1000) return terbilang($i / 100) . " Ratus" . terbilang($i % 100);
  elseif ($i < 2000) return " Seribu" . terbilang($i - 1000);
  elseif ($i < 1000000) return terbilang($i / 1000) . " Ribu" . terbilang($i % 1000);
  elseif ($i < 1000000000) return terbilang($i / 1000000) . " Juta" . terbilang($i % 1000000);   
}
function RP($rupiah){
	return number_format($rupiah, "2", ",", ".");
} 
function WKT($sekarang){
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


function setKurang($con,$jum,$pid){
	$sql="update `products` set `productStock`=`productStock`-'$jum' where `id`='$pid' "; 
	$q=mysqli_query($con,$sql);
	return 0;
}

function setUpdate($con,$jum1,$jum2,$pid){
	$sel=$jum1-$jum2;
	//10 (90)-14(86)=-4
	//10 (90)-14(86)=-4
	//tambah
	$sql="update `products` set `productStock`=`productStock`+'$sel' where `id`='$pid' "; 
	$q=mysqli_query($con,$sql);
	return 0;
}

function setDel($con,$jum,$pid,$status){
	//tambah
	$sql="update `products` set `productStock`=`productStock`-'$jum' where `id`='$pid' ";
	if($status=="batal"){
		$sql="update `products` set `productStock`=`productStock`+'$jum' where `id`='$pid' ";
	}
	$q=mysqli_query($con,$sql);
	return 0;
}
//f925916e2754e5e03f75dd58a5733251  admin
//c8f81e72ed8e703e593c1008f00de366
//3af4c9341e31bce1f4262a326285170d

?>