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
                        
$id_user	  = $infoguy['id_user'];
$photo_user	= $infoguy['photo_user'];

 
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
    <td bgcolor="#c12a19" align="center" style="box-shadow: 0px 5px 15px #000;" height="50"><?php include ('menu.php');?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td bgcolor="#FFFFFF" style="box-shadow: 0px 5px 15px #000;" height="500" valign="top">
      <form action="eventform.php?a=new" method="post">
        <table width="100%" border="0">
          <tr>
            <td width="5%">&nbsp;</td>
            <td align="left">
              <input name="tit_event" style="font-size:30px" placeholder="Título" />
              <input type="hidden" value="<?=$id_user?>" name="iu" id="iu" />
            </td>
            <td width="5%">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left">
              <input type="date" name="data_event" style="font-size:30px" />
              <br /><br />
            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>
              <table width="100%">
                <tr>
                  <td width="5%" valign="top">
                    <font size="+2">Descrição:</font>
                  </td>
                  <td width="95%" align="left">
                    <textarea name="desc_event" style="font-size:20px; width: 100%; height:50px; margin: 0; padding: 0; border-width: 1; font-family:Verdana, Geneva, sans-serif;" placeholder="Informações, horários, local, etc."></textarea><br /><br />
                  </td>
                </tr>
              </table>
            </td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <br /><br />
        <table width="100%" border="0">
          <tr>
            <td align="center">
              <h2>
                <input type="submit" style="font-family:Verdana, Geneva, sans-serif; width:50px; height:30px;" value="Criar"> | <a href="events.php">Voltar</a>
              </h2>
            </td>
          </tr>
        </table>
      </form>
    </td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>