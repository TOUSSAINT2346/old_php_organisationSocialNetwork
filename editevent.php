<?php
include('rest.php');
include('conectar.php');

$id_event = $_GET['i'] ?? '';

if(empty($id_event)){
    header('Location: events.php');
    exit;
}

// Fetch user information
$query_guy= "SELECT * FROM user WHERE nickname_user = ?";
$stmt_guy = $conexao->prepare($query_guy);
$stmt_guy->bind_param("s", $login_user);
$stmt_guy->execute();
$rs_guy   = $stmt_guy->get_result();
$infoguy  = $rs_guy->fetch_assoc();
$stmt_guy->close();
                        
$id_user	= $infoguy['id_user'];
$photo_user	= $infoguy['photo_user'];

// Fetch event information
$query_event    = "SELECT * FROM events WHERE id_event = ?";
$stmt_event     = $conexao->prepare($query_event);
$stmt_event->bind_param("s", $id_event);
$stmt_event->execute();
$rs_event   = $stmt_event->get_result();
$eventinfo  = $rs_event->fetch_assoc();
$stmt_event->close();

$tit_event      = $eventinfo['tit_event'];
$desc_event     = $eventinfo['desc_event'];
$data_event     = $eventinfo['data_event'];
$creat_event    = $eventinfo['creat_event'];

// Fetch creator information
$query_creat = "SELECT * FROM user WHERE id_user = ?";
$stmt_creat = $conexao->prepare($query_creat);
$stmt_creat->bind_param("s", $creat_event);
$stmt_creat->execute();
$rs_creat = $stmt_creat->get_result();
$creatinfus = $rs_creat->fetch_assoc();
$stmt_creat->close();

$nome_creat     = $creatinfus['nome_user'];
$sobnome_creat  = $creatinfus['sobrenome_user'];
$photo_creat    = $creatinfus['photo_user'];
 
if($id_user != $creat_event){
	header("Location: eventsee.php?i=$id_event");
    exit;
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
    <td bgcolor="#c12a19" align="center" style="box-shadow: 0px 5px 15px #000;" height="50"><?php include ('menu.php');?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td bgcolor="#FFFFFF" style="box-shadow: 0px 5px 15px #000;" height="500" valign="top">
<form action="eventform.php?a=edit" method="post">
    <table width="100%" border="0">
        <tr>
            <td width="5%">&nbsp;</td>
            <td align="left"><input name="tit_event" value="<?=$tit_event?>" style="font-size:30px" placeholder="Titulo" />
            <input type="hidden" value="<?=$id_event?>" name="id" id="id" />
            <input type="hidden" value="<?=$id_user?>" name="iu" id="iu" /></td>
            <td width="5%">&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td align="left">
                <input name="data_event" style="font-size:25px" type="date" value="<?=$data_event;?>" placeholder="Data" />
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
                            <textarea name="desc_event" style="font-size:20px; width: 100%; height:50px; margin: 0; padding: 0; border-width: 1; font-family:Verdana, Geneva, sans-serif;"><?=$desc_event?></textarea><br /><br />
                        </td>
                    </tr>
                    <tr>
                        <td width="5%" valign="top">
                        <font size="+2">Criado por:</font>
                        </td>
                        <td width="95%" align="left">
                            <table width="100%">
                                <tr>
                                    <td width="15%">
                                        <img src="photos/user/<?=$photo_creat;?>" style="width: 60px;
                                        height: 60px;
                                        border-radius: 40px;
                                        -webkit-border-radius: 50px;
                                        -moz-border-radius: 50px;
                                        background: url(photos/user/<?=$photo_creat?>);
                                        background-size:contain;
                                        box-shadow: 0 0 8px rgba(0, 0, 0, .8);
                                        -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);
                                        -moz-box-shadow: 0 0 8px rgba(0, 0, 0, .8);">
                                    </td>
                                    <td width="85%">
                                        <font size="+2"><?=$nome_creat?> <?=$sobnome_creat?></font>
                                    </td>
                                </tr>
                            </table>
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
                <h2><input type="submit" style="font-family:Verdana, Geneva, sans-serif; width:50px; height:30px;" value="Editar"> | <a href="eventsee.php?i=<?=$id_event?>">Voltar</a></h2>
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