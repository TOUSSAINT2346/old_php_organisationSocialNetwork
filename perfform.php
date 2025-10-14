CARREGANDO...
<?php
include('conectar.php');
include('rest.php');


switch($_GET['a']){
	case 'edit':

        $bday_new     = $_POST['bday_new'];
        $turno_new	 = $_POST['turno_new'];
        $desc_new	 = $_POST['desc_new'];

        if($bday_new == '' || $turno_new == '' || $desc_new == ''){
            header("Location: editperfil.php?i=erro");
            exit;
        }else{
            $query_guy = "SELECT id_user FROM user WHERE nickname_user = ?";
            $stmt_guy = $conexao->prepare($query_guy);
            $stmt_guy->bind_param("s", $login_user);
            $stmt_guy->execute();
            $stmt_guy->bind_result($id_user);
            $stmt_guy->fetch();
            $stmt_guy->close();

            $query = "UPDATE user SET bday_user = ?, turno_user = ?, desc_user = ? WHERE id_user = ?";
            $stmt = $conexao->prepare($query);
            $stmt->bind_param("sssi", $bday_new, $turno_new, $desc_new, $id_user);
            $stmt->execute();
            $stmt->close();
            $conexao->close();

            header("Location: perfil.php");
            exit;
        }
    break;
    case 'pass':
        $pass_new = password_hash($_POST['pass_new'], PASSWORD_DEFAULT);
        $pass_old = $_POST['pass_old'];

        $query_guy = "SELECT id_user, pass_user FROM user WHERE nickname_user = ?";
        $stmt_guy = $conexao->prepare($query_guy);
        $stmt_guy->bind_param("s", $login_user);
        $stmt_guy->execute();
        $stmt_guy->bind_result($id_user, $user_pass);
        $stmt_guy->fetch();
        $stmt_guy->close();

        if (password_verify($pass_old, $user_pass)) {
            $query = "UPDATE user SET pass_user = ? WHERE id_user = ?";
            $stmt = $conexao->prepare($query);
            $stmt->bind_param("si", $pass_new, $id_user);
            $stmt->execute();
            $stmt->close();
            $conexao->close();

            header("Location: perfil.php");
            exit;
        } else {
            header("Location: editperfil.php?t=senha&i=erro");
            exit;
        }
    break;
	case 'photo':
    function findexts($filename) {
        $filename = strtolower($filename);
        $exts = pathinfo($filename, PATHINFO_EXTENSION);
        return $exts;
    }

    $query_guy = "SELECT id_user, photo_user FROM user WHERE nickname_user = ?";
    $stmt_guy = $conexao->prepare($query_guy);
    $stmt_guy->bind_param("s", $login_user);
    $stmt_guy->execute();
    $stmt_guy->bind_result($id_guy, $photo_old);
    $stmt_guy->fetch();
    $stmt_guy->close();

    if ($_FILES['photo_new']['name'] == '') {
        header("Location: perfil.php");
        exit;
    } else {
        $ext = findexts($_FILES['photo_new']['name']);
        $ran = rand();
        $photo_fim = $ran . '.' . $ext;
        $target = "photos/user/" . $photo_fim;

        if (move_uploaded_file($_FILES['photo_new']['tmp_name'], $target)) {
            if ($photo_old != 'nonem' && !empty($photo_old)) {
                @unlink('photos/user/' . $photo_old);
            }
            $query = "UPDATE user SET photo_user = ? WHERE id_user = ?";
            $stmt = $conexao->prepare($query);
            $stmt->bind_param("si", $photo_fim, $id_guy);
            $stmt->execute();
            $stmt->close();
            $conexao->close();
            header("Location: perfil.php");
            exit;
        } else {
            header("Location: editperfil.php?t=photo&i=erro");
            exit;
        }
    }
    break;
}
?>
CARREGANDO...