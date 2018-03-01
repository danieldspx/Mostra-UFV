<?php
    session_name(md5("security".$_SERVER['REMODE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
	session_start();
    if(!isset($_SESSION['usuario']['id'])){
        $_SESSION['loginErro'] = "Faça o login!";
        header("Location: index.php");
    }
    $administrador = true;
    require_once 'private_html_protected/config.php';
    require_once 'private_html_protected/connection.php';
    require_once 'private_html_protected/database.php';
    $pagina_atual = $_GET['p'];
    $qpp = 20; //Quantidade por pagina
    if(empty($pagina_atual)){
        $pagina_atual = 1;
    }
    $pagina_atual--;
    $pesquisa = DBSearch("cadastros","INNER JOIN cidades ON cidades_idcidades = cidades.idcidades ORDER BY idcadastro DESC LIMIT ".$pagina_atual*$qpp.",".$qpp,"nome,cidades.descricao AS cidade,isestudante AS estudante, data, idcadastro");

    $totalCadastros = DBSearch("cadastros","WHERE 1","count(*) AS total");
    
    $nPaginas = $totalCadastros[0]['total'];
    if(($nPaginas%$qpp)!=0){
        $nPaginas = round($nPaginas/$qpp) + 1;
    } else{
        $nPaginas = $nPaginas/$qpp;
    }
    
?>
<html>
    <head>
        <link rel="stylesheet" href="css/reset.css">
        <link href="css/font-awesome.css" rel="stylesheet">
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
        <script src="js/jquery.maskMoney.js" type="text/javascript"></script>
        <link href="css/icon.css" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
        <link rel="stylesheet" href="css/relatorio.css">
        <script src="js/relatorio.js" type="text/javascript" defer></script>
    </head>
    <body>
        <div class="container-fluid"> 
            <?php if($administrador==true){ ?>
                <header class="col-md-12" id="headerTag">
                    <div class="col-md-6 col-md-push-3">
                        <div class="row card-panel teal vTotal">
                            <p>Total de Cadastros: <?php echo $totalCadastros[0]['total']; ?></p>
                        </div>
                    </div>
                </header>
            <?php }; ?>
            
            <div id="main" class="col-md-6">
                <table class="striped tableRelatorio">
                    <thead>
                      <tr class="titleTable">
                          <th>Nome</th>
                          <th>Cidade</th>
                          <th>Estudante</th>
                          <th>Data</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i = 0;
                            while(isset($pesquisa[$i])){
                                echo "<tr id='linha".$pesquisa[$i]['idcadastro']."'><td><i class='material-icons clickIcon' title='Excluir este Registro!' onclick='deleteMe(".$pesquisa[$i]['idcadastro'].")'>delete_forever</i> <i class=\"material-icons clickIcon\" title='Alterar o Registro' onclick='alterarRegistro(".$pesquisa[$i]['idcadastro'].")'>create</i>".$pesquisa[$i]['nome']."</td>";
                                echo "<td>".$pesquisa[$i]['cidade']."</td>";
                                $isEstudante = $pesquisa[$i]['estudante']==1 ? "Sim" : "Não";
                                echo "<td>".$isEstudante."</td>";
                                echo "<td>".$pesquisa[$i]['data']."</td></tr>";
                                $i++;
                            }
                        ?>
                    </tbody>
                </table>
                <div id="paginasCenter">
                <ul class="pagination">
                    <li <?php if($pagina_atual == 0){ echo "class=\"disabled\"";} else { echo "class=\"waves-effect\"";} ?>><a onclick="muda_paginaNext(0)"><i class="material-icons">chevron_left</i></a></li>
                    <?php
                        for($i=1;$i<$nPaginas;$i++){
                            if($i==$pagina_atual+1){
                                echo '<li class="active red lighten-1"><a>'.$i.'</a></li>';
                            } else {
                                echo '<li class="waves-effect"><a onclick="muda_paginaParam('.$i.')">'.$i.'</a></li>';
                            }
                        }
                    ?>
                    <li <?php if($pagina_atual+1 == $nPaginas){ echo "class=\"disabled\"";} else { echo "class=\"waves-effect\"";} ?>><a onclick="muda_paginaNext(1)"><i class="material-icons">chevron_right</i></a></li>
                </ul></div>
                <a class="btn-floating btn-large waves-effect waves-light red floatingBack" href="painel.php" title="Voltar"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            </div>
            <div id="loadingDiv">
                <div class="spinner">
                    <div class="double-bounce1"></div>
                    <div class="double-bounce2"></div>
                </div>
            </div>
        <script src="js/Chart.bundle.min.js"></script>
        <script src="js/jquery.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.js"><\/script>')</script>
        <script src="js/vendor/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
    </body>
</html>
