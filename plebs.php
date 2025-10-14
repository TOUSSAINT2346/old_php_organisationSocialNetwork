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
        <!---- TABLE REFERENDA --------------->
        <table width="100%" border="0">
            <tr>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                    <h1>Plebiscitos</h1>
                </td>
                <td>&nbsp;</td>
            </tr>
            <?php if($id_capuma == $id_useruma){ ?>
            <tr>
                <td>&nbsp;</td>
                <td align="center" bgcolor="#CCCCFF">
                    <h4><a href="addpleb.php">&laquo; Criar um novo Plebiscito &raquo;</a></h4>
                </td>
                <td>&nbsp;</td>
            </tr>
            <?php } ?>
            <tr>
                <td>&nbsp;</td>
                <td>
                        <table border="0" cellpadding="1" cellspacing="1" width="100%">
                            <tr bgcolor="#CCCCCC">
                                <td colspan="4"><h2>Plebiscitos ativos</h2></td>
                            </tr>
                            <tr bgcolor="#CCCCCC">
                                <td align="center" width="40%">Título</td>
                                <td align="center" width="20%">Idealizador</td>
                                <td align="center" width="20%">Criado em</td>
                                <td align="center" width="20%">Fim de votação</td>
                            </tr>
                            <?php
                                $query_pleb = "SELECT * FROM plebs WHERE vis_plebs = ? ORDER BY id_plebs DESC";
                                $stmt_pleb  = $conexao->prepare($query_pleb);
                                $vis_plebs  = '0';
                                $stmt_pleb->bind_param("s", $vis_plebs);
                                $stmt_pleb->execute();
                                $rs_pleb    = $stmt_pleb->get_result();
                                $npleb      = $rs_pleb->num_rows;

                                if($npleb == 0){
                            ?>
                                <tr>
                                    <td colspan="4" align="center">
                                    <h3>Não há plebiscitos ativos! :/</h3>
                                    </td>
                                </tr>
                            <?php
                            }else{
                                while($plebinfo = $rs_pleb->fetch_assoc()){	

                                    $id_pleb	    = $plebinfo['id_plebs'];
                                    $perg_pleb      = $plebinfo['perg_plebs'];
                                    $creat_pleb	    = $plebinfo['creat_plebs'];
                                    $date_pleb	    = new DateTime($plebinfo['date_plebs']);
                                    $datef_pleb	    = new DateTime($plebinfo['datef_plebs']);

                                    $query_popostu  = "SELECT * FROM user WHERE id_user = ?";
                                    $stmt_popostu   = $conexao->prepare($query_popostu);
                                    $stmt_popostu->bind_param("i", $creat_pleb);
                                    $stmt_popostu->execute();
                                    $rs_popostu     = $stmt_popostu->get_result();
                                    $popostu_info   = $rs_popostu->fetch_assoc();

                                    $nom_popost     = $popostu_info['nome_user'];
                                    $sobnom_popost  = $popostu_info['sobrenome_user'];
                                    $sex_popost     = $popostu_info['sexo_user'];

                                    switch($sex_popost){
                                        case 'm':
                                            $tituluz = 'Signore';
                                        break;
                                        case 'f':
                                            $tituluz = 'Signora';
                                        break;
                                        default:
                                            $tituluz = 'Signore/a';
                                        break;
                                    }
                            ?>
                                    <tr>
                                        <td><a href="readpleb.php?i=<?=$id_pleb;?>"><?=$perg_pleb;?></a></td>
                                        <td>
                                            <?=$tituluz?> <a href="perfil.php?p=<?=$creat_pleb?>"><font style="text-transform:capitalize;"><?=$nom_popost;?>
                                            <?=$sobnom_popost?></font></a>
                                        </td>
                                        <td><?=$date_pleb->format('d/m/Y');?></td>
                                        <td><?=$datef_pleb->format('d/m/Y');?></td>
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
<!---- TABLE REFERENDA ENDS --------------->
</td>
<td>&nbsp;</td>
</tr>
</table>
</body>
</html>