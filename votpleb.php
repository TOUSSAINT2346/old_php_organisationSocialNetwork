<?php
include('rest.php');
include('conectar.php');

$opc        = $_POST['escolha'] ?? '';
$id_pleb    = $_POST['id'] ?? '';

if(!isset($opc) || empty($opc) || !is_numeric($opc) || $opc < 1 || $opc > 4){
    header("Location: plebs.php");
    exit;
}

// Fetch user information
$query_guy= "SELECT * FROM user WHERE nickname_user = ?";
$stmt_guy = $conexao->prepare($query_guy);
$stmt_guy->bind_param("s", $login_user);
$stmt_guy->execute();
$rs_guy   = $stmt_guy->get_result();
$infoguy  = $rs_guy->fetch_assoc();
$stmt_guy->close();
                        
$id_user	= $infoguy['id_user'];

$query_vot = "SELECT * FROM votpleb WHERE idus_vtp = ? AND idple_vtp = ?";
$stmt_vot = $conexao->prepare($query_vot);
$stmt_vot->bind_param("ii", $id_user, $id_pleb);
$stmt_vot->execute();
$rs_vot = $stmt_vot->get_result();
$nvot  = $rs_vot->num_rows;

if($nvot == 0){

    $query = $conexao->prepare("INSERT INTO votpleb(id_vtp,idus_vtp,idple_vtp,resp_vtp) VALUES (NULL,?,?,?)");
    $query->bind_param("iii", $id_user, $id_pleb, $opc);
    $query->execute();
    $query->close();

    header("Location: readpleb.php?i=$id_pleb");
    exit;
}else{
    header("Location: readpleb.php?i=$id_pleb");
    exit;
}
?>