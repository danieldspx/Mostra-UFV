<?php
    session_name(md5("security".$_SERVER['REMODE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
	session_start();
    if(!isset($_SESSION['usuario']['id'])){
        $_SESSION['loginErro'] = "Faça o login!";
        header("Location: index.php");
    }
    if(isset($_GET['logout'])){
        $_SESSION = array();
        session_destroy();
        session_name(md5("security".$_SERVER['REMODE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
	    session_start();
        $_SESSION['loginErro'] = "Você saiu com sucesso!";
        header("Location: index.php");
    }
    if(empty($_GET['idcadastro'])){
        header('Location: relatorio.php');
    }
    $id_cadastro = $_GET['idcadastro'];

    require_once 'private_html_protected/config.php';
    require_once 'private_html_protected/connection.php'; //Arquivos para Pesquisa
    require_once 'private_html_protected/database.php';
    
    $pesquisa = DBSearch("cadastros","WHERE idcadastro = $id_cadastro LIMIT 1","idcadastro, isestudante, interesseufv, nome, email, telefone, curso_idcurso AS curso_1, segop_curso AS curso_2, nivel_escola_id_lvlEscola AS nivel, tipo_escola_id_typeEscola AS tipo, cidades_idcidades AS cidade, divulgacao_id, motivo_visita AS motivo");
    $cidades = DBSearch("cidades");
    $cursos = DBSearch("curso");
    $tipo_escola = DBSearch("tipo_escola");
    $lvl = DBSearch("nivel_escola");
    $divulgacao = DBSearch("divulgacao");
?>
<html>
    <head>
        <link rel="stylesheet" href="css/reset.css">
        <link href="css/font-awesome.css" rel="stylesheet">
        <style>
            @font-face {
                font-family: 'Montserrat' ;
                font-style: normal;
                font-weight: normal;
                src: url('fonts/Montserrat-Regular.ttf');
            }
            @font-face {
                font-family: 'Material Icons' ;
                font-style: normal;
                font-weight: normal;
                src: url('fonts/MaterialIcons-Regular.ttf');
            }
        </style>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Mostra de Profissões</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="sortcut icon" href="img/bonfire.png" type="image/png"/>
        <script src="js/jquery-1.11.1.min.js"></script>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/animate.css">
        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
        <script src="js/jquery.min.js" type="text/javascript"></script>
        <link href="css/icon.css" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
        <link rel="stylesheet" href="css/painel.css">
        <script src="js/painel.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            <header class="col-md-12">
                <div class="row">
                    <a href="painel.php"><button class="waves-effect waves-light btn-large cyan darken-1 btnTop">Cadastrar</button></a>
                </div>
                
                <hr class="separador" class="row">
                
            </header>
            <div class="main">
            <form method="post" action="salvarAlteracao.php">
                <div class="row">
                    <div class="input-field col s6 nplf">
                    <i class="material-icons prefix setColor">account_circle</i>
                    <input id="nome" name="nome" type="text" <?php echo "value=\"".$pesquisa[0]['nome']."\"";?> class="validate" required>
                    <label for="nome">Nome</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6 nplf">
                        <i class="material-icons prefix setColor">email</i>
                        <input id="email" name="email" type="email" <?php echo "value=\"".$pesquisa[0]['email']."\"";?> class="validate">
                        <label for="email">Email</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6 nplf">
                        <i class="material-icons prefix setColor">phone_android</i>
                        <input id="telefone" name="telefone" type="text" class="validate" <?php echo "value=\"".$pesquisa[0]['telefone']."\"";?> onkeydown="MaskDown(this)" onkeyup="MaskUp(this,event,'(##) #####-####')">
                        <label for="telefone">Telefone</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6 nplf">
                        <i class="material-icons prefix setColor">place</i>
                        <label>Cidade:</label><br><br>
                        <select required id="cidade" name="cidade" style="display: block">
                            <?php
                                $i = 1;
                                while(isset($cidades[$i-1])){
                                    if($cidades[$i-1]['idcidades'] == $pesquisa[0]['cidade']){
                                        echo "<option value='$i' selected>".$cidades[$i-1]['descricao']."</option>";
                                    } else {
                                        echo "<option value='$i'>".$cidades[$i-1]['descricao']."</option>";
                                    }
                                    $i++;
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6 nplf">
                    <label style="position: relative;left: 0px;margin-left: 0px; font-size:1.2rem;">Como ficou sabendo do Evento: </label><br>
                        <?php
                            $i = 1;
                            while(isset($divulgacao[$i-1])){
                                if($divulgacao[$i-1]['id'] == $pesquisa[0]['divulgacao_id']){
                                    echo "<input type='radio' required class='filled-in' checked id='divulga$i' value='$i' name='divulga'/>
                                    <label for='divulga$i'>".$divulgacao[$i-1]['descricao']."</label><br>";
                                } else {
                                    echo "<input type='radio' required class='filled-in' id='divulga$i' value='$i' name='divulga'/>
                                    <label for='divulga$i'>".$divulgacao[$i-1]['descricao']."</label><br>";
                                }
                                $i++;
                            }
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="switch">
                    <label for="isEstudante" class="lblSwitch">Você é estudante?</label><br>
                        <label>
                        Não
                        <input id="isEstudante" name="isEstudante" onchange="isStudent(this)" <?php echo "value='".$pesquisa[0]['isestudante']."'";
                        if($pesquisa[0]['isestudante']==1){
                            echo " checked";
                        }?> type="checkbox">
                        <span class="lever"></span>
                        Sim
                        </label>
                    </div>
                </div>
                <div class="row noStudent">
                    <div class="switch">
                    <label for="interesse" class="lblSwitch">Você tem interesse em estudar na UFV?</label><br>
                        <label>
                        Não
                        <input id="interesse" name="interesse" onchange="interesseUFV(this)" <?php echo "value='".$pesquisa[0]['interesseufv']."'";
                        if($pesquisa[0]['interesseufv']==1){
                            echo " checked";
                        }?> type="checkbox">
                        <span class="lever"></span>
                        Sim
                        </label>
                    </div>
                </div>
                <div class="row motivoVisita">
                    <div class="input-field col s6 nplf">
                        <textarea id="motivoVisita" name="motivoVisita" class="materialize-textarea"><?php echo $pesquisa[0]['motivo']; ?></textarea>
                        <label for="motivoVisita">Motivo da Visita</label>
                    </div>
                </div>
                <div class="row isStudent">
                    <div class="input-field col s6 nplf">
                        <label>Nível de Ensino:</label><br><br>
                        <select id="lvlEM" name="lvlEM" style="display: block">
                                <?php
                                    $i = 1;
                                    while(isset($lvl[$i-1])){
                                        if($lvl[$i-1]['id_lvlEscola'] == $pesquisa[0]['nivel']){
                                            echo "<option value='$i' selected>".$lvl[$i-1]['descricao']."</option>";
                                        } else {
                                            echo "<option value='$i'>".$lvl[$i-1]['descricao']."</option>";
                                        }
                                        $i++;
                                    }
                                ?>
                        </select>
                    </div>
                </div>
                <div class="row isStudent">
                <div class="input-field col s6 nplf">
                        <label>Tipo de Escola:</label><br><br>
                        <select id="typeEscola" name="typeEscola" style="display: block">
                                <?php
                                    $i = 1;
                                    while(isset($tipo_escola[$i-1])){
                                        if($tipo_escola[$i-1]['id_typeEscola'] == $pesquisa[0]['tipo']){
                                            echo "<option value='$i' selected>".$tipo_escola[$i-1]['descricao']."</option>";
                                        } else {
                                            echo "<option value='$i'>".$tipo_escola[$i-1]['descricao']."</option>";
                                        }
                                        $i++;
                                    }
                                ?>
                        </select>
                    </div>
                </div>
                <div class="row cursoInteresse">
                    <div class="input-field col s6 nplf">
                        <label>Curso de 1ª Opção:</label><br><br>
                            <select id="curso1" name="curso1" style="display: block">
                                <?php
                                    $i = 0;
                                    while(isset($cursos[$i])){
                                        if($cursos[$i]['idcurso'] == $pesquisa[0]['curso_1']){
                                            echo "<option value='$i' selected>".$cursos[$i]['descricao']."</option>";
                                        } else {
                                            echo "<option value='$i'>".$cursos[$i]['descricao']."</option>";
                                        }
                                        $i++;
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                <div class="row cursoInteresse">
                    <div class="input-field col s6 nplf">
                        <label>Curso de 2ª Opção:</label><br><br>
                            <select id="curso2" name="curso2" style="display: block">
                                <?php
                                    $i = 0;
                                    while(isset($cursos[$i])){
                                        if($cursos[$i]['idcurso'] == $pesquisa[0]['curso_2']){
                                            echo "<option value='$i' selected>".$cursos[$i]['descricao']."</option>";
                                        } else {
                                            echo "<option value='$i'>".$cursos[$i]['descricao']."</option>";
                                        }
                                        $i++;
                                    }
                                ?>
                            </select>
                    </div>
                </div>
                <input type="hidden" name="idcadastro" <?php echo "value='$id_cadastro'"; ?> >
                <br><br>
                <div class="row">
                    <div class="col s6 offset-s1">
                        <button class="waves-effect waves-light btn-large red accent-2" type="submit" onclick="validaRadio()">Salvar Alterações</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
        <script src="js/jquery.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.js"><\/script>')</script>
        <script src="js/vendor/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        <script defer>
            function isStudent(elem){
                if(elem.value==1){
                   elem.value=0;
                } else {
                    elem.value=1;
                }
            }

            function validaRadio(){
                var elem = document.getElementsByName('divulga');
                var encontrou = 0;
                for(var i=0;i<elem.length;i++){
                    if(elem[i].checked==true){
                       encontrou = 1;
                    }
                }
                if(encontrou==0){
                   Materialize.toast("Selecione 'Como ficou sabendo do Evento'",4500);
                }
            }

            function interesseUFV(elem){
                if(elem.value==1){
                   elem.value=0;
                } else {
                    elem.value=1;
                }
            }
        </script>
    </body>
</html>
