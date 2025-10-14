CARREGANDO...
<?php
include('conectar.php');
include('rest.php');

if(!isset($_GET['a']) || empty($_GET['a'])){
    header('Location: pri.php');
    exit;
}

switch($_GET['a']){
    // Edit a post
	case 'edit':

        $id_post	 = (int)$_POST['id_post'];
        $creator	 = (int)$_POST['creat_post'];
        $tit_new 	 = htmlspecialchars($_POST['tit_post']);
        $text_new	 = htmlspecialchars($_POST['text_post']);
        $font_new	 = htmlspecialchars($_POST['font_post']);
        $cat_new     = htmlspecialchars($_POST['cat_post']);

        $query_edit  = "UPDATE posts SET tit_post=?, text_post=?, cat_post=?, font_post=? WHERE id_post = ? AND creat_post = ?";
        $stmt_edit   = $conexao->prepare($query_edit);
        $stmt_edit->bind_param("ssssii", $tit_new, $text_new, $cat_new, $font_new, $id_post, $creator);
        $stmt_edit->execute();
        $stmt_edit->close();

        header("Location: readpost.php?i=$id_post");
    break;
    // Insert a new post
	case 'new':
	
        $creator	 = (int)$_POST['creat_post'];
        $tit_new 	 = htmlspecialchars($_POST['tit_post']);
        $date_new	 = htmlspecialchars($_POST['date_post']);
        $text_new	 = htmlspecialchars($_POST['text_post']);
        $cat_new	 = htmlspecialchars($_POST['cat_post']);
        $font_new	 = htmlspecialchars($_POST['font_post']);

        $query_insert = "INSERT INTO posts(id_post, tit_post, text_post, creat_post, date_post, totutil_post, cat_post, font_post, vis_post, util_post, inutil_post) VALUES (NULL, ?, ?, ?, ?, '0', ?, ?, '0', '0', '0')";
        $stmt_insert = $conexao->prepare($query_insert);
        $stmt_insert->bind_param(
            "ssisss", 
            $tit_new, 
            $text_new, 
            $creator,
            $date_new, 
            $cat_new, 
            $font_new
        );
        $stmt_insert->execute();
        $stmt_insert->close();

        header("Location: odmpri.php");        
    break;
    // Create a project
    case 'proj':
        
        $creator	 = htmlspecialchars($_POST['creat']);
        $nome	 	 = htmlspecialchars($_POST['nome']);
        $teor		 = htmlspecialchars($_POST['teor']);
        $date		 = htmlspecialchars($_POST['date']);
        $date_end	 = htmlspecialchars($_POST['date_end']);

        $query = "INSERT INTO projetos(id_proj, nome_proj, teor_proj, sit_proj, dat_proj, datf_proj, creat_proj) VALUES (NULL, ?, ?, 'vot', ?, ?, ?)";
        $stmt = $conexao->prepare($query);
        $stmt->bind_param("sssss", $nome, $teor, $date, $date_end, $creator);
        $stmt->execute();
        $stmt->close();
        $conexao->close();

        header("Location: projectos.php");
        exit;        
    break;
    // Create a plebiscite
    case 'pleb':
        
        $pergunta	 = htmlspecialchars($_POST['pergunta']);
        $desc	 	 = htmlspecialchars($_POST['desc']);
        $creat		 = htmlspecialchars($_POST['creat']);
        $date		 = new DateTime($_POST['date']);
        $resp1		 = htmlspecialchars($_POST['resp1']);
        $resp2		 = htmlspecialchars($_POST['resp2']);
        $resp3		 = htmlspecialchars($_POST['resp3']);
        $resp4		 = htmlspecialchars($_POST['resp4']);
        $dur		 = htmlspecialchars($_POST['dur']);
        $vis         = '0';

        $date_inic = $date->format('Y-m-d');

        // Add $dur days to the date
        $date->modify("+$dur days");
        $datef = $date->format('Y-m-d');

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

        // Fetch current Capo information
        $query_capo = "SELECT * FROM capone_ger ORDER BY id_capger DESC LIMIT 1";
        $stmt_capo = $conexao->prepare($query_capo);
        $stmt_capo->execute();
        $rs_capo = $stmt_capo->get_result();
        $capinfus = $rs_capo->fetch_assoc();
        $stmt_capo->close();

        $id_capo     = $capinfus['iduser_capger'];

        // Only Capo can create plebiscites
        if($id_user != $id_capo){
            header("Location: pri.php");
            exit;
        }else{
            // Insert new plebiscite
            $query = "INSERT INTO plebs(desc_plebs, perg_plebs, resp1_plebs, resp2_plebs, resp3_plebs, resp4_plebs, creat_plebs, date_plebs, datef_plebs, vis_plebs) VALUES (?,?,?,?,?,?,?,?,?,?)";
            $stmt = $conexao->prepare($query);
            // Bind parameters for plebiscite insertion
            $stmt->bind_param(
                "ssssssssss", // Parameter types: 6 strings, 2 integers, 1 string
                $desc,        // Description of plebiscite
                $pergunta,    // Question
                $resp1,       // Response 1
                $resp2,       // Response 2
                $resp3,       // Response 3
                $resp4,       // Response 4
                $creat,       // Creator user ID
                $date_inic,  // Start date
                $datef,       // End date
                $vis          // Visibility
            );
            $stmt->execute();
            $stmt->close();

            /////// Prepares new notification
            $query_creat = "SELECT * FROM user WHERE id_user = ?";
            $stmt_creat = $conexao->prepare($query_creat);
            $stmt_creat->bind_param("i", $creat);
            $stmt_creat->execute();
            $rs_creat = $stmt_creat->get_result();
            $creatinfo = $rs_creat->fetch_assoc();
            $stmt_creat->close();

            $nom_creat     = $creatinfo['nome_user'];

            $txt = 'Há plebiscito rolando!<br>Vota!';

            $link = 'plebs.php';

            $hoje = new DateTime();
            $hoj = $hoje->format('d/m/Y');
            $hor = $hoje->format('H:i');

            $query_uzeras = "SELECT * FROM user";
            $rs_uzeras = $conexao->query($query_uzeras);

            while($uzerasinfo = $rs_uzeras->fetch_assoc()){
                $id_uzers     = $uzerasinfo['id_user'];

                $query_notif = "INSERT INTO notifs(id_not, iduse_not, msg_not, link_not, date_not, hor_not, sit_not) VALUES (NULL, ?, ?, ?, ?, ?, '0')";
                $stmt_notif = $conexao->prepare($query_notif);
                $stmt_notif->bind_param("issss", $id_uzers, $txt, $link, $hoj, $hor);
                $stmt_notif->execute();
                $stmt_notif->close();
            }
            ///////NOTIF QUERIES

            header("Location: plebs.php");
            exit;
        }
    break;
}
?>
CARREGANDO...