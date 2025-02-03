<?php
// logout.php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// blueirect to login page
header("Location: login.php");
exit();
?>
