<?php
include('rest.php');
include('conectar.php');

$opc = $_GET['o'] ?? '';
$project_id = $_GET['i'] ?? '';

if(empty($opc) || empty($project_id)){
    header('Location: projectos.php');
    exit;
}

// Fetch user information
$query_guy= "SELECT * FROM user WHERE nickname_user = ?";
$stmt_guy = $conexao->prepare($query_guy);
$stmt_guy->bind_param("s", $login_user);
$stmt_guy->execute();
$rs_guy   = $stmt_guy->get_result();
$infoguy  = $rs_guy->fetch_assoc();
$stmt_guy->close();
                        
$id_user	= $infoguy['id_user'];

// Fetch Capo information
$query_capo = "SELECT * FROM capone_ger ORDER BY id_capger DESC LIMIT 1";
$stmt_capo  = $conexao->prepare($query_capo);
$stmt_capo->execute();
$rs_capo    = $stmt_capo->get_result();
$infocapo   = $rs_capo->fetch_assoc();
$stmt_capo->close();
                        
$id_capo	= $infocapo['iduser_capger'];

if($id_capo == $id_user){

    // INFOS CAPO
    $query_capi = "SELECT * FROM user WHERE id_user = ?";
    $stmt_capi  = $conexao->prepare($query_capi);
    $stmt_capi->bind_param("i", $id_capo);
    $stmt_capi->execute();
    $rs_capi    = $stmt_capi->get_result();
    $infocapi   = $rs_capi->fetch_assoc();
    $stmt_capi->close();
                            
    $nom_capo	= $infocapi['nome_user'];
    $snom_capo	= $infocapi['sobrenome_user'];
    $sex_capo	= $infocapi['sexo_user'];

    // Defines title by gender
    if($sex_capo == 'm'){
        $byz 	= 'pelo Capo Signore';
    }else{
        $byz 	= 'pela Capo Signora';
    }

    // DECISAO
    if($opc == 'a'){
        $decisao = 'Projeto <u>aprovado</u> '. $byz . ' ' . $nom_capo . ' ' . $snom_capo;
    }elseif($opc == 'd'){
        $decisao = 'Projeto <u>reprovado</u> '. $byz . ' ' . $nom_capo . ' ' . $snom_capo;	
    }else{
        $decisao = 'Projeto <u>reprovado</u> '. $byz . ' ' . $nom_capo . ' ' . $snom_capo;		
    }

    // Defines final message by decision
    if($opc == 'a'){
        $finale = 'Projeto <u>aprovado</u> ';
    }elseif($opc == 'd'){
        $finale = 'Projeto <u>reprovado</u> ';	
    }else{
        $finale = 'Projeto <u>reprovado</u> ';		
    }

    // Defines final message by decision
    if($opc == 'a'){
        $finalem = 'O projeto há-de efetivar-se o mais rápido possível';
    }elseif($opc == 'd'){
        $finalem = '';	
    }else{
        $finalem = '';		
    }

    //INFOS PROJET
    $query_proj = "SELECT * FROM projetos WHERE id_proj = ?";
    $stmt_proj  = $conexao->prepare($query_proj);
    $stmt_proj->bind_param("i", $project_id);
    $stmt_proj->execute();
    $rs_proj    = $stmt_proj->get_result();
    $infoproj   = $rs_proj->fetch_assoc();
    $stmt_proj->close();

    $creat_proj = $infoproj['creat_proj'];
    $dat_proj   = $infoproj['dat_proj'];
    $datf_proj  = $infoproj['datf_proj'];

    // Fetch project creator information
    $query_projc    = "SELECT * FROM user WHERE id_user = ?";
    $stmt_projc     = $conexao->prepare($query_projc);
    $stmt_projc->bind_param("i", $creat_proj);
    $stmt_projc->execute();
    $rs_projc   = $stmt_projc->get_result();
    $infoprojc  = $rs_projc->fetch_assoc();
    $stmt_projc->close();

    $nom_cre    = $infoprojc['nome_user'];
    $sobnom_cre = $infoprojc['sobrenome_user'];

    //INFOS END PROJET

    $hoje_data  = new DateTime();
    $hj         = $hoje_data->format('Y-m-d');

    // Update project status
    $query = $conexao->prepare("UPDATE projetos SET sit_proj = ? WHERE id_proj = ?");
    $query->bind_param("si", $decisao, $project_id);
    $query->execute();
    $query->close();

    $titu   = 'Resultado do projeto N&deg; ' . $project_id;

    $textu  = "<p><b>Veredicto del Capo: $decisao</b><br></p><br>
    <p>O projeto de N&deg; $project_id , criado por $nom_cre $sobnom_cre , em $dat_proj , submetido à aprovação del Capo em $datf_proj teve seu veredicto julgado como: <b>$finale </b></p><br><p>$finalem</p>";


    $query2 = $conexao->prepare("INSERT INTO posts(id_post,tit_post,text_post,creat_post,date_post,totutil_post,cat_post,font_post,vis_post,util_post,inutil_post) VALUES (NULL,?,?,0,?,'','m','',0,0,0)");
    $query2->bind_param(
        "sss",
        $titu,
        $textu,
        $hj);
    $query2->execute();
    $query2->close();

    $conexao->close();

    header("Location: readproject.php?i=$project_id");
    exit;
}else{
    header("Location: readproject.php?i=$project_id");
    exit;
}
?>