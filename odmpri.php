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
                <?php include ('headodm.php');?>
                <tr>
                    <td>&nbsp;</td>
                    <td align="center">
                        <!---- TABELA POSTS ----->
                        <table width="100%" cellpadding="1" cellspacing="1">
                            <tr>
                                <td valign="top" width="66%" colspan="2" align="left">
                                    <font face="Georgia, Times New Roman, Times, serif"><h2><i>Últimos Posts</i></h2></font>
                                    <table border="0" width="100%">
                                        <tr>
                                        <?php		
                                        // Look for last 3 posts
                                            $query_posts    = "SELECT * FROM posts ORDER BY id_post DESC LIMIT 3";
                                            $stmt_posts     = $conexao->prepare($query_posts);
                                            $stmt_posts->execute();
                                            $rs_posts   = $stmt_posts->get_result();
                                            $nposts     = $rs_posts->num_rows;

                                        if($nposts == 0){
                                        ?>
                                        <br />
                                            <b>Ainda não há nenhum post! :|</b>
                                        <?php 
                                        }else{
                                            while($postinfo = $rs_posts->fetch_assoc()){

                                            $id_post    = $postinfo['id_post'];
                                            $tit_post   = $postinfo['tit_post'];
                                            $text_post  = $postinfo['text_post'];
                                            $cat_post   = $postinfo['cat_post'];
                                        ?>
                                            <td valign="top" bgcolor="#FFFFFF" align="left" width="33%">
                                                <a style="font-family:Georgia, 'Times New Roman', Times, serif;" href="readpost.php?i=<?=$id_post;?>">
                                                <h4><b>
                                                <i>
                                                <?php
                                                    if($tit_post == ''){
                                                        echo 'Sem título';
                                                    }else{
                                                        echo $tit_post;
                                                    }
                                                ?>
                                                </i>
                                                </b></h4>
                                                </a> ...<br />
                                                <a href="readpost.php?i=<?=$id_post;?>"><b><i>Saiba +</i></b></a>
                                            </td>
                                        <?php }
                                        } ?>
                                        </tr>
                                    </table>
                                </td>
                                <td width="33%" align="center">
                                    <h2><font face="Georgia, Times New Roman, Times, serif"><b><i>&laquo; <a href="addpost.php">Faz um novo post!</a> &raquo;</i></b></font></h2>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <hr width="100%" size="1" color="#CCCCCC" />
                                    <hr width="100%" size="2" color="#CCCCCC" />
                                </td>
                            </tr>
                            <tr>
                                <?php
                                // Defines all areas in an array
                                $area_texts = [
                                    'nn' => 'Notícias Nacionais',
                                    'ni' => 'Notícias Internacionais',
                                    'c'  => 'Cursos',
                                    'co' => 'Concursos',
                                    'uu' => 'Utilidade Universitária',
                                    'a'  => 'Anúncios',
                                    'p'  => 'Política',
                                    'hi' => 'Humor Instrutivo',
                                    'ri' => 'RI',
                                    'm'  => 'Notícias Mafiosas',
                                ];
                                $i = 0;
                                foreach($area_texts as $area_code => $area_name) {
                                    $i++;
                                ?>
                                    <!--- SEC <?=strtoupper($area_name);?> --->
                                    <td width="33%" align="left" valign="top">
                                        <font face="Georgia, Times New Roman, Times, serif"><h2><i>Seção <?=$area_name;?></i></h2></font>
                                        <table border="0" width="100%">
                                            <?php
                                                $query_popost = "SELECT * FROM posts WHERE cat_post = ? ORDER BY id_post DESC LIMIT 5";
                                                $stmt_popost = $conexao->prepare($query_popost);
                                                $stmt_popost->bind_param("s", $area_code);
                                                $stmt_popost->execute();
                                                $rs_popost = $stmt_popost->get_result();
                                                $npopost = $rs_popost->num_rows;

                                                // Check if there are no posts in this category
                                                if($npopost == 0){
                                                ?>
                                                <tr>
                                                    <td colspan="2" style="font-family:Georgia, 'Times New Roman', Times, serif">
                                                        Ainda não há nenhum artigo nesta seção!
                                                    </td>
                                                </tr>
                                            <?php
                                                }else{ 
                                                    while($popost_info = $rs_popost->fetch_assoc()){

                                                        $id_popost	= $popost_info['id_post'];
                                                        $tit_popost = $popost_info['tit_post'];
                                                        $creat_popost = $popost_info['creat_post'];

                                                        $query_popostu = "SELECT * FROM user WHERE id_user = ?";
                                                        $stmt_popostu = $conexao->prepare($query_popostu);
                                                        $stmt_popostu->bind_param("s", $creat_popost);
                                                        $stmt_popostu->execute();
                                                        $rs_popostu = $stmt_popostu->get_result();
                                                        $popostu_info = $rs_popostu->fetch_assoc();

                                                        $photo_popost = $popostu_info['photo_user'] ?? 'back.png';
                                                ?>
                                                    <tr>
                                                        <td width="82%" style="font-family:Georgia, 'Times New Roman', Times, serif">
                                                            <a href="readpost.php?i=<?=$id_popost;?>"><i><b><?=$tit_popost;?></b></i></a>
                                                        </td>
                                                        <td width="18%">
                                                            <a href="<?=($creat_popost == 0) ? '#' : 'perfil.php?p=' . $creat_popost; ?>"><img src="photos/user/<?=$photo_popost;?>" alt="" style="width: 40px;
                                                            height: 40px;
                                                            border-radius: 40px;
                                                            -webkit-border-radius: 50px;
                                                            -moz-border-radius: 50px;
                                                            background: url(photos/user/<?=$photo_popost?>);
                                                            background-size:contain;
                                                            box-shadow: 0 0 8px rgba(0, 0, 0, .8);
                                                            -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);
                                                            -moz-box-shadow: 0 0 8px rgba(0, 0, 0, .8);" /></a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <hr width="90%" size="1" color="#CCCCCC" />
                                                        </td>
                                                    </tr>
                                                <?php
                                                    }
                                                }
                                            ?>
                                        </table>
                                        <!----- END <?=strtoupper($area_name);?> SEC ----------->
                                        </td>
                                <?php
                                    if($i % 3 == 0) {
                                        echo '</tr><tr>'; // Start a new row after every 3 areas
                                    }
                                }
                                ?>
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