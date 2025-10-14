<?php
include('rest.php');
include('conectar.php');

// Fetch user information
$query_guy  = "SELECT * FROM user WHERE nickname_user = ?";
$stmt_guy   = $conexao->prepare($query_guy);
$stmt_guy->bind_param("s", $login_user);
$stmt_guy->execute();
$rs_guy = $stmt_guy->get_result();
$infoguy= $rs_guy->fetch_assoc();
$stmt_guy->close();
                        
$id_user	= $infoguy['id_user'];

// Fetch Capo information
$query_capo = "SELECT * FROM capone_ger LIMIT 1";
$stmt_capo  = $conexao->prepare($query_capo);
$stmt_capo->execute();
$rs_capo    = $stmt_capo->get_result();
$capoinfo   = $rs_capo->fetch_array();
$stmt_capo->close();

$iduser_capo = $capoinfo['iduser_capger'];

$sum = 0;
$hoje_data = new DateTime();
$hj = $hoje_data->format('d/m/Y');
/// CONQUISTAS AREA CODES ========================

//// BADGE 'JORNALISTA' ===============

$query_badge_jj = "SELECT * FROM posts WHERE creat_post = ?";
$stmt_badge_jj = $conexao->prepare($query_badge_jj);
$stmt_badge_jj->bind_param("i", $id_user);
$stmt_badge_jj->execute();
$rs_badge_jj = $stmt_badge_jj->get_result();
$num_jj = $rs_badge_jj->num_rows;
$stmt_badge_jj->close();

