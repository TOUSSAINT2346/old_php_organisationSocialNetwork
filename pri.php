<?php
  include('rest.php');
  include('conectar.php');
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
      <table width="100%" border="0">
        <?php 
        // Look for referenda being held
        $query_plebson= "SELECT * FROM plebs WHERE vis_plebs = 0";
        $stmt_plebson = $conexao->prepare($query_plebson);
        $stmt_plebson->execute();
        $rs_plebson   = $stmt_plebson->get_result();
        $nplebson     = $rs_plebson->num_rows;

        // Define user's vote as "0" default
        $nvotpa = 0;

        while($plebinfoa = $rs_plebson->fetch_assoc()){
          $id_plebsa  = $plebinfoa['id_plebs'];

          // Check if user has already voted
          $query_votpa  = "SELECT * FROM votpleb WHERE idple_vtp = ? AND idus_vtp = ?";
          $stmt_votpa   = $conexao->prepare($query_votpa);
          $stmt_votpa->bind_param("ii", $id_plebsa, $id_useruma);
          $stmt_votpa->execute();
          $rs_votpa     = $stmt_votpa->get_result();
          $nvotpa      += $rs_votpa->num_rows;
          $stmt_votpa->close();
        }


        //=== Show referenda if there are any and user hasn't voted in all of them ===//
        if($nplebson != 0 && $nplebson != $nvotpa){
        ?>
          <tr>
            <td colspan="4" align="center">
            <!--- REFERENDA --->
              <table cellpadding="0" cellspacing="0" style="background: linear-gradient(#F00, #F03);border-radius:10px;-moz-border-radius:10px;-webkit-border-radius:10px;" width="100%" height="20" border="0">
                <tr>
                  <td width="10%">&nbsp;</td>
                  <td width="80%">
                    <h3>Há plebiscito ocorrendo! Vota!</h3>
                  </td>
                  <td width="10%">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>
                    <table width="100%" border="0">
                      <tr>
                        <td width="58%">Pergunta:</td>
                        <td width="42%">Fim da votação:</td>
                        <td width="42%">Já votei?</td>
                      </tr>
                      <tr>
                        <td colspan="3">
                        <hr width="100%" size="1" />
                        </td>
                      </tr>
                      <?php
                        while($plebinfo = $rs_plebson->fetch_assoc()){
                          $id_plebs   = $plebinfo['id_plebs'];
                          $perg_plebs = $plebinfo['perg_plebs'];
                          $datef_plebs= $plebinfo['datef_plebs'];

                          /// Did user already voted?
                          $query_votp = "SELECT * FROM votpleb WHERE idple_vtp = ? AND idus_vtp = ?";
                          $stmt_votp = $conexao->prepare($query_votp);
                          $stmt_votp->bind_param("ii", $id_plebs, $id_useruma);
                          $stmt_votp->execute();
                          $rs_votp = $stmt_votp->get_result();
                          $nvotp = $rs_votp->num_rows;
                          $stmt_votp->close();

                          /// Duration
                          $date_dp	= new DateTime();
                          
                          $exdatefp = new DateTime($datef_plebs);
                          $date_dfp = $exdatefp->format('Y/m/d');
                          
                          $startTimeStampp  = $date_dp->getTimestamp();
                          $endTimeStampp    = $exdatefp->getTimestamp();
                          $timeDiffp = abs($endTimeStampp - $startTimeStampp);

                          $numberDaysp = $timeDiffp/86400;

                          $durp = intval($numberDaysp);
                          /// Duration ends
                              
                        ?>
                        <tr>
                          <td width="58%">
                            <b><i><a href="readpleb.php?i=<?=$id_plebs?>"><font style="text-transform:capitalize;"><?=$perg_plebs?></font></a></i></b>
                          </td>
                          <td width="42%" align="center">
                            <font title="<?=$datef_plebs?>">
                              <?php
                                if($durp > 1){
                                  echo '<b>' .$durp . ' dias</b>';
                                }else{
                                  echo '<b>Amanhã!</b>';	
                                }		
                              ?>
                            </font>
                          </td>
                          <td align="center">
                            <?php
                              if($nvotp == 0){
                                echo '<b style="color:#FF0;">Não</b>';
                              }else{
                                echo 'Sim';
                              }
                            ?>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="3">
                            <hr width="100%" size="1" />
                          </td>
                        </tr>
                      <?php } ?>
                    </table>
                  </td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table>
            <!--- REFERENDA END --->
            </td>
          </tr>
        <?php
        }
        //=== End showing referenda ===//

        // Look for election day
        $query_datele = "SELECT * FROM eleicao ORDER BY id_ele ASC LIMIT 1";
        $stmt_datele  = $conexao->prepare($query_datele);
        $stmt_datele->execute();
        $rs_datele    = $stmt_datele->get_result();
        $infodatele   = $rs_datele->fetch_assoc();
        $stmt_datele->close();
                                
        $dia_ele	= $infodatele['dia_ele'];
        $mes_ele	= $infodatele['mes_ele'];

        $hoje     = new DateTime();

        $hj			  = $hoje->format('d');
        $hjmes		= $hoje->format('m');

        // IF TODAY IS ELECTION DAY
        if($dia_ele == $hj && $mes_ele == $hjmes){ 
          $elehj = 's';
        }else{
          $elehj = 'n';
        }

        // Show election day notification if today is election day
        if($elehj == 's'){
        ?>
          <tr>
            <td colspan="4" align="center">
              <p><b><font color="#F63"><a style="color:#F63;" href="capo.php">A eleição é hoje! Já votaste? Vota agora clicando aqui!</a><br />
              <!--- Link to explanatory video about elections and how to vote --->
              <a href="http://youtu.be/9_a9Z0X-lLM" style="color:#F63;"  target="_blank">(Dúvidas? Assite o vídeo explicativo aqui!)</a></font></b>
              </p>
            </td>
          </tr>
        <?php
        }
        ?>
          <tr height="5">
            <td width="5%">&nbsp;</td>
            <td width="33%" align="center"></td>
            <td width="57%" align="center"></td>
            <td width="5%">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
