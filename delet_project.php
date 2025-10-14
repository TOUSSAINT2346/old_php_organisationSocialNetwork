CARREGANDO...
<?php
include('conectar.php');
include('rest.php');

$id_project = $_GET['i'];

$query_guy = "SELECT * FROM user WHERE nickname_user = ?";
$stmt_guy = $conexao->prepare($query_guy);
$stmt_guy->bind_param("s", $login_user);
$stmt_guy->execute();
$rs_guy = $stmt_guy->get_result();
$infoguy = $rs_guy->fetch_assoc();

$id_user = $infoguy['id_user'];

$query_proj = "SELECT * FROM projetos WHERE id_proj = ?";
$stmt_proj = $conexao->prepare($query_proj);
$stmt_proj->bind_param("s", $id_project);
$stmt_proj->execute();
$rs_proj = $stmt_proj->get_result();
$infoproj = $rs_proj->fetch_assoc();

$id_creat = $infoproj['creat_proj'];

if ($id_user == $id_creat) {
    $query1 = $conexao->prepare("DELETE FROM projetos WHERE id_proj = ?");
    $query1->bind_param("s", $id_project);
    $query1->execute();

    $query2 = $conexao->prepare("DELETE FROM comment WHERE idpag_com = ? AND tip_com = 'project'");
    $query2->bind_param("s", $id_project);
    $query2->execute();

    $conexao->close();

    header("Location: projectos.php");
    exit;
} else {
    header("Location: projectos.php");
    exit;
}
?>
CARREGANDO...