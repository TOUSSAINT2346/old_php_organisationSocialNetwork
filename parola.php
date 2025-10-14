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

// Fetch Capo information
$query_capo = "SELECT * FROM capone_ger LIMIT 1";
$stmt_capo = $conexao->prepare($query_capo);
$stmt_capo->execute();
$rs_capo = $stmt_capo->get_result();
$num_capo = $rs_capo->num_rows;
if($num_capo != 0){
    $capoinfo = $rs_capo->fetch_assoc();
    $iduser_capo = $capoinfo['iduser_capger'];
}else{
    $iduser_capo = 0; // No Capo set
}
$stmt_capo->close();

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
    <td bgcolor="#c12a19" align="center" style="box-shadow: 0px 5px 15px #000;
" height="50"><?php include ('menu.php');?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td bgcolor="#FFFFFF" style="box-shadow: 0px 5px 15px #000;
" height="500" valign="top">
<!---- TABLE PAROLE --------------->
<table width="100%" border="0">      
    <tr>
        <td>&nbsp;</td>
        <td align="center" valign="top">
            <h1>Parole del Capo</h1>
        </td>
        <td>&nbsp;</td>
    </tr>
    <?php
        // Check if the user is the Capo
	    if($id_user == $iduser_capo){
	?>
    <tr>
        <td>&nbsp;</td>
        <td>
            <!--- PUBLICATION ------------->
            <form action="post_publication.php?a=capo" method="post" >
                <table bgcolor="#f5f5f5" width="100%" border="0">
                    <tr>
                        <td width="1%">&nbsp;</td>
                        <td colspan="2">
                        <b>Pronuncie-se, Capo:</b>
                        </td>
                    </tr>
                    <tr>
                        <td width="1%">&nbsp;</td>
                        <td colspan="2"><div id="wrapper"><textarea class="txt" name="text" id="text" tabindex="1" style="width: 100%; height:50px; margin: 0; padding: 0; border-width: 1; -webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 10px; font-family:Verdana, Geneva, sans-serif;"></textarea>
                            <p id="counter"><span>0</span> caracteres (100 total)</p>                            
                        </td>
                        <td width="3%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="1%">&nbsp;</td>
                        <td width="85%"><input name="iu" type="hidden" id="iu" value="<?=$id_user?>"></td>
                        <td width="11%" align="right"><input name="Envoyer" type="submit" value="Pronunciar-se" align="right"  style="-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px; width:100px; height:40px;">
                        </td>
                        <td width="3%">&nbsp;</td>
                    </tr>
                </table>
            </form>
            <!--- PUB ENDS ----------------->
        </td>
        <td>&nbsp;</td>
    </tr>
    <?php } ?>
<tr>
      <td>&nbsp;</td>
      <td align="left" valign="top">
      <h2>Últimas 20 parole dei Capi:</h2>
      </td>
      <td>&nbsp;</td>
      </tr>
      <tr>
      <td>&nbsp;</td>
      <td align="center">
      <?php
        $query_parole = "SELECT * FROM parola ORDER BY id_parola DESC LIMIT 20";
        $stmt_parole = $conexao->prepare($query_parole);
        $stmt_parole->execute();
        $rs_parole = $stmt_parole->get_result();
        $nparole = $rs_parole->num_rows;
        $stmt_parole->close();
        if($nparole == 0){
	  ?>
            <h3>Ainda não há nenhum pronunciamento del Capo!</h3>      
      <?php
        }else{
		    while($parole_info = $rs_parole->fetch_assoc()){	

                $text_parola	   = $parole_info['text_parola'];
                $creat_parola	   = $parole_info['creat_parola'];
	  
                $query_infcapo  = "SELECT * FROM user WHERE id_user = ?";
                $stmt_infcapo   = $conexao->prepare($query_infcapo);
                $stmt_infcapo->bind_param("i", $creat_parola);
                $stmt_infcapo->execute();
                $rs_infcapo = $stmt_infcapo->get_result();
                $capoinfus  = $rs_infcapo->fetch_assoc();
                $stmt_infcapo->close();

                $caponame     = $capoinfus['nome_user'];
                $caposobname  = $capoinfus['sobrenome_user'];
                $capophoto	  = $capoinfus['photo_user'];
                $caposexo	  = $capoinfus['sexo_user'];
	  ?>
      <table width="100%" border="0">
        <tr>
            <td align="center">
                <h3><i>"<?=$text_parola?>"</i></h3>
            </td>
        </tr>      
        <tr>
            <td align="right">
            <i>
                <?php
                    if($caposexo == 'm'){
                        echo 'Signore';
                    }else{
                        echo 'Signora';	
                    }
                ?>
                <?=$caponame?> <?=$caposobname?>
            </i>
            </td>
        </tr>
        <tr>
            <td><hr width="100%" size="1" />
        </tr>
    </table>            
    <?php } } ?>
</td>
<td>&nbsp;</td>
</tr>
</table>
</td>
<td>&nbsp;</td>
</tr>
</table>
<!---- TABLE PAROLE ENDS --------------->
</td>
<td>&nbsp;</td>
</tr>
</table>
</body>
</html>