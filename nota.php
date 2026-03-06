<style type="text/css">body {width: 100%;} </style> 
<body OnLoad="window.print()" OnFocus="window.close()"> 

<?php
session_start();
//error_reporting(0);
include('includes/config.php');
echo"<link href='greenblack.css' rel='stylesheet' type='text/css' />";
$kelompok=$_GET["id"];

echo"<b><h2>Nota $kelompok</h2>";
?>
<table width="98%">
<thead>
	<tr>
		<th class="cart-romove item">#</th>
		<th class="cart-description item">Image</th>
		<th class="cart-product-name item">Product Name</th>
		<th class="cart-qty item">Quantity</th>
		<th class="cart-sub-total item">Price Per unit</th>
		<th class="cart-sub-total item">Shipping Charge</th>
		<th class="cart-total item">Grandtotal</th>
	</tr>
</thead><!-- /thead -->

<tbody>

<?php 
$tot=0;
$jml=0;
echo"<tr bgcolor='#dddddd'><td colspan='12'>";
$query=mysqli_query($con,"select products.productImage1 as pimg1,products.productName as pname,products.id as proid,orders.productId as opid,orders.quantity as qty,products.productPrice as pprice,products.shippingCharge as shippingcharge,orders.paymentMethod as paym,orders.orderStatus as orderStatus,orders.orderDate as odate,orders.id as orderid from orders join products on orders.productId=products.id where orders.userId='".$_SESSION['id']."' and orders.orderDate='$kelompok' and orders.paymentMethod is not null ");
$cnt=1;
$jum=0;
$order="";
$pay="";

while($row=mysqli_fetch_array($query)){
$order=$row['orderStatus'];
$pay=$row['paym'];
?>
	<tr>
		<td><?php echo $cnt;?></td>
		<td class="cart-image">
			<a class="entry-thumbnail" href="detail.html">
				<img src="admin/productimages/<?php echo $row['proid'];?>/<?php echo $row['pimg1'];?>" alt="" width="60" height="50">
			</a>
		</td>
		<td class="cart-product-name-info">
			<h4 class='cart-product-description'><a href="product-details.php?pid=<?php echo $row['opid'];?>">
			<?php echo $row['pname'];?></a></h4>
		</td>
		<td class="cart-product-quantity">
			<?php echo $qty=$row['qty']; ?>   
		</td>
		<td class="cart-product-sub-total"><?php echo $price=$row['pprice']; ?>k</td>
		<td class="cart-product-sub-total"><?php echo $shippcharge=$row['shippingcharge']; ?> </td>
		<td class="cart-product-grand-total"><?php echo (($qty*$price)+$shippcharge);?>k</td>
	</tr>
<?php 
$cnt=$cnt+1;
$tot+=(($qty*$price)+$shippcharge);
$jum+=$qty;
}//while loop utama 
?>
				
</tbody><!-- /tbody -->
</table><!-- /table -->

<div align='right'>	
<?php
echo"<big><b><small>
Jumlah Item: $cnt (SubItem $jum) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></br>";
echo "<b><i>Tagihan: ".RP($tot)." Terbilang ".terbilang($tot)." Ribu Rupiah; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i><br>
Payment $pay, Status $order &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</small></big></b>";

?>		
</div>