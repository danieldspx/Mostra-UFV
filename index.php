<?php
    session_name(md5("security".$_SERVER['REMODE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
	session_start();
    if(isset($_SESSION['usuario']['id'])){
        header('Location: painel.php');
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Mostra de Profissões</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="sortcut icon" href="img/bonfire.png" type="image/png"/>
        <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="css/index.css"/>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <p id="imgLogo" style="text-align:center">
            <img  src="img/logo-sem-inscricao.png" id="imgUFV" width="100px" title="Universidade Federal de Viçosa" alt="Logo da UFV">
        </p>
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Sistema de Cadastro - Mostra de Profissões UFV - Florestal</h1>
            <div class="account-wall">
                <img class="profile-img" src="img/photo.png"
                    alt="">
                <form class="form-signin" action="valida.php" method="POST">
                    <input type="text" class="form-control" autocomplete="off" placeholder="E-mail" name="nEmail" required autofocus>
                    <br>
                    <input style="margin-top 10px;" type="password" autocomplete="off" class="form-control" placeholder="Password" name="nPassword" required>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">
                        Sign in</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--
    Made with <3 by Daniel dos Santos - 2017
-->
<script type="text/javascript">
    <?php
        if(isset($_SESSION['loginErro'])){
            echo "setTimeout(function(){Materialize.toast('".$_SESSION['loginErro']."', 3500)},0);";
            unset($_SESSION['loginErro']);
        }
    ?>
</script>
<script type="text/javascript" src="js/materialize.min.js"></script>
</body>
</html>
