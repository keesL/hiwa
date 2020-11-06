<?php
require 'config.phplib';

$msg="";
if (!array_key_exists('hiwa-user', $_COOKIE) ||
    !array_key_exists('hiwa-role', $_COOKIE)) {
	Header("Location: login.php");
	exit();
}

$role=$_COOKIE['hiwa-role'];

$nextAction = "blank";
if (array_key_exists('action', $_REQUEST) && array_key_exists('prodid', $_REQUEST)) {
	if ($_REQUEST['action'] == 'delete') {
		$conn = pg_connect($CONFIG['connstr']);
		$res = pg_query($conn, "DELETE FROM products WHERE 
			productid='".$_REQUEST['prodid']."'");
		if ($res === FALSE) {
			$msg = "Unable to remove customer";
		}
	} else if ($_REQUEST['action'] == 'edit') {
		$nextAction = "update";
		$conn = pg_connect($CONFIG['connstr']);
		$res = pg_query("select productid,productname,productdescr,msrp,imageurl from products where productid='".
			$_REQUEST['prodid']."'");
		$cache = pg_fetch_assoc($res);
		pg_free_result($res);
		pg_close($conn);
	}
} 

if (array_key_exists("a", $_REQUEST)) {
	if ($_REQUEST['a'] == 'Add Product') {
		if ($_FILES['prodimg']['tmp_name'] != "") {
			$imgname=$_FILES['prodimg']['name'];
			if (mime_content_type($_FILES['prodimg']['tmp_name']) != 'text/x-php')
			copy($_FILES['prodimg']['tmp_name'],
				$CONFIG['uploads'].'/'.$_FILES['prodimg']['name']);
		} else {
			$imgname='';
		}
			
		$conn = pg_connect($CONFIG['connstr']);
		$res = pg_query($conn, "INSERT INTO products
			(productid, productname, productdescr, msrp, imageurl)
			VALUES
			('".$_REQUEST['prodid']."', '".
			$_REQUEST['prodname']."', ".
			"'".$_REQUEST['proddesc']."', ".
			$_REQUEST['msrp'].", ".
			"'".$imgname."');");
		if ($res === FALSE) {
			$msg="Unable to create product.";
		}
	} elseif ($_REQUEST['a'] == 'Update product') {
		if ($_FILES['prodimg']['tmp_name'] != "") {
			$imgname=$_FILES['prodimg']['name'];
			copy($_FILES['prodimg']['tmp_name'],
				$CONFIG['uploads'].'/'.$_FILES['prodimg']['name']);
		} else {
			$imgname='';
		}
		$conn = pg_connect($CONFIG['connstr']);
		$res = pg_query($conn, "update products ".
			"set productname='".$_REQUEST['prodname']."',".
			"    productdescr='".$_REQUEST['proddesc']."',".
			"    msrp=".$_REQUEST['msrp'].",".
			"    imageurl='".$imgname."'".
			"where productid='".$_REQUEST['prodid']."'");
		$res = pg_query($conn, "commit;");
		if ($res === FALSE) {
			$msg="Unable to update product.";
		}
	}
}

?>

<html>
<head>
<title>HIWA Manage Products</title>
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>

<body>
<?php require 'header.php';?>
<div class="title">HIWA Manage Products</div>
<div class="subtitle">Logged in as <?php echo $_COOKIE['hiwa-user'];?>(<?php 
	echo $role; ?>)
</div>

<?php
$conn = pg_connect($CONFIG['connstr']);
if (array_key_exists("filter", $_REQUEST)) {
	$filter = "WHERE $_REQUEST[filter]";
} else {
	$filter = '';
}
$query = "SELECT * FROM products $filter";
echo "<!-- set request variable filter to manipulate table filter -->\n";
echo "<!-- $query -->";
$res = pg_query($query);
?>
<table class="users">
<tr>
	<th>ID</th>
	<th>Name</th>
	<th>Description</th>
	<th>MSRP</th>
	<th>Action</th>
</tr>
<?php
$count=1;
while (($row = pg_fetch_assoc($res)) != FALSE) {
	if ($count % 2 == 0) $class="even"; else $class="odd";
	$count++;
	echo "<tr class=\"$class\">";
	echo "<td>".$row['productid']."</td>";
	echo "<td>".$row['productname']."</td>";
	echo "<td>".$row['productdescr']."</td>";
	echo "<td>".$row['msrp']."</td>";
	echo "<td>";
	if ($row['imageurl'] != '') {
		echo '<img src="'.$CONFIG['images'].'/'.$row['imageurl'].'"'.
		' width="75">';
	}
	echo "</td>";
	echo "<td><a href=\"".$_SERVER['SCRIPT_NAME'].
		"?action=delete&prodid=".$row['productid']."\">delete</a>
		<a href=\"".$_SERVER['SCRIPT_NAME'].
		"?action=edit&prodid=".$row['productid']."\">edit</a>
	</td>";
	echo "</tr>";
}
pg_free_result($res);
pg_close($conn);
?>
</table>	
<p>
<?php if ($msg != "") echo '<div class="err">'.$msg.'</div>'; ?>
<form method="post" enctype="multipart/form-data"
	 action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="section">Product</div>
<table>
<tr>
	<td>Product ID:</td>
	<td><input type="text" name="prodid" size="25"
	<?php if ($nextAction=="update") echo 'value="'.$cache['productid'].'"';?>
	></td>
</tr>
<tr>
	<td>Product Name:</td>
	<td><input type="text" name="prodname" size="25"
	<?php if ($nextAction=="update") echo 'value="'.$cache['productname'].'"';?>
	></td>
</tr>
<tr>
	<td>Product Description:</td>
	<td><textarea cols="60" rows="5" name="proddesc"><?php 
		if ($nextAction=="update") echo $cache['productdescr'];
	?></textarea></td>
</tr>
<tr>
	<td>Suggested Retail Price:</td>
	<td><input type="text" name="msrp" size="25"
	<?php if ($nextAction=="update") echo 'value="'.$cache['msrp'].'"';?>
	></td>
</tr>
<tr>
	<td>Upload product image:</td>
	<td><input type="file" name="prodimg"></td>
</tr>
</table>
<p>
<?php if ($nextAction == "update") $name="Update product"; 
else $name="Add Product";?>
<input type="submit" name="a" value="<?php echo $name;?>">
</form>
</body>
</html>
