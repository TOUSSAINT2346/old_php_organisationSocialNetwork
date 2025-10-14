<?php
include('rest.php');
include('conectar.php');

$hoje  = new DateTime();
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
" height="500" valign="top"><table width="100%" border="0">
      <tr>
        <td width="5%">&nbsp;</td>
        <td align="center"><h1>Eventos</h1><br />
<a href="addevent.php">&laquo; Adicionar Evento &raquo;</a></td>
        <td width="5%">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="center">
        <!---- TABELA EVENTOS ----->
        <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
        <td width="33%" align="center">
        <p><b>Eventos Hoje<br />(<?php echo $hoje->format('d/m');?>)
</b></p>
        </td>
        <td width="33%" align="center">
        <p><b>Eventos ainda este mês<br />(<?php $mezu = $hoje->format('m'); include ('meses.php');?>)</b></p>
        </td>
        <td width="33%" align="center">
        <p><b>Eventos no resto do ano<br />(<?php echo $hoje->format('Y');?>)</b></p>
        </td>
        </tr>
        <tr>
        <!--- EVENTS TODAY --->
        <td align="center">
        <?php
          $diahj = $hoje->format('d');
          $meshj = $hoje->format('m');

          // Query to fetch today's events
          $query_eventh = "SELECT * FROM events WHERE data_event = CURDATE() ORDER BY data_event ASC";
          $stmt_eventh = $conexao->prepare($query_eventh);
          $stmt_eventh->execute();
          $rs_eventh = $stmt_eventh->get_result();

          $neventh = $rs_eventh->num_rows;

          // If no events today
          if($neventh == 0){
	      ?>
          <br />
          <b>Não há nenhum evento planejado para hoje</b>
      <?php
          }else{
		  ?>
        <table width="100%" border="0" cellpadding="1" cellspacing="1">
        <?php
          while($eventinfoh = $rs_eventh->fetch_assoc()){	
            $id_eventh  = $eventinfoh['id_event'];
            $data_eventh= new DateTime($eventinfoh['data_event']);

            $dia_eventh = $data_eventh->format('d');
            $mes_eventh = $data_eventh->format('m');
            $tit_eventh = $eventinfoh['tit_event'];
        ?>
          <tr>
            <td bgcolor="#32b2cd" width="23%">
              <table border="0" align="center" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="center">
                    <font size="+2"><?=$dia_eventh;?></font>
                  </td>
                </tr>
                <tr>
                  <td align="center">
                    <b>
                      <?php
                        $mezu = $mes_eventh;
                        include('meses.php');
                      ?>
                    </b>
                  </td>
                </tr>
              </table>
            </td>
            <td bgcolor="#32b2cd" align="center" width="77%">
              <a href="eventsee.php?i=<?=$id_eventh;?>"> <h3><?=$tit_eventh?></h3></a>
            </td>
          </tr>
          <?php
            }
          ?>
        </table>
      <?php
        }
      ?>
      </td>
      <!--- EVENTS THIS MONTH --->
        <td align="center">
        <?php
          // Get current year and month
          $currentYear = $hoje->format('Y');
          $currentMonth = $hoje->format('m');
          // Query events where data_event is in the current month
          $query_eventm = "SELECT * FROM events WHERE YEAR(data_event) = ? AND MONTH(data_event) = ? AND data_event > CURDATE() ORDER BY data_event ASC";
          $stmt_eventm  = $conexao->prepare($query_eventm);
          $stmt_eventm->bind_param("ss", $currentYear, $currentMonth);
          $stmt_eventm->execute();
          $rs_eventm = $stmt_eventm->get_result();
          $neventm    = $rs_eventm->num_rows;
          
          // If no more events this month
          if($neventm == 0){
	      ?>
        <br />
          <b>Não há nenhum evento próximo até o fim do mês! :/</b>
        <?php
          }else{
		    ?>
        <table width="100%" border="0" cellpadding="1" cellspacing="1">
        <?php
            while($eventinfom = $rs_eventm->fetch_assoc()){	
              $id_eventm	    = $eventinfom['id_event'];
              $data_eventm    = new DateTime($eventinfom['data_event']);
              $dia_eventm     = $data_eventm->format('d');
              $mes_eventm     = $data_eventm->format('m');
              $tit_eventm     = $eventinfom['tit_event'];
          ?>      
              <tr>
                <td bgcolor="#83c817" width="23%">
                  <table border="0" align="center" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="center">
                        <font size="+2"><?=$dia_eventm;?></font>
                      </td>
                    </tr>
                    <tr>
                      <td align="center">
                        <b><?php
                          $mezu = $mes_eventm;
                          include('meses.php'); ?></b>
                      </td>
                    </tr>   
                  </table>
                </td>
                <td bgcolor="#83c817" align="center" width="77%">
                  <a href="eventsee.php?i=<?=$id_eventm;?>"> <h3><?=$tit_eventm?></h3></a>
                </td>
              </tr>
          <?php
            }
          ?>
        </table>
        <?php
          }
        ?>
        </td>
        <!--- OTHER EVENTS --->
        <td align="center">
        <?php		
          // Get current year and month
          $currentYear  = $hoje->format('Y');
          $currentMonth = $hoje->format('m');

          // Query to fetch events from next month onwards in the current year
          $query_eventa = "SELECT * FROM events WHERE YEAR(data_event) = ? AND MONTH(data_event) > ? AND data_event > CURDATE() ORDER BY data_event ASC";
          $stmt_eventa  = $conexao->prepare($query_eventa);
          $stmt_eventa->bind_param("ss", $currentYear, $currentMonth);
          $stmt_eventa->execute();
          $rs_eventa  = $stmt_eventa->get_result();
          $neventa    = $rs_eventa->num_rows;
          if($neventa == 0){
        ?>
        <br />
          <b>Não há nenhum evento planejado até o fim do ano</b>
        <?php
          }else{
		    ?>
          <table width="100%" border="0" cellpadding="1" cellspacing="1">
          <?php
            while($eventinfoa = $rs_eventa->fetch_assoc()){	
              $id_eventa	    = $eventinfoa['id_event'];
              $data_eventa    = new DateTime($eventinfoa['data_event']);
              $dia_eventa     = $data_eventa->format('d');
              $mes_eventa     = $data_eventa->format('m');
              $tit_eventa     = $eventinfoa['tit_event'];
          ?>
            <tr>
              <td bgcolor="#30f6d8" width="23%">
                <table border="0" align="center" width="100%" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center">
                      <font size="+2"><?=$dia_eventa;?></font>
                    </td>
                  </tr>
                  <tr>
                    <td align="center">
                      <b><?php
                        $mezu = $mes_eventa;
                        include('meses.php'); ?></b>
                    </td>
                  </tr>
                  </table>
              </td>
              <td bgcolor="#30f6d8" align="center" width="77%">
                <a href="eventsee.php?i=<?=$id_eventa;?>"> <h3><?=$tit_eventa?></h3></a>
            </td>
          </tr>
          <?php
            }
          ?>
          </table>
        <?php } ?>
        </td>
        </tr>
        </table>
        <!---- FIM TABELA EVENTOS ----->
        </td>
        <td>&nbsp;</td>
      </tr>
    </table>
    </td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>