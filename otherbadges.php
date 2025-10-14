//// BADGE 'ORGANIZADOR' =====================================================================================

$query_badge_o = "SELECT * FROM events WHERE creat_event = '$id_user'";
$rs_badge_o = mysql_query($query_badge_o);
$num_o  = mysql_num_rows($rs_badge_o);

////// NV SENIOR
if($num_o >= 30){
	
	/// CHECK IF HAVE OR NOT THIS BADGE
	$query_badge_ex_o = "SELECT * FROM badge_won WHERE idba_tot_bw = '2' AND iduse_bw = '$id_user'";
	$rs_badge_ex_o = mysql_query($query_badge_ex_o);
	$num_ex_o  = mysql_num_rows($rs_badge_ex_o);
	
	if($num_ex_o == 0){	
	$add_badge_o_o = mysql_query("INSERT INTO badge_won(id_bw,idba_tot_bw,idba_bw,iduse_bw,date_bw) VALUES (NULL,'2','3','$id_user','$hj')");
	$sum += '1';
	}else{
	/// CHECK IF HAVE OR NOT THIS BADGE LEVEL
	$query_badge_ex_lvl_o = "SELECT * FROM badge_won WHERE idba_tot_bw = '2' AND idba_bw = '3' AND iduse_bw = '$id_user'";
	$rs_badge_ex_lvl_o = mysql_query($query_badge_ex_lvl_o);
	$num_ex_lvl_o  = mysql_num_rows($rs_badge_ex_lvl_o);
	
	if($num_ex_lvl_o == 0){
	$upd_badge_o_o = mysql_query("UPDATE badge_won SET idba_bw = '3', date_bw = '$hj' WHERE iduse_bw = '$id_user' AND idba_tot_bw = '2'");	
	$sum += '1';
	}
	}
	
}else{
////// NV CERIMONIAL
if($num_o > 9 && $num_o < 30){
	
	/// CHECK IF HAVE OR NOT THIS BADGE
	$query_badge_ex_o = "SELECT * FROM badge_won WHERE idba_tot_bw = '2' AND iduse_bw = '$id_user'";
	$rs_badge_ex_o = mysql_query($query_badge_ex_o);
	$num_ex_o  = mysql_num_rows($rs_badge_ex_o);
	
	if($num_ex_o == 0){	
	$add_badge_o_o = mysql_query("INSERT INTO badge_won(id_bw,idba_tot_bw,idba_bw,iduse_bw,date_bw) VALUES (NULL,'2','2','$id_user','$hj')");
	$sum += '1';
	}else{
	/// CHECK IF HAVE OR NOT THIS BADGE LEVEL
	$query_badge_ex_lvl_o = "SELECT * FROM badge_won WHERE idba_tot_bw = '2' AND idba_bw = '2' AND iduse_bw = '$id_user'";
	$rs_badge_ex_lvl_o = mysql_query($query_badge_ex_lvl_o);
	$num_ex_lvl_o  = mysql_num_rows($rs_badge_ex_lvl_o);
	
	if($num_ex_lvl_o == 0){
	$upd_badge_o_o = mysql_query("UPDATE badge_won SET idba_bw = '2', date_bw = '$hj' WHERE iduse_bw = '$id_user' AND idba_tot_bw = '2'");	
	$sum += '1';
	}
	}
	
}else{
////// NV JUNIOR
if($num_o > 4 && $num_o < 10){

	/// CHECK IF HAVE OR NOT THIS BADGE
	$query_badge_ex_o = "SELECT * FROM badge_won WHERE idba_tot_bw = '2' AND iduse_bw = '$id_user'";
	$rs_badge_ex_o = mysql_query($query_badge_ex_o);
	$num_ex_o  = mysql_num_rows($rs_badge_ex_o);
	
	if($num_ex_o == 0){	
	$add_badge_o_o = mysql_query("INSERT INTO badge_won(id_bw,idba_tot_bw,idba_bw,iduse_bw,date_bw) VALUES (NULL,'2','1','$id_user','$hj')");
	$sum += '1';
	}else{
	/// CHECK IF HAVE OR NOT THIS BADGE LEVEL
	$query_badge_ex_lvl_o = "SELECT * FROM badge_won WHERE idba_tot_bw = '2' AND idba_bw = '1' AND iduse_bw = '$id_user'";
	$rs_badge_ex_lvl_o = mysql_query($query_badge_ex_lvl_o);
	$num_ex_lvl_o  = mysql_num_rows($rs_badge_ex_lvl_o);
	
	if($num_ex_lvl_o == 0){
	$upd_badge_o_o = mysql_query("UPDATE badge_won SET idba_bw = '1', date_bw = '$hj' WHERE iduse_bw = '$id_user' AND idba_tot_bw = '2'");	
	$sum += '1';
	}
	}	
}
}
}
//// BADGE 'ORGANIZADOR' ENDS ===========================================================================

