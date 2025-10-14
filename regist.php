<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mi mafia, Tu mafia</title>
<link rel="stylesheet" href="css/geral.css" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
  $(document).ready(function(){
    // When the username text field loses focus
    $("#username").change(function(){
      var username = $("#username").val(); //Get the value in the username textbox
      
      // If the lenght greater than 3 characters
      if(username.length > 3){
        $("#availability_status").html('<img src="img/loader.gif" align="absmiddle">&nbsp;<small>Checando disponibilidade...</small>');
        //Add a loading image in the span id="availability_status"

        $.ajax({  //Make the Ajax Request
            type: "POST",  
            url: "ajax_check_username.php",
            data: "username="+ username,  //data
            success: function(server_response){          
              $("#availability_status").ajaxComplete(function(event, request){ 

                // If "0" is returned by PHP (i.e. username is available)
                if(server_response == '0'){ 
                  $("#availability_status").html('<img src="img/available.png" align="absmiddle"> <font color="Green"> <small>Disponível!</small></font>');
                  //add this image to the span with id "availability_status"
                }else if(server_response == '1'){  // If "1" is returned by PHP (i.e. username is NOT available)
                  $("#availability_status").html('<img src="img/not_available.png" align="absmiddle"> <font color="red"><small>Já está sendo usado!</small></font>');
                }  
                
              });
            }              
        }); 
      }else{
        $("#availability_status").html('<font color="#cc0000"><small>Usuário muito pequeno!</small></font>');
        //if in case the username is less than or equal 3 characters only 
      }
      return false;
    });
  });
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
    <td bgcolor="#c12a19" align="center" style="box-shadow: 0px 5px 15px #000;" height="50"><b>Para ter acesso à máfia, conecta-te ou registra-te!</b></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td bgcolor="#FFFFFF" style="box-shadow: 0px 5px 15px #000;" height="500"><table width="100%" border="0">
      <tr>
        <td>&nbsp;</td>
        <td align="center"><h2>Registro</h2></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="center">
          <form action="registform.php" enctype="multipart/form-data" method="post">
            <table width="500" border="0">
              <tr>
                <td width="262">Nome:</td>
                <td colspan="2"><label for="nome"></label>
                  <input type="text" name="nome" id="nome" required="required" /></td>
                </tr>
              <tr>
                <td>Sobrenome:</td>
                <td colspan="2"><input type="text" name="sobrenome" required="required" id="sobrenome" /></td>
              </tr>
              <tr>
                <td>Usuário <small>(usado para acessar o site)</small>:</td>
                <td width="148"><input type="text" name="username" required="required" id="username" /></td><td width="76"><span id="availability_status"></span></td>
              </tr>
              <tr>
                <td>Aniversário:</td>
                <td colspan="2"><input type="date" name="aniversario" id="aniversario" required="required" /></td>
              </tr>
              <tr>
                <td>Senha:</td>
                <td colspan="2"><input type="password" name="pass" id="pass" required="required" /></td>
              </tr>
              <tr>
                <td>Email:</td>
                <td colspan="2"><input type="text" name="email" id="email" required="required" /></td>
              </tr>
              <tr>
                <td>Sexo:</td>
                <td colspan="2"><label for="sexo"></label>
                  <select name="sexo" id="sexo">
                    <option value="m">Masculino</option>
                    <option value="f">Feminino</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Descrição<br />
                  <small>(um pequeno resumo sobre ti)</small>
                  :</td>
                <td colspan="2"><textarea required="required" name="desc" id="desc"></textarea></td>
              </tr>
              <tr>
                <td>Matrícula na UFPB <small>(não aparecerá para ninguém, apenas para confirmar o cadastro)</small>:</td>
                <td colspan="2"><input name="mat" type="text" id="mat" value="" required="required" /></td>
              </tr>
              <tr>
                <td>Turno:</td>
                <td colspan="2"><label for="turno"></label>
                  <select name="turno" id="turno">
                    <option value="m">Manhã</option>
                    <option value="n">Noite</option>
                  </select></td>
              </tr>
              <tr>
                <td>Foto de perfil:</td>
                <td colspan="2"><input name="photo" type="file" id="pass" value="" required="required" /></td>
              </tr>
              <tr>
                <td colspan="3" align="center"><input type="submit" style="width:100px; height:40px" value="Cadastrar-me" /></td>
              </tr>
            </table>
          </form>
        </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    </td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>