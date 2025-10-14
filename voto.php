SALVANDO VOTO...
<?php
include('rest.php');
include('conectar.php');
$id_cand = $_POST['voto'];

// Assuming $login_user is set somewhere before
$query_guy = $conexao->prepare("SELECT id_user FROM user WHERE nickname_user = ?");
$query_guy->bind_param("s", $login_user);
$query_guy->execute();
$query_guy->bind_result($id_user);
$query_guy->fetch();
$query_guy->close();

$query_votos = $conexao->prepare("SELECT COUNT(*) FROM votos WHERE iduser_voto = ?");
$query_votos->bind_param("i", $id_user);
$query_votos->execute();
$query_votos->bind_result($nvoto);
$query_votos->fetch();
$query_votos->close();

if ($nvoto == 0) {
    $query_cand = $conexao->prepare("SELECT votos_capreg FROM capone_reg WHERE idcand_capreg = ?");
    $query_cand->bind_param("i", $id_cand);
    $query_cand->execute();
    $query_cand->bind_result($vottot);
    $query_cand->fetch();
    $query_cand->close();

    $vottot_new = $vottot + 1;

    $query1 = $conexao->prepare("INSERT INTO votos(iduser_voto) VALUES (?)");
    $query1->bind_param("i", $id_user);
    $query1->execute();
    $query1->close();

    $query2 = $conexao->prepare("UPDATE capone_reg SET votos_capreg = ? WHERE idcand_capreg = ?");
    $query2->bind_param("ii", $vottot_new, $id_cand);
    $query2->execute();
    $query2->close();

    header("Location: capo.php");
    exit;
} else {
    header("Location: capo.php");
    exit;
}



?>