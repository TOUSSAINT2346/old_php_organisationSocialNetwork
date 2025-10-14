<?php
include('conectar.php');
include('rest.php');

// Actions: new, edit, cancel, restore
switch($_GET['a']){
	// Edit event
	case 'edit':

		$id_event	 = (int)$_POST['id']; // Event ID
		$creator	 = (int)$_POST['iu']; // Creator ID
		$tit_new 	 = htmlspecialchars($_POST['tit_event']); // Title
		$data_new	 = $_POST['data_event']; //	Date
		$desc_new	 = htmlspecialchars($_POST['desc_event']); // Description

		$stmt = $conexao->prepare("UPDATE events SET tit_event=?, data_event=?, desc_event=? WHERE id_event=? AND creat_event=?");
		$stmt->bind_param("sssii", $tit_new, $data_new, $desc_new, $id_event, $creator);
		$stmt->execute();
		$stmt->close();
		$conexao->close();

		header("Location: eventsee.php?i=$id_event");
		exit;
	break;
	// Create new event
	case 'new':
	
		$creator	 = (int)$_POST['iu'];
		$tit_new 	 = htmlspecialchars($_POST['tit_event']);
		$data_new	 = $_POST['data_event'];
		$desc_new	 = htmlspecialchars($_POST['desc_event']); // Description

		// Insert new event
		$query_insert= "INSERT INTO events (tit_event, data_event, creat_event) VALUES (?, ?, ?)";
		$stmt_insert = $conexao->prepare($query_insert);
		$stmt_insert->bind_param("ssi", $tit_new, $data_new, $creator);
		$stmt_insert->execute();
		$stmt_insert->close();

		// Fetch creator information
		$query_creat = "SELECT * FROM user WHERE id_user = ?";
		$stmt_creat = $conexao->prepare($query_creat);
		$stmt_creat->bind_param("i", $creator);
		$stmt_creat->execute();
		$result_creat = $stmt_creat->get_result();
		$creatinfo = $result_creat->fetch_assoc();
		$stmt_creat->close();

		$nom_creat     = $creatinfo['nome_user'];

		// Fetch the event that has just been created to get its new ID
		$query_event = "SELECT * FROM events WHERE tit_event = ? AND creat_event = ?";
		$stmt_event = $conexao->prepare($query_event);
		$stmt_event->bind_param("si", $tit_new, $creator);
		$stmt_event->execute();
		$result_event = $stmt_event->get_result();
		$eventinfo = $result_event->fetch_assoc();
		$stmt_event->close();

		$id_event = $eventinfo['id_event'];

		$txt = '<font style="text-transform:capitalize;">' . $nom_creat . '</font> criou um novo evento!<br>Clica aqui para vê-lo!'; // Notification text

		$link = 'eventsee.php?i=' . $id_event; // Notification URL

		$hoje = new DateTime();
		$hoj = $hoje->format('d/m/Y');
		$hor = $hoje->format('H:i');

		$query_uzeras = "SELECT * FROM user";
		$stmt_uzeras  = $conexao->prepare($query_uzeras);
		$stmt_uzeras->execute();
		$result_uzeras = $stmt_uzeras->get_result();

		// Loop through each user to create a notification
		while($uzerasinfo = $result_uzeras->fetch_assoc()){

			$id_uzers     = $uzerasinfo['id_user'];

			$query_notif = "INSERT INTO notifs (id_not, iduse_not, msg_not, link_not, date_not, hor_not, sit_not) VALUES (NULL, ?, ?, ?, ?, ?, '0')";
			$stmt_notif = $conexao->prepare($query_notif);
			$stmt_notif->bind_param("issss", $id_uzers, $txt, $link, $hoj, $hor);
			$stmt_notif->execute();
			$stmt_notif->close();
		}

		header("Location: eventsee.php?i=$id_event");
		exit;		
	break;
	// Cancel event
	case 'anular':
	
		$id_event = (int)$_POST['ie'];
		$creator  = (int)$_POST['creator'];

		$query_cancel 	= "UPDATE event SET exist_event='1' WHERE id_event = ? AND creator_event = ?";
		$stmt_cancel 	= $conexao->prepare($query_cancel);
		$stmt_cancel->bind_param("ii", $id_event, $creator);
		$stmt_cancel->execute();
		$stmt_cancel->close();
		$conexao->close();

		header("Location: eventshow.php?i=$id_event");
		exit;
	break;
	// Restore event
	case 'restaurar':
	
		$id_event = $_POST['ie'];
		$creator  = $_POST['creator'];

		$query_update = "UPDATE event SET exist_event='0' WHERE id_event = ? AND creator_event = ?";
		$stmt_update = $conexao->prepare($query_update);
		$stmt_update->bind_param("ii", $id_event, $creator);
		$stmt_update->execute();
		$stmt_update->close();
		$conexao->close();

		header("Location: eventshow.php?i=$id_event");
		exit;		
	break;
	}
?>
CARREGANDO...