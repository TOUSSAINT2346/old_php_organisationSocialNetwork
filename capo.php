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
        <tr>
          <td>&nbsp;</td>
          <td align="center"><h1>Il Capo del<br />mese è:</h1></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="center">
            <?php
              // Look for month's Capo
              $query_capo = "SELECT * FROM capone_ger LIMIT 1";
              $stmt_capo  = $conexao->prepare($query_capo);
              $stmt_capo->execute();
              $rs_capo    = $stmt_capo->get_result();
              $ncapo      = $rs_capo->num_rows;
              $stmt_capo->close();

              // If no Capo found
              if($ncapo == 0){
            ?>
              <h2>Ainda não há um Il Capo! :O</h2>
            <?php 
              // Set empty variables to avoid errors
              $caponame     = '';
              $caposobname  = '';
              $capophoto	  = '';
              $caposexo	    = '';
              
              }else{      
                $capoinfo     = $rs_capo->fetch_assoc();
                $iduser_capo  = $capoinfo['iduser_capger'];
                
                // Fetch Capo's info
                $query_infcapo  = "SELECT * FROM user WHERE id_user = ?";
                $stmt_infcapo   = $conexao->prepare($query_infcapo);
                $stmt_infcapo->bind_param("i", $iduser_capo);
                $stmt_infcapo->execute();
                $rs_infcapo = $stmt_infcapo->get_result();
                $capoinfus  = $rs_infcapo->fetch_assoc();
                $stmt_infcapo->close();

                $caponame     = $capoinfus['nome_user'];
                $caposobname  = $capoinfus['sobrenome_user'];
                $capophoto	  = $capoinfus['photo_user'];
                $caposexo	    = $capoinfus['sexo_user'];                  
            ?>       
              <img src="photos/user/<?=$capophoto;?>" style="width: 200px;
                height: 200px;
                border-radius: 90px;
                -webkit-border-radius: 100px;
                -moz-border-radius: 100px;
                background: url(photos/user/<?=$capophoto?>);
                background-size:contain;
                box-shadow: 0 0 20px rgba(0, 0, 0, .20);
                -webkit-box-shadow: 0 0 20px rgba(0, 0, 0, .20);
                -moz-box-shadow: 0 0 20px rgba(0, 0, 0, .20);">
            <?php
              }
            ?>
          </td>
          <td>&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="center">
          <h2>
            <?php
              // Display appropriate title based on gender
                switch($caposexo){
                  case 'm':
                    echo 'Signore';
                  break;
                  case 'f':
                    echo 'Signora';
                  break;
                  default:
                    echo '';
                  break;
                }
            ?>
            <?=$caponame?> <?=$caposobname?>
          </h2>
        </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="left">
        <h3>Última parola do Capo:</h3>
        <?php
          // Fetch the latest parola (message) from the Capo
          $query_parola = "SELECT * FROM parola ORDER BY id_parola DESC LIMIT 1";
          $stmt_parola = $conexao->prepare($query_parola);
          $stmt_parola->execute();
          $rs_parola = $stmt_parola->get_result();
          $parolinfo = $rs_parola->fetch_assoc();
          $nparola = $rs_parola->num_rows;
          if($nparola == 0){
            $text_parola     = '';
            $creat_parola    = 0;
          }else{            
            $text_parola     = $parolinfo['text_parola'];
            $creat_parola    = $parolinfo['creat_parola'];
          }
          $stmt_parola->close();

          // If no parola at all is found
          if($nparola == 0){
        ?>
          <h2 align="center">Questo Capo não se pronunciou ainda!</h2>
        <?php
          }else{ 
            // If the latest parola is not from the current Capo
            if($creat_parola != $iduser_capo){
              echo '<h2 align="center">Questo Capo não se pronunciou ainda!</h2>';
            }else{
		    ?>
          <h2><p align="center">"<i><?=$text_parola?></i>"</p></h2>
        <?php
            }
          } ?>
        <br />
        <hr width="90%" />
        <?php
        //////// RESULTS AREA
        // Check election date
        $query_datele = "SELECT * FROM eleicao ORDER BY id_ele ASC LIMIT 1";
        $stmt_datele = $conexao->prepare($query_datele);
        $stmt_datele->execute();
        $rs_datele = $stmt_datele->get_result();
        $infodatele = $rs_datele->fetch_assoc();
        $stmt_datele->close();
                                
        $dia_ele	= $infodatele['dia_ele'];
        $mes_ele	= $infodatele['mes_ele'];

        $hoje     = new DateTime();
        
        $hj		= $hoje->format('d');
        $hjmes	= $hoje->format('m');

        // Check if election is today
        if($dia_ele == $hj && $mes_ele == $hjmes){ 
          $elehj = 's';
        }else{
          $elehj = 'n';
        }

        // Calculate the day after the election using DateTime
        $electionDate = DateTime::createFromFormat('d-m', sprintf('%02d-%02d', $dia_ele, $mes_ele));
        $electionDate->modify('+1 day');
        $pos_ele_d = $electionDate->format('d');

        // If today is the day after the election, show results
        if($hj == $pos_ele_d){
          $elepos = 's';
        ?>
          <table border="0" width="100%">
            <tr>
              <td colspan="5" align="center"><h2>Resultados da Eleição</h2></td>
            </tr>
            <tr>
              <td width="20%">
            <?php
              /// Count total votes

                $query_votos  = "SELECT * FROM votos";
                $stmt_votos   = $conexao->prepare($query_votos);
                $stmt_votos->execute();
                $rs_votos = $stmt_votos->get_result();
                $nvotos   = $rs_votos->num_rows;
                $stmt_votos->close();
              ?>
              <h3 align="center"> <?=$nvotos?> votos </h3>
              <?php
                // Fetch top 5 candidates
                $query_candidatos = "SELECT * FROM capone_reg ORDER BY id_capreg ASC LIMIT 5";
                $stmt_candidatos  = $conexao->prepare($query_candidatos);
                $stmt_candidatos->execute();
                $rs_candidatos = $stmt_candidatos->get_result();
                $ncandi = $rs_candidatos->num_rows;
                $stmt_candidatos->close();

                while($candinfos = $rs_candidatos->fetch_assoc()){
                  $idcand     = $candinfos['idcand_capreg'];
                  $votscand   = $candinfos['votos_capreg'];

                  $percentvots = ($votscand * 100)/$nvotos;
                  $percentvots = number_format($percentvots, 2, '.', '');

                  $query_candidatosi = "SELECT * FROM user WHERE id_user = ?";
                  $stmt_candidatosi = $conexao->prepare($query_candidatosi);
                  $stmt_candidatosi->bind_param("i", $idcand);
                  $stmt_candidatosi->execute();
                  $rs_candidatosi = $stmt_candidatosi->get_result();
                  $candinfosi = $rs_candidatosi->fetch_assoc();
                  $stmt_candidatosi->close();

                  $id_cand	    = $candinfosi['id_user'];
                  $photo_cand   = $candinfosi['photo_user'];
                  $nome_cand 		= $candinfosi['nome_user'];
                  $sobnome_cand	= $candinfosi['sobrenome_user'];

                  ?>
                  <table width="100%" border="0">
                    <tr>
                      <td align="center">
                        <a href="perfil.php?p=<?=$idcand;?>"><img src="photos/user/<?=$photo_cand;?>" style="width: 60px;
                          height: 60px;
                          border-radius: 40px;
                          -webkit-border-radius: 50px;
                          -moz-border-radius: 50px;
                          background: url(photos/user/<?=$photo_cand?>);
                          background-size:contain;
                          box-shadow: 0 0 8px rgba(0, 0, 0, .8);
                          -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);
                          -moz-box-shadow: 0 0 8px rgba(0, 0, 0, .8);"></a>
                      </td>
                    </tr>
                    <tr>
                      <td align="center">
                        <a href="perfil.php?p=<?=$idcand;?>">
                        <?=$nome_cand?> 
                        <?=$sobnome_cand?>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td align="center">
                        <b><?=$percentvots?>%</b>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          <hr width="90%" />
          <?php
                }
              }else{
	            $elepos = 'n';
              }
          //////// END RESULTS AREA
        ?>
      <table width="100%" border="0">
        <?php
          // If election is not today or the day after, show candidates and voting option
          if($elepos == 'n'){ 
        ?>
          <tr>
            <td width="21%">
              <h3>Próxima Eleição:</h3>
            </td>
            <td width="79%">
              <h3>
                <?php if($elehj == 's'){ ?>
                  A eleição é hoje!
                <?php }else{
                  echo $dia_ele . '/' . $mes_ele;
                } ?>
              </h3>
            </td>
          </tr>
          <tr>
            <td colspan="2" align="center">
              <?php
                // Check how many candidates there are
                $query_candidatos = "SELECT * FROM capone_reg";
                $stmt_candidatos = $conexao->prepare($query_candidatos);
                $stmt_candidatos->execute();
                $rs_candidatos = $stmt_candidatos->get_result();
                $ncandi = $rs_candidatos->num_rows;
                $stmt_candidatos->close();

                // Check if the user is already a candidate
                $query_cand1 = "SELECT * FROM capone_reg WHERE idcand_capreg = ?";
                $stmt_cand1 = $conexao->prepare($query_cand1);
                $stmt_cand1->bind_param("i", $id_user);
                $stmt_cand1->execute();
                $rs_cand1 = $stmt_cand1->get_result();
                $ncand1 = $rs_cand1->num_rows;
                $stmt_cand1->close();

                // Show candidacy option if election is not today
                if($elehj == 'n'){
                  // Check if there are less than 5 candidates
                  if($ncandi <= 5){
                    // If user is already a candidate
                    if($ncand1 == '1'){
              ?>
                      <h2>Já estás como candidato!</h2><br />
                      <h4><a href="deletcand.php">[Tirar minha candidatura]</a></h4>
                      <?php
                    }else{
                      ?>
                      <h2><a href="cand.php">Candidata-te!</a></h2>
                    <?php 
                    }
                  }else{ ?>
                    <h2>Não há mais vagas :(</h2>
                  <?php
                  }
                }else{ ?>
                  <h2>A eleição é hoje! Não há mais como candidatar-se</h2>
                <?php
                } ?>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                Candidatos:
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <?php
                    $votook   = 'n';
                // If there are no candidates
                if($ncandi == 0){
                    ?>
                    <h3 align="center">Não há candidatos ainda!</h3>
                    <?php
                }else{
                  //--- Checks whether election is today and if user can vote
                  if($elehj == 's'){
                    $query_votos  = "SELECT * FROM votos WHERE iduser_voto = ?";
                    $stmt_votos   = $conexao->prepare($query_votos);
                    $stmt_votos->bind_param("i", $id_user);
                    $stmt_votos->execute();
                    $rs_votos = $stmt_votos->get_result();
                    $nvoto    = $rs_votos->num_rows;
                    $stmt_votos->close();
                    // If user hasn't voted yet
                    if($nvoto == '0'){
                      $votook = 's';
                    }else{
                      $votook = 'n';
                    }
                  }
                //--- Check ends
                ?>
              <table width="100%" border="0">
                <?php if($elehj == 's'){
                        // If election is today and user has not voted yet
                        if($votook == 's'){
                      ?>
                      <tr>
                        <td align="center" colspan="5">
                          <b style="color:#F00;">* Atenção! Só é possível votar uma vez! O Voto não pode ser desfeito! *</b>
                        </td>
                      </tr>
                      <?php
                        // If user has already voted
                        }else{
                      ?>
                      <tr>
                        <td align="center" colspan="5">
                          <b style="color:#F00;">Teu voto já foi computado! O resultado sai amanhã!</b>
                        </td>
                      </tr>
                      <?php
                        }
                      }
                      ?>
                  <tr>
                <?php
                  while($candinfos = $rs_candidatos->fetch_assoc()){
                    $idcand     = $candinfos['idcand_capreg'];

                    // Fetch candidate's info
                    $query_candidatosi = "SELECT * FROM user WHERE id_user = ?";
                    $stmt_candidatosi = $conexao->prepare($query_candidatosi);
                    $stmt_candidatosi->bind_param("i", $idcand);
                    $stmt_candidatosi->execute();
                    $rs_candidatosi = $stmt_candidatosi->get_result();
                    $candinfosi = $rs_candidatosi->fetch_assoc();
                    $stmt_candidatosi->close();

                    $id_cand	    = $candinfosi['id_user'];
                    $photo_cand   = $candinfosi['photo_user'];
                    $nome_cand 		= $candinfosi['nome_user'];
                    $sobnome_cand	= $candinfosi['sobrenome_user'];

		            ?>
                <td width="20%">
                  <table width="100%" border="0">
                    <tr>
                      <td align="center">
                        <a href="perfil.php?p=<?=$idcand;?>">
                          <img src="photos/user/<?=$photo_cand;?>" style="width: 60px;
                            height: 60px;
                            border-radius: 40px;
                            -webkit-border-radius: 50px;
                            -moz-border-radius: 50px;
                            background: url(photos/user/<?=$photo_cand?>);
                            background-size:contain;
                            box-shadow: 0 0 8px rgba(0, 0, 0, .8);
                            -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);
                            -moz-box-shadow: 0 0 8px rgba(0, 0, 0, .8);">
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td align="center">
                        <a href="perfil.php?p=<?=$idcand;?>">
                        <?=$nome_cand?> 
                        <?=$sobnome_cand?>
                        </a>
                      </td>
                    </tr>
                    <?php
                    // If election is today and user can vote, show voting button
                      if($votook == 's'){
                    ?>
                    <tr>
                      <td align="center">
                        <form action="voto.php" method="post">
                          <input name="voto" type="hidden" id="voto" value="<?=$id_cand;?>" />
                          <input name="Envoyer" type="submit" value="Votar em <?=$nome_cand?>" />
                        </form>
                      </td>
                    </tr>
                  <?php } ?>
                </table>
              </td>
            <?php } } ?>
          </tr>
        <?php }else{ ?>
          <tr>
            <td colspan="2" align="center">
              <h2>As candidaturas começam amanhã!</h2>
            </td>
          </tr>
        <?php } ?>
          <tr>
            <td colspan="5">
              <hr width="90%" />
              <h3 align="center">Informações</h3>
              <p align="center">
                <a href="capopoter.php">
                  <small>Clique aqui para ver todos os poderes del Capo e dos Estudantes</small>
                </a>
              </p>
              <ul><h3>Que é Il Capo?</h3>
                <li>Il Capo é &quot;O Chefe&quot; da Máfia.</li>
              </ul>
              <ul><h3>Que ganha sendo Il Capo?</h3>
                <li>Meu filho... Tu já és Il Capo, queres ganhar mais o quê?</li>
              </ul>
              <ul><h3>Que Il Capo pode fazer a mais que os outros?</h3>
                <li>Il Capo possui um canal de pronunciamentos privado. Só ele pode postar nele. O Capo também é responsável por juntar as ideias dos estudantes, transformá-las em projetos para o site e/ou aprová-los. <a href="capopoter.php">Veja +</a></li>
              </ul>
              <ul><h3>Como posso virar Il Capo?</h3>
                <li>Basta candidatar-se acima, no dia da eleição as pessoas votarão e então o candidato com mais votos vira Il Capo por 1 mês.</li>
              </ul>
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
</td>
<td>&nbsp;</td>
</tr>
</table>
</body>
</html>