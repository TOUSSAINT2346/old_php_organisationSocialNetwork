<?php
// This file updates the notifications to mark them as read
include("rest.php");
include("conectar.php");

// WHO'S USER?
$query_useruma = "SELECT * FROM user WHERE nickname_user = ?";
$stmt = $conexao->prepare($query_useruma);
$stmt->bind_param("s", $login_user);
$stmt->execute();
$rs_useruma = $stmt->get_result();
$userumainfus = $rs_useruma->fetch_array();

$id_useruma     = $userumainfus['id_user'];

$stmt_update = $conexao->prepare("UPDATE notifs SET sit_not = 1 WHERE iduse_not = ?");
$stmt_update->bind_param("i", $id_useruma);
$stmt_update->execute();
?>