<?php
include('rest.php');
include('conectar.php');

$project_id = $_GET['i'] ?? '';

if(empty($project_id)){
    header('Location: pri.php');
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

// Fetch Capo information
$query_capo = "SELECT * FROM capone_ger ORDER BY id_capger DESC LIMIT 1";
$stmt_capo  = $conexao->prepare($query_capo);
$stmt_capo->execute();
$rs_capo    = $stmt_capo->get_result();
$infocapo   = $rs_capo->fetch_assoc();
$stmt_capo->close();

$id_capo    = $infocapo['iduser_capger'];

// Fetch project information
$query_post = "SELECT * FROM projetos WHERE id_proj = ?";
$stmt_post  = $conexao->prepare($query_post);
$stmt_post->bind_param("i", $project_id);
$stmt_post->execute();
$rs_post = $stmt_post->get_result();
$postinfo       = $rs_post->fetch_assoc();
$stmt_post->close();

$tit_proj       = $postinfo['nome_proj'];
$text_proj      = $postinfo['teor_proj'];
$sit_proj       = $postinfo['sit_proj'];
$date_proj      = new DateTime($postinfo['dat_proj']);
$datef_proj     = new DateTime($postinfo['datf_proj']);
$creat_proj     = $postinfo['creat_proj'];

$date   = $datef_proj->format('d/m/Y');
$hj     = new DateTime();

// Fetch creator information
$query_creat    = "SELECT * FROM user WHERE id_user = ?";
$stmt_creat     = $conexao->prepare($query_creat);
$stmt_creat->bind_param("i", $creat_proj);
$stmt_creat->execute();
$rs_creat   = $stmt_creat->get_result();
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
    <td bgcolor="#FFFFFF" style="box-shadow: 0px 5px 15px #000;" height="500" valign="top">
<!---- TABLE PROJECT --------------->
<table width="100%" border="0">
    <tr>
        <td>&nbsp;</td>
        <td align="left" valign="top">
            <font face="Georgia, Times New Roman, Times, serif"><h1><i><?=$tit_proj?></i></h1></font>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="left" style="font-family:Georgia, 'Times New Roman', Times, serif; color:#999;">
            <p><i>Projeto criado em <?=$date_proj->format('d/m/Y');?>, por <?php if($nome_creat == ''){ echo 'Sistema'; }else{ ?>
                <a style="font-family:Georgia, 'Times New Roman', Times, serif; color:#999;" href="perfil.php?p=<?=$creat_proj?>">
                    <font style="text-transform:capitalize;"><?=$nome_creat?> <?=$sobnome_creat?></font>
                </a>
                <?php } 
                if ($id_user == $creat_proj) { if($sit_proj != 'vot'){ echo ' | Não é mais possível excluir o projeto!'; }else{?> | <a href="delet_project.php?i=<?=$project_id?>">(Excluir projeto)</a>
                <?php } } ?>
                <br />
                <font color="#000000">
                    <b>Situação:
                    <?php
                    if($sit_proj == 'vot'){
                        if($date <= $hj){
                        echo 'Esperando julgamento del Capo';
                        }else{
                        echo 'Em processo de votação';
                        }
                    }elseif($sit_proj == 'esp'){
                        echo 'Esperando julgamento del Capo';
                    }else{
                        echo $sit_proj;
                    }
                    ?>
                    </b>
                </font>
            </i></p>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="left" style="font-family:Georgia, 'Times New Roman', Times, serif;"><?=$text_proj;?><br /><br /></td>
        <td>&nbsp;</td>
    </tr>
        <?php
        // If user is Capo, show approval options
	    if($id_capo == $id_user){
            // Check project status
	        if($sit_proj == 'vot'){ ?>
                <tr>
                    <td>&nbsp;</td>     
                    <td align="center" bgcolor="#CCCCFF">
                        Il Capo só pode aprovar ou desaprovar o projeto após o término do período de votação!
                    </td>
                    <td>&nbsp;</td>
                </tr>
        <?php
            }elseif($sit_proj == 'esp'){
        ?>
                <tr>
                    <td>&nbsp;</td>
                    <td align="center" bgcolor="#CCCCFF">
                        <table border="0" width="100%">
                            <tr>
                                <td align="center" colspan="2">
                                Il Capo já pode fazer sua decisão:<br /><b style="color:#F00">* Atenção! A decisão é única e imútavel! *</b>
                                </td>
                            </tr>
                            <tr>
                                <td align="center"><strong style="color:#0C0;"><a href="provs.php?i=<?=$project_id?>&o=a" style="color:#0C0;">Aprovar</a></strong></td>
                                <td align="center"><strong style="color:#F00;"><a href="provs.php?i=<?=$project_id?>&o=d" style="color:#F00;">Desaprovar</a></strong></td>
                            </tr>
                        </table>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <?php 
            }else{
                ?>
                <tr>
                    <td>&nbsp;</td>     
                    <td align="center" bgcolor="#CCCCFF">
                        Il Capo já deu seu parecer sobre este projeto!<br /><i>"<?=$sit_proj?>"</i>
                    </td>
                    <td>&nbsp;</td>
                </tr>
		  <?php
	        }
        }
        // Check if voting period is over
	    if($datef_proj <= $hj){ 	 
	  ?>
        <tr>
            <td>&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC" style="font-family:Georgia, 'Times New Roman', Times, serif;">
                <table border="0" width="200">
                    <tr>
                        <td align="center" colspan="4" style="font-family:Georgia, 'Times New Roman', Times, serif;">Resultado popular:</td>
                    </tr>
                    <?php
                        // Fetch voting information
                        $query_vot = "SELECT * FROM vot_proj WHERE iduser_vop = ? AND idproj_vop = ?";
                        $stmt_vot = $conexao->prepare($query_vot);
                        $stmt_vot->bind_param("ii", $id_user, $project_id);
                        $stmt_vot->execute();
                        $rs_vot = $stmt_vot->get_result();
                        $nvot = $rs_vot->num_rows;
                        $infvot = $rs_vot->fetch_assoc();
                        $stmt_vot->close();

                        $op = $infvot['op_vop'] ?? '0';

                        // Count total votes
                        $query_vots = "SELECT COUNT(*) as total FROM vot_proj WHERE idproj_vop = ?";
                        $stmt_vots = $conexao->prepare($query_vots);
                        $stmt_vots->bind_param("i", $project_id);
                        $stmt_vots->execute();
                        $rs_vots = $stmt_vots->get_result();
                        $row_vots = $rs_vots->fetch_assoc();
                        $nvots = $row_vots['total'];
                        $stmt_vots->close();

                        // Count votes 'yes' (op_vop = 1)
                        $query_votsi = "SELECT COUNT(*) as total FROM vot_proj WHERE idproj_vop = ? AND op_vop = '1'";
                        $stmt_votsi = $conexao->prepare($query_votsi);
                        $stmt_votsi->bind_param("i", $project_id);
                        $stmt_votsi->execute();
                        $rs_votsi = $stmt_votsi->get_result();
                        $row_votsi = $rs_votsi->fetch_assoc();
                        $nvotsi = $row_votsi['total'];
                        $stmt_votsi->close();

                        // Count votes 'no' (op_vop = 2)
                        $query_votn = "SELECT COUNT(*) as total FROM vot_proj WHERE idproj_vop = ? AND op_vop = '2'";
                        $stmt_votn = $conexao->prepare($query_votn);
                        $stmt_votn->bind_param("i", $project_id);
                        $stmt_votn->execute();
                        $rs_votn = $stmt_votn->get_result();
                        $row_votn = $rs_votn->fetch_assoc();
                        $nvotn = $row_votn['total'];
                        $stmt_votn->close();

                        if($nvotsi != 0){
                            $perc_s = ($nvotsi * 100)/$nvots;
                        }else{
                            $perc_s = 0;	
                        }
                        if($nvotn != 0){
                            $perc_n = ($nvotn * 100)/$nvots;
                        }else{
                            $perc_n = 0;	
                        }
                    ?>
                    <tr>
                        <td colspan="3">
                            Total de votos: <B><?=$nvots?></B>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%" align="center">
                            <?php if($op == 2){ ?>
                                <img src="img/unlike.png" width="28">
                            <?php }elseif($op == 1){ ?>
                                <img src="img/like.png" width="28">
                            <?php }elseif($op == ''){ ?>
                                Não votaste neste projeto!
                            <?php } ?>
                        </td>
                        <td width="66%" align="center">
                            <h3>
                                <span style="color:#0C0">
                                <?php echo round($perc_s, 2);?>%
                            </span>
                            </h3></td><td width="66%" align="center"><h3><span style="color:#F00">
                        </td>
                        <td width="66%" align="center">
                            <h3>
                                <span style="color:#F00">
                                    <?php echo round($perc_n, 2);?>%
                                </span>
                            </h3>
                        </td>
                    </tr>    
                </table>
                <font face="Georgia, Times New Roman, Times, serif" size="-1"><b> * O PERÍODO DE VOTAÇÃO FOI ENCERRADO *</b></font>
            </td>
            <td>&nbsp;</td>
        </tr>
      <?php
      // If voting period is not over, show voting options
	  }else{
	  ?>
        <tr>
            <td>&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC" style="font-family:Georgia, 'Times New Roman', Times, serif;">
                <table border="0" width="200">
                    <tr>
                        <td align="center" colspan="4" style="font-family:Georgia, 'Times New Roman', Times, serif;">Este projeto deveria ser aprovado?:</td>
                    </tr>
                    <?php
                        // Fetch voting information
                        $query_vot = "SELECT * FROM vot_proj WHERE iduser_vop = ? AND idproj_vop = ?";
                        $stmt_vot = $conexao->prepare($query_vot);
                        $stmt_vot->bind_param("ii", $id_user, $project_id);
                        $stmt_vot->execute();
                        $rs_vot = $stmt_vot->get_result();
                        $nvot = $rs_vot->num_rows;
                        $infvot = $rs_vot->fetch_assoc();
                        $stmt_vot->close();

                        $op = $infvot['op_vop'] ?? '';

                        // Count total votes
                        $query_vots = "SELECT COUNT(*) as total FROM vot_proj WHERE idproj_vop = ?";
                        $stmt_vots = $conexao->prepare($query_vots);
                        $stmt_vots->bind_param("i", $project_id);
                        $stmt_vots->execute();
                        $rs_vots = $stmt_vots->get_result();
                        $row_vots = $rs_vots->fetch_assoc();
                        $nvots = $row_vots['total'];
                        $stmt_vots->close();

                        // Count votes 'yes' (op_vop = 1)
                        $query_votsi = "SELECT COUNT(*) as total FROM vot_proj WHERE idproj_vop = ? AND op_vop = '1'";
                        $stmt_votsi = $conexao->prepare($query_votsi);
                        $stmt_votsi->bind_param("i", $project_id);
                        $stmt_votsi->execute();
                        $rs_votsi = $stmt_votsi->get_result();
                        $row_votsi = $rs_votsi->fetch_assoc();
                        $nvotsi = $row_votsi['total'];
                        $stmt_votsi->close();

                        // Count votes 'no' (op_vop = 2)
                        $query_votn = "SELECT COUNT(*) as total FROM vot_proj WHERE idproj_vop = ? AND op_vop = '2'";
                        $stmt_votn = $conexao->prepare($query_votn);
                        $stmt_votn->bind_param("i", $project_id);
                        $stmt_votn->execute();
                        $rs_votn = $stmt_votn->get_result();
                        $row_votn = $rs_votn->fetch_assoc();
                        $nvotn = $row_votn['total'];
                        $stmt_votn->close();

                        if($nvotsi != 0){
                            $perc_s = ($nvotsi * 100)/$nvots;
                        }else{
                            $perc_s = 0;	
                        }
                        if($nvotn != 0){
                            $perc_n = ($nvotn * 100)/$nvots;
                        }else{
                            $perc_n = 0;	
                        }
                    ?>
                    <tr>
                        <td colspan="3">
                            Total de votos: <B><?=$nvots?></B>
                        </td>
                    </tr>
                    <?php
                        if($nvot == 0){
                    ?>        
                        <tr>
                            <td colspan="3">
                                <table border="0" width="100%">
                                    <tr>
                                        <td width="25%" align="center"><a href="votproj.php?i=<?=$project_id;?>&o=1"><img src="img/like.png" width="28"></a></td>
                                        <td width="25%" align="center"><h3 style="color:#0C0"><?php echo round($perc_s,2);?>%</h3></td>
                                        <td width="25%" align="center"><h3 style="color:#F00"><?php echo round($perc_n,2);?>%</h3></td>
                                        <td width="25%" align="center"><a href="votproj.php?i=<?=$project_id;?>&o=2"><img src="img/unlike.png" width="28"></a></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <?php }else{ ?>
                        <tr>
                            <td width="33%" align="center">
                                <?php if($op == 2){ ?>
                                    <img src="img/unlike.png" width="28">
                                <?php }elseif($op == 1){ ?>
                                    <img src="img/like.png" width="28">
                                <?php } ?>
                            </td>
                            <td width="66%" align="center">
                                <h3><span style="color:#0C0">
                                    <?php echo round($perc_s, 2);?>%
                                </span></h3>
                            </td>
                            <td width="66%" align="center">
                                <h3><span style="color:#F00">
                                <?php echo round($perc_n, 2);?>%
                                </span></h3>
                            </td>
                        </tr>
                        <?php } ?>      
                </table>
                <font face="Georgia, Times New Roman, Times, serif" size="-1"><b> * ATENÇÃO! O VOTO SÓ PODE SER FEITO UMA VEZ, E NÃO PODE SER DESFEITO! *</b></font>
            </td>
            <td>&nbsp;</td>
        </tr>
      <?php } ?>
        <tr>
            <td>&nbsp;</td>
            <td align="left" style="font-family:Georgia, 'Times New Roman', Times, serif;">
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
                        <td width="85%">
                            <input name="iu" type="hidden" id="iu" value="<?=$id_user?>">
                            <input name="ie" type="hidden" id="ie" value="<?=$project_id?>">
                            <input name="tip" type="hidden" id="tip" value="project" />
                        </td>
                        <td width="11%" align="right">
                            <input name="Envoyer" type="submit" value="Comentar" align="right"  style="-webkit-border-radius: 5px;
                            -moz-border-radius: 5px;
                            border-radius: 5px; width:100px; height:40px;">
                        </td>
                        <td width="3%">&nbsp;</td>
                    </tr>
                </table>
            </form>
            <!--- PUBLICATION ENDS ----------------->
            <table bgcolor="#e4e4e4" cellspacing="5" width="100%">
                <?php
                    // Fetch comments
                    $q_list10 = "SELECT * FROM comment WHERE tip_com = 'project' AND idpag_com = ? ORDER BY id_com ASC";
                    $stmt_list10 = $conexao->prepare($q_list10);
                    $stmt_list10->bind_param("i", $project_id);
                    $stmt_list10->execute();
                    $rs_list10 = $stmt_list10->get_result();
                    $nconfirmpub = $rs_list10->num_rows;
                    
                    if($nconfirmpub == 0){
                ?>
                    <tr>
                        <td colspan="4" align="center">
                            Não há nenhum comentário neste projeto!
                        </td>
                    </tr>
                <?php
                    }else{
                        while($list10 = $rs_list10->fetch_assoc()){
                                                
                        $id_com		= $list10['id_com'];
                        $idpag_com	= $list10['idpag_com'];
                        $creat_com	= $list10['creat_com'];
                        $text_com	= $list10['text_com'];
                        
                        // Fetch comment creator information
                        $q_list11 = "SELECT * FROM user WHERE id_user = ?";
                        $stmt_list11 = $conexao->prepare($q_list11);
                        $stmt_list11->bind_param("i", $creat_com);
                        $stmt_list11->execute();
                        $rs_list11 = $stmt_list11->get_result();
                        $list11 = $rs_list11->fetch_assoc();
                        $stmt_list11->close();
                                                
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
                        <td align="left" colspan="2"><?=$text_com?>
                            <?php
                                if($creat_com == $id_user){ ?>
                                    <table style="vertical-align:bottom" border="0">
                                        <tr>
                                            <td>(</td>
                                            <td>
                                                <form  method="post" action="delet_pub.php?a=pub">
                                                    <input name="pi" type="hidden" id="pi" value="<?=$id_com?>">
                                                    <input name="ie" type="hidden" id="ie" value="<?=$project_id?>">
                                                    <input name="ui" type="hidden" id="ui" value="<?=$creat_com?>">
                                                    <input name="tip" type="hidden" id="tip" value="project">
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
                    $q_list12 = "SELECT * FROM comment WHERE idpag_com = ? AND tip_com = 'project_com' ORDER BY id_com ASC";
                    $stmt_list12 = $conexao->prepare($q_list12);
                    $stmt_list12->bind_param("i", $id_com);
                    $stmt_list12->execute();
                    $rs_list12 = $stmt_list12->get_result();
                    $nconfirmcom = $rs_list12->num_rows;
                    $stmt_list12->close();
                    
                    if($nconfirmcom != 0){
                        while($list12 = $rs_list12->fetch_assoc()){
                                                
                        $id_comm	= $list12['id_com'];
                        $idpag_comm	= $list12['idpag_com'];
                        $creat_comm	= $list12['creat_com'];
                        $text_comm	= $list12['text_com'];

                        // Fetch comment creator information
                        $q_list13 = "SELECT * FROM user WHERE id_user = ?";
                        $stmt_list13 = $conexao->prepare($q_list13);
                        $stmt_list13->bind_param("i", $creat_comm);
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
                                    if($creat_comm == $id_user){ ?>
                                        <table style="vertical-align:bottom" border="0">
                                            <tr>
                                                <td>(</td>
                                                <td>
                                                    <form  method="post" action="delet_pub.php?a=comment">
                                                        <input name="ci" type="hidden" id="pi" value="<?=$id_comm?>">
                                                        <input name="ui" type="hidden" id="ui" value="<?=$creat_comm?>">
                                                        <input name="ie" type="hidden" id="ie" value="<?=$idpag_comm?>">
                                                        <input name="tip" type="hidden" id="ie" value="<?=$project_id?>">
                                                        <input name="tipu" type="hidden" id="tipu" value="project">
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
                        }
                    }
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
                                    -moz-box-shadow: 0 0 8px rgba(0, 0, 0, .8);"></a>
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
                                    <input name="ie" type="hidden" id="ie" value="project_com">
                                    <input type="hidden" value="<?=$id_com?>" name="ip" id="ip">
                                    <input type="hidden" value="<?=$project_id?>" name="im" id="im">
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
</td>
<td>&nbsp;</td>
</tr>
</table>
<!---- TABLE PROJECT ENDS --------------->
</td>
<td>&nbsp;</td>
</tr>
</table>
</body>
</html>