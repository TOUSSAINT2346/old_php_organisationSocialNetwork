<?php
include('rest.php');
include('conectar.php');

// Fetch user information
$query_guy= "SELECT * FROM user WHERE nickname_user = ?";
$stmt_guy = $conexao->prepare($query_guy);
$stmt_guy->bind_param("s", $login_user);
$stmt_guy->execute();
$rs_guy   = $stmt_guy->get_result();
$infoguy  = $rs_guy->fetch_assoc();
$stmt_guy->close();

$id_user	= $infoguy['id_user'];

$query_cand = "SELECT * FROM user WHERE nickname_user = ?";
$stmt_cand = $conexao->prepare($query_cand);
$stmt_cand->bind_param("s", $login_user);
$stmt_cand->execute();
$rs_cand = $stmt_cand->get_result();
$ncand = $rs_cand->num_rows;
$stmt_cand->close();

if($ncand < 5){

    $query_cand1 = "SELECT * FROM capone_reg WHERE idcand_capreg = ?";
    $stmt_cand1 = $conexao->prepare($query_cand1);
    $stmt_cand1->bind_param("i", $id_user);
    $stmt_cand1->execute();
    $rs_cand1 = $stmt_cand1->get_result();
    $ncand1 = $rs_cand1->num_rows;
    $stmt_cand1->close();

    if($ncand1 != 1){
        $query_insert = "INSERT INTO capone_reg(id_capreg, idcand_capreg, votos_capreg) VALUES (NULL, ?, 0)";
        $stmt_insert = $conexao->prepare($query_insert);
        $stmt_insert->bind_param("i", $id_user);
        $stmt_insert->execute();
        $stmt_insert->close();

        header("Location: capo.php");
        exit; 
    }
}else{
    header("Location: capo.php");
    exit;
}

?>