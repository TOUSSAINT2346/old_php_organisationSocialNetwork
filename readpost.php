<?php
include('rest.php');
include('conectar.php');

$post_id = $_GET['i'] ?? '';

if(empty($post_id)){
    header('Location: odmpri.php');
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

// Fetch post information
$query_post = "SELECT * FROM posts WHERE id_post = ?";
$stmt_post = $conexao->prepare($query_post);
$stmt_post->bind_param("s", $post_id);
$stmt_post->execute();
$rs_post = $stmt_post->get_result();
$postinfo = $rs_post->fetch_assoc();
$stmt_post->close();

$tit_post     = $postinfo['tit_post'];
$text_post    = $postinfo['text_post'];
$creat_post	  = $postinfo['creat_post'];
$date_post    = new DateTime($postinfo['date_post']);
$area	      = $postinfo['cat_post'];
$font_post	  = $postinfo['font_post'];
$util_post	  = $postinfo['util_post'];
$inutil_post  = $postinfo['inutil_post'];
$sees_all	  = $postinfo['vis_post'];
$totutil_post = $postinfo['totutil_post'];

$nome_creat     = '';
$sobnome_creat  = '';
$photo_creat    = '';

// Fetch creator information
if($creat_post != 0){
    $query_creat = "SELECT * FROM user WHERE id_user = ?";
    $stmt_creat = $conexao->prepare($query_creat);
    $stmt_creat->bind_param("s", $creat_post);
    $stmt_creat->execute();
    $rs_creat = $stmt_creat->get_result();
    $creatinfus = $rs_creat->fetch_assoc();
    $stmt_creat->close();

    $nome_creat     = $creatinfus['nome_user'];
    $sobnome_creat  = $creatinfus['sobrenome_user'];
    $photo_creat    = $creatinfus['photo_user'];
}

include('areas.php');

////VIEWS
// Update view count
$sees_new = $sees_all + 1;
$stmt_views = $conexao->prepare("UPDATE posts SET vis_post = ? WHERE id_post = ?");
$stmt_views->bind_param("is", $sees_new, $post_id);
$stmt_views->execute();
$stmt_views->close();

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
        <!---- TABELA NOTICIAS --------------->
        <table width="100%" border="0">
            <?php include ('headodm.php');?>
            <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">
                <font face="Georgia, Times New Roman, Times, serif">
                    <h1><i>
                    <?php            
                        if($tit_post == ''){
                            echo 'Sem título';
                        }else{
                            echo $tit_post;  
                        }
                    ?>
                    </i></h1>
                </font>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td align="left" style="font-family:Georgia, 'Times New Roman', Times, serif; color:#999;">
                    <p>
                        <i>
                        Postado em <a style="color:#999;" href="odmareas.php?a=<?=$area?>"><?=$area_text?></a>, por <?php if($nome_creat == ''){ echo 'Sistema'; }else{ ?> <a style="font-family:Georgia, 'Times New Roman', Times, serif; color:#999;" href="perfil.php?p=<?=$creat_post?>"><font style="text-transform:capitalize;"><?=$nome_creat?> <?=$sobnome_creat?></font></a><?php } ?>, <?=$date_post->format('d/m/Y');?><?php if ($id_user == $creat_post) {?> | (<a style="color:#999" href="editpost.php?i=<?=$post_id?>">Modificar Artigo</a>)
                        <?php } ?>
                        </i>
                        | <span title="Este artigo foi visto <?=$sees_all;?> <?php if($sees_all == 1){ echo 'vez'; }else{ echo 'vezes'; } ?>"><img src="img/eye.png" width="19px"> <?=$sees_all;?></span>
                    </p>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td align="left" style="font-family:Georgia, 'Times New Roman', Times, serif;">
                    <?=$text_post;?><br /><br />
                    <?php
                    // Display source if available
                    if($font_post != ""){
                    ?>
                        <font style="font-family:Georgia, 'Times New Roman', Times, serif; color:#999;"><i>Fonte: <?=$font_post;?></i></font>
                    <?php
                    }
                    ?>
                </td>
                <td>&nbsp;</td>
            </tr>
            <?php
                // Show like/dislike only if the post is not created by the system
                if($creat_post != '0'){
            ?>
            <tr>
                <td>&nbsp;</td>
                    <td align="center" bgcolor="#CCCCCC" style="font-family:Georgia, 'Times New Roman', Times, serif;">
                        <table border="0" width="140">
                            <tr>
                                <td align="center" colspan="3" style="font-family:Georgia, 'Times New Roman', Times, serif;">
                                    Este artigo foi útil?
                                </td>
                            </tr>
                            <?php
                                $query_lik  = "SELECT * FROM liking WHERE use_lik = ? AND post_lik = ?";
                                $stmt_lik   = $conexao->prepare($query_lik);
                                $stmt_lik->bind_param("ss", $id_user, $post_id);
                                $stmt_lik->execute();
                                $rs_lik     = $stmt_lik->get_result();
                                $nlik       = $rs_lik->num_rows;
                                if($nlik > 0){
                                    $infolik    = $rs_lik->fetch_assoc();
                                    $stmt_lik->close();

                                    $op = $infolik['op_lik'];
                                }
                                if($nlik == 0){
                            ?>
                            <tr>
                                <td width="33%" align="center"><a href="lik.php?i=<?=$post_id;?>&o=1"><img src="img/like.png" width="28"></a></td>
                                <td width="33%" align="center"><h3><?=$totutil_post?></h3></td>
                                <td width="33%" align="center"><a href="lik.php?i=<?=$post_id;?>&o=2"><img src="img/unlike.png" width="28"></a></td>
                            </tr>
                            <?php
                                }else{ ?>
                            <tr>
                                <td width="33%" align="center">
                                    <?php if($op == 2){ ?>
                                        <img src="img/unlike.png" width="28">
                                    <?php }elseif($op == 1){ ?>
                                        <img src="img/like.png" width="28">
                                    <?php } ?>
                                </td>
                                <td width="66%" colspan="2" align="center"><h3><?=$totutil_post?></h3></td>                        
                            </tr>
                        <?php   } ?>                
                    </table>
                    <font face="Georgia, Times New Roman, Times, serif" size="-1"> * Se o contador chegar a -10 o artigo ficará indisponível para leitura *</font>
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
                                <td width="85%"><input name="iu" type="hidden" id="iu" value="<?=$id_user?>">
                                    <input name="ie" type="hidden" id="ie" value="<?=$post_id?>">
                                    <input name="tip" type="hidden" id="tip" value="post" /></td>
                                <td width="11%" align="right"><input name="Envoyer" type="submit" value="Comentar" align="right"  style="-webkit-border-radius: 5px;
                                    -moz-border-radius: 5px;
                                    border-radius: 5px; width:100px; height:40px;">
                                </td>
                                <td width="3%">&nbsp;</td>
                            </tr>
                        </table>
                    </form>
            <!--- PUB ENDS ----------------->
            <!--- SHOW PUBLICATIONS -------->
                <table bgcolor="#e4e4e4" cellspacing="5" width="100%">
                    <?php
                        // Fetch comments for the post
                        $q_list10 = "SELECT * FROM comment WHERE tip_com = 'post' AND idpag_com = ? ORDER BY id_com ASC";
                        $stmt_list10 = $conexao->prepare($q_list10);
                        $stmt_list10->bind_param("s", $post_id);
                        $stmt_list10->execute();
                        $rs_list10 = $stmt_list10->get_result();
                        $nconfirmpub = $rs_list10->num_rows;
                        
                        if($nconfirmpub == 0){
                        ?>
                            <tr>
                                <td colspan="4" align="center">
                                    Não há nenhum comentário neste artigo!
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
                            $stmt_list11->bind_param("s", $creat_com);
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
                        <td align="left" colspan="2">
                            <?=$text_com?>
                            <?php
                            if($creat_com == $id_user){
                                ?>
                            <table style="vertical-align:bottom" border="0">
                                <tr>
                                    <td>(</td>
                                    <td>
                                        <form  method="post" action="delet_pub.php?a=pub">
                                            <input name="pi" type="hidden" id="pi" value="<?=$id_com?>">
                                            <input name="ie" type="hidden" id="ie" value="<?=$post_id?>">
                                            <input name="ui" type="hidden" id="ui" value="<?=$creat_com?>">
                                            <input name="tip" type="hidden" id="tip" value="post">
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
                        // Fetch and display replies to the comment
                        $q_list12    = "SELECT * FROM comment WHERE idpag_com = ? AND tip_com = 'post_com' ORDER BY id_com ASC";
                        $stmt_list12 = $conexao->prepare($q_list12);
                        $stmt_list12->bind_param("s", $id_com);
                        $stmt_list12->execute();
                        $rs_list12   = $stmt_list12->get_result();
                        $nconfirmcom = $rs_list12->num_rows;
                        
                        // If there are no replies
                        if($nconfirmcom != 0){
                            while($list12 = $rs_list12->fetch_assoc()){
                                                        
                            $id_comm	= $list12['id_com'];
                            $idpag_comm	= $list12['idpag_com'];
                            $creat_comm	= $list12['creat_com'];
                            $text_comm	= $list12['text_com'];

                            $q_list13 = "SELECT * FROM user WHERE id_user = ?";
                            $stmt_list13 = $conexao->prepare($q_list13);
                            $stmt_list13->bind_param("s", $creat_comm);
                            $stmt_list13->execute();
                            $rs_list13 = $stmt_list13->get_result();
                            $list13 = $rs_list13->fetch_assoc();
                            $stmt_list13->close();
                            
                            $photo_com	= $list13['photo_user'];
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
                                                <input name="tip" type="hidden" id="ie" value="<?=$post_id?>">
                                                <input name="tipu" type="hidden" id="tipu" value="post">
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
                                            -moz-box-shadow: 0 0 8px rgba(0, 0, 0, .8);"></a></td><td><font size="+6">:</font>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="66%" align="left">
                            <form action="post_publication.php?a=comment"  method="post">
                                <table width="90%" align="left" border="0">
                                    <tr>
                                        <td colspan="2">
                                            <textarea name="text_com" id="text_com" style="width: 80%; height:50px; margin: 0; padding: 0; border-width: 1; -webkit-border-radius: 5px;
                                            -moz-border-radius: 5px;
                                            border-radius: 10px; font-family:Verdana, Geneva, sans-serif;"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="52"><input name="ie" type="hidden" id="ie" value="post_com">
                                            <input type="hidden" value="<?=$id_com?>" name="ip" id="ip">
                                            <input type="hidden" value="<?=$post_id?>" name="im" id="im">
                                            <input type="hidden" value="<?=$id_user?>" name="iu" id="iu">      <input name="Envoyer" type="submit" value="Comentar" align="right" width="50px" height="20px">
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
<!---- FIM TABELA NOTICIAS --------------->
</td>
<td>&nbsp;</td>
</tr>
</table>
</body>
</html>