////// NV SENIOR
if($num_jj >= 100){
	
    /// CHECK IF HAVE OR NOT THIS BADGE
    $query_badge_ex_jj = "SELECT * FROM badge_won WHERE idba_tot_bw = '1' AND iduse_bw = ?";
    $stmt_badge_ex_jj = $conexao->prepare($query_badge_ex_jj);
    $stmt_badge_ex_jj->bind_param("i", $id_user);
    $stmt_badge_ex_jj->execute();
    $rs_badge_ex_jj = $stmt_badge_ex_jj->get_result();
    $num_ex_jj  = $rs_badge_ex_jj->num_rows;
    $stmt_badge_ex_jj->close();
	
    if($num_ex_jj == 0){
        $query_insert_badge = "INSERT INTO badge_won(id_bw,idba_tot_bw,idba_bw,iduse_bw,date_bw) VALUES (NULL,'1','4',?,?)";
        $stmt_insert_badge = $conexao->prepare($query_insert_badge);
        $stmt_insert_badge->bind_param("is", $id_user, $hj);
        $stmt_insert_badge->execute();
        $stmt_insert_badge->close();
        $sum += 1;
    }else{
        // CHECK IF HAVE OR NOT THIS BADGE LEVEL
        $query_badge_ex_lvl_jj = "SELECT * FROM badge_won WHERE idba_tot_bw = '1' AND idba_bw = '4' AND iduse_bw = ?";
        $stmt_badge_ex_lvl_jj = $conexao->prepare($query_badge_ex_lvl_jj);
        $stmt_badge_ex_lvl_jj->bind_param("i", $id_user);
        $stmt_badge_ex_lvl_jj->execute();
        $rs_badge_ex_lvl_jj = $stmt_badge_ex_lvl_jj->get_result();
        $num_ex_lvl_jj  = $rs_badge_ex_lvl_jj->num_rows;
        $stmt_badge_ex_lvl_jj->close();

        if($num_ex_lvl_jj == 0){
            $query_update_badge = "UPDATE badge_won SET idba_bw = '4', date_bw = ? WHERE iduse_bw = ? AND idba_tot_bw = '1'";
            $stmt_update_badge = $conexao->prepare($query_update_badge);
            $stmt_update_badge->bind_param("si", $hj, $id_user);
            $stmt_update_badge->execute();
            $stmt_update_badge->close();
            $sum += 1;
        }
    }
	
}else{
////// NV PROFISSIONAL
if($num_jj > 49 && $num_jj < 100){
	
    /// CHECK IF HAVE OR NOT THIS BADGE
    $query_badge_ex_jj = "SELECT * FROM badge_won WHERE idba_tot_bw = '1' AND iduse_bw = ?";
    $stmt_badge_ex_jj = $conexao->prepare($query_badge_ex_jj);
    $stmt_badge_ex_jj->bind_param("i", $id_user);
    $stmt_badge_ex_jj->execute();
    $rs_badge_ex_jj = $stmt_badge_ex_jj->get_result();
    $num_ex_jj  = $rs_badge_ex_jj->num_rows;
    $stmt_badge_ex_jj->close();

    if($num_ex_jj == 0){
        $query_insert_badge = "INSERT INTO badge_won(id_bw,idba_tot_bw,idba_bw,iduse_bw,date_bw) VALUES (NULL,'1','3',?,?)";
        $stmt_insert_badge = $conexao->prepare($query_insert_badge);
        $stmt_insert_badge->bind_param("is", $id_user, $hj);
        $stmt_insert_badge->execute();
        $stmt_insert_badge->close();
        $sum += 1;
    }else{
        /// CHECK IF HAVE OR NOT THIS BADGE LEVEL
        $query_badge_ex_lvl_jj = "SELECT * FROM badge_won WHERE idba_tot_bw = '1' AND idba_bw = '3' AND iduse_bw = ?";
        $stmt_badge_ex_lvl_jj = $conexao->prepare($query_badge_ex_lvl_jj);
        $stmt_badge_ex_lvl_jj->bind_param("i", $id_user);
        $stmt_badge_ex_lvl_jj->execute();
        $rs_badge_ex_lvl_jj = $stmt_badge_ex_lvl_jj->get_result();
        $num_ex_lvl_jj  = $rs_badge_ex_lvl_jj->num_rows;
        $stmt_badge_ex_lvl_jj->close();

        if($num_ex_lvl_jj == 0){
            $query_update_badge = "UPDATE badge_won SET idba_bw = '3', date_bw = ? WHERE iduse_bw = ? AND idba_tot_bw = '1'";
            $stmt_update_badge = $conexao->prepare($query_update_badge);
            $stmt_update_badge->bind_param("si", $hj, $id_user);
            $stmt_update_badge->execute();
            $stmt_update_badge->close();
            $sum += 1;
        }
    }
	
}else{
////// NV SEMI-PROFISSIONAL
if($num_jj > 9 && $num_jj < 50){

    /// CHECK IF HAVE OR NOT THIS BADGE
    $query_badge_ex_jj = "SELECT * FROM badge_won WHERE idba_tot_bw = '1' AND iduse_bw = ?";
    $stmt_badge_ex_jj = $conexao->prepare($query_badge_ex_jj);
    $stmt_badge_ex_jj->bind_param("i", $id_user);
    $stmt_badge_ex_jj->execute();
    $rs_badge_ex_jj = $stmt_badge_ex_jj->get_result();
    $num_ex_jj  = $rs_badge_ex_jj->num_rows;
    $stmt_badge_ex_jj->close();

    if($num_ex_jj == 0){
        $query_insert_badge = "INSERT INTO badge_won(id_bw,idba_tot_bw,idba_bw,iduse_bw,date_bw) VALUES (NULL,'1','2',?,?)";
        $stmt_insert_badge = $conexao->prepare($query_insert_badge);
        $stmt_insert_badge->bind_param("is", $id_user, $hj);
        $stmt_insert_badge->execute();
        $stmt_insert_badge->close();
        $sum += 1;
    }else{
        /// CHECK IF HAVE OR NOT THIS BADGE LEVEL
        $query_badge_ex_lvl_jj = "SELECT * FROM badge_won WHERE idba_tot_bw = '1' AND idba_bw = '2' AND iduse_bw = ?";
        $stmt_badge_ex_lvl_jj = $conexao->prepare($query_badge_ex_lvl_jj);
        $stmt_badge_ex_lvl_jj->bind_param("i", $id_user);
        $stmt_badge_ex_lvl_jj->execute();
        $rs_badge_ex_lvl_jj = $stmt_badge_ex_lvl_jj->get_result();
        $num_ex_lvl_jj  = $rs_badge_ex_lvl_jj->num_rows;
        $stmt_badge_ex_lvl_jj->close();

        if($num_ex_lvl_jj == 0){
            $query_update_badge = "UPDATE badge_won SET idba_bw = '2', date_bw = ? WHERE iduse_bw = ? AND idba_tot_bw = '1'";
            $stmt_update_badge = $conexao->prepare($query_update_badge);
            $stmt_update_badge->bind_param("si", $hj, $id_user);
            $stmt_update_badge->execute();
            $stmt_update_badge->close();
            $sum += 1;
        }
    }

}else{
////// NV JUNIOR
if($num_jj > 4 && $num_jj < 10){

    /// CHECK IF HAVE OR NOT THIS BADGE
    $query_badge_ex_jj = "SELECT * FROM badge_won WHERE idba_tot_bw = '1' AND iduse_bw = ?";
    $stmt_badge_ex_jj = $conexao->prepare($query_badge_ex_jj);
    $stmt_badge_ex_jj->bind_param("i", $id_user);
    $stmt_badge_ex_jj->execute();
    $rs_badge_ex_jj = $stmt_badge_ex_jj->get_result();
    $num_ex_jj  = $rs_badge_ex_jj->num_rows;
    $stmt_badge_ex_jj->close();

    if($num_ex_jj == 0){
        $query_insert_badge = "INSERT INTO badge_won(id_bw,idba_tot_bw,idba_bw,iduse_bw,date_bw) VALUES (NULL,'1','1',?,?)";
        $stmt_insert_badge = $conexao->prepare($query_insert_badge);
        $stmt_insert_badge->bind_param("is", $id_user, $hj);
        $stmt_insert_badge->execute();
        $stmt_insert_badge->close();
        $sum += 1;
    }else{
        /// CHECK IF HAVE OR NOT THIS BADGE LEVEL
        $query_badge_ex_lvl_jj = "SELECT * FROM badge_won WHERE idba_tot_bw = '1' AND idba_bw = '1' AND iduse_bw = ?";
        $stmt_badge_ex_lvl_jj = $conexao->prepare($query_badge_ex_lvl_jj);
        $stmt_badge_ex_lvl_jj->bind_param("i", $id_user);
        $stmt_badge_ex_lvl_jj->execute();
        $rs_badge_ex_lvl_jj = $stmt_badge_ex_lvl_jj->get_result();
        $num_ex_lvl_jj  = $rs_badge_ex_lvl_jj->num_rows;
        $stmt_badge_ex_lvl_jj->close();

        if($num_ex_lvl_jj == 0){
            $query_update_badge = "UPDATE badge_won SET idba_bw = '1', date_bw = ? WHERE iduse_bw = ? AND idba_tot_bw = '1'";
            $stmt_update_badge = $conexao->prepare($query_update_badge);
            $stmt_update_badge->bind_param("si", $hj, $id_user);
            $stmt_update_badge->execute();
            $stmt_update_badge->close();
            $sum += 1;
        }
    }   
}
}
}
}
//// BADGE 'JORNALISTA' ENDS =================================================================================

