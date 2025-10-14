<?php
include('rest.php');
include('conectar.php');

$opc        = $_GET['o'] ?? '';
$id_post    = $_GET['i'] ?? '';

if(!isset($id_post) || empty($id_post) || !is_numeric($id_post) || !isset($opc) || ($opc != 1 && $opc != 2)){
    header("Location: pri.php");
    exit;
}

// Fetch user information
$query_guy  = "SELECT * FROM user WHERE nickname_user = ?";
$stmt_guy   = $conexao->prepare($query_guy);
$stmt_guy->bind_param("s", $login_user);
$stmt_guy->execute();
$rs_guy = $stmt_guy->get_result();
$infoguy= $rs_guy->fetch_assoc();
$stmt_guy->close();
                        
$id_user	= $infoguy['id_user'];

$query_lik = "SELECT * FROM liking WHERE use_lik = ? AND post_lik = ?";
$stmt_lik = $conexao->prepare($query_lik);
$stmt_lik->bind_param("ss", $id_user, $id_post);
$stmt_lik->execute();
$rs_lik = $stmt_lik->get_result();
$nlik  = $rs_lik->num_rows;

if($nlik == 0){

    $query_post = "SELECT * FROM posts WHERE id_post = ?";
    $stmt_post = $conexao->prepare($query_post);
    $stmt_post->bind_param("s", $id_post);
    $stmt_post->execute();
    $rs_post = $stmt_post->get_result();
    $infopost= $rs_post->fetch_assoc();
    $stmt_post->close();
                            
    $utilos	= $infopost['totutil_post'];

    if($opc == 1){
        $newutil = $utilos + 1;
    }else{
        $newutil = $utilos - 1;
    }

    // Insert into liking table
	$query_insert_liking = "INSERT INTO liking(id_lik, use_lik, post_lik, op_lik) VALUES (NULL, ?, ?, ?)"; 
    $stmt_insert_liking = $conexao->prepare($query_insert_liking);
    $stmt_insert_liking->bind_param("sss", $id_user, $id_post, $opc);
    $stmt_insert_liking->execute();
    $stmt_insert_liking->close();

    // Update totutil_post in posts table
    $query_update_post = "UPDATE posts SET totutil_post = ? WHERE id_post = ?";
    $stmt_update_post = $conexao->prepare($query_update_post);
    $stmt_update_post->bind_param("is", $newutil, $id_post);
    $stmt_update_post->execute();
	
    header("Location: readpost.php?i=$id_post");
    exit;
}else{
    header("Location: readpost.php?i=$id_post");
    exit;
}
?>