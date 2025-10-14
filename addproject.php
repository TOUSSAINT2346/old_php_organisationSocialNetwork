<?php
include('rest.php');
include('conectar.php');

$post_id = $_GET['i'] ?? '';

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
    <td bgcolor="#c12a19" align="center" style="box-shadow: 0px 5px 15px #000;
" height="50"><?php include ('menu.php');?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td bgcolor="#FFFFFF" style="box-shadow: 0px 5px 15px #000;" height="500" valign="top">
<!---- FORM TABLE --------------->
    <form action="postform.php?a=proj" method="post">
        <table width="100%" border="0">
            <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">
                    <h1><font face="Georgia, Times New Roman, Times, serif"><i>Novo projeto</i></font></h1>
                </td>
                <td>&nbsp;</td>
            </tr>
        <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">
                <input name="nome" id="nome" placeholder="Título" style="font-size:30px" />
                <font size="30px" title="Dúvida na categoria? Clica aqui"><a href="catdoubt.php" target="_blank"></a></font>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td align="left" style="font-family:Georgia, 'Times New Roman', Times, serif;">
                <b>* Descreva o projeto o máximo possível e argumente porque ele deveria ser aprovado. Quando o projeto é postado, ele não pode ser editado! Releia-o antes de postá-lo! *</b>
                <textarea name="teor" cols="60" rows="20" id="teor" placeholder="Texto do artigo" style="width:100%;"></textarea><br />
                <input name="creat" type="hidden" id="creat" value="<?=$id_user?>" />
                <input name="date" type="hidden" id="date" value="<?php echo date('Y-m-d');?>" />
                <input name="date_end" type="hidden" id="date_end" value="<?php 
                $enddate = (new DateTime())->modify('+5 days')->getTimestamp();
                echo date('Y-m-d', $enddate);?>" />
                <br />
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td align="center" style="font-family:Georgia, 'Times New Roman', Times, serif;">
                <input name="Envoyer" type="submit" style="font-size:30px;" value="Postar" />
            </td>
            <td>&nbsp;</td>
        </tr>
        </table>
    </form>
<!---- FORM TABLE ENDS --------------->
    </td>
    <td>&nbsp;</td>
  </tr>
</table>
<script src="js/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">
    bkLib.onDomLoaded(function() { new
        nicEditor({buttonList : ['fontSize','fontFormat', 'bold', 'italic', 'underline', 'left', 'right', 'center', 'justify', 'ol', 'ul', 'indent', 'outdent', 'strikeThrough', 'subscript', 'superscript', 'xhtml', 'image', 'upload', 'arrow', 'link', 'unlink','forecolor','bgcolor']}).panelInstance('teor'); });
    function Ok(){
        nicEditors.findEditor('teor').saveContent();
        document.formname.submit();
    }
</script>
</body>
</html>