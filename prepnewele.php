<?php
include('rest.php');
include('conectar.php');

// This file should be run once a month to prepare for a new election
// It resets the election data for the new month

// Prepare and execute SELECT
$stmt = $conexao->prepare("SELECT mes_ele, dia_ele FROM eleicao WHERE id_ele = ?");
$id_ele = 1;
$stmt->bind_param("i", $id_ele);
$stmt->execute();
$stmt->bind_result($mes_ele, $dia_ele);
$stmt->fetch();
$stmt->close();

$pos_ele = mktime(0, 0, 0, $mes_ele + 1, $dia_ele);
$new_mes_ele = date("m", $pos_ele);

// DELETE FROM capone_reg
$stmt1 = $conexao->prepare("DELETE FROM capone_reg");
$stmt1->execute();
$stmt1->close();

// DELETE FROM votos
$stmt2 = $conexao->prepare("DELETE FROM votos");
$stmt2->execute();
$stmt2->close();

// UPDATE eleicao SET mes_ele = ?
$stmt3 = $conexao->prepare("UPDATE eleicao SET mes_ele = ? WHERE id_ele = ?");
$stmt3->bind_param("ii", $new_mes_ele, $id_ele);
$stmt3->execute();
$stmt3->close();
?>