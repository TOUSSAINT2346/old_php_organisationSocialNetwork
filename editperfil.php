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
                        
$id_user	= $infoguy['id_user'];

$id_perfil = $_GET['p'] ?? '';

if($id_perfil == ''){
	$id_perfilo = $id_user;
}else{
	$id_perfilo = $id_perfil;
}

// Fetch profile information
$query_perf = "SELECT * FROM user WHERE id_user = ?";
$stmt_perf  = $conexao->prepare($query_perf);
$stmt_perf->bind_param("i", $id_perfilo);
$stmt_perf->execute();
$rs_perf    = $stmt_perf->get_result();
$infoperf   = $rs_perf->fetch_assoc();
$stmt_perf->close();
                        
$nome_perf		= $infoperf['nome_user'];
$sobnome_perf	= $infoperf['sobrenome_user'];
$bday_perf		= new DateTime($infoperf['bday_user']);
$desc_perf		= $infoperf['desc_user'];
$photo_perf		= $infoperf['photo_user'];
$turno_perf		= $infoperf['turno_user'];

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
<?php
if(!isset($_GET['t'])){
    $t = '';
}else{
    $t = $_GET['t'];
}

if(!isset($_GET['i'])){
    $i = '';
}else{
    $i = $_GET['i'];
}

switch($t){
	default:
?>
<!---- TABELA NOTICIAS --------------->
<table width="100%" border="0">
      
      <tr>
      <td>&nbsp;</td>
      <td align="center" valign="top">
      <form action="perfform.php?a=edit" method="post">
      <table border="0" width="100%">
      <?php
      if($i == 'erro'){
	  ?><tr>
      <td colspan="2" align="center"><h3>Alguma parte do formulário não foi preenchida! Tente novamente!</h3></td>
      </tr>
      <?php } ?>
      <tr>
      <td align="center" width="34%" rowspan="3"><img src="photos/user/<?=$photo_perf;?>" alt="" style="width: 200px;
	height: 200px;
	border-radius: 90px;
	-webkit-border-radius: 100px;
	-moz-border-radius: 100px;
	background: url(photos/user/<?=$photo_perf?>);
	background-size:contain;
	box-shadow: 0 0 20px rgba(0, 0, 0, .20);
	-webkit-box-shadow: 0 0 20px rgba(0, 0, 0, .20);
	-moz-box-shadow: 0 0 20px rgba(0, 0, 0, .20);" /><br />
    <hr width="50%" size="1" />
    <a href="editperfil.php?t=photo">Para modificar tua foto, clica aqui!</a><br />
<hr width="50%" size="1" />
<a href="editperfil.php?t=senha">Para modificar tua senha, clica aqui!</a><hr width="50%" size="1" /></td>
      <td width="66%">
      <h1><?=$nome_perf?> <?=$sobnome_perf?></h1></td>
      </tr>
      <tr>
      <td>
      <table border="0" width="100%">
      <tr>
      <td>
      <h2>
        <input type="date" name="bday_new" id="bday_new" style="font-size:30px" value="<?=$bday_perf->format('Y-m-d');?>" />
      </h2></td>
      <td align="center">
        <label for="turno_new"></label>
        <select name="turno_new" style="font-size:30px" id="turno_new">
          <option selected="selected" value="<?=$turno_perf?>"><?php
          if($turno_perf == 'm'){
			  echo 'Manhã';
		  }else{
			   echo 'Noite';
		  }
		  ?></option>
          <option disabled="disabled">Turno</option>
          <option value="m">Manhã</option>
          <option value="n">Noite</option>
        </select></td>
        </tr>
        </table>
      </td>
      </tr>
      <tr>
      <td>
	  <textarea name="desc_new" id="desc_new" style="width:100%; font-family:Verdana, Geneva, sans-serif; font-size:20px;" placeholder="Descrição"><?=$desc_perf?></textarea></td>
      </tr>
      <tr>
      <td align="center" colspan="2">
      <input name="Envoyer" type="submit" style="font-size:30px;" value="Salvar" />
      </td>
      </tr>
      </table>
      </form>
      </td>
      <td>&nbsp;</td>
      </tr>
     
<tr>
      <td>&nbsp;</td>
      <td align="left" valign="top">
      <h2>&nbsp;</h2>
      </td>
      <td>&nbsp;</td>
      </tr>
      </table>
      </td>
      <td>&nbsp;</td>
  </tr>
    </table>
<!---- FIM TABELA NOTICIAS --------------->
<?php break;
case 'senha':
?>
<!---- TABELA NOTICIAS --------------->
<table width="100%" border="0">
      
      <tr>
      <td>&nbsp;</td>
      <td align="center" valign="top">
      <form action="perfform.php?a=pass" method="post">
      <table border="0" width="100%">
      <tr>
      <td align="center" colspan="2">
      <h2>Modificar senha</h2></td>
      </tr>
      <?php if ($i == 'erro'){?>
      <tr>
      <td align="center" colspan="2">
      <h3>A senha atual que digitaste não está correcta, digita de novo!</h3>
      </td>
      </tr>
      <?php } ?>
      <tr>
      <td width="30%">Senha atual:
      
      </td>
      <td width="70%"><input name="pass_old" type="password" id="pass_old" style="font-size:30px" /></td>
      </tr>
      <tr>
      <td>Nova senha:</td>
      <td><input name="pass_new" type="password" id="pass_new" style="font-size:30px" /></td>
      </tr>
      <tr>
      <td align="center" colspan="2">
      <input name="Envoyer" type="submit" style="font-size:30px;" value="Modificar" />
      </td>
      </tr>
      </table>
      </form>
      </td>
      <td>&nbsp;</td>
      </tr>
     
<tr>
      <td>&nbsp;</td>
      <td align="left" valign="top">
      <h2>&nbsp;</h2>
      </td>
      <td>&nbsp;</td>
      </tr>
      </table>
      </td>
      <td>&nbsp;</td>
  </tr>
    </table>
<!---- FIM TABELA NOTICIAS --------------->
<?php
break;

case 'photo':
?>
<!---- TABELA NOTICIAS --------------->
<table width="100%" border="0">
      
      <tr>
      <td>&nbsp;</td>
      <td align="center" valign="top">
      <form action="perfform.php?a=photo" method="post" enctype="multipart/form-data">
      <table border="0" width="100%">
      <tr>
      <td align="center" colspan="2">
      <h2>Modificar foto</h2></td>
      </tr>
      <tr>
      <td width="30%">Selecione uma foto:</td>
      <td width="70%"><input name="photo_new" type="file"  id="photo_new" style="font-size:30px" /></td>
      </tr>
      <tr>
        <td align="center" colspan="2">
         <input name="photo_old" type="hidden" id="photo_old" value="<?=$photo_perf?>">
          <input name="Envoyer" type="submit" style="font-size:30px;" value="Modificar" />
          </td>
      </tr>
      </table>
      </form>
      </td>
      <td>&nbsp;</td>
      </tr>
     
<tr>
      <td>&nbsp;</td>
      <td align="left" valign="top">
      <h2>&nbsp;</h2>
      </td>
      <td>&nbsp;</td>
      </tr>
      </table>
      </td>
      <td>&nbsp;</td>
  </tr>
    </table>
<!---- FIM TABELA NOTICIAS --------------->
<?php
break;
}
?>
    </td>
    <td>&nbsp;</td>
  </tr>

</table>

</body>
</html>