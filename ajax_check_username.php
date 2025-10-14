<?php
include('conectar.php');
//Include The Database Connection File 

//If a username has been submitted 
if(isset($_POST['username'])){

    $username = htmlspecialchars($_POST['username']); //Some clean up :)

    $query_checkusername= "SELECT nickname_user FROM user WHERE nickname_user = ?";
    $stmt_checkusername = $conexao->prepare($query_checkusername);
    $stmt_checkusername->bind_param("s", $username);
    $stmt_checkusername->execute();
    $res_checkusername  = $stmt_checkusername->get_result();
    $check_for_username = $res_checkusername->num_rows;

    //Query to check if username is available or not 
    if($check_for_username){
        echo '1'; //If there is a  record match in the Database - Not Available
    }else{
        echo '0'; //No Record Found - Username is available 
    }

}

?>