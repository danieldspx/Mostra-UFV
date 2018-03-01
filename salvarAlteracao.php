<?php
    session_name(md5("security".$_SERVER['REMODE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
	session_start();
    require_once 'private_html_protected/config.php';
    require_once 'private_html_protected/connection.php'; //Arquivos para salvar as alterações no Registro
    require_once 'private_html_protected/database.php';
    date_default_timezone_set('America/Sao_Paulo');
    $id_user = $_SESSION['usuario']['id'];
    $data = date("H:i:s d/m/Y");
    $update['idcadastro'] = $_POST['idcadastro'];
    $update['interesse'] = isset($_POST['interesse']) ? $_POST['interesse'] : 0;
    $update['isestudante'] = isset($_POST['isEstudante']) ? $_POST['isEstudante'] : 0;
    $update['nome'] = $_POST['nome'];
    $update['email'] = $_POST['email'];
    $update['telefone'] = $_POST['telefone'];
    $update['data'] = $data;
    $update['curso_idcurso'] = $_POST['curso1'];
    $update['segop_curso'] = $_POST['curso2'];
    $update['nivel'] = $_POST['lvlEM'];
    $update['tipo'] = $_POST['typeEscola'] ;
    $update['cidade'] = $_POST['cidade'];
    $update['divulgacao'] = $_POST['divulga'];
    $update['admin_id'] = $id_user;
    $update['motivo'] = $_POST['motivoVisita'];
    
    $query = "UPDATE cadastros SET isestudante=$update[isestudante],interesseufv=$update[interesse],nome='$update[nome]',email='$update[email]',telefone='$update[telefone]',data='$data',curso_idcurso=$update[curso_idcurso],segop_curso=$update[segop_curso],nivel_escola_id_lvlEscola=$update[nivel],tipo_escola_id_typeEscola=$update[tipo],cidades_idcidades=$update[cidade],divulgacao_id=$update[divulgacao],admin_id=$id_user,motivo_visita='$update[motivo]' WHERE idcadastro = $update[idcadastro]";
    if(isset($id_user)){
        DBExecute($query);
    }
    header("Location: relatorio.php");
    
        
    
?>