//// BADGE 'RAT LABO' ===============

////// NV 1
if($id_user < 18){
	
	/// CHECK IF HAVE OR NOT THIS BADGE
	$query_badge_ex_ratlab = "SELECT * FROM badge_won WHERE idba_tot_bw = '3' AND iduse_bw = '$id_user'";
	$rs_badge_ex_ratlab = mysql_query($query_badge_ex_ratlab);
	$num_ex_ratlab  = mysql_num_rows($rs_badge_ex_ratlab);
	
	if($num_ex_ratlab == 0){	
	$add_badge_ratlab_ratlab = mysql_query("INSERT INTO badge_won(id_bw,idba_tot_bw,idba_bw,iduse_bw,date_bw) VALUES (NULL,'3','1','$id_user','$hj')");
	$sum += '1';
	}else{
	/// CHECK IF HAVE OR NOT THIS BADGE LEVEL
	$query_badge_ex_lvl_ratlab = "SELECT * FROM badge_won WHERE idba_tot_bw = '3' AND idba_bw = '1' AND iduse_bw = '$id_user'";
	$rs_badge_ex_lvl_ratlab = mysql_query($query_badge_ex_lvl_ratlab);
	$num_ex_lvl_ratlab  = mysql_num_rows($rs_badge_ex_lvl_ratlab);
	
	if($num_ex_lvl_ratlab == 0){
	$upd_badge_ratlab_ratlab = mysql_query("UPDATE badge_won SET idba_bw = '1', date_bw = '$hj' WHERE iduse_bw = '$id_user' AND idba_tot_bw = '3'");	
	$sum += '1';
	}
	}
	
}
//// BADGE 'RAT LABO' ENDS =================================================================================

//// BADGE 'ARQUITECTO' ===============

$query_badge_ar = "SELECT * FROM projetos WHERE creat_proj = '$id_user'";
$rs_badge_ar = mysql_query($query_badge_ar);
$num_ar  = mysql_num_rows($rs_badge_ar);

