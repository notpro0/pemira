<?php
include 'config.php';
unset($_SESSION['admin']);
header("Location: admin_login.php");
exit();
?>
