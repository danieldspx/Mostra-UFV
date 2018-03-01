<?php
    session_name(md5("security".$_SERVER['REMODE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
	session_start();
    if(!isset($_SESSION['usuario']['id'])){
        $_SESSION['loginErro'] = "Faça o login!";
        header("Location: index.php");
    }
    require_once 'private_html_protected/config.php';
    require_once 'private_html_protected/connection.php';
    require_once 'private_html_protected/database.php';
    $pagina_atual = $_GET['p'];
    $qpp = 20; //Quantidade por pagina
    if(empty($pagina_atual)){
        $pagina_atual = 1;
    }
    $pagina_atual--;
    $total = DBSearch("cadastros","","COUNT(*) AS total");
    $nPaginas = $total[0]['total'];
    unset($pesquisaNP);
    if(($nPaginas%$qpp)!=0){
        $nPaginas = round($nPaginas/$qpp) + 1;
    } else{
        $nPaginas = $nPaginas/$qpp;
    }
    //------------------------PESQUISA DE DADOS--------------------//
    $pesquisa = DBSearch("cadastros","","COUNT(*) AS total");
    $total_cadastros = $pesquisa[0]['total'];
    unset($pesquisa);

    $pesquisa = DBSearch("cadastros","WHERE isestudante = 0 AND interesseufv = 1","COUNT(*) AS total");
    $nsInteressado = $pesquisa[0]['total'];
    unset($pesquisa);

    //CURSOS OP1
    $pesquisa = DBSearch("cadastros","WHERE curso_idcurso>=2 AND curso_idcurso<=11","COUNT(*) AS total");
    $supUFV1 = $pesquisa[0]['total'];
    unset($pesquisa);
    $pesquisa = DBSearch("cadastros","WHERE curso_idcurso>=12 AND curso_idcurso<=17","COUNT(*) AS total");
    $tecUFV1 = $pesquisa[0]['total'];
    unset($pesquisa);
    $pesquisa = DBSearch("cadastros","WHERE curso_idcurso=0 AND (isestudante = 1 OR interesseufv = 1)","COUNT(*) AS total");
    $nenhumUFV1 = $pesquisa[0]['total'];
    unset($pesquisa);

    //CURSOS OP2
    $pesquisa = DBSearch("cadastros","WHERE segop_curso>=2 AND segop_curso<=11","COUNT(*) AS total");
    $supUFV2 = $pesquisa[0]['total'];
    unset($pesquisa);
    $pesquisa = DBSearch("cadastros","WHERE segop_curso>=12 AND segop_curso<=17","COUNT(*) AS total");
    $tecUFV2 = $pesquisa[0]['total'];
    unset($pesquisa);
    $pesquisa = DBSearch("cadastros","WHERE segop_curso=0  AND (isestudante = 1 OR interesseufv = 1)","COUNT(*) AS total");
    $nenhumUFV2 = $pesquisa[0]['total'];
    unset($pesquisa);

    //Escola Pública
    $pesquisa = DBSearch("cadastros","WHERE tipo_escola_id_typeEscola = 1","COUNT(*) AS total");
    $publica = $pesquisa[0]['total'];
    unset($pesquisa);
    
    //Escola Privada
    $pesquisa = DBSearch("cadastros","WHERE tipo_escola_id_typeEscola = 2","COUNT(*) AS total");
    $privada = $pesquisa[0]['total'];
    unset($pesquisa);

    //Nivel Ensino
        //Fundamental
        $pesquisa = DBSearch("cadastros","WHERE nivel_escola_id_lvlEscola = 1","COUNT(*) AS total");
        $fundamental = $pesquisa[0]['total'];
        unset($pesquisa);
        //Médio
        $pesquisa = DBSearch("cadastros","WHERE nivel_escola_id_lvlEscola = 2","COUNT(*) AS total");
        $medio = $pesquisa[0]['total'];
        unset($pesquisa);
        //Graduação
        $pesquisa = DBSearch("cadastros","WHERE nivel_escola_id_lvlEscola = 3","COUNT(*) AS total");
        $graduacao = $pesquisa[0]['total'];
        unset($pesquisa);
        //Pós-Graduação
        $pesquisa = DBSearch("cadastros","WHERE nivel_escola_id_lvlEscola = 4","COUNT(*) AS total");
        $posgraduacao = $pesquisa[0]['total'];
        unset($pesquisa);
        //Pós-Graduação
        $pesquisa = DBSearch("cadastros","WHERE nivel_escola_id_lvlEscola = 6","COUNT(*) AS total");
        $lvloutro = $pesquisa[0]['total'];
        unset($pesquisa);


    //Estudantes
    $pesquisa = DBSearch("cadastros","WHERE isestudante = 1","COUNT(*) AS total");
    $isestudante = $pesquisa[0]['total'];
    unset($pesquisa);

    //Estudantes
    $pesquisa = DBSearch("cadastros","WHERE interesseufv = 1","COUNT(*) AS total");
    $interesse = $pesquisa[0]['total'];
    unset($pesquisa);

    //Divulgação
        //Internet
        $pesquisa = DBSearch("cadastros","WHERE divulgacao_id = 1","COUNT(*) AS total");
        $internet = $pesquisa[0]['total'];
        unset($pesquisa);
        //Panfleto
        $pesquisa = DBSearch("cadastros","WHERE divulgacao_id = 2","COUNT(*) AS total");
        $panfleto = $pesquisa[0]['total'];
        unset($pesquisa);
        //TV
        $pesquisa = DBSearch("cadastros","WHERE divulgacao_id = 3","COUNT(*) AS total");
        $tv = $pesquisa[0]['total'];
        unset($pesquisa);
        //Rádio
        $pesquisa = DBSearch("cadastros","WHERE divulgacao_id = 4","COUNT(*) AS total");
        $radio = $pesquisa[0]['total'];
        unset($pesquisa);
        //Amigo
        $pesquisa = DBSearch("cadastros","WHERE divulgacao_id = 5","COUNT(*) AS total");
        $amigo = $pesquisa[0]['total'];
        unset($pesquisa);
        //Visitou a UFV-Florestal
        $pesquisa = DBSearch("cadastros","WHERE divulgacao_id = 6","COUNT(*) AS total");
        $visita = $pesquisa[0]['total'];
        unset($pesquisa);
?>
<html>
    <head>
        <link rel="stylesheet" href="css/reset.css">
        <link href="css/font-awesome.css" rel="stylesheet">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Relatorio - Mostra de Profissões</title>
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
        <link rel="stylesheet" href="css/graficos.css">
        <script src="js/graficos.js" type="text/javascript" defer></script>
    </head>
    <body>
        <div class="container-fluid"> 
            <div id="main" class="col-md-12">
                <div class="row">
                    <div role="main" class="col-md-5 col-xs-12 z-depth-4 graph">
                        <canvas id="cursos1"></canvas><label class="lblSubGraph">*Considerando ESTUDANTES e NÃO ESTUDANTES(INTERESSADOS EM ESTUDAR NA UFV)</label>
                        <canvas id="cursos2"></canvas><label class="lblSubGraph">*Considerando ESTUDANTES e NÃO ESTUDANTES(INTERESSADOS EM ESTUDAR NA UFV)</label>
                    </div>
                    <div role="main" class="col-md-5 col-md-push-1 col-xs-12 z-depth-4 graph">
                        <canvas id="lvlEnsino"></canvas><label class="lblSubGraph">*Considerando apenas ESTUDANTES</label>
                        <canvas id="tipoEnsino"></canvas><label class="lblSubGraph">*Considerando apenas ESTUDANTES</label>
                    </div>
                </div>
                <div class="row">
                    <div role="main" class="col-md-5 col-xs-12 z-depth-4 graph">
                        <canvas id="isEstudante"></canvas><label class="lblSubGraph">*Considerando todos</label>
                        <canvas id="interesse"></canvas><label class="lblSubGraph">*Considerando apenas NÃO ESTUDANTES</label>
                    </div>
                    <div role="main" class="col-md-5 col-md-push-1 col-xs-12 z-depth-4 graph">
                        <canvas id="divulgacao"></canvas><label class="lblSubGraph">*Considerando todos</label>
                    </div>
                </div>
                <a class="btn-floating btn-large waves-effect waves-light red floatingBack" href="painel.php" title="Voltar"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            </div>
            <div id="loadingDiv">
                <div class="spinner">
                    <div class="double-bounce1"></div>
                    <div class="double-bounce2"></div>
                </div>
            </div>
        <script src="js/Chart.bundle.min.js"></script>
        <script>
            var ctx1 = document.getElementById("cursos1").getContext("2d");
            var chartGraph1 = new Chart(ctx1, {
                type: 'doughnut',
                data:{
                    labels: [
                        "Superior UFV",
                        "Técnico UFV",
                        "Nenhum",
                        "Outros Cursos"
                    ],
                    datasets: [
                        {
                            data: [<?php echo("$supUFV1,$tecUFV1,$nenhumUFV1,".(($nsInteressado+$isestudante)-($supUFV1+$tecUFV1+$nenhumUFV1))); ?>],
                            borderColor: [
                                "rgba(35, 35, 35, .8)",
                                "rgba(35, 35, 35, .8)",
                                "rgba(35, 35, 35, .8)",
                                "rgba(35, 35, 35, .8)"
                            ],
                            backgroundColor: [
                                "#2ecc71",
                                "#f39c12",
                                "#ef5350",
                                "#3498db"
                            ]
                        }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Cursos Preferidos 1ª Opção',
                        fontFamily: "'Arial', 'sans-serfi'",
                        fontSize: 25
                    },
                    animation: {
                        easing: 'easeOutBounce'
                    },
                    legend: {
                        display: true,
                    }
                }
            });
            var ctx2 = document.getElementById("cursos2").getContext("2d");
            var chartGraph2 = new Chart(ctx2, {
                type: 'doughnut',
                data:{
                    labels: [
                        "Superior UFV",
                        "Técnico UFV",
                        "Nenhum",
                        "Outros Cursos"
                    ],
                    datasets: [
                        {
                            data: [<?php echo("$supUFV2,$tecUFV2,$nenhumUFV2,".(($nsInteressado+$isestudante)-($supUFV2+$tecUFV2+$nenhumUFV2))); ?>],
                            borderColor: [
                                "rgba(35, 35, 35, .8)",
                                "rgba(35, 35, 35, .8)",
                                "rgba(35, 35, 35, .8)",
                                "rgba(35, 35, 35, .8)"
                            ],
                            backgroundColor: [
                                "#2ecc71",
                                "#f39c12",
                                "#ef5350",
                                "#3498db"
                            ]
                        }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Cursos Preferidos 2ª Opção',
                        fontFamily: "'Arial', 'sans-serfi'",
                        fontSize: 25
                    },
                    animation: {
                        easing: 'easeOutBounce'
                    },
                    legend: {
                        display: true,
                    }
                }
            });
            
            
            
            
            //----------------------------//
            
            
            
            var ctx3 = document.getElementById("lvlEnsino").getContext("2d");
            var chartGraph3 = new Chart(ctx3, {
                type: 'doughnut',
                data:{
                    labels: [
                        "Ensino Fundamental",
                        "Ensino Médio",
                        "Graduação",
                        "Pós-Graduação",
                        "Outro",
                        "Nenhum"
                    ],
                    datasets: [
                        {
                            data: [<?php echo("$fundamental,$medio,$graduacao,$posgraduacao,$lvloutro,".($isestudante-($fundamental+$medio+$graduacao+$posgraduacao+$lvloutro))); ?>],
                            borderColor: [
                                "rgba(35, 35, 35, .8)",
                                "rgba(35, 35, 35, .8)",
                                "rgba(35, 35, 35, .8)",
                                "rgba(35, 35, 35, .8)",
                                "rgba(35, 35, 35, .8)",
                                "rgba(35, 35, 35, .8)"
                            ],
                            backgroundColor: [
                                "#64b5f6",
                                "#26a69a",
                                "#4caf50",
                                "#ffa726",
                                "#00e676",
                                "#ef5350"
                            ]
                        }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Nível de Ensino',
                        fontFamily: "'Arial', 'sans-serfi'",
                        fontSize: 25
                    },
                    animation: {
                        easing: 'easeOutBounce'
                    },
                    legend: {
                        display: true,
                    }
                }
            });
            var ctx4 = document.getElementById("tipoEnsino").getContext("2d");
            var chartGraph4 = new Chart(ctx4, {
                type: 'doughnut',
                data:{
                    labels: [
                        "Pública",
                        "Privada",
                        "Nenhum"
                    ],
                    datasets: [
                        {
                            data: [<?php echo("$publica,$privada,".($isestudante-($publica+$privada))); ?>],
                            borderColor: [
                                "rgba(35, 35, 35, .8)",
                                "rgba(35, 35, 35, .8)",
                                "rgba(35, 35, 35, .8)"
                            ],
                            backgroundColor: [
                                "#2ecc71",
                                "#3498db",
                                "#f44336"
                            ]
                        }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Tipo de Ensino',
                        fontFamily: "'Arial', 'sans-serfi'",
                        fontSize: 25
                    },
                    animation: {
                        easing: 'easeOutBounce'
                    },
                    legend: {
                        display: true,
                    }
                }
            });
            
            
            //----------------------------------/
            
            
             var ctx5 = document.getElementById("isEstudante").getContext("2d");
            var chartGraph5 = new Chart(ctx5, {
                type: 'doughnut',
                data:{
                    labels: [
                        "Estudantes",
                        "Não Estudantes"
                    ],
                    datasets: [
                        {
                            data: [<?php echo("$isestudante,".($total_cadastros-$isestudante)); ?>],
                            borderColor: [
                                "rgba(35, 35, 35, .8)",
                                "rgba(35, 35, 35, .8)"
                            ],
                            backgroundColor: [
                                "#2ecc71",
                                "#ef5350"
                            ]
                        }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Número de Estudantes',
                        fontFamily: "'Arial', 'sans-serfi'",
                        fontSize: 25
                    },
                    animation: {
                        easing: 'easeOutBounce'
                    },
                    legend: {
                        display: true,
                    }
                }
            });
            var ctx6 = document.getElementById("interesse").getContext("2d");
            var chartGraph6 = new Chart(ctx6, {
                type: 'doughnut',
                data:{
                    labels: [
                        "Tem interesse",
                        "Não tem interesse"
                    ],
                    datasets: [
                        {
                            data: [<?php echo("$interesse,".(($total_cadastros-$isestudante)-$interesse)); ?>],
                            borderColor: [
                                "rgba(35, 35, 35, .8)",
                                "rgba(35, 35, 35, .8)"
                            ],
                            backgroundColor: [
                                "#2ecc71",
                                "#ef5350"
                            ]
                        }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Interesse em estudar na UFV',
                        fontFamily: "'Arial', 'sans-serfi'",
                        fontSize: 25
                    },
                    animation: {
                        easing: 'easeOutBounce'
                    },
                    legend: {
                        display: true,
                    }
                }
            });
            
            
            
            //-----------------------//
            
            
            var ctx7 = document.getElementById("divulgacao").getContext("2d");
            var chartGraph7 = new Chart(ctx7, {
                type: 'doughnut',
                data:{
                    labels: [
                        "Internet",
                        "Panfleto",
                        "TV",
                        "Rádio",
                        "Amigo",
                        "Visitou a UFV",
                        "Outras"
                    ],
                    datasets: [
                        {
                            data: [<?php echo("$internet,$panfleto,$tv,$radio,$amigo,$visita,".($total_cadastros-($internet+$panfleto+$tv+$radio+$amigo+$visita))); ?>],
                            borderColor: [
                                "rgba(35, 35, 35, .8)",
                                "rgba(35, 35, 35, .8)",
                                "rgba(35, 35, 35, .8)",
                                "rgba(35, 35, 35, .8)",
                                "rgba(35, 35, 35, .8)",
                                "rgba(35, 35, 35, .8)",
                                "rgba(35, 35, 35, .8)"
                            ],
                            backgroundColor: [
                                "#2ecc71",
                                "#3498db",
                                "#9b59b6",
                                "#f1c40f",
                                "#1de9b6",
                                "#34495e",
                                "#ff5722"
                            ]
                        }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Meios de Divulgação',
                        fontFamily: "'Arial', 'sans-serfi'",
                        fontSize: 25
                    },
                    animation: {
                        easing: 'easeOutBounce'
                    },
                    legend: {
                        display: true,
                    }
                }
            });
            
        </script>
        <script src="js/jquery.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.js"><\/script>')</script>
        <script src="js/vendor/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
    </body>
</html>
