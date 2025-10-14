<?
include('conectar.php');

$query_newcapo = "SELECT * FROM capone_reg ORDER BY votos_capreg DESC LIMIT 1";
$rs_newcapo	= mysql_query($query_newcapo);
$infonewcapo	= mysql_fetch_array($rs_newcapo);
                        
$id_newcapo	= $infonewcapo['idcand_capreg'];

$query_savencapo = mysql_query("INSERT INTO capone_ger(id_capger,iduser_capger) VALUES (NULL,'$id_newcapo')") or die(mysql_error());

$query_capo = "SELECT * FROM user WHERE id_user = '$id_newcapo'";
$rs_capo	= mysql_query($query_capo);
$infocapo	= mysql_fetch_array($rs_capo);
                        
$id_capo	= $infocapo['id_user'];
$nome_capom	= $infocapo['nome_user'];
$snome_capom	= $infocapo['sobrenome_user'];
$sexo_capom = $infocapo['sexo_user'];

if($sexo_capom == 'm'){
	$sex_capu = 'Signore';
}else{
	$sex_capu = 'Signora';
}

$query_votos = "SELECT * FROM votos";
$rs_votos	= mysql_query($query_votos);
$nvoto  = mysql_num_rows($rs_votos);
                        
$id_newcapo	= $infonewcapo['idcand_capreg'];

$query_cands = "SELECT * FROM capone_reg ORDER BY votos_capreg DESC LIMIT 5";
$rs_cands	= mysql_query($query_cands);

$text .= "Resultado da última eleição para Capo:<br><br>


  <b>Total de votos: $nvoto</b><br>

  <br>";
                        
while($info_cands	= mysql_fetch_array($rs_cands)){
	$id_cand	= $info_cands['idcand_capreg'];
	$vots_cand	= $info_cands['votos_capreg'];
	
	$query_cand = "SELECT * FROM user WHERE id_user = '$id_cand'";
$rs_cand	= mysql_query($query_cand);
$infocand	= mysql_fetch_array($rs_cand);

$percentvots = ($vots_cand * 100)/$nvoto;
                        
$nome_cand	= $infocand['nome_user'];
$sobnome_cand	= $infocand['sobrenome_user'];

$text .= '<li>' . $nome_cand . ' ' . $sobnome_cand . ' - ' . $vots_cand . ' voto(s) (' . $percentvots . '%).</li>';
}

$text .= "<br>
O novo Capo fica sendo doravante por um mês:<br><br>

<h2 align=center><a href=perfil.php?p=$id_capo><b>" . $sex_capu . " " . $nome_capom . " " . $snome_capom . "</b></a></h2>";

$hj = date('d/m/Y');
$hor = date('G:i');

$query_postresul = mysql_query("INSERT INTO posts(id_post,tit_post,text_post,creat_post,date_post,totutil_post,cat_post,font_post,vis_post,util_post,inutil_post) VALUES (NULL,'Resultados da Eleição - Capo','$text',0,'$hj',0,'m','',0,0,0)") or die(mysql_error());

$txt = 'Foste eleito Capo! Parabéns!!';

$query_notfresul = mysql_query("INSERT INTO notifs(id_not,iduse_not,msg_not,link_not,date_not,hor_not,sit_not) VALUES(NULL,'$id_newcapo','$txt','#','$hj','$hor','0')") or die(mysql_error());

mysql_close($conexao);

?>