<!--------- PRIMEIRA PARTE ESQUERDA ALTO --------->
            <td align="left" valign="top">
              <!--- AL CAPONE --->
                <table class="tableado" width="400" border="0">
                  <tr>
                    <td width="10%">&nbsp;</td>
                    <td width="80%"><h3>Nostro Capo</h3></td>
                    <td width="10%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <!--- AL CAPONE INFO --->
                    <td>
                      <?php
                        // Look for current Il Capo
                        $query_capo = "SELECT * FROM capone_ger LIMIT 1";
                        $stmt_capo = $conexao->prepare($query_capo);
                        $stmt_capo->execute();
                        $rs_capo = $stmt_capo->get_result();
                        $ncapo = $rs_capo->num_rows;
                        if($ncapo == 0){
                      ?>
                        <b>Ainda não há um Il Capo! :O</b>
                      <?php 
                        }else{
                          $capoinfo   = $rs_capo->fetch_assoc();
                          $iduser_capo= $capoinfo['iduser_capger'];

                          $query_infcapo  = "SELECT * FROM user WHERE id_user = ?";
                          $stmt_infcapo   = $conexao->prepare($query_infcapo);
                          $stmt_infcapo->bind_param("i", $iduser_capo);
                          $stmt_infcapo->execute();
                          $rs_infcapo   = $stmt_infcapo->get_result();
                          $capoinfus    = $rs_infcapo->fetch_assoc();

                          $caponame     = $capoinfus['nome_user'];
                          $caposobname  = $capoinfus['sobrenome_user'];
                          $capophoto	  = $capoinfus['photo_user'];                          
                      ?>       
                        <table width="100%" border="0">
                          <tr>
                            <td width="26%"><img src="photos/user/<?=$capophoto;?>" style="width: 60px;
                            height: 60px;
                            border-radius: 40px;
                            -webkit-border-radius: 50px;
                            -moz-border-radius: 50px;
                            background: url(photos/user/<?=$capophoto?>);
                            background-size:contain;
                            box-shadow: 0 0 8px rgba(0, 0, 0, .8);
                            -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);
                            -moz-box-shadow: 0 0 8px rgba(0, 0, 0, .8);"></td>
                            <td width="74%"><?=$caponame;?> <?=$caposobname;?></td>
                          </tr>
                        </table>
                      <?php 
                          }
                      ?>
                      <p>
                        <a href="capo.php">
                          Saiba + sobre
                        </a>
                      </p>
                    </td>
                    <!--- ENDS AL CAPONE INFO --->
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table>
              <!--- AL CAPONE ENDS --->
                <br /><br /><br />
              <!--- POSTS --->
                <table class="tablaposts" width="400" border="0">
                  <tr>
                    <td width="5%">&nbsp;</td>
                    <td width="85%"><h3>O Diário Mafioso <font title="No Diário Mafioso tu encontras posts que os alunos fazem sobre assuntos que sejam do interesse destes. Ex.: Avisos, anúncios, notícias, etc.">(?)</font></h3></td>
                    <td width="10%">&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>
              <!--- POSTS ------------>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td>Últimos posts:</td>
                      </tr>
                    </table>
                    <?php
                      // Look for posts
                      $query_posts  = "SELECT * FROM posts ORDER BY id_post DESC LIMIT 5";
                      $stmt_posts   = $conexao->prepare($query_posts);
                      $stmt_posts->execute();
                      $rs_posts = $stmt_posts->get_result();
                      $nposts   = $rs_posts->num_rows;
                      
                      if($nposts == 0){
                    ?>
                    <br />
                    <b>Ainda não há nenhum post! :|</b>
                    <?php 
                      }else{
                    ?>
                        <table width="100%" border="0" cellpadding="1" cellspacing="1">
                          <?php
                            while($postinfo = $rs_posts->fetch_assoc()){
                              $id_post     = $postinfo['id_post'];
                              $tit_post    = $postinfo['tit_post'];
                          ?>
                            <tr>
                              <td bgcolor="#FFFFFF" align="left" width="77%">
                                <a href="readpost.php?i=<?=$id_post;?>"> <h4><?=$tit_post?></h4></a>
                              </td>
                              <td bgcolor="#FFFFFF"><a href="readpost.php?i=<?=$id_post;?>">(LER)</a></td>
                            </tr>
                          <?php
                            }
                          ?>
                        </table>
                    <?php
                      }
                    ?>
                    <p><a href="odmpri.php">Ver + posts</a></p>
              <!--- POSTS ENDS --------->       
                  </td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table>
              <!--- POSTS ENDS --->
            </td>
