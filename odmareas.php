<?php
include('rest.php');
include('conectar.php');

$area = $_GET['a'] ?? '';

include('areas.php');
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
      <td align="center" valign="top">
      <font face="Georgia, Times New Roman, Times, serif"><h1><i>&laquo; <?=$area_text?> &raquo;</i></h1></font>
      </td>
      <td>&nbsp;</td>
      </tr>
      <?php
        $query_popost = "SELECT * FROM posts WHERE cat_post = ? ORDER BY id_post DESC";
        $stmt_popost = $conexao->prepare($query_popost);
        $stmt_popost->bind_param("s", $area);
        $stmt_popost->execute();
        $rs_popost = $stmt_popost->get_result();
        $npopost = $rs_popost->num_rows;
        if($npopost == 0){
      ?>
      <tr>
      <td>&nbsp;</td>
      <td align="center" style="font-family:Georgia, 'Times New Roman', Times, serif;"><i>
      <h3>Ainda não há nenhum artigo nesta seção!</h3>
      </i>
      </td>
      <td>&nbsp;</td>
      </tr>
      <?php 
        }else{
		      while($popost_info = $rs_popost->fetch_assoc()){	
                $id_popost	     = $popost_info['id_post'];
                $tit_popost      = $popost_info['tit_post'];
                $creat_popost	   = $popost_info['creat_post'];
                $date_popost	   = $popost_info['date_post'];

                // Fetch information about the user who created the post
                $query_popostu = "SELECT * FROM user WHERE id_user = ?";
                $stmt_popostu = $conexao->prepare($query_popostu);
                $stmt_popostu->bind_param("s", $creat_popost);
                $stmt_popostu->execute();
                $rs_popostu = $stmt_popostu->get_result();
                $popostu_info = $rs_popostu->fetch_assoc();

                $photo_popost	   = $popostu_info['photo_user'] ?? 'back.png';
                $nom_popost		   = $popostu_info['nome_user'] ?? 'Sistema';
                $sobnom_popost	 = $popostu_info['sobrenome_user'] ?? '';
		  ?>
      <tr>
      <td>&nbsp;</td>
      <td>
      <table border="0" width="100%">
      <tr>
      <td style="font-family:Georgia, 'Times New Roman', Times, serif;" width="50%">
      <h3>
        <a href="readpost.php?i=<?=$id_popost;?>"><i><b>
        <?php      
          if($tit_popost == ''){
            echo 'Sem título';
          }else{
            echo $tit_popost;  
          }?>
        </b></i></a>
      </h3>
      </td>
      <td width="25%">
      <table border="0" width="100%">
      <tr>
      <td width="13%">
        <?php if($nom_popost != ''){ ?>
        <a href="<?=($creat_popost != 0) ? "perfil.php?p=$creat_popost" : "#"?>"><img src="photos/user/<?=$photo_popost;?>" alt="" style="width: 40px;
          height: 40px;
          border-radius: 40px;
          -webkit-border-radius: 50px;
          -moz-border-radius: 50px;
          background: url(photos/user/<?=$photo_popost?>);
          background-size:contain;
          box-shadow: 0 0 8px rgba(0, 0, 0, .8);
          -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);
          -moz-box-shadow: 0 0 8px rgba(0, 0, 0, .8);" />
        <?php } ?></a></td>    
      <td width="87%">
      <?php if($nom_popost == ''){ echo 'Sistema'; }else{ ?><font style="text-transform:capitalize;"><?=$nom_popost?> <?=$sobnom_popost?></font><?php } ?>
      </td>
      </tr>
      </table>      
      <td width="25%" align="center">
      <?=$date_popost;?>
      </td>
      </tr>
      </table>
      </td>  
      </tr>
      <?php
		  }
}
	  ?>
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