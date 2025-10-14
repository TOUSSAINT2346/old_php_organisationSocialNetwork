<?php
include('rest.php');
include('conectar.php');

// Fetch user information
$query_guy  = "SELECT * FROM user WHERE nickname_user = ?";
$stmt_guy   = $conexao->prepare($query_guy);
$stmt_guy->bind_param("s", $login_user);
$stmt_guy->execute();
$rs_guy = $stmt_guy->get_result();
$infoguy= $rs_guy->fetch_assoc();
$stmt_guy->close();

$id_user	= $infoguy['id_user'];

$id_perfil  = $_GET['p'] ?? '';

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

$nome_perf     = $infoperf['nome_user'];
$sobnome_perf  = $infoperf['sobrenome_user'];
$bday_perf     = new DateTime($infoperf['bday_user']);
$desc_perf     = $infoperf['desc_user'];
$photo_perf    = $infoperf['photo_user'];
$turno_perf    = $infoperf['turno_user'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Mi mafia, Tu mafia</title>
    <link rel="stylesheet" href="css/geral.css" type="text/css" />
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript" src="js/txtlimit.js"></script>
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
                <!---- PROFILE TABLE --------------->
                <table width="100%" border="0">
                    <tr>
                        <td>&nbsp;</td>
                        <td align="center" valign="top">
                            <table border="0" width="100%">
                            <tr>
                                <td align="center" width="34%" rowspan="3">
                                    <img src="photos/user/<?=$photo_perf;?>" alt="" style="width: 200px;
                                    height: 200px;
                                    border-radius: 90px;
                                    -webkit-border-radius: 100px;
                                    -moz-border-radius: 100px;
                                    background: url(photos/user/<?=$photo_perf?>);
                                    background-size:contain;
                                    box-shadow: 0 0 20px rgba(0, 0, 0, .20);
                                    -webkit-box-shadow: 0 0 20px rgba(0, 0, 0, .20);
                                    -moz-box-shadow: 0 0 20px rgba(0, 0, 0, .20);" />
                                </td>
                                <td width="66%">
                                    <h1><font style="text-transform:capitalize;"><?=$nome_perf?> <?=$sobnome_perf?></font></h1>
                                    <?php if($id_perfilo == $id_user){ ?>
                                        <a href="editperfil.php">&laquo; Editar Perfil &raquo;</a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table border="0" width="100%">
                                        <tr>
                                            <td>
                                                <h2><?=$bday_perf->format('d/m/Y')?></h2>
                                            </td>
                                            <td align="center">
                                                <img src="img/<?=$turno_perf?>.png" alt="" width="78" height="78" title="<?=$nome_perf?> estuda <?php if($turno_perf == 'm'){ echo "pela manhã"; }else{ echo 'à noite'; }?>" />
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td><?=$desc_perf?></td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2">
                                    <hr width="100%" size="1" />
                                    <?php
                                    $query_capo = "SELECT * FROM capone_ger LIMIT 1";
                                    $stmt_capo  = $conexao->prepare($query_capo);
                                    $stmt_capo->execute();
                                    $rs_capo    = $stmt_capo->get_result();
                                    $capoinfo   = $rs_capo->fetch_assoc();
                                    $stmt_capo->close();
                                    
                                    $iduser_capo = $capoinfo['iduser_capger'];

                                    if($id_perfilo == $iduser_capo){
                                    ?>
                                        <h3><?=$nome_perf?> é atualmente Il Capo! <a href="parola.php">Veja suas últimas parole!</a></h3>
                                        <hr width="100%" size="1" />
                                    <?php } ?>
                                </td>
                            </tr>
                        <tr>
                            <td align="center" colspan="2">
                            <!--- AREA CONQUISTAS ------------>
                            <?php
                                $query_badges   = "SELECT * FROM badge_won WHERE iduse_bw = ?";
                                $stmt_badges    = $conexao->prepare($query_badges);
                                $stmt_badges->bind_param("i", $id_perfilo);
                                $stmt_badges->execute();
                                $rs_badges  = $stmt_badges->get_result();
                                $num_badges = $rs_badges->num_rows;
                                $stmt_badges->close();
                                ?>
                                <table border="0" width="100%">
                                    <tr>
                                        <td colspan="6">
                                            <h2>
                                                Conquistas de <?=$nome_perf?> (<font title="<?=$nome_perf?>
                                                <?php
                                                if($num_badges == 0){
                                                    echo 'não possui nenhuma conquista :O';
                                                }else{
                                                    if($num_badges == 1){
                                                        echo 'possui uma conquista :)';
                                                    }else{
                                                        echo 'possui ' . $num_badges . ' conquistas';
                                                    }
                                                }
                                                ?>"><?=$num_badges;?>)</font>
                                                <?php 
                                                if($id_perfilo == $id_user){
                                                    ?>
                                                    <small>| <a href="newbadge.php">Requerer conquistas</a></small>
                                                <?php } ?>
                                            </h2>
                                        </td>
                                    </tr>
                                    <tr>
                                    <?php
                                        // All points
                                        $query_badges_sem = "SELECT * FROM badge_won WHERE iduse_bw = ? ORDER BY id_bw";
                                        $stmt_badges_sem = $conexao->prepare($query_badges_sem);
                                        $stmt_badges_sem->bind_param("i", $id_perfilo);
                                        $stmt_badges_sem->execute();
                                        $rs_badges_sem = $stmt_badges_sem->get_result();
                                        $valuetot = 0;
                                        while($badges_infom = $rs_badges_sem->fetch_assoc()){

                                            $grupo_badgem = $badges_infom['idba_tot_bw'];
                                            $level_badgem = $badges_infom['idba_bw'];

                                            // Look for badge info
                                            $query_badges_seam = "SELECT * FROM badges WHERE nsup_ba = ? AND ninf_ba = ?";
                                            $stmt_badges_seam = $conexao->prepare($query_badges_seam);
                                            $stmt_badges_seam->bind_param("ii", $grupo_badgem, $level_badgem);
                                            $stmt_badges_seam->execute();
                                            $rs_badges_seam = $stmt_badges_seam->get_result();
                                            $badgesa_infom = $rs_badges_seam->fetch_assoc();

                                            $valuetot	 += $badgesa_infom['value_ba'];
                                        }

                                        //DEMAIS
                                        $query_badges_se = "SELECT * FROM badge_won WHERE iduse_bw = ? ORDER BY id_bw DESC LIMIT 5";
                                        $stmt_badges_se = $conexao->prepare($query_badges_se);
                                        $stmt_badges_se->bind_param("i", $id_perfilo);
                                        $stmt_badges_se->execute();
                                        $rs_badges_se = $stmt_badges_se->get_result();
                                        $num_badges_se= $rs_badges_se->num_rows;

                                        if($num_badges_se == 0){
                                        ?>
                                        <td colspan="6" align="center">
                                        <p><b><?=$nome_perf?> não tem nenhuma conquista ainda :/</b></p>
                                        </td>
                                    <?php
                                    }else{
                                        while($badges_info = $rs_badges_se->fetch_assoc()){

                                            $grupo_badge = $badges_info['idba_tot_bw'];
                                            $level_badge = $badges_info['idba_bw'];

                                            // Look for badge info
                                            $query_badges_sea = "SELECT * FROM badges WHERE nsup_ba = ? AND ninf_ba = ?";
                                            $stmt_badges_sea = $conexao->prepare($query_badges_sea);
                                            $stmt_badges_sea->bind_param("ii", $grupo_badge, $level_badge);
                                            $stmt_badges_sea->execute();
                                            $rs_badges_sea = $stmt_badges_sea->get_result();
                                            $badgesa_info = $rs_badges_sea->fetch_assoc();

                                            $id_badge	 	= $badgesa_info['id_ba'];
                                            $name_badge 	= $badgesa_info['name_ba'];
                                            $img_badge		= $badgesa_info['img_ba'];
                                            $value_badge    = $badgesa_info['valueof_ba'];
                                            $text_badge		= $badgesa_info['text_ba'];
                                        ?>
                                        <td align="center">
                                            <a href="badginfo.php?i=<?=$id_badge;?>"><img title="<?=$name_badge?> - <?=$text_badge?> - <?=$value_badge?> Pts" src="img/badges/<?=$img_badge;?>.png" width="57"/></a>
                                        </td>
                                    <?php 
                                        }
                                    }
                                ?>
                                    </tr>
                                    <tr>
                                        <td align="center" colspan="6">
                                        Conquistopoints: <?php
                                            if($valuetot == 0){
                                                echo 0;
                                            }else{
                                                echo $valuetot;
                                            }?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">
                                            <b><a href="allconq.php?p=<?=$id_perfilo?>">Ver todas as conquistas de 
                                            <?=$nome_perf?>
                                            </a></b>
                                        </td>
                                    </tr>
                                </table>
                            <!--- AREA FIM CONQUISTAS ------------> 
                            <hr width="100%" size="1" /> 
                        </td>
                    </tr>
                    <tr>
                        <td align="left" colspan="2">
                        <h2>Últimos posts de <?=$nome_perf?>:</h2>
                        <table border="0" width="100%">
                        <?php
                            $query_posts = "SELECT * FROM posts WHERE creat_post = ? ORDER BY id_post DESC LIMIT 5";
                            $stmt_posts = $conexao->prepare($query_posts);
                            $stmt_posts->bind_param("i", $id_perfilo);
                            $stmt_posts->execute();
                            $rs_posts = $stmt_posts->get_result();
                            $nposts = $rs_posts->num_rows;

                            if($nposts == 0){                            
                            ?>
                                <tr>
                                    <td align="center" colspan="3">
                                        <h3><?=$nome_perf?> ainda não fez nenhuma postagem!</h3>
                                    </td>
                                </tr>
                            <?php
                            }else{
                            
                                while($postinfo = $rs_posts->fetch_assoc()){
                                    $id_post	= $postinfo['id_post'];
                                    $tit_post	= $postinfo['tit_post'];
                                    $date_post	= new DateTime($postinfo['date_post']);
                                    $area = $postinfo['cat_post'];

                                    include('areas.php');
                            ?>
                                    <tr>
                                        <td width="33%">
                                        <a href="readpost.php?i=<?=$id_post?>"><h3 style="font-family:Georgia, 'Times New Roman', Times, serif"><?=$tit_post?></h3></a>
                                        </td>
                                        <td align="center" style="font-family:Georgia, 'Times New Roman', Times, serif" width="33%">
                                        <?=$area_text;?>
                                        </td>
                                        <td align="center" style="font-family:Georgia, 'Times New Roman', Times, serif" width="33%">
                                        <?=$date_post->format('d/m/Y');?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <hr size="1" />
                                        </td>
                                    </tr>
                            <?php
                                }
                            } 
                            ?>
                        </table>
                    </td>
                </tr>
            </table>
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
<!---- PROFILE TABLE ENDS --------------->
</td>
<td>&nbsp;</td>
</tr>
</table>
</body>
</html>