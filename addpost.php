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
    <td bgcolor="#FFFFFF" style="box-shadow: 0px 5px 15px #000;
" height="500" valign="top">
<!---- TABELA NOTICIAS --------------->
<table width="100%" border="0">
      <?php include ('headodm.php');?>
      </table>
      <script src="js/nicEdit-latest.js" type="text/javascript">
 
</script><br />
<script type="text/javascript">
bkLib.onDomLoaded(function() { new
nicEditor({buttonList : ['fontSize','fontFormat', 'bold', 'italic', 'underline', 'left', 'right', 'center', 'justify', 'ol', 'ul', 'indent', 'outdent', 'strikeThrough', 'subscript', 'superscript', 'xhtml', 'image', 'upload', 'arrow', 'link', 'unlink','forecolor','bgcolor']}).panelInstance('text_post'); });
</script>
<script languaje="javascript">
function Ok()
{
nicEditors.findEditor('text_post').saveContent();
document.formname.submit();
}
</script>
      <form action="postform.php?a=new" method="post">
      <table width="100%" border="0">
      <tr>
      <td>&nbsp;</td>
      <td align="left" valign="top">
      <font face="Georgia, Times New Roman, Times, serif"><h1><i>Novo post</i></h1></font>
      </td>
      <td>&nbsp;</td>
      </tr>
      <tr>
      <td>&nbsp;</td>
      <td align="left" valign="top">
      
        <input name="tit_post" id="tit_post" placeholder="Título" required="required" style="font-size:30px" />
<select name="cat_post" id="cat_post" style="font-size:30px">
  <option disabled="disabled" selected="selected">Categorias</option>
  <option value="nn">Notícias Nacionais</option>
  <option value="ni">Notícias Internacionais</option>
  <option value="c">Cursos</option>
  <option value="co">Concursos</option>
  <option value="uu">Utilidade Universitária</option>
  <option value="a">Anúncios</option>
  <option value="p">Política</option>
  <option value="hi">Humor Instrutivo</option>
  <option value="ri">RI</option>
  <option value="m">Notícias Mafiosas</option>
</select>
<font size="30px" title="Dúvida na categoria? Clica aqui"><a href="catdoubt.php" target="_blank">(?)</a></font>
      </td>
      <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="left" style="font-family:Georgia, 'Times New Roman', Times, serif;">
          <textarea name="text_post" cols="60" rows="20" id="text_post" placeholder="Texto do artigo" style="width:100%;"></textarea><br />
          <input name="creat_post" type="hidden" id="creat_post" value="<?=$id_user?>" />
          <input name="date_post" type="hidden" id="date_post" value="<?php echo date('Y-m-d');?>" />
          <br />
  </td>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
      <td>&nbsp;</td>
      <td align="left" style="font-family:Georgia, 'Times New Roman', Times, serif;"><input name="font_post" id="font_post" placeholder="Se houver fontes ponha-nas aqui!" style="font-size:30px; width:70%;" /></td>
      <td>&nbsp;</td>
      </tr>
      <tr>
      <td>&nbsp;</td>
      <td align="center" style="font-family:Georgia, 'Times New Roman', Times, serif;"><input name="Envoyer" type="submit" style="font-size:30px;" value="Postar" /></td>
      <td>&nbsp;</td>
      </tr>
      </table>

    </form>
<!---- FIM TABELA NOTICIAS --------------->
    </td>
    <td>&nbsp;</td>
  </tr>

</table>

</body>
</html>