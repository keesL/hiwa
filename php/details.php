<?php
require 'config.phplib';

$msg="";
if (!array_key_exists('hiwa-user', $_COOKIE) ||
    !array_key_exists('hiwa-role', $_COOKIE)) {
	Header("Location: login.php");
	exit();
}

$role=$_COOKIE['hiwa-role'];
if (array_key_exists('action', $_REQUEST)) {
	switch ($_REQUEST['action']) {
		case 'Add item':
			$conn = pg_connect("user=".$CONFIG['username'].
				" dbname=".$CONFIG['database']);
			$res = pg_query_params($conn, "INSERT INTO lineitems
			(orderid, productid, numprods, prodprice)
			VALUES
			($1, $2, $3, $4)", array(
				$_REQUEST['orderid'], 
				$_REQUEST['productid'],
				$_REQUEST['amount'],
				$_REQUEST['price']));
			pg_free_result($res);
			pg_close($conn);
			break;
		
		case 'remove':
			$conn = pg_connect("user=".$CONFIG['username'].
				" dbname=".$CONFIG['database']);
			$res = pg_query_params($conn, "DELETE FROM lineitems
				WHERE orderid=$1
			 	AND productid=$2", array(
				$_REQUEST['orderid'], 
				$_REQUEST['prodcode']));
			pg_free_result($res);
			pg_close($conn);
			break;
	}
}
?>


<html>
<head>
<title>HIWA Manage Order</title>
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>

<body>
<?php require 'header.php';?>
<div class="title">HIWA Manage Order</div>
<div class="subtitle">Logged in as <?php echo $_COOKIE['hiwa-user'];?>
	(<?php echo $role; ?>)
</div>

<?php
$conn = pg_connect("user=".$CONFIG['username']." dbname=".$CONFIG['database']);
$res = pg_query_params($conn, "SELECT * 
	FROM orders, customers
	WHERE orders.customerid = customers.customerid
	AND orderid=$1
	ORDER BY orderid DESC", array($_REQUEST['orderid']));
	if (pg_num_rows($res) == 0) {
		echo '<div class="err">Invalid order number</div>';
		exit();
	}
	$row = pg_fetch_assoc($res);
	pg_free_result($res);
?>
<table>
<tr>
	<td>Order Number</td>
	<td><?php echo '<a href="orders.php?orderid="'.
		$_REQUEST['orderid'].'>'.$_REQUEST['orderid'].'</a>';
		?></td>
</tr>
<tr>
	<td>Customer Name</td>
	<td><?php echo $row['customername']; ?></td>
</tr>
<tr>
	<td>Credit Limit</td>
	<td><?php echo $row['creditlimit']; ?></td>
</tr>
<tr>
	<td>Order Status</td>
	<td><?php echo $row['status']; ?></td>
</tr>
</table>

<table class="lineitems">
<tr>
	<th>Product code</th>
	<th>Product name</th>
	<th>Amount</th>
	<th>Extended price each</th>
	<th>Total price</th>
	<th>Actions</th>
</tr>
<?php
$total = 0;
$res = pg_query_params($conn, "SELECT *
	FROM lineitems, products
	WHERE orderid = $1
	AND   lineitems.productid = products.productid
	ORDER BY lineitems.productid", array($_REQUEST['orderid']));
while (($row = pg_fetch_assoc($res)) !== false) {
	$subtotal=$row['prodprice'] * $row['numprods'];
	$total += $subtotal;
	echo '<tr><td class="item">'.$row['productid'].'</td>
	<td class="item">'.$row['productname'].'</td>
	<td class="item num">'.$row['numprods'].'</td>
	<td class="item num">'.sprintf("%.2f", $row['prodprice']).'</td>
	<td class="item num">'.sprintf("%.2f", $subtotal).'</td>
	<td class="item"><a href="'.$_SERVER['SCRIPT_NAME'].'?action=remove&prodcode='.
		$row['productid'].'&orderid='.$_REQUEST['orderid'].'">remove</a></td></tr>';
}
echo '</table>';
echo 'Order total: <B>$'.sprintf("%.2f", $total).'</B>';
?>

<div class="itemadd">
<form method="post" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<input type="hidden" name="orderid" value="<?php echo $_REQUEST['orderid'];?>">
<tr>
	<td>Product</td>
	<td><select name="productid">
	<?php
pg_free_result($res);
$res = pg_query($conn, "SELECT *
	FROM products
	ORDER BY productid");
while (($row = pg_fetch_assoc($res)) !== false) {
	echo '<option value="'.$row['productid'].'">'.$row['productname'].
	 ' ('.$row['msrp'].')</option>';
}
	?>
	</select></td>
</tr>
<tr>
	<td>Amount</td>
	<td><input type="text" size="10" name="amount"></td>
</tr>
<tr>
	<td>Price each</td>
	<td><input type="text" size="10" name="price"></td>
</tr>
</table>

<input type="submit" name="action" value="Add item"/>
</div>

</form>
</body>
</html>
