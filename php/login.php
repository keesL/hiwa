<?php
if (array_key_exists('login', $_REQUEST) &&
    array_key_exists('password', $_REQUEST)) {
 	require 'config.phplib';

	$conn = pg_connect("user=".$CONFIG['username'].
	    " dbname=".$CONFIG['database']);
	$result = pg_query("SELECT * from users
	    WHERE login='".$_REQUEST['login']."'
	    AND password='".$_REQUEST['password']."'");
	$row = pg_fetch_assoc($result);
	if ($row === False) {
		require 'header.php';
		print '<div class="err">Incorrect username/password</div>';
		exit();
	}
	setcookie("hiwa-user", $_REQUEST['login']);
	setcookie("hiwa-role", $row[0]['role']);
	Header("Location: menu.php");
	exit();
}
?>

<html>
<head>
<title>HIWA Login Screen</title>
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>

<body>
<?php require 'header.php'; ?>

<div class="login">
<p>Welcome to the Horribly Insecure Web Application.</p>


<form method="POST">
<div class="loginfield">
	<div class="loginlabel">Username</div>
	<div class="logininput">
		<input type="text" size="30" name="login">
	</div>
</div>
<div class="loginfield">
	<div class="loginlabel">Password</div>
	<div class="logininput">
		<input type="password" size="30" name="password">
	</div>
</div>
<p/><input type="submit" name="Login"/>
</form>
</div><!-- login -->
</body>
</html>

