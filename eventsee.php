<?php
include('rest.php');
include('conectar.php');

$id_event = $_GET['i'] ?? '';

// Check if event ID is empty
if(empty($id_event)) {
    header("Location: events.php");
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

// Fetch event information using mysqli
$query_event  = "SELECT * FROM events WHERE id_event = ?";
$stmt_event   = $conexao->prepare($query_event);
$stmt_event->bind_param("s", $id_event);
$stmt_event->execute();
$rs_event   = $stmt_event->get_result();
$eventinfo  = $rs_event->fetch_assoc();
$stmt_event->close();

$tit_event      = $eventinfo['tit_event'];
$desc_event     = $eventinfo['desc_event'];
$data_event     = new DateTime($eventinfo['data_event']);
$dia_event	    = $data_event->format('d');
$mes_event      = $data_event->format('m');
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
    <td bgcolor="#FFFFFF" style="box-shadow: 0px 5px 15px #000;" height="500" valign="top"><table width="100%" border="0">
      <tr>
        <td width="5%">&nbsp;</td>
        <td align="left"><h1><?=$tit_event?></h1>
        <?php
          if($id_user == $creat_event){
        ?>
        <a href="editevent.php?i=<?=$id_event?>">&laquo; Editar Evento &raquo;</a>
        <?php } ?></td>
        <td width="5%">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="left">
          <font size="+8"><?=$dia_event;?></font> <font size="+3">/</font>
          <font size="+2">
            <?php
              $mezu = $mes_event;
              include('meses.php');
            ?>
          </font>
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
              <font size="+1"><?=$desc_event?><br /><br /></font>
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
  <!--- PUBLICATION ------------->
  <form action="post_publication.php?a=pub" method="post" >
    <table bgcolor="#f5f5f5" width="100%" border="0">
      <tr>
        <td width="1%">&nbsp;</td>
        <td colspan="2">
          <b>Comenta:</b>
        </td>
      </tr>
      <tr>
        <td width="1%">&nbsp;</td>
        <td colspan="2">
          <textarea name="text_com" id="text_com" style="width: 100%; height:50px; margin: 0; padding: 0; border-width: 1; -webkit-border-radius: 5px;
          -moz-border-radius: 5px;
          border-radius: 10px; font-family:Verdana, Geneva, sans-serif;"></textarea>
        </td>
        <td width="3%">&nbsp;</td>
      </tr>
      <tr>
        <td width="1%">&nbsp;</td>
        <td width="85%"><input name="iu" type="hidden" id="iu" value="<?=$id_user?>">
          <input name="ie" type="hidden" id="ie" value="<?=$id_event?>">
          <input name="tip" type="hidden" id="tip" value="event" /></td>
        <td width="11%" align="right">
          <input name="Envoyer" type="submit" value="Comentar" align="right"  style="-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px; width:100px; height:40px;">
        </td>
        <td width="3%">&nbsp;</td>
      </tr>
    </table>
   </form>
   <!--- PUB ENDS ----------------->
   <!--- SHOW PUBLICATIONS -------->
   <table bgcolor="#e4e4e4" cellspacing="5" width="100%">
    <?php
      // Fetch comments for this event
      $q_list10 = "SELECT * FROM comment WHERE tip_com = 'event' AND idpag_com = ?";
      $stmt_list10 = $conexao->prepare($q_list10);
      $stmt_list10->bind_param("s", $id_event);
      $stmt_list10->execute();
      $rs_list10 = $stmt_list10->get_result();
      $nconfirmpub = $rs_list10->num_rows;
    
      if($nconfirmpub == 0){
      ?>
        <tr>
          <td colspan="4" align="center">
            Não há nenhum comentário neste evento!
          </td>
        </tr>
      <?php
    }else{
      while($list10 = $rs_list10->fetch_assoc()){                                   
        $id_com		  = $list10['id_com'];
        $idpag_com	= $list10['idpag_com'];
        $creat_com	= $list10['creat_com'];
        $text_com	  = $list10['text_com'];

        // Fetch comment creator information
        $q_list11 = "SELECT * FROM user WHERE id_user = ?";
        $stmt_list11 = $conexao->prepare($q_list11);
        $stmt_list11->bind_param("s", $creat_com);
        $stmt_list11->execute();
        $rs_list11 = $stmt_list11->get_result();
        $list11 = $rs_list11->fetch_assoc();
                                      
        $photo_pub		= $list11['photo_user'];
   ?>
        <tr>
          <td width="16%">
            <table border="0">
              <tr>
                <td>
                  <a href="perfil.php?p=<?=$creat_com?>"><img src="photos/user/<?=$photo_pub?>" alt="" style="width: 50px;
                    height: 50px;
                    border-radius: 40px;
                    -webkit-border-radius: 50px;
                    -moz-border-radius: 50px;
                    background: url(photos/user/<?=$photo_pub?>);
                    background-size:contain;
                    box-shadow: 0 0 8px rgba(0, 0, 0, .8);
                    -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);
                    -moz-box-shadow: 0 0 8px rgba(0, 0, 0, .8);"></a>
                </td>
                <td>
                  <font size="+6">:</font>
                </td>
              </tr>
            </table>
          </td>
          <td align="left" colspan="2">
            <?=$text_com?>
            <?php if($creat_com == $id_user){ ?>
            <table style="vertical-align:bottom" border="0">
              <tr>
                <td>(</td>
                <td>
                  <form  method="post" action="delet_pub.php?a=pub">
                    <input name="pi" type="hidden" id="pi" value="<?=$id_com?>">
                    <input name="ie" type="hidden" id="ie" value="<?=$id_event?>">
                    <input name="ui" type="hidden" id="ui" value="<?=$creat_com?>">
                    <input name="tip" type="hidden" id="tip" value="event" />
                    <input name="Envoyer" type="submit" value="X" align="right" width="50px" height="20px">
                  </form>
                </td>
                <td>)</td>
              </tr>
            </table>
            <?php
          }
          ?>
          </td>
        </tr>
        <?php
        // Now fetch comments for this publication
        $q_list12 = "SELECT * FROM comment WHERE idpag_com = ? AND tip_com = 'event_com'";
        $stmt_list12 = $conexao->prepare($q_list12);
        $stmt_list12->bind_param("s", $id_com);
        $stmt_list12->execute();
        $rs_list12 = $stmt_list12->get_result();
        $nconfirmcom = $rs_list12->num_rows;
        $stmt_list12->close();
        
        if($nconfirmcom != 0){
          while($list12 = $rs_list12->fetch_assoc()){
                                        
          $id_comm		= $list12['id_com'];
          $idpag_comm	= $list12['idpag_com'];
          $creat_comm	= $list12['creat_com'];
          $text_comm	= $list12['text_com'];

          // Fetch comment creator information
          $q_list13 = "SELECT * FROM user WHERE id_user = ?";
          $stmt_list13 = $conexao->prepare($q_list13);
          $stmt_list13->bind_param("s", $creat_comm);
          $stmt_list13->execute();
          $rs_list13 = $stmt_list13->get_result();
          $list13 = $rs_list13->fetch_assoc();
          $stmt_list13->close();
                                        
          $photo_com		= $list13['photo_user'];
        ?>
        <tr>
          <td>&nbsp;</td>
          <td width="16%">
            <table border="0">
              <tr>
                <td>
                  <a href="perfil.php?p=<?=$creat_comm?>"><img src="photos/user/<?=$photo_com?>" alt="" style="width: 50px;
                  height: 50px;
                  border-radius: 40px;
                  -webkit-border-radius: 50px;
                  -moz-border-radius: 50px;
                  background: url(photos/user/<?=$photo_com?>);
                  background-size:contain;
                  box-shadow: 0 0 8px rgba(0, 0, 0, .8);
                  -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);
                  -moz-box-shadow: 0 0 8px rgba(0, 0, 0, .8);"></a>
                </td>
                <td>
                  <font size="+6">:</font>
                </td>
              </tr>
            </table>
          </td>
          <td width="66%" align="left"><?=$text_comm?>
            <?php 
            // If the comment was made by the logged-in user, show delete option
            if($creat_comm == $id_user){
              ?>
                <table style="vertical-align:bottom" border="0">
                  <tr>
                    <td>(</td>
                    <td>
                      <form  method="post" action="delet_pub.php?a=comment">
                        <input name="ci" type="hidden" id="pi" value="<?=$id_comm?>">
                        <input name="ui" type="hidden" id="ui" value="<?=$creat_comm?>">
                        <input name="ie" type="hidden" id="ie" value="<?=$idpag_comm?>">
                        <input name="tip" type="hidden" id="ie" value="<?=$id_event?>">
                        <input name="tipu" type="hidden" id="tipu" value="post" />
                        <input name="Envoyer" type="submit" value="X" align="right" width="50px" height="20px">
                      </form>
                    </td>
                    <td>)</td>
                  </tr>
              </table>
            <?php
          }
          ?>
          </td>
        </tr>
      <?php
      } }
      ?>
     <tr>
   <td>&nbsp;</td>
   <td width="16%">
    <table border="0">
      <tr>
        <td>
          <a href="perfshow.php?id=<?=$id_user?>"><img src="photos/user/<?=$photo_user?>" alt="" style="width: 50px;
            height: 50px;
            border-radius: 40px;
            -webkit-border-radius: 50px;
            -moz-border-radius: 50px;
            background: url(photos/user/<?=$photo_user?>);
            background-size:contain;
            box-shadow: 0 0 8px rgba(0, 0, 0, .8);
            -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);
            -moz-box-shadow: 0 0 8px rgba(0, 0, 0, .8);">
          </a>
        </td>
        <td>
          <font size="+6">:</font>
        </td>
      </tr>
    </table>
  </td>
  <td width="66%" align="left">
    <form action="post_publication.php?a=comment"  method="post">
      <table width="90%" align="left" border="0">
        <tr>
          <td colspan="2">
            <textarea name="text_com" id="text_com" style="width: 80%; height:50px; margin: 0; padding: 0; border-width: 1; -webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 10px; font-family:Verdana, Geneva, sans-serif;"></textarea>
          </td>
        </tr>
        <tr>
          <td width="52">
            <input name="ie" type="hidden" id="ie" value="event_com">
            <input type="hidden" value="<?=$id_com?>" name="ip" id="ip">
            <input type="hidden" value="<?=$id_event?>" name="im" id="im">
            <input type="hidden" value="<?=$id_user?>" name="iu" id="iu">
            <input name="Envoyer" type="submit" value="Comentar" align="right" width="50px" height="20px">
          </td>
        </tr>
      </table>
    </form>
    </td>
   </tr>
     <?php } }
   ?>
   </table>
   <!--- PUBLICATIONS END --------->
    </td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>