/// Other badges can be found in the file "otherbadges.php". It still holds the old mysql_connect code, which needs to be converted to mysqli in order to work in modern PHP versions.
/// Originally, everything used to be in this file, but it got too big, so I planned to split it into another file (which hasn't been done yet).

/// CONQUISTAS AREA CODES END ===========================================================================
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mi mafia, Tu mafia</title>
<link rel="stylesheet" href="css/geral.css" type="text/css" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  <script type="text/javascript" src="js/txtlimit.js"></script>
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
<!---- TABELA NOTICIAS --------------->
<table width="100%" border="0">
      
      <tr>
      <td>&nbsp;</td>
      <td align="center" valign="top">
      <h1>Conquistonovidades</h1>
      </td>
      <td>&nbsp;</td>
      </tr>
      <?php
	  if($id_user == $iduser_capo){
	  ?>
<?php } ?>
<tr>
      <td>&nbsp;</td>
      <td align="left" valign="top">
      <h2>&nbsp;</h2>
      </td>
      <td>&nbsp;</td>
      </tr>
      <tr>
      <td>&nbsp;</td>
      <td align="center">
<h2>
<?php


if ($sum == 0){
	echo 'Não há novas conquistas para ti :(<br /><a href="perfil.php">Clica aqui para voltar</a>';
}else{
	if ($sum == 1){
		echo 'Ganhaste 1 nova conquista! :)<br /><a href="perfil.php">Clica aqui para ver tuas conquistas</a>';
	}else{
		echo 'Ganhaste ' . $sum . ' novas conquistas! :D<br /><a href="perfil.php">Clica aqui para ver tuas conquistas</a>';
	}
}
?></h2>
      </td>
      <td>&nbsp;</td>
      </tr>
      </table>
      </td>
      <td>&nbsp;</td>
      </tr>
    </table>
<!---- FIM TABELA NOTICIAS --------------->
    </td>
    <td>&nbsp;</td>
  </tr>

</table>
</body>
</html>