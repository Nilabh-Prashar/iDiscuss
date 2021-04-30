<?php
session_start();
session_unset();
session_destroy();
header("location: /iforum/index.php");
exit;
?>