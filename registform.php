<?php
include('conectar.php');

$nome 		= $_POST['nome'];
$sobnome 	= $_POST['sobrenome'];
$nickname	= $_POST['username'];
$bday       = $_POST['aniversario'];
$mat 		= (int)$_POST['mat'];
$pass       = password_hash($_POST['pass'], PASSWORD_DEFAULT);
$desc 		= $_POST['desc'];
$turno 		= $_POST['turno'];
$email 		= $_POST['email'];
$sexo 		= $_POST['sexo'];

$query_mat= "SELECT * FROM matricula WHERE num_mat = ?";
$stmt_mat = $conexao->prepare($query_mat);
$stmt_mat->bind_param("i", $mat);
$stmt_mat->execute();
$res_mat  = $stmt_mat->get_result();
$infomat  = $res_mat->fetch_array();
$nmat     = $res_mat->num_rows;

$erro     = ''; // EMPTY AS DEFAULT

// IF FOR MAT EXIST OR NOT
if($nmat == '0'){
		$erro = 'A matrícula digitada não está cadastrada!';
    exit;
}

$query_mat2 = "SELECT * FROM matricula WHERE num_mat = ? AND use_mat = '1'";
$stmt_mat2  = $conexao->prepare($query_mat2);
$stmt_mat2->bind_param("i", $mat);
$stmt_mat2->execute();
$res_mat2   = $stmt_mat2->get_result();
$nmat2      = $res_mat2->num_rows;

// IF FOR MAT USED OR NOT
if($nmat2 == '1'){
		$erro = 'A matrícula digitada já está sendo usada por outro estudante!';
    exit;
}

$query_user = "SELECT * FROM user WHERE nickname_user = ?";
$stmt_user  = $conexao->prepare($query_user);
$stmt_user->bind_param("s", $nickname);
$stmt_user->execute();
$res_user   = $stmt_user->get_result();
$nuser      = $res_user->num_rows;

// IF FOR USER EXIST OR NOT
if($nuser == '1'){
		$erro = 'Este nome de usuário já está sendo usado!';
    exit;
}
	
//CADASTRO ENFIM	
	
//PHOTO PART
function findexts ($filename){ 
  $filename = strtolower($filename); 
  $exts     = preg_split("#[/\\.]#", $filename);
  $n        = count($exts)-1; 
  $exts     = $exts[$n]; 
  return $exts; 
}
 
$ext  = findexts($_FILES['photo']['name']); 
$ran  = rand();
$ran2 = $ran.".";
$target = "photos/user/";
$target = $target . $ran2.$ext; 
$ranno	= $ran2.$ext;

if(move_uploaded_file($_FILES['photo']['tmp_name'], $target)){
  $photo_fim = $ranno;
}
//PHOTO PART ENDS

//INSERTS USER
$query_insert = "INSERT INTO user(id_user,nome_user,sobrenome_user,nickname_user,bday_user,turno_user,mail_user,sexo_user,pass_user,desc_user,matricula_user,photo_user) VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt_insert  = $conexao->prepare($query_insert);
$stmt_insert->bind_param(
  "sssssssssis",
  $nome,
  $sobnome,
  $nickname,
  $bday,
  $turno,
  $email,
  $sexo,
  $pass,
  $desc,
  $mat,
  $photo_fim
);
$stmt_insert->execute();

//UPDATE MAT TO NOT BE USED AGAIN
$query_update = "UPDATE matricula SET use_mat='1' WHERE num_mat = ?";
$stmt_update  = $conexao->prepare($query_update);
$stmt_update->bind_param("i", $mat);
$stmt_update->execute();

if(!empty($erro)){
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
    <td bgcolor="#c12a19" align="center" style="box-shadow: 0px 5px 15px #000;" height="50"><b>Para ter acesso à máfia, conecta-te ou registra-te!</b></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td bgcolor="#FFFFFF" style="box-shadow: 0px 5px 15px #000;" height="500"><table width="100%" border="0">
      <tr>
        <td>&nbsp;</td>
        <td align="center"><h2>Erro!</h2></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="center"><p><?=$erro;?></p>
          <a href="javascript:history.go(-1)">Clica aqui para voltar</a>
        </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    </td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php }else{ ?>
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
" height="50"><b>Para ter acesso à máfia, conecta-te ou registra-te!</b></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td bgcolor="#FFFFFF" style="box-shadow: 0px 5px 15px #000;
" height="500"><table width="100%" border="0">
      <tr>
        <td>&nbsp;</td>
        <td align="center"><h2>Tua conta foi criada!!</h2></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="center">
          <a href="index.php">Clica aqui para acessá-la!</a>
        </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    </td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php } ?>