<?php
@session_start();
if (isset($_SESSION['usera'])){
   $login_user = $_SESSION['usera'];
}else{
   header("Location:index.php");
   exit;
}
?>