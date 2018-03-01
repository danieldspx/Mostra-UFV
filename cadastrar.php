<?php
    session_name(md5("security".$_SERVER['REMODE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
	session_start();
    require_once 'private_html_protected/config.php';
    require_once 'private_html_protected/connection.php';
    require_once 'private_html_protected/database.php';
    date_default_timezone_set('America/Sao_Paulo');
    $id_user = $_SESSION['usuario']['id'];
    $data = date("H:i:s d/m/Y");
    $cadastro['isestudante'] = $_POST['isEstudante']=='' ? 0 : 1;
    $cadastro['interesseufv'] = $_POST['interesse']=='' ? 0 : 1;
    $cadastro['nome'] = strtoupper($_POST['nome']);
    $cadastro['email'] = strtoupper($_POST['email']);
    $cadastro['telefone'] = $_POST['telefone'];
    $cadastro['data'] = $data;
    $cadastro['curso_idcurso'] = $_POST['curso1'];
    $cadastro['segop_curso'] = $_POST['curso2'];
    $cadastro['nivel_escola_id_lvlEscola'] = $_POST['lvlEM'];
    $cadastro['tipo_escola_id_typeEscola'] = $_POST['typeEscola'] ;
    $cadastro['cidades_idcidades'] = $_POST['cidade'];
    $cadastro['divulgacao_id'] = $_POST['divulga'];
    $cadastro['admin_id'] = $id_user;
    $cadastro['motivo_visita'] = $_POST['motivoVisita'];
    DBCadastro('cadastros',$cadastro);//Cadastra
    header("Location: painel.php");
?>