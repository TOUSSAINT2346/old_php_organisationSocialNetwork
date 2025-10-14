<?php
include('rest.php');
include('conectar.php');

$id_guy = $_GET['p'] ?? '';

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

// ALL BADGES
$query_conqs = "SELECT * FROM badges";
$stmt_conqs = $conexao->prepare($query_conqs);
$stmt_conqs->execute();
$rs_conqas = $stmt_conqs->get_result();
$stmt_conqs->close();
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
      <h1><i><font face="Georgia, Times New Roman, Times, serif">Todas as conquistas</font></i></h1>
      </td>
      <td>&nbsp;</td>
      </tr>
<tr>
  <td>&nbsp;</td>
  <td><p>Abaixo todos as conquistas que existem no site atualmente:</p></td>
  <td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>
<table align="center" border="0" width="100%">
<?php
$i = 0;
while($conqvalinfoa = $rs_conqas->fetch_assoc()){
    if($i == 0){
        echo"<TR>";
    }
	
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