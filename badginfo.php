<?php
include('rest.php');
include('conectar.php');

$badgid = $_GET['i'];

// Fetch user information
$query_guy= "SELECT * FROM user WHERE nickname_user = ?";
$stmt_guy = $conexao->prepare($query_guy);
$stmt_guy->bind_param("s", $login_user);
$stmt_guy->execute();
$rs_guy   = $stmt_guy->get_result();
$infoguy  = $rs_guy->fetch_assoc();
$stmt_guy->close();

$id_useruma     = $infoguy['id_user'];
$foto_useruma   = $infoguy['photo_user'];

$query_badgi = "SELECT * FROM badges WHERE id_ba = ?";
$stmt_badgi = $conexao->prepare($query_badgi);
$stmt_badgi->bind_param("i", $badgid);
$stmt_badgi->execute();
$rs_badgi = $stmt_badgi->get_result();
$infobadg = $rs_badgi->fetch_assoc();
$stmt_badgi->close();
                        
$nome_badgi		= $infobadg['name_ba'];
$su_badgi		= $infobadg['nsup_ba'];
$in_badgi		= $infobadg['ninf_ba'];
$img_badgi		= $infobadg['img_ba'];
$valof_badgi	= $infobadg['valueof_ba'];
$text_badgi		= $infobadg['text_ba'];
$next_badgi		= $infobadg['next_ba'];

$query_badgim = "SELECT * FROM badge_won WHERE iduse_bw = ? AND idba_tot_bw = ? AND idba_bw = ?";
$stmt_badgim = $conexao->prepare($query_badgim);
$stmt_badgim->bind_param("iii", $id_useruma, $su_badgi, $in_badgi);
$stmt_badgim->execute();
$rs_badgim = $stmt_badgim->get_result();
$infobadgm = $rs_badgim->fetch_assoc();
$num_badgm = $rs_badgim->num_rows;
$stmt_badgim->close();

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
      <h4><i><font face="Georgia, Times New Roman, Times, serif">Conquista: <?=$nome_badgi?></font></i></h4>
      </td>
      <td>&nbsp;</td>
      </tr>
<tr>
<td>&nbsp;</td>
<td>
<table border="0" width="100%">
<tr>
<td width="310" align="center" rowspan="5" valign="top">
<img src="img/badges/<?=$img_badgi?>.png" title="<?=$nome_badgi?> - <?=$text_badgi?> - <?=$valof_badgi?> Pts" width="300" />
</td>
<td valign="top">
<h2><?=$nome_badgi?></h2>
</td>
</tr>
<tr>
<td valign="top">
<p>
<?=$text_badgi?>
</p>
</td>
</tr>
<tr>
<td valign="top">
<p>
Conquistopoints: <?=$valof_badgi?> Pts
</p>
</td>
</tr>
<tr>
<td valign="top">
<p><table border="0" width="100%">
<tr>
<?php
//CHECK IF HAS OR NOT

if($num_badgm == 0){
	echo '<td>Ainda não possuis esta conquista! :/</td>';
}else{
	echo '<td><img src="photos/user/'. $foto_useruma . '" alt="" style="width: 57px;
	height: 57px;
	border-radius: 90px;
	-webkit-border-radius: 100px;
	-moz-border-radius: 100px;
	background: url(photos/user/'. $foto_useruma . ');
	background-size:contain;
	box-shadow: 0 0 20px rgba(0, 0, 0, .20);
	-webkit-box-shadow: 0 0 20px rgba(0, 0, 0, .20);
	-moz-box-shadow: 0 0 20px rgba(0, 0, 0, .20);" /></td><td>Já tens esta conquista! Ganhaste-a em ' . $date_badgi . '</td>';
}
?>
</tr>
</table>
</p>
</td>
</tr>
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