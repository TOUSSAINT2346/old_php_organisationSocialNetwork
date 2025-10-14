<?php
session_start();
unset($_SESSION["usera"]);
session_destroy();
header("location: index.php");
?>