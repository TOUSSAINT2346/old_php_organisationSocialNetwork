<?
include('conectar.php');

$hj = date('d/m/Y');

$mysql_query1 = mysql_query("UPDATE plebs SET vis_plebs = '1' WHERE datef_plebs = '$hj' AND vis_plebs = '0'") or die(mysql_error());

$query_ple = "SELECT * FROM plebs WHERE datef_plebs = '$hj'";
$rs_ple	= mysql_query($query_ple);
while($infople	= mysql_fetch_array($rs_ple)){
                        
$id_pleb	= $infople['id_plebs'];
$date_pleb	= $infople['date_plebs'];
$datef_pleb	= $infople['datef_plebs'];
$creat_pleb	= $infople['creat_plebs'];
$perg_pleb	= $infople['perg_plebs'];
$r1_pleb	= $infople['resp1_plebs'];
$r2_pleb	= $infople['resp2_plebs'];
$r3_pleb	= $infople['resp3_plebs'];
$r4_pleb	= $infople['resp4_plebs'];

$query_capo = "SELECT * FROM user WHERE id_user = '$creat_pleb'";
$rs_capo	= mysql_query($query_capo);
$infocapo	= mysql_fetch_array($rs_capo);

$nome_capo = $infocapo['nome_user'];
$snome_capo = $infocapo['sobrenome_user'];
$sex_capo	= $infocapo['sexo_user'];

switch($sex_capo){
	case 'm':
		$bym	= 'pelo Capo Signore';
	break;
	case 'f':
		$bym	= 'pela Capo Signora';
	break;
}
///CONTA VOTOS TOTAIS
$query_vott = "SELECT * FROM votpleb WHERE idple_vtp = '$id_pleb'";
$rs_vott	= mysql_query($query_vott);
$nvott  = mysql_num_rows($rs_vott);

if($nvott != 0){
	$per = 1;
}
///CONTA VOTOS 1
$query_vot1 = "SELECT * FROM votpleb WHERE idple_vtp = '$id_pleb' AND resp_vtp = '1'";
$rs_vot1	= mysql_query($query_vot1);
$nvot1  = mysql_num_rows($rs_vot1);

if($per == 1){
	$per1 = ($nvot1 * 100)/$nvott;
}
$rez1 = '<li>' .$r1_pleb . ' - ' . $per1 . '% (' . $nvot1 . ' voto(s))</li>';
///CONTA VOTOS 2
$query_vot2 = "SELECT * FROM votpleb WHERE idple_vtp = '$id_pleb' AND resp_vtp = '2'";
$rs_vot2	= mysql_query($query_vot2);
$nvot2  = mysql_num_rows($rs_vot2);

if($per == 1){
	$per2 = ($nvot2 * 100)/$nvott;
}
$rez2 = '<li>' .$r2_pleb . ' - ' . $per2 . '% (' . $nvot2 . ' voto(s))</li>';
///CONTA VOTOS 3
$query_vot3 = "SELECT * FROM votpleb WHERE idple_vtp = '$id_pleb' AND resp_vtp = '3'";
$rs_vot3	= mysql_query($query_vot3);
$nvot3  = mysql_num_rows($rs_vot3);

if($per == 1){
	$per3 = ($nvot3 * 100)/$nvott;
}
if($r3_pleb != ''){
$rez3 = '<li>' .$r3_pleb . ' - ' . $per3 . '% (' . $nvot3 . ' voto(s))</li>';
}else{
$rez3 = '';	
}
///CONTA VOTOS 4
$query_vot4 = "SELECT * FROM votpleb WHERE idple_vtp = '$id_pleb' AND resp_vtp = '4'";
$rs_vot4	= mysql_query($query_vot4);
$nvot4  = mysql_num_rows($rs_vot4);

if($per == 1){
	$per4 = ($nvot4 * 100)/$nvott;
}
if($r4_pleb != ''){
$rez4 = '<li>' .$r4_pleb . ' - ' . $per4 . '% (' . $nvot4 . ' voto(s))</li>';
}else{
$rez4 = '';	
}
///DURAÇÃO
$exdate = explode('/', $date_pleb);
	  $day_d	= $exdate[0];
	  $mon_d	= $exdate[1];
	  $yea_d	= $exdate[2];
	  $date_d	= $yea_d . '/' . $mon_d . '/' . $day_d;
	  
	  $exdatef = explode('/', $datef_pleb);
	  $day_df	= $exdatef[0];
	  $mon_df	= $exdatef[1];
	  $yea_df	= $exdatef[2];
	  $date_df	= $yea_df . '/' . $mon_df . '/'
 . $day_df;	  
	  $startTimeStamp = strtotime($date_d);
		$endTimeStamp = strtotime($date_df);
	  
	  $timeDiff = abs($endTimeStamp - $startTimeStamp);

$numberDays = $timeDiff/86400;

$dur = intval($numberDays);
///DURAÇÃO FIM

$titu = 'Resultado do Plebiscito N&deg;' .$id_pleb;
$textu = '<p>O Plebiscito N&deg; ' . $id_pleb . ', criado em ' .$date_pleb . ' ' . $bym . ' ' . $nome_capo . ' ' .  $snome_capo . ', com duração de ' . $dur . ' dias, tendo findado hoje (' . $datef_pleb . ') submeteu a seguinte questão aos mafiosos:</p>
<h2>&laquo; ' . $perg_pleb . ' &raquo;</h2>
<p>Contabilizando um total de ' . $nvott . ' voto(s), os resultados foram os seguintes:</p>
<ul>
' . $rez1 . '
' . $rez2 . '
' . $rez3 . '
' . $rez4 . '
</ul>
<p>Lembrando que para que um plebiscito seja válido há-de haver um mínimo de 10 votos!</p>
';

$query_postresul = mysql_query("INSERT INTO posts(id_post,tit_post,text_post,creat_post,date_post,totutil_post,cat_post,font_post,vis_post,util_post,inutil_post) VALUES (NULL,'$titu','$textu',0,'$hj',0,'m','',0,0,0)") or die(mysql_error());

}



?>