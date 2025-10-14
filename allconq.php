<?php
include('rest.php');
include('conectar.php');

$id_guy = $_GET['p'];

// Fetch user information
$query_guy= "SELECT * FROM user WHERE nickname_user = ?";
$stmt_guy = $conexao->prepare($query_guy);
$stmt_guy->bind_param("s", $login_user);
$stmt_guy->execute();
$rs_guy   = $stmt_guy->get_result();
$infoguy  = $rs_guy->fetch_assoc();
$stmt_guy->close();

$id_useruma     = $infoguy['id_user'];

if($id_guy == ''){
	$id_perfillo = $id_useruma;
}else{
	$id_perfillo = $id_guy;
}

// CONQUESTS?
$query_conqs = "SELECT * FROM badge_won WHERE iduse_bw = '$id_perfillo'";
$stmt_conqs = $conexao->prepare($query_conqs);
$stmt_conqs->execute();
$rs_conqs = $stmt_conqs->get_result();
$stmt_conqs->close();

// CONQUESTS?
$query_conqas = "SELECT * FROM badge_won WHERE iduse_bw = ? ORDER BY id_bw DESC";
$stmt_conqas = $conexao->prepare($query_conqas);
$stmt_conqas->bind_param("s", $id_perfillo);
$stmt_conqas->execute();
$rs_conqas = $stmt_conqas->get_result();
$stmt_conqas->close();

// WHO'S THIS USER?
$query_userum = "SELECT * FROM user WHERE id_user = ?";
$stmt_userum = $conexao->prepare($query_userum);
$stmt_userum->bind_param("s", $id_perfillo);
$stmt_userum->execute();
$rs_userum = $stmt_userum->get_result();
$useruminfus = $rs_userum->fetch_assoc();
$stmt_userum->close();

$nome_userum = $useruminfus['nome_user'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mi mafia, Tu mafia</title>
<link rel="stylesheet" href="css/geral.css" type="text/css" />
</head>
<body leftmargin="0" topmargin="0" background="img/back2.png">
<table cellpadding="0" cellspacing="0" width="100%" border="0">
  <tr>
    <td width="10%">&nbsp;</td>
    <td align="center" valign="bottom"><p><img src="img/tit.png"></p></td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td bgcolor="#c12a19" align="center" style="box-shadow: 0px 5px 15px #000;
" height="50"><?php include ('menu.php');?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td bgcolor="#FFFFFF" style="box-shadow: 0px 5px 15px #000;
" height="500" valign="top">
<!---- TABELA NOTICIAS --------------->
<table width="100%" border="0">
      <tr>
      <td>&nbsp;</td>
      <td align="left" valign="top">
      <h1><i><font face="Georgia, Times New Roman, Times, serif">Conquistas de <?=$nome_userum;?></font></i></h1>
      </td>
      <td>&nbsp;</td>
      </tr>
<tr>
<td>&nbsp;</td>
<?php
$valtot = 0;
while($conqsinfo = $rs_conqs->fetch_assoc()){
	$sup = $conqsinfo['idba_tot_bw'];
	$inf = $conqsinfo['idba_bw'];
	
$conqval_query = "SELECT * FROM badges WHERE nsup_ba = '$sup' AND ninf_ba = '$inf'";
$conqval_rs    = mysql_query($conqval_query);
$conqvalinfo = mysql_fetch_array($conqval_rs);

$valtot += $conqvalinfo['value_ba'];
}
?>
<td>Conquistopoints de <?=$nome_userum?>: <b><?=$valtot;?> pts</b></td>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td><p>Abaixo todos as conquistas ganhas por <?=$nome_userum?> (as mais novas vêm primeiro):<a href="allconqa.php"><br />
  <small>Clica aqui para ver todas as conquistas que existem atualmente</small></a></p>
  </td>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>
<table align="center" border="0" width="100%">
<?php
$num_badges  = $rs_conqas->num_rows;

if($num_badges == 0){
	?>
    <tr>
    <td align="center">
    <h2><?=$nome_userum?> não possui nenhuma conquista ainda :|</h2>
    </td>
    </tr>
    <?php
}else{
$i = 0;
while($infos = mysql_fetch_array($rs_conqas)){
    if($i == 0){
        echo"<TR>";
    }
	$supa = $infos['idba_tot_bw'];
	$infa = $infos['idba_bw'];


	$conqval_querya = "SELECT * FROM badges WHERE nsup_ba = ? AND ninf_ba = ?";
	$stmt_conqval_a = $conexao->prepare($conqval_querya);
    $stmt_conqval_a->bind_param("ii", $supa, $infa);
    $stmt_conqval_a->execute();
    $rs_conqval_a = $stmt_conqval_a->get_result();
    $stmt_conqval_a->close();
    ?>
    <td width="33%">
    <table border="0" align="center" width="100%">
    <tr>
    <td align="center">
    <a href="badginfo.php?i=<?=$conqvalinfoa['id_ba']?>"><img src="img/badges/<?=$conqvalinfoa['img_ba']?>.png" width="115" /></a>
    </td>
    </tr>
    <tr>
    <td align="center">
    <b><a href="badginfo.php?i=<?=$conqvalinfoa['id_ba']?>"><?=$conqvalinfoa['name_ba']?></a></b>
    </td>
    </tr>
    <tr>
    <td align="center">
    <font title="Conquistado em <?=$dates = $infos['date_bw'];?>"><?=$dates = $infos['date_bw'];?></font>
    </td>
    </tr>
    </table>
    </td>
    <?php
    $i++;
    if($i == 3)
    {
        $i = 0;
        echo"</tr>";
    }
}
if($i ==1){
    echo "<td></td><td></td></tr>";
}
if($i ==2)
{
    echo "<td></td></tr>";
}
}
?>
</table>
</td>
<td>&nbsp;</td>
</tr>
      </table>
      </td>
      <td>&nbsp;</td>
      </tr>
    </table>
<!---- FIM TABELA NOTICIAS --------------->
    </td>
    <td>&nbsp;</td>
  </tr>

</table>

</body>
</html>