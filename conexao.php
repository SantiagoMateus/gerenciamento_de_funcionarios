<?php
    include "config.php";
    $conexao = mysqli_connect(BD_SERVIDOR, BD_USUARIO, BD_SENHA, BD_BANCO);
    mysqli_set_charset($conexao, 'utf8');
    //Detecção de erros ao conectar
    if(mysqli_connect_errno($conexao)){
        echo "Problemas para conectar no banco. Verifique os dados!";
        die();
    }
    
    //Função responsável por gravar um funcionário no banco
    function gravar_funcionario($conexao, $funcionario){        
        /*PS: lembre-se que em cada função, a variável funcionário tem seu próprio contexto.
         * Aqui, recebemos como parâmetro um array $funcionario, que armazena as informações que foram 
         * lidas do formulário (utilizando o método $_POST). Pegamos as informações que foram preenchidas
         * pelo usuário, e fazemos um insert para gravar o registro de um novo funcionário no PHPMyAdmin. */
        $sqlGravar = "INSERT INTO funcionarios
                    (nome, endereco, cargo, dataadmissao)
                    VALUES(
                        '{$funcionario['nome']}',
                        '{$funcionario['endereco']}',
                        '{$funcionario['cargo']}',
                        '{$funcionario['dataadmissao']}'
                    )";
        mysqli_query($conexao, $sqlGravar);
        //Se ouver erro na SQL, erro é reportado pelo comando abaixo. Utilize esta função sempre que 
        //quiser saber se a sua SQL foi feita da forma correta.
        echo mysqli_error($conexao);
    }
    
    //Função responsável por editar um funcionário no banco
    function buscar_funcionario($conexao, $id){
        //SQL nos retorna um único registro (garantimos isso pois o id de um funcionário é único em nosso banco)
        $sqlBusca = "SELECT * FROM funcionarios WHERE id = " . $id;
        //$resultado nos retorna um objeto mysqli_result, contendo um único registro de funcionário
        $resultado = mysqli_query($conexao, $sqlBusca);
        //Transformamos esse objeto mysqli_result em um vetor associativo e armazenamos na variável $funcionario
        $funcionario = mysqli_fetch_assoc($resultado);
        //Print_r escreve para nós na tela o conteúdo do array $funcionario.
        //print_r($funcionario);
        //Retornamos o funcionário.
        return $funcionario;
    }
    
    //Função responsável pela atualização das informações de um funcionário no banco (PHPMyAdmin). A função recebe como parâmetro
    //um vetor $funcionario, que contém as informações lidas do formulário, que foram recuperadas utilizando o método $_POST.
    function editar_funcionario($conexao, $funcionario){
        $sqlEditar = "UPDATE funcionarios SET
                        nome = '{$funcionario['nome']}',
                        endereco = '{$funcionario['endereco']}',
                        cargo = '{$funcionario['cargo']}',
                        dataadmissao = '{$funcionario['dataadmissao']}'
                        WHERE id = {$funcionario['id']}";    
        //MySqli_query realiza a nossa SQL no PHPMyAdmin.        
        mysqli_query($conexao, $sqlEditar);
        //Nos retorna erro na SQL, caso exista.
        echo mysqli_error($conexao);
        //Direciona nosso usuário para a tela inicial de cadastro.
        //header('Location: funcionarios.php');

    }
    
    //Função responsável pela remoção de funcionários do banco phpMyAdmin
    function remover_funcionario($conexao, $id){
        $sqlRemover = "DELETE FROM funcionarios WHERE id = {$id}";
        mysqli_query($conexao, $sqlRemover);
        echo mysqli_error($conexao);
    }
    
    
    function gravar_anexo($conexao, $anexo){
        $sqlGravar = "Insert INTO anexos 
                (funcionario_id, nome, arquivo)
                VALUES (
                  {$anexo['funcionario_id']},
                  '{$anexo['nome']}',
                  '{$anexo['arquivo']}'
                 )";
        mysqli_query($conexao, $sqlGravar);
        echo mysqli_error($conexao);
    }
        
    function buscar_anexos($conexao, $funcionario_id) {
        $sql = "SELECT * FROM anexos WHERE funcionario_id = {$funcionario_id}";
        $resultado = mysqli_query($conexao, $sql);
        $anexos = array();
        
        while($anexo = mysqli_fetch_assoc($resultado)){
            $anexos[] = $anexo;
        }
        echo mysqli_error($conexao);
        return $anexos;
    }   
    
    function buscar_funcionarios($conexao){
        //SQL que será executada no PHPMyAdmin
        $Busca = 'SELECT * FROM funcionarios';
        /*Variável resultado recebe um objeto mysqli_result, que contém todos os funcionários que foram cadastrados
         * no banco. Para transformarmos esse objeto mysqli_result em um vetor associativo, (para facilitar nossa manipulação dos dados),
         * utilizamos a função mysqli_fetch_assoc, que em cada iteração do while pega o registro de um funcionário 
         * e atribui ao array associativo $funcionario. Depois de realizar esta atribuição, fazemos com que o vetor 
         * $funcionarios (um array de arrays) receba este funcionário em sua próxima posição vazia. */
        $resultado = mysqli_query($conexao, $Busca);
        $funcionarios = array();
        while($funcionario = mysqli_fetch_assoc($resultado)){
            $funcionarios[] = $funcionario;
        }
        //Print_r imprime para nós o conteúdo de um vetor. 
        //No caso, estamos imprindo o conteúdo do vetor que acabamos de criar,
        //que possui a lista dos funcionários que estão cadastrados no banco (PHPMyAdmin).
        //print_r($funcionarios);
        return $funcionarios;
    }
    
    function busca_funcionarios_pagina($conexao, 
            $pagina, $quantidade_pg){
        //Calcular início da visualização
        $inicio = 
         ($quantidade_pg * $pagina)-$quantidade_pg;
        //Selecionar os funcionarios a serem 
        //apresentados na página
        $Busca = "SELECT * FROM funcionarios
                   limit $inicio, $quantidade_pg";
        $result_funcionarios = mysqli_query($conexao, 
                $Busca);

       //Crio vetor de índices a partir da variável $funcionarios_mysqli_obj
        $funcionarios = array();
        while($funcionario = 
                mysqli_fetch_assoc($result_funcionarios)){
            $funcionarios[] = $funcionario;
        }
        //Retorna vetor de índices
        return $funcionarios;
    }
    
    function pesquisa_funcionarios($conexao, $string_busca){
        $Busca = "SELECT * FROM funcionarios where nome LIKE '%$string_busca%'";
        $resultado = mysqli_query($conexao, $Busca);
        $funcionarios = array();
        while($funcionario = mysqli_fetch_assoc($resultado)){
            $funcionarios[] = $funcionario;
        }
        return $funcionarios;
    }
    
    function pesquisa_funcionarios_por_pagina($conexao, $string_busca, $quantidade_pg, $pagina){
        //Calcular início da visualização
        $inicio = ($quantidade_pg * $pagina)-$quantidade_pg;
    
        //Selecionar os funcionarios a serem apresentados na página
        $Busca = "SELECT * FROM funcionarios where nome LIKE '%$string_busca%' limit $inicio, $quantidade_pg";
        $result_funcionarios = mysqli_query($conexao, $Busca);
    
        //Crio vetor de índices a partir da variável $funcionarios_mysqli_obj
        $funcionarios = array();
        while($funcionario = mysqli_fetch_assoc($result_funcionarios)){
            $funcionarios[] = $funcionario;
        }
        return $funcionarios;
    }
