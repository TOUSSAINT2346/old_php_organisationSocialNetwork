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
<!---- TABLE PROJECTS --------------->
<table width="100%" border="0">
      <tr>
      <td>&nbsp;</td>
      <td align="center" valign="top">
      <h1>Projetos</h1>
      </td>
      <td>&nbsp;</td>
      </tr>
      <tr>
      <td>&nbsp;</td>
      <td align="left">
      <h4><a href="addproject.php">&laquo; Criar um projeto &raquo;</a></h4>      
      </td>
      <td>&nbsp;</td>
      </tr>
      <tr>
      <td>&nbsp;</td>
      <td>
      <table border="0" cellpadding="1" cellspacing="1" width="100%">
      <tr bgcolor="#CCCCCC">
      <td colspan="4"><h2>Últimos projetos</h2></td>
      </tr>
      <tr bgcolor="#CCCCCC">
      <td align="center" width="40%">Título</td>
      <td align="center" width="20%">Situação</td>
      <td align="center" width="20%">Criador</td>
      <td align="center" width="20%">Criação</td>
      </tr>
      <?php
        // Fetch projects
        $query_proj = "SELECT id_proj, nome_proj, sit_proj, dat_proj, creat_proj FROM projetos ORDER BY id_proj DESC";
        $stmt_proj = $conexao->prepare($query_proj);
        $stmt_proj->execute();
        $rs_proj = $stmt_proj->get_result();
        $nproj = $rs_proj->num_rows;

        if($nproj == 0){
        ?>
        <tr>
        <td colspan="4" align="center">
        <h3>Ainda não há nenhum projeto! :/</h3>
        </td>
        </tr>
        <?php
        }else{
		    while($projinfo = $rs_proj->fetch_assoc()){	

                $id_proj    = $projinfo['id_proj'];
                $nome_proj  = $projinfo['nome_proj'];
                $sit_proj   = $projinfo['sit_proj'];
                $dat_proj   = $projinfo['dat_proj'];
                $creat_proj = $projinfo['creat_proj'];

                // Fetch creator information
                $query_popostu  = "SELECT nome_user, sobrenome_user FROM user WHERE id_user = ?";
                $stmt_popostu   = $conexao->prepare($query_popostu);
                $stmt_popostu->bind_param("i", $creat_proj);
                $stmt_popostu->execute();
                $rs_popostu     = $stmt_popostu->get_result();
                $popostu_info   = $rs_popostu->fetch_assoc();

                $nom_popost     = $popostu_info['nome_user'];
                $sobnom_popost  = $popostu_info['sobrenome_user'];
		?>
      <tr>
      <td><a href="readproject.php?i=<?=$id_proj;?>"><?=$nome_proj;?></a></td>
      <td><?php
	    if($sit_proj == 'vot'){
            echo 'Em processo de votação';            
        }elseif($sit_proj == 'esp'){
            echo 'Esperando julgamento del Capo';
        }else{
            echo $sit_proj;
        }
	  ?></td>
      <td><a href="perfil.php?p=<?=$creat_proj?>"><font style="text-transform:capitalize;"><?=$nom_popost;?> <?=$sobnom_popost?></font></a></td>
      <td><?=$dat_proj?></td>
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
      </td>
      <td>&nbsp;</td>
      </tr>
    </table>
<!---- TABLE PROJECTS ENDS --------------->
    </td>
    <td>&nbsp;</td>
  </tr>

</table>

</body>
</html>