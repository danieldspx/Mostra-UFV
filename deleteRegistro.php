<?php
    session_name(md5("security".$_SERVER['REMODE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
	session_start();
    if(isset($_SESSION['usuario']['id'])){
        require_once 'private_html_protected/config.php';
        require_once 'private_html_protected/connection.php';
        require_once 'private_html_protected/database.php';
        $idCad = $_POST['idcadastro'];
        $query = "DELETE FROM cadastros WHERE idcadastro = ".$idCad;
        DBExecute($query);
    }
?>