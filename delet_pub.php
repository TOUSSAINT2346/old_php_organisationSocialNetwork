<?php
include('conectar.php');
include('rest.php');

if(!isset($_GET['a']) || empty($_GET['a'])){
    header('Location: pri.php');
    exit;
}

switch($_GET['a']){
	case 'pub':

        $id_com     = $_POST['pi'];
        $use_id	    = $_POST['ui'];
        $event_id   = $_POST['ie'];
        $tip 	    = $_POST['tip'];

        // Fetch user information
        $query_guy= "SELECT * FROM user WHERE nickname_user = ?";
        $stmt_guy = $conexao->prepare($query_guy);
        $stmt_guy->bind_param("s", $login_user);
        $stmt_guy->execute();
        $rs_guy   = $stmt_guy->get_result();
        $infoguy  = $rs_guy->fetch_assoc();
        $stmt_guy->close();
                                
        $id_user	= $infoguy['id_user'];

        // Delete comment if the user is the owner
        if($use_id == $id_user){

            $query1 = $conexao->prepare("DELETE FROM comment WHERE id_com = ?");
            $query1->bind_param("s", $id_com);
            $query1->execute();
            $query1->close();

            if($tip == 'event'){
                $query2 = $conexao->prepare("DELETE FROM comment WHERE idpag_com = ? AND tip_com = 'event_com'");
                $query2->bind_param("s", $id_com);
                $query2->execute();
                $query2->close();
            }elseif($tip == 'post'){
                $query2 = $conexao->prepare("DELETE FROM comment WHERE idpag_com = ? AND tip_com = 'post_com'");
                $query2->bind_param("s", $id_com);
                $query2->execute();
                $query2->close();
            }
            elseif($tip == 'project'){
                $query2 = $conexao->prepare("DELETE FROM comment WHERE idpag_com = ? AND tip_com = 'project_com'");
                $query2->bind_param("s", $id_com);
                $query2->execute();
                $query2->close();
            }

            if($tip == 'event'){
                header("Location: eventsee.php?i=$event_id");
                exit;
            }elseif($tip == 'post'){
                header("Location: readpost.php?i=$event_id");
                exit;
            }elseif($tip == 'project'){
                header("Location: readproject.php?i=$event_id");
                exit;
            }

        }else{
            if($tip == 'event'){
                header("Location: eventsee.php?i=$event_id");
                exit;
            }elseif($tip == 'post'){
                header("Location: readpost.php?i=$event_id");
                exit;
            }elseif($tip == 'project'){
                header("Location: readproject.php?i=$event_id");
                exit;
            }
        }
    break;
    // ------------- DELET COMMENT OF COMMENT ---------------------------------
	case 'comment':
        $com_id   = $_POST['ci'];
        $use_id	  = $_POST['ui'];
        $idpag    = $_POST['ie'];
        $id_event = $_POST['tip'];
        $tip 	  = $_POST['tipu'];

        // Fetch user information
        $query_guy= "SELECT * FROM user WHERE nickname_user = ?";
        $stmt_guy = $conexao->prepare($query_guy);
        $stmt_guy->bind_param("s", $login_user);
        $stmt_guy->execute();
        $rs_guy   = $stmt_guy->get_result();
        $infoguy  = $rs_guy->fetch_assoc();
        $stmt_guy->close();
                                
        $id_user	= $infoguy['id_user'];

        // Delete comment if the user is the owner
        if($use_id == $id_user){

            $query1 = $conexao->prepare("DELETE FROM comment WHERE id_com = ?");
            $query1->bind_param("s", $com_id);
            $query1->execute();
            $query1->close();

            if($tip == 'event'){
                header("Location: eventsee.php?i=$id_event");
                exit;
            }elseif($tip == 'post'){
                header("Location: readpost.php?i=$id_event");
                exit;
            }elseif($tip == 'project'){
                header("Location: readproject.php?i=$id_event");
                exit;
            }
        }else{
            if($tip == 'event'){
                header("Location: eventsee.php?i=$id_event");
                exit;
            }elseif($tip == 'post'){
                header("Location: readpost.php?i=$id_event");
                exit;
            }elseif($tip == 'project'){
                header("Location: readproject.php?i=$id_event");
                exit;
            }
        }
	break;
}
?>