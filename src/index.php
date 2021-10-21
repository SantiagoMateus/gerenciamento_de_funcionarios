<?php 
    
	require 'rb.php';
     R::setup( 'mysql:host=localhost;dbname=funcionarios',
        '', '' ); 
    include "conexao.php";
    include "ajudantes.php";
   
    if(isset($_POST['nome'])){
        //echo "Estou salvando as informações enviadas pelo usuário";
        $funcionario = array(); 
        $funcionario['nome'] = $_POST['nome'];
        if(isset($_POST['endereco'])){
            $funcionario['endereco'] = $_POST['endereco'];
        }else{
            $funcionario['endereco'] = '';
        }
        if(isset($_POST['cargo'])){
            $funcionario['cargo'] = $_POST['cargo'];
        }else{
            $funcionario['cargo'] = '';
        }
        if(isset($_POST['dataadmissao'])){
            $funcionario['dataadmissao'] = $_POST['dataadmissao'];
        }else{
            $funcionario['dataadmissao'] = '';
        }
       
        //Depois de salvar todas as informações em noss vetor $funcionario, enviamos estas informações
        //para a função responsável por gravar funcionário no banco de dados.
        gravar_funcionario($conexao, $funcionario);   
    }//Final do IF
    
    //Verificar se está sendo passado na URL a página 
    //atual, senão, é atribuído a página 1.
    if(isset($_GET['pagina'])){
        $pagina = $_GET['pagina'];
    }else{
        $pagina = 1;
    }
    $lista_funcionarios = buscar_funcionarios($conexao);
    
    //Conta a quantidade de registros
    $total_funcionarios = count($lista_funcionarios);
    
    //Seta a quantidade_pg = 6;
    $quantidade_pg = 6;
    
    //Calcular o número de páginas necessárias para 
    //apresentar os funcionários
    $numero_pagina = ceil($total_funcionarios/
            $quantidade_pg);
    
    //Vetor lista_funcionarios recebe os registros 
    //correspondentes a página
    //que estamos acessando
    $lista_funcionarios = 
            busca_funcionarios_pagina($conexao, 
                    $pagina, $quantidade_pg);
    
?>  
<!-- Formulário e Tabela para cadastro e listagem de funcionários!-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cadastro de Funcionários</title>
        <link rel="stylesheet" href="funcionarios.css" type="text/css" />
    </head>
    <body>
        <h1>Cadastro de funcionários</h1>
        <form method="POST" action="index.php">
            Nome: 
            <input type="text" name="nome" required="Preencha o nome!"/>
            Endereço: <input type="text" name="endereco" required="Preencha o endereço!"/>
            Selecione o cargo:
            <select name="cargo" size="1" >
                <option value="dono">Dono</option>
                <option value="gerente">Gerente</option>
                <option value="supervisor">Supervisor</option>
                <option value="operario">Operário</option>
            </select>  
            Data de Admissão:
            <input type="date" name="dataadmissao" 
                   value="<?php echo date('Y-m-d'); ?>"/>
            
            <input type="submit" value="Cadastrar"/>
        </form>
        
        <table width=1000 height=100 center>
            <tr align="left">
                <th>Funcionário</th>
                <th>Endereço</th>
                <th>Cargo</th>
                <th>Admissão</th>
                <th>Opções</th>
            </tr>
            <!-- $lista_funcionarios foi definida antes do nosso código html, na linha 103. Ou seja, $lista_funcionarios
            é um array que nos retorna todos os registros que estão cadastrados no banco (PHPMyAdmin). Fazemos um foreach para
            acessarmos de forma individual cada um dos funcionários armazenados. Para cada iteração do foreach, armazenamos
            um funcionário no vetor $funcionario, e escrevemos as informações deste funcionário em um linha de nossa tabela. -->
            <?php foreach ($lista_funcionarios as $funcionario) :?>
            <tr>
                <td>
                    <a href="funcionario.php?id=<?php echo $funcionario['id']; ?>">
                        <?php echo $funcionario['nome'];?></td>
                    </a>
                <td><?php echo $funcionario['endereco'];?></td>
                <td><?php echo $funcionario['cargo'];?></td>
                <td>
                 <?php 
                  echo  traduz_admissao_para_exibir($funcionario['dataadmissao']);
                 ?>
                </td>
                <td>
                    <!-- Links responsáveis pela edição e remoção de registros. Oferecemos esta opção para cada funcionário 
                    de nossa tabela. 
                    Quando clicarmos nos links, seremos redirecionados para as páginas de edição ou remoção de registros.
                    Caso isso aconteça, enviados como parâmetro o id do funcionário que queremos fazer a ação. 
                    Id é enviado pelo método get, ou seja, passamos um "?" seguido pelo parâmetro (id) e seu valor ($funcionario['id']) -->
                    <a href="editar.php?id=<?php echo $funcionario['id'];?>">Editar
                    <a href="remover.php?id=<?php echo $funcionario['id'];?>">Remover
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <center>
            <?php 
                //Verifica a página anterior e posterior
                $pagina_anterior = $pagina - 1;
                $pagina_posterior = $pagina + 1;
            ?>
            <?php  if($pagina_anterior != 0) : ?>
                    <a href="index.php?pagina=<?php echo $pagina_anterior; ?>" > 
                        &laquo;
                    </a>
            <?php  endif; ?>
            <?php for($i = 1; $i < $numero_pagina + 1; $i++): ?>
                <a href="index.php?pagina=<?php echo $i; ?>"> 
                    <?php echo $i; ?> 
                </a>
            <?php endfor; ?>
            <?php  if($pagina_posterior <= $numero_pagina) : ?>
                    <a href="index.php?pagina=<?php echo $pagina_posterior; ?>" > 
                        &raquo;
                    </a>
            <?php  endif; ?>
        </center>
    </body>
</html>
