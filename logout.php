<?php
session_start();
session_unset();
session_destroy();


session_start();
setcookie("active_user", "", time() - 3600, "/"); // Remove the cookie
session_destroy();
header("Location: login.php");
exit();



// Prevent back button from restoring session
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");

header("Location: login.php");
exit();
?>
