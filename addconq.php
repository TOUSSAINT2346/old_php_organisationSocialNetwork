<?php
include('rest.php');
include('conectar.php');

// Fetch user information
$query_guy= "SELECT * FROM user WHERE nickname_user = ?";
$stmt_guy = $conexao->prepare($query_guy);
$stmt_guy->bind_param("s", $login_user);
$stmt_guy->execute();
$rs_guy   = $stmt_guy->get_result();
$infoguy  = $rs_guy->fetch_assoc();
$stmt_guy->close();

$id_useruma     = $infoguy['id_user'];

// Only admin
// This part hadn't been integrated in the full system at the time of building of the system, so it stays like this for now
if($id_useruma != 2){
    header("Location: perfil.php");
    exit;
}
	
//CHECK POST
if(isset($_POST['nome'])){
	
	$sup = $_POST['sup'];
	$inf = $_POST['inf'];
	$nom = $_POST['nome'];
	$img = $_POST['img'];
	$val = $_POST['value'];
	$vao = $_POST['valueof'];
	$txt = $_POST['text'];
	$nxt = $_POST['next'];
	
	
$veio = array('"', "'");
$vai  = array("&quot;", "&quot;");

$text = str_replace($veio, $vai, $txt);
	
$query_addconq = "INSERT INTO badges (nsup_ba, ninf_ba, name_ba, img_ba, valueof_ba, value_ba, text_ba, next_ba) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt_addconq = $conexao->prepare($query_addconq);
$stmt_addconq->bind_param("ssssssss", $sup, $inf, $nom, $img, $vao, $val, $text, $nxt);
$stmt_addconq->execute();
$text_ok = 'Conquista adicionada com sucesso!';
$stmt_addconq->close();
}
	
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
      <h1><i><font face="Georgia, Times New Roman, Times, serif">Cadastrar nova conquista</font></i></h1>
      </td>
      <td>&nbsp;</td>
      </tr>
<tr>
<td>&nbsp;</td>
<td>
<form method="post" action="addconq.php">
<table border="0" width="100%">
<?php if(isset($text_ok)){ ?>
<tr>
<td colspan="2" align="center">
<h2><?=$text_ok;?></h2><img src="img/badges/<?=$img;?>.png" alt="" width="57" title="<?=$nom?> - <?=$text?> - <?=$vao?> Pts"/></td>
</tr>
<?php } ?>
<tr>
<td>Grupo:</td>
<td><input name="sup" style="width:100%;" type="text" id="sup" /></td>
</tr>
<tr>
<td>Nível:</td>
<td><input name="inf" style="width:100%;" type="text" id="inf" /></td>
</tr>
<tr>
<td>Nome:</td>
<td><input name="nome" style="width:100%;" type="text" id="nome" /></td>
</tr>
<tr>
<td>Imagem:</td>
<td><input name="img" style="width:100%;" type="text" id="img" /></td>
</tr>
<tr>
<td>Valor Oficial:</td>
<td><input name="valueof" style="width:100%;" type="text" id="valueof" /></td>
</tr>
<tr>
<td>Valor quantitativo <small>(seguindo a lógica valor de um é ele mais o dos anteriores)</small>:</td>
<td><input name="value" style="width:100%;" type="text" id="value" /></td>
</tr>
<tr>
<td>Texto:</td>
<td><textarea name="text" cols="40" rows="5" id="text"></textarea></td>
</tr>
<tr>
<td>Como conseguir o próximo nível:</td>
<td><textarea name="next" cols="40" rows="5" id="next"></textarea></td>
</tr>
<tr>
<td colspan="2" align="center"><input name="Envoyer" type="submit" value="Adicionar" /></td>
</tr>
</table>
</form>
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