////// NV SENADOR
if($num_ar >= 100){
	
	/// CHECK IF HAVE OR NOT THIS BADGE
	$query_badge_ex_ar = "SELECT * FROM badge_won WHERE idba_tot_bw = '4' AND iduse_bw = '$id_user'";
	$rs_badge_ex_ar = mysql_query($query_badge_ex_ar);
	$num_ex_ar  = mysql_num_rows($rs_badge_ex_ar);
	
	if($num_ex_ar == 0){	
	$add_badge_ar_ar = mysql_query("INSERT INTO badge_won(id_bw,idba_tot_bw,idba_bw,iduse_bw,date_bw) VALUES (NULL,'4','3','$id_user','$hj')");
	$sum += '1';
	}else{
	/// CHECK IF HAVE OR NOT THIS BADGE LEVEL
	$query_badge_ex_lvl_ar = "SELECT * FROM badge_won WHERE idba_tot_bw = '4' AND idba_bw = '3' AND iduse_bw = '$id_user'";
	$rs_badge_ex_lvl_ar = mysql_query($query_badge_ex_lvl_ar);
	$num_ex_lvl_ar  = mysql_num_rows($rs_badge_ex_lvl_ar);
	
	if($num_ex_lvl_ar == 0){
	$upd_badge_ar_ar = mysql_query("UPDATE badge_won SET idba_bw = '4', date_bw = '$hj' WHERE iduse_bw = '$id_user' AND idba_tot_bw = '4'");	
	$sum += '1';
	}
	}
	
}else{
////// NV DEPUTADO
if($num_ar > 19 && $num_ar < 100){
	
	/// CHECK IF HAVE OR NOT THIS BADGE
	$query_badge_ex_ar = "SELECT * FROM badge_won WHERE idba_tot_bw = '4' AND iduse_bw = '$id_user'";
	$rs_badge_ex_ar = mysql_query($query_badge_ex_ar);
	$num_ex_ar  = mysql_num_rows($rs_badge_ex_ar);
	
	if($num_ex_ar == 0){	
	$add_badge_ar_ar = mysql_query("INSERT INTO badge_won(id_bw,idba_tot_bw,idba_bw,iduse_bw,date_bw) VALUES (NULL,'4','2','$id_user','$hj')");
	$sum += '1';
	}else{
	/// CHECK IF HAVE OR NOT THIS BADGE LEVEL
	$query_badge_ex_lvl_ar = "SELECT * FROM badge_won WHERE idba_tot_bw = '4' AND idba_bw = '2' AND iduse_bw = '$id_user'";
	$rs_badge_ex_lvl_ar = mysql_query($query_badge_ex_lvl_ar);
	$num_ex_lvl_ar  = mysql_num_rows($rs_badge_ex_lvl_ar);
	
	if($num_ex_lvl_ar == 0){
	$upd_badge_ar_ar = mysql_query("UPDATE badge_won SET idba_bw = '2', date_bw = '$hj' WHERE iduse_bw = '$id_user' AND idba_tot_bw = '4'");	
	$sum += '1';
	}
	}
	
}else{
////// NV VEREADOR
if($num_ar > 4 && $num_ar < 20){

	/// CHECK IF HAVE OR NOT THIS BADGE
	$query_badge_ex_ar = "SELECT * FROM badge_won WHERE idba_tot_bw = '4' AND iduse_bw = '$id_user'";
	$rs_badge_ex_ar = mysql_query($query_badge_ex_ar);
	$num_ex_ar  = mysql_num_rows($rs_badge_ex_ar);
	
	if($num_ex_ar == 0){	
	$add_badge_ar_ar = mysql_query("INSERT INTO badge_won(id_bw,idba_tot_bw,idba_bw,iduse_bw,date_bw) VALUES (NULL,'4','1','$id_user','$hj')");
	$sum += '1';
	}else{
	/// CHECK IF HAVE OR NOT THIS BADGE LEVEL
	$query_badge_ex_lvl_ar = "SELECT * FROM badge_won WHERE idba_tot_bw = '4' AND idba_bw = '1' AND iduse_bw = '$id_user'";
	$rs_badge_ex_lvl_ar = mysql_query($query_badge_ex_lvl_ar);
	$num_ex_lvl_ar  = mysql_num_rows($rs_badge_ex_lvl_ar);
	
	if($num_ex_lvl_ar == 0){
	$upd_badge_ar_ar = mysql_query("UPDATE badge_won SET idba_bw = '1', date_bw = '$hj' WHERE iduse_bw = '$id_user' AND idba_tot_bw = '4'");	
	$sum += '1';
	}
	}	
}
}
}
//// BADGE 'ARQUITECTO' ENDS =================================================================================

//// BADGE 'ELEITOR 1' ===============

