<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>
function UpdateRecord(id){
    jQuery.ajax({
        type: "POST",
        url: "updatenot.php",
        cache: false,
    });
}
$(function(){
    $("body").click(function(){
        $("#div_name").hide();
    });
});
</script>
<?php
include('conectar.php');
include('rest.php');

// WHO'S USER?
$query_useruma  = "SELECT * FROM user WHERE nickname_user = ?";
$stmt_useruma   = $conexao->prepare($query_useruma);
$stmt_useruma->bind_param("s", $login_user);
$stmt_useruma->execute();
$rs_useruma     = $stmt_useruma->get_result();
$userumainfus   = $rs_useruma->fetch_array();
$stmt_useruma->close();

$id_useruma     = $userumainfus['id_user'];

// LOOKS FOR NOTIFICATIONS
$query_notif  = "SELECT * FROM notifs WHERE iduse_not = ? AND sit_not = '0'";
$stmt_notif   = $conexao->prepare($query_notif);
$stmt_notif->bind_param("i", $id_useruma);
$stmt_notif->execute();
$rs_notif     = $stmt_notif->get_result();
$num_badges   = $rs_notif->num_rows;

// IF NO NOTIFICATIONS
if($num_badges == 0){
?>
    <a onmouseover="document.getElementById('div_name').style.display='';" href="" onclick="return false;" style="text-decoration:none; color:#000; border-bottom:0px;"><b>( 0 )</b></a>
    <?php
// IF THERE ARE NOTIFICATIONS
}else{
?>
    <a onmouseover="document.getElementById('div_name').style.display=''; UpdateRecord(1);" href="" onclick="return false;" style="text-decoration:none; color:#000; border-bottom:0px;">
        <font color="#FF0000"><b>( <?=$num_badges?> )</b></font>
    </a>
<?php
}
?>
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
                <?php
                    // LIST NOTIFICATIONS
                    $query_notifst  = "SELECT * FROM notifs WHERE iduse_not = ? ORDER BY id_not DESC";
                    $stmt_notifst   = $conexao->prepare($query_notifst);
                    $stmt_notifst->bind_param("i", $id_useruma);
                    $stmt_notifst->execute();
                    $rs_notifst = $stmt_notifst->get_result();
                    $notifsnum  = $rs_notifst->num_rows;

                    // IF THERE ARE NOTIFICATIONS
                    if($notifsnum != 0){

                        while($notinfo = $rs_notifst->fetch_array()){
                            $text       = $notinfo['msg_not'];
                            $link		= $notinfo['link_not'];
                            $date		= $notinfo['date_not'];
                            $hor		= $notinfo['hor_not'];
                            $vis		= $notinfo['sit_not'];
                    ?>
                        <table border="0" bgcolor="<?=($vis == 1) ? '#FFF' : '#EDEFF5';?>" width="100%">
                            <tr>
                                <td>
                                    <table border="0" width="100%">
                                        <tr>
                                            <td>
                                                <a onmouseover="UpdateRecord(1);" href="<?=$link;?>">
                                                    <h4><?=$text;?></h4>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <small><?=$date?> | <?=$hor;?></small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <hr width="100%" size="1" />
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    <?php
                        }
                    // IF THERE ARE NO NOTIFICATIONS
                    }else{
                        ?>
                        <table border="0" bgcolor="#FFF" width="100%">
                            <tr>
                                <td>
                                    Não há novas notificações para ti :(
                                </td>
                            </tr>
                        </table>
                <?php
                    }
                ?>
            </td>
        </tr>
    </table>
</div>