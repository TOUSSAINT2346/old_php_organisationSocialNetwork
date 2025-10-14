<?php
include('conectar.php');
include('rest.php');

$id_post = $_POST['ie'];

// Prepare and execute user query
$stmt_guy = $conexao->prepare("SELECT id_user FROM user WHERE nickname_user = ?");
$stmt_guy->bind_param("s", $login_user);
$stmt_guy->execute();
$result_guy = $stmt_guy->get_result();
$infoguy = $result_guy->fetch_assoc();

$id_user = $infoguy['id_user'] ?? null;

// Prepare and execute post query
$stmt_post = $conexao->prepare("SELECT creat_post FROM posts WHERE id_post = ?");
$stmt_post->bind_param("i", $id_post);
$stmt_post->execute();
$result_post = $stmt_post->get_result();
$infopost = $result_post->fetch_assoc();

$id_creat = $infopost['creat_post'] ?? null;

if ($id_user && $id_user == $id_creat) {
    // Delete post
    $stmt1 = $conexao->prepare("DELETE FROM posts WHERE id_post = ?");
    $stmt1->bind_param("i", $id_post);
    $stmt1->execute();

    // Delete comments
    $tip_com = 'post';
    $stmt2 = $conexao->prepare("DELETE FROM comment WHERE idpag_com = ? AND tip_com = ?");
    $stmt2->bind_param("is", $id_post, $tip_com);
    $stmt2->execute();
}

$conexao->close();
header("Location: odmpri.php");
exit;
?>