////// NV 1
if($id_user == 8 || $id_user == 9 || $id_user == 7 || $id_user == 13 || $id_user == 11 || $id_user == 14 || $id_user == 17 || $id_user == 18 || $id_user ==  16){
	
	/// CHECK IF HAVE OR NOT THIS BADGE
	$query_badge_ex_eleum = "SELECT * FROM badge_won WHERE idba_tot_bw = '5' AND iduse_bw = '$id_user'";
	$rs_badge_ex_eleum = mysql_query($query_badge_ex_eleum);
	$num_ex_eleum  = mysql_num_rows($rs_badge_ex_eleum);
	
	if($num_ex_eleum == 0){	
	$add_badge_eleum_eleum = mysql_query("INSERT INTO badge_won(id_bw,idba_tot_bw,idba_bw,iduse_bw,date_bw) VALUES (NULL,'5','1','$id_user','$hj')");
	$sum += '1';
	}else{
	/// CHECK IF HAVE OR NOT THIS BADGE LEVEL
	$query_badge_ex_lvl_eleum = "SELECT * FROM badge_won WHERE idba_tot_bw = '5' AND idba_bw = '1' AND iduse_bw = '$id_user'";
	$rs_badge_ex_lvl_eleum = mysql_query($query_badge_ex_lvl_eleum);
	$num_ex_lvl_eleum  = mysql_num_rows($rs_badge_ex_lvl_eleum);
	
	if($num_ex_lvl_eleum == 0){
	$upd_badge_eleum_eleum = mysql_query("UPDATE badge_won SET idba_bw = '1', date_bw = '$hj' WHERE iduse_bw = '$id_user' AND idba_tot_bw = '5'");	
	$sum += '1';
	}
	}
	
}
//// BADGE 'ELEITOR 1' ENDS =================================================================================

//// BADGE 'CHEFAO' ===============

$query_badge_chef = "SELECT * FROM capone_ger WHERE iduser_capger = '$id_user'";
$rs_badge_chef = mysql_query($query_badge_chef);
$num_chef  = mysql_num_rows($rs_badge_chef);

////// NV CORLEONE
if($num_chef >= 10){
	
	/// CHECK IF HAVE OR NOT THIS BADGE
	$query_badge_ex_chef = "SELECT * FROM badge_won WHERE idba_tot_bw = '6' AND iduse_bw = '$id_user'";
	$rs_badge_ex_chef = mysql_query($query_badge_ex_chef);
	$num_ex_chef  = mysql_num_rows($rs_badge_ex_chef);
	
	if($num_ex_chef == 0){	
	$add_badge_chef_chef = mysql_query("INSERT INTO badge_won(id_bw,idba_tot_bw,idba_bw,iduse_bw,date_bw) VALUES (NULL,'6','3','$id_user','$hj')");
	$sum += '1';
	}else{
	/// CHECK IF HAVE OR NOT THIS BADGE LEVEL
	$query_badge_ex_lvl_chef = "SELECT * FROM badge_won WHERE idba_tot_bw = '6' AND idba_bw = '3' AND iduse_bw = '$id_user'";
	$rs_badge_ex_lvl_chef = mysql_query($query_badge_ex_lvl_chef);
	$num_ex_lvl_chef  = mysql_num_rows($rs_badge_ex_lvl_chef);
	
	if($num_ex_lvl_chef == 0){
	$upd_badge_chef_chef = mysql_query("UPDATE badge_won SET idba_bw = '3', date_bw = '$hj' WHERE iduse_bw = '$id_user' AND idba_tot_bw = '6'");	
	$sum += '1';
	}
	}
	
}else{
////// NV CAPONE
if($num_chef > 4 && $num_chef < 10){
	
	/// CHECK IF HAVE OR NOT THIS BADGE
	$query_badge_ex_chef = "SELECT * FROM badge_won WHERE idba_tot_bw = '6' AND iduse_bw = '$id_user'";
	$rs_badge_ex_chef = mysql_query($query_badge_ex_chef);
	$num_ex_chef  = mysql_num_rows($rs_badge_ex_chef);
	
	if($num_ex_chef == 0){	
	$add_badge_chef_chef = mysql_query("INSERT INTO badge_won(id_bw,idba_tot_bw,idba_bw,iduse_bw,date_bw) VALUES (NULL,'6','2','$id_user','$hj')");
	$sum += '1';
	}else{
	/// CHECK IF HAVE OR NOT THIS BADGE LEVEL
	$query_badge_ex_lvl_chef = "SELECT * FROM badge_won WHERE idba_tot_bw = '6' AND idba_bw = '2' AND iduse_bw = '$id_user'";
	$rs_badge_ex_lvl_chef = mysql_query($query_badge_ex_lvl_chef);
	$num_ex_lvl_chef  = mysql_num_rows($rs_badge_ex_lvl_chef);
	
	if($num_ex_lvl_chef == 0){
	$upd_badge_chef_chef = mysql_query("UPDATE badge_won SET idba_bw = '2', date_bw = '$hj' WHERE iduse_bw = '$id_user' AND idba_tot_bw = '6'");	
	$sum += '1';
	}
	}
	
}else{
////// NV JUNIOR
if($num_chef >= 1 && $num_chef < 5){

	/// CHECK IF HAVE OR NOT THIS BADGE
	$query_badge_ex_chef = "SELECT * FROM badge_won WHERE idba_tot_bw = '6' AND iduse_bw = '$id_user'";
	$rs_badge_ex_chef = mysql_query($query_badge_ex_chef);
	$num_ex_chef  = mysql_num_rows($rs_badge_ex_chef);
	
	if($num_ex_chef == 0){	
	$add_badge_chef_chef = mysql_query("INSERT INTO badge_won(id_bw,idba_tot_bw,idba_bw,iduse_bw,date_bw) VALUES (NULL,'6','1','$id_user','$hj')");
	$sum += '1';
	}else{
	/// CHECK IF HAVE OR NOT THIS BADGE LEVEL
	$query_badge_ex_lvl_chef = "SELECT * FROM badge_won WHERE idba_tot_bw = '6' AND idba_bw = '1' AND iduse_bw = '$id_user'";
	$rs_badge_ex_lvl_chef = mysql_query($query_badge_ex_lvl_chef);
	$num_ex_lvl_chef  = mysql_num_rows($rs_badge_ex_lvl_chef);
	
	if($num_ex_lvl_chef == 0){
	$upd_badge_chef_chef = mysql_query("UPDATE badge_won SET idba_bw = '1', date_bw = '$hj' WHERE iduse_bw = '$id_user' AND idba_tot_bw = '6'");	
	$sum += '1';
	}
	}	
}
}
}
//// BADGE 'CHEFAO' ENDS =================================================================================

