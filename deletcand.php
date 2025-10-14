<?php
include('rest.php');
include('conectar.php');

$stmt = $conexao->prepare("SELECT id_user FROM user WHERE nickname_user = ?");
$stmt->bind_param("s", $login_user);
$stmt->execute();
$stmt->bind_result($id_user);
$stmt->fetch();
$stmt->close();

$stmt_del = $conexao->prepare("DELETE FROM capone_reg WHERE idcand_capreg = ?");
$stmt_del->bind_param("i", $id_user);
$stmt_del->execute();
$stmt_del->close();

header("Location: capo.php");
exit;
?>