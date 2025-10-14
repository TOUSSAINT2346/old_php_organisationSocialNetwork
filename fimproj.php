<?
include('conectar.php');
include('rest.php');

$hj = date('d/m/Y');

$query_prom = "SELECT * FROM projetos WHERE datf_proj = '$hj' AND sit_proj = 'vot'";
$rs_prom	= mysql_query($query_prom);
while($infoprom	= mysql_fetch_array($rs_prom)){

$id_projm	= $infoprom['id_proj'];
$creat_proj	= $infoprom['creat_proj'];
$dat_proj	= $infoprom['dat_proj'];

///VOTOS
$query_vots = "SELECT * FROM vot_proj WHERE idproj_vop = '$id_projm'";
$rs_vots	= mysql_query($query_vots);
$nvots  = mysql_num_rows($rs_vots);

$query_votsi = "SELECT * FROM vot_proj WHERE idproj_vop = '$id_projm' AND op_vop = '1'";
$rs_votsi	= mysql_query($query_votsi);
$nvotsi  = mysql_num_rows($rs_votsi);

$query_votn = "SELECT * FROM vot_proj WHERE idproj_vop = '$id_projm' AND op_vop = '2'";
$rs_votn	= mysql_query($query_votn);
$nvotn  = mysql_num_rows($rs_votn);

if($nvotsi != 0){
$perc_s = ($nvotsi * 100)/$nvots;
}else{
$perc_s = 0;	
}
if($nvotn != 0){
$perc_n = ($nvotn * 100)/$nvots;
}else{
$perc_n = 0;	
}
/// VOTOS ENDS

/////CHECA SE O MÍNIMO DE VOTOS FOI ATINGIDO
if($nvots < 5){
	
//////NÃO TEVE QUORUM ATUALIZA E POSTA

///CRIADOR
$query_projc = "SELECT * FROM user WHERE id_user = '$creat_proj'";
$rs_projc	= mysql_query($query_projc);
$infoprojc	= mysql_fetch_array($rs_projc);
                        
$nom_cre	= $infoprojc['nome_user'];
$sobnom_cre	= $infoprojc['sobrenome_user'];
///CRIADOR ENDS
	$mysql_query1 = mysql_query("UPDATE projetos SET sit_proj = 'Projeto <u>reprovado por falta de quórum</b>' WHERE id_proj = '$id_projm'") or die(mysql_error());
	
	$titu = 'Resultado do projeto N&deg; ' . $id_projm;

$textu = "<p><b>O Projeto foi <u>reprovado por falta de quórum</u></b><br></p>

  <br>
  <p>O projeto de N&deg; $id_projm, criado por $nom_cre $sobnom_cre, em $dat_proj, não alcançou o quórum mínimo estabelecido para aprovação de projetos. Fazendo-o, assim, ser reprovado.</p>";


$query2 = mysql_query("INSERT INTO posts(id_post,tit_post,text_post,creat_post,date_post,totutil_post,cat_post,font_post,vis_post) VALUES (NULL,'$titu','$textu',0,'$hj',0,'m','',0)") or die(mysql_error());


///////NOTIF QUERIES
$query_creat = "SELECT * FROM user WHERE id_user = '$creat_proj'";
$rs_creat    = mysql_query($query_creat);
$creatinfo = mysql_fetch_array($rs_creat);

$id_creaza     = $creatinfo['id_user'];

$query_post = "SELECT * FROM posts WHERE tit_post = '$titu' AND creat_post = '0'";
$rs_post    = mysql_query($query_post);
$eventpost = mysql_fetch_array($rs_post);

$id_post     = $eventpost['id_post'];

$txt = 'Teu projeto foi reprovado por falta de quórum! :(<br>Clica aqui para ler a decisão!';

$link = 'readpost.php?i=' . $id_post;

$hoj = date('d/m/Y');
$hor = date('G:i');

$notpost = mysql_query("INSERT INTO notifs(id_not,iduse_not,msg_not,link_not,date_not,hor_not,sit_not) VALUES(NULL,'$id_creaza','$txt','$link','$hoj','$hor','0')");

///////NOTIF QUERIES
	
}else{
///OBTEVE QUÓRUM NECESSÁRIO

/////CHECA SE TEVE + 50% CONTRA
if($perc_n > 50){
	////TEVE MAIS DE 50% CONTRA ATUALIZA E POSTA
	
	///CRIADOR
$query_projc = "SELECT * FROM user WHERE id_user = '$creat_proj'";
$rs_projc	= mysql_query($query_projc);
$infoprojc	= mysql_fetch_array($rs_projc);
                        
$nom_cre	= $infoprojc['nome_user'];
$sobnom_cre	= $infoprojc['sobrenome_user'];
///CRIADOR ENDS
	$mysql_query1 = mysql_query("UPDATE projetos SET sit_proj = 'Projeto <u>reprovado pelo resultado popular</b>' WHERE id_proj = '$id_projm'") or die(mysql_error());
	
	$titu = 'Resultado do projeto N&deg; ' . $id_projm;

$textu = "<p><b>O Projeto foi <u>reprovado pelo resultado popular</u></b><br></p>

  <br>
  <p>O projeto de N&deg; $id_projm, criado por $nom_cre $sobnom_cre, em $dat_proj, obteve mais de 50% de votos negativos na consulta popular. Fazendo-o, assim, ser reprovado.</p>";


$query2 = mysql_query("INSERT INTO posts(id_post,tit_post,text_post,creat_post,date_post,totutil_post,cat_post,font_post,vis_post) VALUES (NULL,'$titu','$textu',0,'$hj',0,'m','',0)") or die(mysql_error());

///////NOTIF QUERIES
$query_creat = "SELECT * FROM user WHERE id_user = '$creat_proj'";
$rs_creat    = mysql_query($query_creat);
$creatinfo = mysql_fetch_array($rs_creat);

$id_creaza     = $creatinfo['id_user'];

$query_post = "SELECT * FROM posts WHERE tit_post = '$titu' AND creat_post = '0'";
$rs_post    = mysql_query($query_post);
$eventpost = mysql_fetch_array($rs_post);

$id_post     = $eventpost['id_post'];

$txt = 'Teu projeto foi reprovado pela consulta popular! :/<br>Clica aqui para ler a decisão!';

$link = 'readpost.php?i=' . $id_post;

$hoj = date('d/m/Y');
$hor = date('G:i');

$notpost = mysql_query("INSERT INTO notifs(id_not,iduse_not,msg_not,link_not,date_not,hor_not,sit_not) VALUES(NULL,'$id_creaza','$txt','$link','$hoj','$hor','0')");

///////NOTIF QUERIES

mysql_close($conexao);
	
}else{
	///OBTEVE QUÓRUM E MENOS DE 50% DE REPROVAÇÃO ATUALIZA STATUS
	
	$mysql_query1 = mysql_query("UPDATE projetos SET sit_proj = 'esp' WHERE id_proj = '$id_projm'") or die(mysql_error());
	
	///////NOTIF QUERIES
$query_creat = "SELECT * FROM user WHERE id_user = '$creat_proj'";
$rs_creat    = mysql_query($query_creat);
$creatinfo = mysql_fetch_array($rs_creat);

$id_creaza     = $creatinfo['id_user'];

$txt = 'Teu projeto foi submetido al Capo!<br>!';

$link = '#';

$hoj = date('d/m/Y');
$hor = date('G:i');

$notpost = mysql_query("INSERT INTO notifs(id_not,iduse_not,msg_not,link_not,date_not,hor_not,sit_not) VALUES(NULL,'$id_creaza','$txt','$link','$hoj','$hor','0')");

///////NOTIF QUERIES
	
}
}

}
?>