//// BADGE 'ABC' ===============

$query_badge_abcba = "SELECT * FROM posts WHERE creat_post = '$id_user'";
$rs_badge_abcba = mysql_query($query_badge_abcba);
$num_abcba  = mysql_num_rows($rs_badge_abcba);

////// NV 1
if($num_abcba >= 1){
	
	/// CHECK IF HAVE OR NOT THIS BADGE
	$query_badge_ex_abcba = "SELECT * FROM badge_won WHERE idba_tot_bw = '7' AND iduse_bw = '$id_user'";
	$rs_badge_ex_abcba = mysql_query($query_badge_ex_abcba);
	$num_ex_abcba  = mysql_num_rows($rs_badge_ex_abcba);
	
	if($num_ex_abcba == 0){	
	$add_badge_abcba_abcba = mysql_query("INSERT INTO badge_won(id_bw,idba_tot_bw,idba_bw,iduse_bw,date_bw) VALUES (NULL,'7','1','$id_user','$hj')");
	$sum += '1';
	}else{
	/// CHECK IF HAVE OR NOT THIS BADGE LEVEL
	$query_badge_ex_lvl_abcba = "SELECT * FROM badge_won WHERE idba_tot_bw = '7' AND idba_bw = '1' AND iduse_bw = '$id_user'";
	$rs_badge_ex_lvl_abcba = mysql_query($query_badge_ex_lvl_abcba);
	$num_ex_lvl_abcba  = mysql_num_rows($rs_badge_ex_lvl_abcba);
	
	if($num_ex_lvl_abcba == 0){
	$upd_badge_abcba_abcba = mysql_query("UPDATE badge_won SET idba_bw = '1', date_bw = '$hj' WHERE iduse_bw = '$id_user' AND idba_tot_bw = '7'");	
	$sum += '1';
	}
	}
	
}
//// BADGE 'ABC' ENDS =================================================================================