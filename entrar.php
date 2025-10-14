<?php
include("conectar.php");

$usera = $_POST['user'];
$pass_input = $_POST['pass'];

$sql_logar  = "SELECT * FROM user WHERE nickname_user = ?";
$stmt_logar = $conexao->prepare($sql_logar);
$stmt_logar->bind_param("s", $usera);
$stmt_logar->execute();
$exe_logar  = $stmt_logar->get_result();
$fet_logar  = $exe_logar->fetch_assoc();
$num_logar  = $exe_logar->num_rows;
$stmt_logar->close();

if($num_logar == 0 || !password_verify($pass_input, $fet_logar['pass_user'])){
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
    <td bgcolor="#c12a19" align="center" style="box-shadow: 0px 5px 15px #000;" height="50">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td bgcolor="#FFFFFF" style="box-shadow: 0px 5px 15px #000;" height="500">
      <table align="center" background="Imagens/backpayed.png" width="681 " height="452" border="0">
        <tr>
          <td height="111" align="center"><h1 class="texto1"><strong><font face="Verdana, Geneva, sans-serif">Ocorreu um erro :(</font></strong></h1></td>
        </tr>
        <tr>
          <td height="205" align="center">Parece que ou o teu usuário ou tua senha está(ão) errado(s)</td>
        </tr>
        <tr>
          <td class="texto1" align="center"><a href="index.php">Clica aqui para voltar</a></td>
        </tr>
      </table>
    </td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
}else{

/// Notify about an election day
$hj = new DateTime();

$query_datel  = "SELECT * FROM eleicao LIMIT 1";
$stmt_datele  = $conexao->prepare($query_datel);
$stmt_datele->execute();
$rs_datele    = $stmt_datele->get_result();
$dateleinf    = $rs_datele->fetch_assoc();
$stmt_datele->close();

$dia_ele      = $dateleinf['dia_ele'];
$mes_ele      = $dateleinf['mes_ele'];

$ele = $dia_ele . '/' . $mes_ele;

// IF TODAY IS ELECTION DAY
if($hj->format('d/m') == $ele){

  $query_user = "SELECT * FROM user WHERE nickname_user = ?";
  $stmt_user  = $conexao->prepare($query_user);
  $stmt_user->bind_param("s", $usera);
  $stmt_user->execute();
  $rs_user    = $stmt_user->get_result();
  $userinfo   = $rs_user->fetch_assoc();
  $stmt_user->close();

  // Verify password before proceeding
  if (!$userinfo || !password_verify($pass_input, $userinfo['pass_user'])) {
    // Handle invalid login (optional: redirect or show error)
    header("Location: index.php");
    exit;
  }

  $id_user    = $userinfo['id_user'];

  $hoj = new DateTime();

  /// DOES A NOTIF ALREADY EXIST?
  $query_notifs = "SELECT * FROM notifs WHERE link_not = ? AND date_not = ? AND iduse_not = ?";
  $stmt_notifs  = $conexao->prepare($query_notifs);
  $link_not     = 'capo.php';
  $date_not     = $hoj->format('Y-m-d');
  $stmt_notifs->bind_param("ssi", $link_not, $date_not, $id_user);
  $stmt_notifs->execute();
  $rs_notifs    = $stmt_notifs->get_result();
  $notifsnum    = $rs_notifs->num_rows;
  $stmt_notifs->close();

  // IF NOT, INSERT
  if($notifsnum == 0){

    $hor = $hoj->format('H:i:s');
    $txt = "Dia de Eleição! Já votaste?<br>Se não, clica aqui e vota!"; // Message

    $query_insert_notif = "INSERT INTO notifs (iduse_not, msg_not, link_not, date_not, hor_not, sit_not) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_insert_notif = $conexao->prepare($query_insert_notif);
    $sit_not = 0;
    $stmt_insert_notif->bind_param(
      "issssi", 
      $id_user,    // User ID
      $txt,        // Notification message
      $link_not,   // Link for notification
      $date_not,   // Notification date
      $hor,        // Notification time
      $sit_not     // Notification status
    );
    $stmt_insert_notif->execute();
    $stmt_insert_notif->close();
  }
}
/// End of election day notify

session_start();
$_SESSION['usera']    = $usera;
   
header("Location: pri.php");
}
?>