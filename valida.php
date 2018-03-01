<?php
	session_name(md5("security".$_SERVER['REMODE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
	session_start();
	//Incluindo a conexão com banco de dados
    require_once 'private_html_protected/config.php';
    require_once 'private_html_protected/connection.php';
    require_once 'private_html_protected/database.php';
	//O campo usuário e senha preenchido entra no if para validar
        $email = DBEscape($_POST['nEmail'],true); //Escapar de caracteres especiais, como aspas, prevenindo SQL injection
        $senha = md5(DBEscape($_POST['nPassword'])); //Transforma para MD5 para comparar com o DB

	if((isset($email)) && (isset($senha))){
		//Buscar na tabela usuario o usuário que corresponde com os dados digitado no formulário
		$resposta = DBSearch("admin","WHERE email = '".$email."' AND senha = '".$senha."' LIMIT 1","senha, email, id");
		//Encontrado um usuario na tabela usuário com os mesmos dados digitado no formulário
		if(isset($resposta) && $email== $resposta[0]["email"] && $senha==$resposta[0]["senha"]){
                        unset($resposta[0]["senha"]);//Exclui senha
            $_SESSION['usuario']['id'] = $resposta[0]["id"];
            header("Location: painel.php");
            
		//Não foi encontrado um usuario na tabela usuário com os mesmos dados digitado no formulário
		//redireciona o usuario para a página de login
		}else{	
                    unset($resposta);
                    unset($email);
                    unset($senha);
			//Váriavel global recebendo a mensagem de erro
			$_SESSION['loginErro'] = "Usuário ou senha inválido";
            header("Location: index.php");
		}
	//O campo usuário e senha não preenchido entra no else e redireciona o usuário para a página de login
	}else{
            $_SESSION['loginErro'] = "Usuário ou senha inválido";
            header("Location: index.php");
	}
?>