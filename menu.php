<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript">// <![CDATA[
$(document).ready(function() {
$.ajaxSetup({ cache: false }); 
setInterval(function() {
$('#divToRefresh').load('notfs.php');
}, 7000);
});
// ]]>
 $(function(){
    $("body").click(function(){
        $("#div_name").hide();
    });
})
</script>
<?php
// WHO'S CAPO?
$query_capuma   = "SELECT * FROM capone_ger ORDER BY id_capger DESC LIMIT 1";
$stmt_capuma    = $conexao->prepare($query_capuma);
$stmt_capuma->execute();
$result_capuma  = $stmt_capuma->get_result();
$capumainfus    = $result_capuma->fetch_assoc();
$stmt_capuma->close();

$id_capuma     = $capumainfus['iduser_capger'];

// WHO'S USER?
$query_useruma = "SELECT * FROM user WHERE nickname_user = ?";
$stmt_useruma  = $conexao->prepare($query_useruma);
$stmt_useruma->bind_param("s", $login_user);
$stmt_useruma->execute();
$result_useruma = $stmt_useruma->get_result();
$userumainfus  = $result_useruma->fetch_assoc();
$stmt_useruma->close();

$id_useruma     = $userumainfus['id_user'];
?>
<b><a href="pri.php">Home</a> | <a href="capo.php">Il Capo</a> | <a href="events.php">Eventos</a> | <a href="odmpri.php">ODM</a> | <a href="parola.php">Parola</a> | <a href="projectos.php">Projetos</a> | <?php
$query_plebum = "SELECT * FROM plebs WHERE vis_plebs = '0'";
$stmt_plebum  = $conexao->prepare($query_plebum);
$stmt_plebum->execute();
$rs_plebum    = $stmt_plebum->get_result();
$nplebum      = $rs_plebum->num_rows;

if($nplebum != 0 || $id_capuma == $id_useruma){
?> <a href="plebs.php">Plebiscitos</a> |<?php } ?> <a href="perfil.php">Perfil</a> | <span id="divToRefresh" ><a onmouseover="document.getElementById('div_name').style.display='';" 
href="" onclick="return false;" 
style="text-decoration:none; color:#000; border-bottom:0px;"><b>( 0 )</b></a>
<div id="div_name" style="width:430px; height:500px; padding:inherit;display:none; position:absolute; padding-left:500px;">
<table bgcolor="#FFFFFF" style="border:thick; border-width:thick;" border="1" width="100%">
<tr>
<td align="left">
<small style="font-family:Verdana, Geneva, sans-serif;">
Notificações
</small>
</td>
</tr>
<tr>
<td>
<table border="0" bgcolor="#FFF" width="100%">
<tr>
<td>
Carregando...
</td>
</tr>
</table>

</td>
</tr>
</table>
</div>
</span> | <a href="logout.php">Sair</a></b>