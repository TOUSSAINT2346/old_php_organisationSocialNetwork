CARREGANDO...
<?php
include('conectar.php');
include('rest.php');

// Actions
switch($_GET['a']){
	case 'pub':
		$text 	= htmlspecialchars($_POST['text_com']); // Comment text
		$use_id	= (int)$_POST['iu']; // User ID
		$idpag 	= (int)$_POST['ie']; // ID of the page (event/post/project)
		$tip 	= htmlspecialchars($_POST['tip']); // Type of page (event/post/project)

		$query_insert = "INSERT INTO comment (creat_com, text_com, tip_com, idpag_com) VALUES (?, ?, ?, ?)";
		$stmt = $conexao->prepare($query_insert);
		$stmt->bind_param("issi", $use_id, $text, $tip, $idpag);
		$stmt->execute();
		$stmt->close();

		/////// Create new notification

		///////////SEARCH FOR PAG CREATOR
		// Depending on the type of page, fetch the creator's ID		
		if($tip == 'event'){ // If it is an event
			$query_coisa 	= "SELECT * FROM events WHERE id_event = ?";
			$stmt_coisa 	= $conexao->prepare($query_coisa);
			$stmt_coisa->bind_param("i", $idpag);
			$stmt_coisa->execute();
			$result_coisa 	= $stmt_coisa->get_result();
			$coisainfo 		= $result_coisa->fetch_assoc();
			$stmt_coisa->close();

			$id_creat     = $coisainfo['creat_event'];		
		}elseif($tip == 'post'){ // If it is a post
			$query_coisa 	= "SELECT * FROM posts WHERE id_post = ?";
			$stmt_coisa 	= $conexao->prepare($query_coisa);
			$stmt_coisa->bind_param("i", $idpag);
			$stmt_coisa->execute();
			$result_coisa 	= $stmt_coisa->get_result();
			$coisainfo 		= $result_coisa->fetch_assoc();
			$stmt_coisa->close();

			$id_creat     = $coisainfo['creat_post'];
		}elseif($tip == 'project'){ // If it is a project
			$query_coisa 	= "SELECT * FROM projetos WHERE id_proj = ?";
			$stmt_coisa 	= $conexao->prepare($query_coisa);
			$stmt_coisa->bind_param("i", $idpag);
			$stmt_coisa->execute();
			$result_coisa 	= $stmt_coisa->get_result();
			$coisainfo 		= $result_coisa->fetch_assoc();
			$stmt_coisa->close();

			$id_creat     = $coisainfo['creat_proj'];
		}
		///////////SEARCH FOR PAG CREATOR

		// If the creator of the page is not the same as the one who commented
		if($id_creat != $use_id){

			$query_comentscreat = "SELECT * FROM user WHERE id_user = ?";
			$stmt_comentscreat 	= $conexao->prepare($query_comentscreat);
			$stmt_comentscreat->bind_param("i", $use_id);
			$stmt_comentscreat->execute();
			$result_comentscreat = $stmt_comentscreat->get_result();
			$comentscreatinfo 	= $result_comentscreat->fetch_assoc();
			$stmt_comentscreat->close();

			$nom_comentscreat     = $comentscreatinfo['nome_user'];

			////PAG KIND
			// Determine the kind of page for the notification message
			if($tip == 'event'){
				$pagkind = 'evento';
			}elseif($tip == 'post'){
				$pagkind = 'artigo';
			}elseif($tip == 'project'){
				$pagkind = 'projeto';
			}
			////PAG KIND

			$txt = '<font style="text-transform:capitalize;">' . $nom_comentscreat . '</font> comentou teu '. $pagkind . '!<br>Clica aqui para lê-lo!';
			
			////PAG LINK
			// Determine the link to the page for the notification
			if($tip == 'event'){
				$link = 'eventsee.php?i=' .$idpag;
			}elseif($tip == 'post'){
				$link = 'readpost.php?i=' .$idpag;
			}elseif($tip == 'project'){
				$link = 'readproject.php?i=' .$idpag;
			}

			$hoje = new DateTime();
			$hoj = $hoje->format('Y-m-d');
			$hor = $hoje->format('H:i');

			$query_notpost = "INSERT INTO notifs (iduse_not, msg_not, link_not, date_not, hor_not, sit_not) VALUES (?, ?, ?, ?, ?, ?)";
			$stmt_notpost = $conexao->prepare($query_notpost);
			$sit_not = 0;
			$stmt_notpost->bind_param("issssi", $id_creat, $txt, $link, $hoj, $hor, $sit_not);
			$stmt_notpost->execute();
			$stmt_notpost->close();
		}
		///////NOTIF QUERIES

		if($tip == 'event'){
			header("Location: eventsee.php?i=$idpag");
			exit;
		}elseif($tip == 'post'){
			header("Location: readpost.php?i=$idpag");
			exit;
		}elseif($tip == 'project'){
			header("Location: readproject.php?i=$idpag");
			exit;
		}
	break;
	// Add a comment
	case 'comment':

		$text     = htmlspecialchars($_POST['text_com']);
		$use_id   = (int)$_POST['iu'];
		$idcom    = (int)$_POST['ip'];
		$tip      = htmlspecialchars($_POST['ie']);
		$im		  = (int)$_POST['im'];

		// Insert the comment into the database
		$query1 = "INSERT INTO comment (creat_com, text_com, tip_com, idpag_com) VALUES (?, ?, ?, ?)";
		$stmt1 = $conexao->prepare($query1);
		$stmt1->bind_param("issi", $use_id, $text, $tip, $idcom);
		$stmt1->execute();
		$stmt1->close();

		///////NOTIF QUERIES

		///////////SEARCH FOR PUB CREATOR
		if($tip == 'event_com'){
			$query_coisa = "SELECT * FROM comment WHERE tip_com = 'event' AND id_com = ?";
			$stmt_coisa = $conexao->prepare($query_coisa);
			$stmt_coisa->bind_param("i", $idcom);
			$stmt_coisa->execute();
			$result_coisa = $stmt_coisa->get_result();
			$coisainfo = $result_coisa->fetch_assoc();
			$stmt_coisa->close();

			$id_creat     = $coisainfo['creat_com'];

		}elseif($tip == 'post_com'){
			$query_coisa = "SELECT * FROM comment WHERE tip_com = 'post' AND id_com = ?";
			$stmt_coisa = $conexao->prepare($query_coisa);
			$stmt_coisa->bind_param("i", $idcom);
			$stmt_coisa->execute();
			$result_coisa = $stmt_coisa->get_result();
			$coisainfo = $result_coisa->fetch_assoc();
			$stmt_coisa->close();

			$id_creat     = $coisainfo['creat_com'];

		}elseif($tip == 'project_com'){
			$query_coisa = "SELECT * FROM comment WHERE tip_com = 'project' AND id_com = ?";
			$stmt_coisa = $conexao->prepare($query_coisa);
			$stmt_coisa->bind_param("i", $idcom);
			$stmt_coisa->execute();
			$result_coisa = $stmt_coisa->get_result();
			$coisainfo = $result_coisa->fetch_assoc();
			$stmt_coisa->close();

			$id_creat     = $coisainfo['creat_com'];
		}
		///////////SEARCH FOR PUB CREATOR

		// If the creator of the original comment is not the same as the one who commented
		if($id_creat != $use_id){

			// Fetch information about the user who made the comment
			$query_comentscreat = "SELECT * FROM user WHERE id_user = ?";
			$stmt_comentscreat = $conexao->prepare($query_comentscreat);
			$stmt_comentscreat->bind_param("i", $use_id);
			$stmt_comentscreat->execute();
			$result_comentscreat = $stmt_comentscreat->get_result();
			$comentscreatinfo = $result_comentscreat->fetch_assoc();
			$stmt_comentscreat->close();

			$nom_comentscreat     = $comentscreatinfo['nome_user'];

			////PAG KIND
			if($tip == 'event_com'){
				$pagkind = 'evento';
			}elseif($tip == 'post_com'){
				$pagkind = 'artigo';
			}elseif($tip == 'project_com'){
				$pagkind = 'projeto';
			}
			////PAG KIND

			///NAME KIND
			if($tip == 'event_com'){
				$query_nomeki = "SELECT * FROM events WHERE id_event = ?";
				$stmt_nomeki = $conexao->prepare($query_nomeki);
				$stmt_nomeki->bind_param("i", $im);
				$stmt_nomeki->execute();
				$result_nomeki = $stmt_nomeki->get_result();
				$nomekiinfo = $result_nomeki->fetch_assoc();
				$stmt_nomeki->close();

				$nom_kind     = $nomekiinfo['tit_event'];
			}elseif($tip == 'post_com'){
				$query_nomeki = "SELECT * FROM posts WHERE id_post = ?";
				$stmt_nomeki = $conexao->prepare($query_nomeki);
				$stmt_nomeki->bind_param("i", $im);
				$stmt_nomeki->execute();
				$result_nomeki = $stmt_nomeki->get_result();
				$nomekiinfo = $result_nomeki->fetch_assoc();
				$stmt_nomeki->close();

				$nom_kind     = $nomekiinfo['tit_post'];
			}elseif($tip == 'project_com'){
				$query_nomeki = "SELECT * FROM projetos WHERE id_proj = ?";
				$stmt_nomeki = $conexao->prepare($query_nomeki);
				$stmt_nomeki->bind_param("i", $im);
				$stmt_nomeki->execute();
				$result_nomeki = $stmt_nomeki->get_result();
				$nomekiinfo = $result_nomeki->fetch_assoc();
				$stmt_nomeki->close();

				$nom_kind     = $nomekiinfo['nome_proj'];
			}
			////NAME KIND

			$txt = '<font style="text-transform:capitalize;">' . $nom_comentscreat . '</font> comentou teu comentário no '. $pagkind . ' &quot;' . $nom_kind . '&quot;!<br>Clica aqui para lê-lo!';

			if($tip == 'event_com'){
				$link = 'eventsee.php?i=' .$im;
			}elseif($tip == 'post_com'){
				$link = 'readpost.php?i=' .$im;
			}elseif($tip == 'project_com'){
				$link = 'readproject.php?i=' .$im;
			}

			$hoje = new DateTime();
			$hoj = $hoje->format('Y-m-d');
			$hor = $hoje->format('H:i');
			
			// Insert the notification into the database
			$query_notpost = "INSERT INTO notifs (iduse_not, msg_not, link_not, date_not, hor_not, sit_not) VALUES (?, ?, ?, ?, ?, ?)";
			$stmt_notpost = $conexao->prepare($query_notpost);
			$sit_not = 0;
			$stmt_notpost->bind_param("issssi", $id_creat, $txt, $link, $hoj, $hor, $sit_not);
			$stmt_notpost->execute();
			$stmt_notpost->close();
		}
		///////NOTIF QUERIES

		if($tip == 'event_com'){
			header("Location: eventsee.php?i=$im");
			exit;
		}elseif($tip == 'post_com'){
			header("Location: readpost.php?i=$im");
			exit;
		}elseif($tip == 'project_com'){
			header("Location: readproject.php?i=$im");
			exit;
		}
	break;
	// Add a new Capo's Parola
	case 'capo':

		$text = $_POST['text'];

		// WHO'S CAPO?
		$query_capuma = "SELECT * FROM capone_ger ORDER BY id_capger DESC LIMIT 1";
		$stmt_capuma  = $conexao->prepare($query_capuma);
		$stmt_capuma->execute();
		$result_capuma 	= $stmt_capuma->get_result();
		$capumainfus  	= $result_capuma->fetch_assoc();

		$id_capuma     = $capumainfus['iduser_capger'];

		// WHO'S USER?
		$query_useruma = "SELECT * FROM user WHERE nickname_user = ?";
		$stmt_useruma = $conexao->prepare($query_useruma);
		$stmt_useruma->bind_param("s", $login_user);
		$stmt_useruma->execute();
		$result_useruma = $stmt_useruma->get_result();
		$userumainfus = $result_useruma->fetch_assoc();
		$stmt_useruma->close();

		$id_useruma     = $userumainfus['id_user'];

		if($id_useruma == $id_capuma){
			$query1 = $conexao->prepare("INSERT INTO parola (id_parola, text_parola, creat_parola) VALUES (NULL, ?, ?)");
			$query1->bind_param("si", $text, $id_useruma);
			$query1->execute();
			$query1->close();

			header("Location: parola.php");
			exit;
		}else{
			header("Location: parola.php");
			exit;
		}
	break;
}
?>
CARREGANDO...