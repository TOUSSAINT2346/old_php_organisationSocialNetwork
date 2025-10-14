<?php
include('rest.php');
include('conectar.php');

$opc        = $_GET['o'] ?? '';
$project_id = $_GET['i'] ?? '';

if(empty($opc) || empty($project_id)){
    header('Location: projectos.php');
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

// Check if user has already voted on this project
$query_vot = "SELECT * FROM vot_proj WHERE iduser_vop = ? AND idproj_vop = ?";
$stmt_vot = $conexao->prepare($query_vot);
$stmt_vot->bind_param("ii", $id_user, $project_id);
$stmt_vot->execute();
$rs_vot = $stmt_vot->get_result();
$nvot  = $rs_vot->num_rows;

// If not voted yet, insert the vote
if($nvot == 0){
    $query = $conexao->prepare("INSERT INTO vot_proj(id_vop,idproj_vop,iduser_vop,op_vop) VALUES (NULL,?,?,?)");
    $query->bind_param("iis", $project_id, $id_user, $opc);
    $query->execute();
    $query->close();

    header("Location: readproject.php?i=$project_id");
    exit;
}else{
    header("Location: readproject.php?i=$project_id");
    exit;
}
?>