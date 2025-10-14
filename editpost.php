<?
include('rest.php');
include('conectar.php');

$post_id = $_GET['i'];

$query_guy = "SELECT * FROM user WHERE nickname_user = '$login_user'";
$rs_guy	= mysql_query($query_guy);
$infoguy	= mysql_fetch_array($rs_guy);
                        
$id_user	= $infoguy['id_user'];
$photo_user	= $infoguy['photo_user'];

$query_post = "SELECT * FROM posts WHERE id_post = '$post_id'";
$rs_post    = mysql_query($query_post);
	
$postinfo = mysql_fetch_array($rs_post);
$tit_post     = $postinfo['tit_post'];
$text_post    = $postinfo['text_post'];
$creat_post	   = $postinfo['creat_post'];
$date_post    = $postinfo['date_post'];
$area	  = $postinfo['cat_post'];
$font_post	  = $postinfo['font_post'];
$util_post	  = $postinfo['util_post'];
$inutil_post  = $postinfo['inutil_post'];
$totutil_post = $postinfo['totutil_post'];


$query_creat = "SELECT * FROM user WHERE id_user = '$creat_post'";
$rs_creat    = mysql_query($query_creat);
$creatinfus = mysql_fetch_array($rs_creat);

$nome_creat     = $creatinfus['nome_user'];
$sobnome_creat  = $creatinfus['sobrenome_user'];
$photo_creat    = $creatinfus['photo_user'];

include('areas.php');

if($id_user != $creat_post){
	 echo "<script language='JavaScript'>
location.href='readpost.php?i=$post_id';
</script>";
}else{
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
" height="50"><? include ('menu.php');?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td bgcolor="#FFFFFF" style="box-shadow: 0px 5px 15px #000;
" height="500" valign="top">
<!---- TABELA NOTICIAS --------------->
<table width="100%" border="0">
      <? include ('headodm.php');?>
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
      <form action="postform.php?a=edit" method="post">
      <table border="0" width="100%">
      <tr>
      <td>&nbsp;</td>
      <td align="left" valign="top">
      <input name="tit_post" id="tit_post" placeholder="Titulo" style="font-size:30px" value="<?=$tit_post?>" required="required" />
      <select name="cat_post" id="cat_post" style="font-size:30px">
      <option selected="selected" value="<?=$area;?>"><?=$area_text;?></option>
        <option disabled="disabled">Categorias</option>
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
          <textarea name="text_post" cols="60" rows="20" id="text_post" placeholder="Texto do artigo" style="width:100%;">
<?=$text_post;?></textarea><br />
  <input name="creat_post" type="hidden" id="creat_post" value="<?=$id_user?>" />
  <input name="id_post" type="hidden" id="id_post" value="<?=$post_id?>" />
  <br /></td>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
      <td>&nbsp;</td>
      <td align="left" style="font-family:Georgia, 'Times New Roman', Times, serif;">
      <input name="font_post" id="font_post" placeholder="Se houver fontes ponha-nas aqui!" value="<?=$font_post;?>" style="font-size:30px; width:70%;" />
     </td>
      <td>&nbsp;</td>
      </tr>
      <tr>
      <td>&nbsp;</td>
      <td align="center" style="font-family:Georgia, 'Times New Roman', Times, serif;"><input name="Envoyer" type="submit" style="font-size:30px;" value="Modificar" /></form><br />
<br />
<br />
<form  method="post" action="delet_post.php">
     
      <input name="ie" type="hidden" id="ie" value="<?=$post_id?>">

      <input name="Envoyer" type="submit" value="Deletar este artigo" style="background:#F00;" align="right" width="50px" height="20px">
    </form></td>
      <td>&nbsp;</td>
      </tr>
      </table>
      


<!---- FIM TABELA NOTICIAS ---------------></td>
<td>&nbsp;</td>
  </tr>

</table>

</body>
</html>
<? } ?>