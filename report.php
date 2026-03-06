<style type="text/css">body {width: 100%;} </style> 
<body OnLoad="window.print()" OnFocus="window.close()"> 

<?php
session_start(); 
include('includes/config.php');
echo"<link href='greenblack.css' rel='stylesheet' type='text/css' />";
$status=$_GET["st"];
$lap=$_SESSION["lap"];
$sql=$_SESSION["sql"];
$gab=$_SESSION["gab"];

echo"<b><h2>Laporan $status $gab</h2>";
?>


<table cellpadding="0" cellspacing="0" border="0" width="98%">
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
$cnt=1;
$query=mysqli_query($con,$sql); 
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
$cnt++;
}
?>
</tbody>
</table>

<?php
echo $lap;
?>