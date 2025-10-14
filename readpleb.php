<?php
include('rest.php');
include('conectar.php');

$pleb_id = $_GET['i'] ?? '';

if(!isset($pleb_id) || empty($pleb_id) || !is_numeric($pleb_id)){
    header("Location: plebs.php");
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

// Fetch plebiscite information
$query_pleb = "SELECT * FROM plebs WHERE id_plebs = ?";
$stmt_pleb = $conexao->prepare($query_pleb);
$stmt_pleb->bind_param("i", $pleb_id);
$stmt_pleb->execute();
$rs_pleb = $stmt_pleb->get_result();
$plebinfo = $rs_pleb->fetch_assoc();
$npleb = $rs_pleb->num_rows;
$stmt_pleb->close();

if($npleb == 0){
    header("Location: plebs.php");
    exit;
}

$perg_pleb      = $plebinfo['perg_plebs'];
$creat_pleb	    = $plebinfo['creat_plebs'];
$date_pleb	    = new DateTime($plebinfo['date_plebs']);
$datef_pleb		= new DateTime($plebinfo['datef_plebs']);
$desc_pleb	    = $plebinfo['desc_plebs'];
$resp1			= $plebinfo['resp1_plebs'];
$resp2			= $plebinfo['resp2_plebs'];
$resp3			= $plebinfo['resp3_plebs'];
$resp4			= $plebinfo['resp4_plebs'];

// Fetch creator information
$query_creater = "SELECT * FROM user WHERE id_user = ?";
$stmt_creater = $conexao->prepare($query_creater);
$stmt_creater->bind_param("i", $creat_pleb);
$stmt_creater->execute();
$rs_creater = $stmt_creater->get_result();
$creatinfus = $rs_creater->fetch_assoc();
$stmt_creater->close();

$nome_creat     = $creatinfus['nome_user'];
$sobnome_creat  = $creatinfus['sobrenome_user'];
$sex_creat		= $creatinfus['sexo_user'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mi mafia, Tu mafia</title>
<link rel="stylesheet" href="css/geral.css" type="text/css" />
<script type="text/javascript">
function showMe (it, box) {
var vis = (box.checked) ? "block" : "none";
document.getElementById(it).style.display = vis;
}
</script>
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
" height="500" valign="top">
<!---- PLEBISCITE TABLE --------------->
<table width="100%" border="0">
      <tr>
      <td>&nbsp;</td>
      <td align="center" valign="top">
      <font face="Georgia, Times New Roman, Times, serif">
      <h1><i>&laquo;<?=$perg_pleb?>&raquo;</i></h1></font>
      </td>
      <td>&nbsp;</td>
      </tr>

      <tr>
      <td>&nbsp;</td>
      <td align="left" style="font-family:Georgia, 'Times New Roman', Times, serif; color:#000;"><p><i>Plebiscito N&deg; <?=$pleb_id?> criado em <?=$date_pleb->format('d/m/Y')?>, com <b><?php 
        $interval = $date_pleb->diff($datef_pleb);
        echo $interval->days;
	  ?> dias de duração</b> (até <?=$datef_pleb->format('d/m/Y')?>), <?php
      if($sex_creat == 'm'){
		  echo 'pelo Capo Signore';
	  }else{
		  echo 'pela Capo Signora';
	  }	  
	  ?> <a style="font-family:Georgia, 'Times New Roman', Times, serif; color:#000;" href="perfil.php?p=<?=$creat_pleb?>"><font style="text-transform:capitalize;"><?=$nome_creat?> <?=$sobnome_creat?></font></a><br />
      </i></p></td>
      <td>&nbsp;</td>
      </tr>
      <tr>
      <td>&nbsp;</td>
      <td align="left" bgcolor="#FFFF99" style="font-family:Georgia, 'Times New Roman', Times, serif;">
        <p align="center">Descrição:</p>
        <?=htmlspecialchars($desc_pleb);?><br /><br />
        </td>
      <td>&nbsp;</td>
      </tr>
      <tr>
      <td>&nbsp;</td>
      <td align="center" style="font-family:Georgia, 'Times New Roman', Times, serif;">
      <?php 
        // Check if user has already voted
        $query_vot = "SELECT * FROM votpleb WHERE idple_vtp = ? AND idus_vtp = ?";
        $stmt_vot = $conexao->prepare($query_vot);
        $stmt_vot->bind_param("ii", $pleb_id, $id_user);
        $stmt_vot->execute();
        $rs_vot = $stmt_vot->get_result();
        $nvot = $rs_vot->num_rows;
        $stmt_vot->close();

        if($nvot != 0){
	  ?>
        <!--- ALREADY VOTED AREA ------------------------>
        <table border="0" width="500">
            <tr>
                <td align="center">
                    <h2>Já votaste neste plebiscito!</h2>
                </td>
            </tr>
        </table>      
        <!--- ALREADY VOTED AREA ENDS ----------------->
      <?php }else{ ?>
        <!--- VOTE AREA --------------------------->
        <table border="0" width="500">
            <tr>
                <td colspan="2" align="center">
                    <h2>Escolhe:</h2>
                </td>
            </tr>
            <form action="votpleb.php" method="post">
                <tr>
                    <td>
                        <p>
                        <label>
                            <input required="required" type="radio" name="escolha" value="1" id="RadioGroup1_0" />
                            <?=$resp1?>
                        </label>
                        </p>
                    </td>
                    <td>
                        <label>
                            <input type="radio" name="escolha" value="2" id="RadioGroup1_1" />
                            <?=$resp2?>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php if($resp3 != ''){ ?>
                        <label>
                            <input type="radio" name="escolha" value="3" id="RadioGroup1_1" />
                            <?=$resp3?>
                        </label>
                        <?php } ?>
                    </td>
                    <td>
                        <?php if($resp4 != ''){ ?>
                        <label>
                            <input type="radio" name="escolha" value="4" id="RadioGroup1_1" />
                            <?=$resp4?>
                            </label>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <p><b><input required="required" name="check" type="checkbox" onclick="showMe('div1', this)" id="check" value="oui" />
                            <label for="check">Confirmo que é esta a opção que realmente escolhi</label></b>
                            <input name="id" type="hidden" id="id" value="<?=$pleb_id?>" />
                        </p>
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="2" style="font-family:Georgia, 'Times New Roman', Times, serif;">                    
                    <div id="div1" style="display:none">
                        <input name="Envoyer" type="submit" style="font-size:30px;" value="Votar" />
                    </div>
                    Ao confirmar a caixa acima o botão aparecerá</td>
                </tr>
            </form>
        </table>      
        <!--- VOTE AREA ENDS ---------------------->
      <?php } ?>
    </td>
    <td>&nbsp;</td>
</tr>
</table>
</td>
<td>&nbsp;</td>
</tr>
</table> 
<!---- PLEBISCITE TABLE ENDS --------------->
</td>
<td>&nbsp;</td>
</tr>
</table>
</body>
</html>