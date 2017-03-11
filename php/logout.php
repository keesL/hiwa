<?php
	setcookie('hiwa-user', '', time()-1);
	setcookie('hiwa-role', '', time()-1);
	Header("Location: login.php");
?>
