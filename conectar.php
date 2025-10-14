<?php   
$database   = "localhost"; // SERVER   
$dbname     = "mimafia"; // DATABASE 
$usuario    = "root"; // USER
$dbsenha    = ""; // PASSWORD

$URL_GERAL  = "http://localhost/projetos%20antigos/mimafia%20(abr-2014)/"; // SYSTEM URL

$conexao    = mysqli_connect($database, $usuario, $dbsenha, $dbname);

if ($conexao) {
      if(mysqli_select_db($conexao, $dbname)){
            print "";
      }else{
            print "Não foi possível selecionar o Banco de Dados";
      }
}else{
      print "Erro ao conectar o MySQL";
}
?>