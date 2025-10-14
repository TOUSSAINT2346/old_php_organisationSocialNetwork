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

$query_capo = "SELECT * FROM capone_ger LIMIT 1";
$stmt_capo  = $conexao->prepare($query_capo);
$stmt_capo->execute();
$rs_capo    = $stmt_capo->get_result();
$capinfus   = $rs_capo->fetch_array();
$stmt_capo->close();

$id_capo    = $capinfus['iduser_capger'];

if($id_user != $id_capo){
    header("Location: pri.php");
    exit;
}

$hoje_data = new DateTime();
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
        <td bgcolor="#c12a19" align="center" style="box-shadow: 0px 5px 15px #000;" height="50"><?php include ('menu.php');?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td bgcolor="#FFFFFF" style="box-shadow: 0px 5px 15px #000;" height="500" valign="top">
        <!---- TABLE REFERENDA --------------->
        <form action="postform.php?a=pleb" method="post">
            <table width="100%" border="0">
                <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">
                        <h1><font face="Georgia, Times New Roman, Times, serif"><i>Novo plebiscito</i></font></h1>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">      
                        <input name="pergunta" id="pergunta" placeholder="Pergunta" required="required" style="font-size:30px" />
                        <font size="30px" title="Dúvida na categoria? Clica aqui"><a href="catdoubt.php" target="_blank"></a></font>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="left" style="font-family:Georgia, 'Times New Roman', Times, serif;">
                        <p align="center"><b style="color:#F00;">* SÊ O MAIS <u>SUCINTO</u> POSSÍVEL NA DESCRIÇÃO DO PLEBISCITO! QUANDO O PLEBISCITO É CRIADO ELE NÃO PODE SER EDITADO! POR FAVOR APENAS CRIA PLEBISCITOS SE FOREM REALMENTE NECESSÁRIOS! *</b></p>
                        <textarea name="desc" cols="60" rows="10" id="desc" placeholder="Texto do artigo" style="width:100%;"></textarea><br />
                        <input name="creat" type="hidden" id="creat" value="<?=$id_user?>" />
                        <input name="date" type="hidden" id="date" value="<?php echo $hoje_data->format('Y-m-d');?>" />
                        <br />
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="center" style="font-family:Georgia, 'Times New Roman', Times, serif;">
                        <table border="0" width="500">
                            <tr>
                                <td align="center" colspan="2">
                                    O plebiscito pode ter de 2 a 4 opções de escolha! Certifica-te que deixaste pelo menos 2 opções para escolha (seguindo a ordem)! <strong>É obrigatório o preenchimento das caixas "1a Opção" e "2a Opção"</strong>
                                </td>
                            </tr>
                            <tr>
                                <td><input name="resp1" id="resp1" placeholder="1a Opção" style="font-size:30px" required="required" /></td>
                                <td><input name="resp2" id="resp2" placeholder="2a Opção" style="font-size:30px" required="required" /></td>
                            </tr>
                            <tr>
                                <td><input name="resp3" id="resp3" placeholder="3a Opção" style="font-size:30px" /></td>
                                <td><input name="resp4" id="resp4" placeholder="4a Opção" style="font-size:30px" /></td>
                            </tr>
                        </table>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="center" style="font-family:Georgia, 'Times New Roman', Times, serif;">
                        <table border="0" width="500">
                            <tr>
                                <td align="center"><strong>
                                    Por quantos dias ocorrerá a votação?<br />(Mínima escolha: 2 - dois - dias / Máxima escolha: 10 - dez - dias)
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">                    
                                    <label for="dur"></label>
                                    <select name="dur" style="font-size:30px" id="dur">
                                    <option disabled="disabled">Escolhe a duração</option>
                                    <option value="2">02 dias</option>
                                    <option value="3">03 dias</option>
                                    <option value="4">04 dias</option>
                                    <option value="5">05 dias</option>
                                    <option value="6">06 dias</option>
                                    <option value="7">07 dias</option>
                                    <option value="8">08 dias</option>
                                    <option value="9">09 dias</option>
                                    <option value="10">10 dias</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="center">
                        <p><b><input required="required" name="check" type="checkbox" onclick="showMe('div1', this)" id="check" value="oui" />
                            <label for="check">Confirmo que a criação deste plebiscito é realmente necessária</label>
                            </b></p>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="center" style="font-family:Georgia, 'Times New Roman', Times, serif;">
                        <div id="div1" style="display:none"><input name="Envoyer" type="submit" style="font-size:30px;" value="Criar plebiscito" /></div>
                        Ao confirmar a caixa acima o botão aparecerá</td>
                    <td>&nbsp;</td>
                </tr>
        </table>
        </form>
        <!---- FIM TABELA NOTICIAS --------------->
        </td>
        <td>&nbsp;</td>
    </tr>
</table>
<script src="js/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">
    bkLib.onDomLoaded(function() { new
    nicEditor({buttonList : ['fontSize','fontFormat', 'bold', 'italic', 'underline', 'left', 'right', 'center', 'justify', 'ol', 'ul', 'indent', 'outdent', 'strikeThrough', 'subscript', 'superscript', 'xhtml', 'image', 'upload', 'arrow', 'link', 'unlink','forecolor','bgcolor']}).panelInstance('desc'); });
    function Ok(){
        nicEditors.findEditor('desc').saveContent();
        document.formname.submit();
    }
</script>
</body>
</html>