<!--------- SEGUNDA PARTE DIREITA ALTO --------->
            <td align="center" valign="top">
              <!--- EVENTS --->
                <table class="tablaeventos" width="400" border="0">
                  <tr>
                    <td width="10%">&nbsp;</td>
                    <td width="80%"><h3>Eventos</h3></td>
                    <td width="10%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><b>Hoje: <?=$hoje->format('d/m/Y');?></b></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>
                    <!--- EVENTOS ------------>
                    <br />
                      <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                          <td>
                          Eventos Programados:
                          </td>
                        </tr>
                      </table>
                      <?php
                        /// Look for events
                        $query_events = "SELECT * FROM events WHERE data_event >= CURDATE() ORDER BY data_event LIMIT 5";
                        $stmt_events  = $conexao->prepare($query_events);
                        $stmt_events->execute();
                        $rs_events = $stmt_events->get_result();
                        $nevents   = $rs_events->num_rows;

                        /// No events?
                        if($nevents == 0){
                        ?>
                          <br />
                          <b>Não há nenhum evento planejado! :/</b>
                        <?php
                        }else{
                      ?>
                          <table width="100%" border="0" cellpadding="1" cellspacing="1">
                            <?php
                              while($eventinfo = $rs_events->fetch_assoc()){	
                              $id_event	     = $eventinfo['id_event'];
                              $data_event    = new DateTime($eventinfo['data_event']);
                              $dia_event     = $data_event->format('d');
                              $mes_event     = $data_event->format('m');
                              $tit_event     = $eventinfo['tit_event'];
                            ?>
                              <tr>
                                <td bgcolor="#FFFFFF" width="23%">
                                  <table border="0" align="center" width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td align="center">
                                        <font size="+2"><?=$dia_event;?></font>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="center">
                                        <b><?php
                                          $mezu = $mes_event;
                                          include('meses.php'); ?></b>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                                <td bgcolor="#FFFFFF" align="center" width="77%">
                                  <a href="eventsee.php?i=<?=$id_event;?>"> <h3><?=$tit_event?></h3></a>
                                </td>
                              </tr>        
                            <?php
                              }
                            ?>
                          </table>
                      <?php
                        }
                      ?>
                    <p><a href="events.php">Ver + eventos</a></p>
                    <!--- EVENTOS ENDS --------->       
                    </td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
              <!--- EVENTS ENDS --->
              <br />
              <!--- PROJETOS --->
                <table class="tablaproj" id="tablaproj" width="400" border="0">
                  <tr>
                    <td width="10%">&nbsp;</td>
                    <td width="80%"><h3>Últimos projetos em votação</h3></td>
                    <td width="10%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>
                      <?php
                        // Look for projects in voting
                        $query_proj = "SELECT * FROM projetos WHERE sit_proj = 'vot' ORDER BY id_proj DESC LIMIT 3";
                        $stmt_proj  = $conexao->prepare($query_proj);
                        $stmt_proj->execute();
                        $rs_proj  = $stmt_proj->get_result();
                        $nproj    = $rs_proj->num_rows;

                        if($nproj == 0){
                      ?>
                        <b>Nenhum projeto está em votação! :|</b>
                      <?php
                        }else{
                      ?>
                        <table width="100%" border="0">
                          <tr>
                            <td width="58%">Nome</td>
                            <td width="42%">Fim da votação:</td>
                            <td width="42%">Já votei?</td>
                          </tr>
                          <tr>
                            <td colspan="3">
                              <hr width="100%" size="1" />
                            </td>
                          </tr>
                          <?php
                          // List projects
                            while($projinfo = $rs_proj->fetch_assoc()){
                              $id_proj     = $projinfo['id_proj'];
                              $nom_proj    = $projinfo['nome_proj'];
                              $datf_proj   = new DateTime($projinfo['datf_proj']);

                              /// Did user already voted?
                              $query_vot  = "SELECT * FROM vot_proj WHERE iduser_vop = ? AND idproj_vop = ?";
                              $stmt_vot   = $conexao->prepare($query_vot);
                              $stmt_vot->bind_param("ii", $id_useruma, $id_proj);
                              $stmt_vot->execute();
                              $rs_vot = $stmt_vot->get_result();
                              $nvot   = $rs_vot->num_rows;
                              $stmt_vot->close();

                              /// Duration
                              $date_d	= $hoje->format('Y/m/d');

                              $day_df	= $datf_proj->format('d');
                              $mon_df	= $datf_proj->format('m');
                              $yea_df	= $datf_proj->format('Y');
                              
                              $date_df	= $datf_proj->format('Y/m/d');

                              $startTimeStamp = $hoje->getTimestamp();
                              $endTimeStamp   = $datf_proj->getTimestamp();

                              $timeDiff   = abs($endTimeStamp - $startTimeStamp);
                              $numberDays = $timeDiff/86400;

                              $dur = intval($numberDays);
                              /// Duration ends                                
                            ?>
                          <tr>
                            <td width="58%">
                              <b><i><a href="readproject.php?i=<?=$id_proj?>"><font style="text-transform:capitalize;"><?=$nom_proj?></font></a></i></b>
                            </td>
                            <td width="42%" align="center">
                              <font title="<?=$datf_proj?>">
                                <?php
                                  if($dur > 1){
                                    echo '<b>' .$dur . ' dias</b>';
                                  }else{
                                    echo '<b>Amanhã!</b>';	
                                  }		
                                ?>
                              </font>
                            </td>
                            <td align="center">
                              <?php
                                if($nvot == 0){
                                  echo '<b style="color:#FF0000">Não</b>';
                                }else{
                                  echo 'Sim';
                                }
                              ?>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="3">
                              <hr width="100%" size="1" />
                            </td>
                          </tr>
                          <?php
                            }
                          ?>
                        </table>
                      <?php
                        }
                      ?>
                      <p>
                        <a href="projectos.php">
                          Ver todos os projetos
                        </a>
                      </p>
                    </td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
              <!--- PROJETOS ENDS --->
              <br /><br />
              <!--- PAROLA --->
              <table class="tablaparola" width="400" border="0">
                <tr>
                  <td width="5%">&nbsp;</td>
                  <td width="85%"><h3>Parola del Capo</h3></td>
                  <td width="10%">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>
                    <!--- POSTS ------------>
                    <?php
                      $query_parola = "SELECT * FROM parola ORDER BY id_parola DESC LIMIT 1";
                      $stmt_parola  = $conexao->prepare($query_parola);
                      $stmt_parola->execute();
                      $rs_parola  = $stmt_parola->get_result();
                      $nparola    = $rs_parola->num_rows;
                      $rs_parolu  = $conexao->query($query_parola);
                      
                      if($nparola == 0){
                    ?>
                    <br />
                    <b>Il Capo não se pronunciou ainda! o_o</b>
                    <?php 
                      }else{
                        $paroliinfo   = $rs_parolu->fetch_assoc();
                        $creat_parola = $paroliinfo['creat_parola'];

                        if($creat_parola != $iduser_capo){
                          echo '<b>Il Capo não se pronunciou ainda! o_o</b>';
                        }else{
                    ?>
                      <table width="100%" border="0" cellpadding="1" cellspacing="1">
                        <?php
                          while($parolinfo = $rs_parola->fetch_assoc()){
                          $text_parola      = $parolinfo['text_parola'];
                        ?>
                        <tr>
                          <td align="center" width="77%"><h4>"<i><?=$text_parola;?></i>"</h4></td>
                        </tr>
                        <?php
                          } 
                        ?>
                      </table>
                    <?php
                        }
                      }
                    ?>
                    <p><a href="parola.php">+ parole</a></p>
                    <!--- POSTS ENDS --------->       
                  </td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table>
              <!--- PAROLA ENDS --->
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