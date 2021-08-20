<?php 
    
    include "conexao.php";
    
    //Verifica se usuário enviou atualizações do funcionário a ser alterado.
    //Se enviou, salva as informações no vetor $funcionario
    if(isset($_POST['nome'])){
        $funcionario = array(); 
        $funcionario['id'] = $_POST['id'];
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
        //Chama a função responsável pela edição de um funcionário, passando como
        //parâmetro os dados que acabamos de armazenar no vetor associativo $funcionario
        @editar_funcionario($conexao, $funcionario);
        
        
    }//Final do IF
    //Recupera a informação do funcionário que estamos editando, utilizando a função buscar_funcionario.
    //Enviamos como parâmetro o id, que foi recuperado pelo método GET da página de cadastro.
    //echo "estou buscando por UM funcionário no banco";
    @$funcionario_banco = buscar_funcionario($conexao, $_GET['id']);
    
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
        <form method="POST" action="editar.php">
            <!-- Como queremos preencher as informações do formulário com as informações que vieram do banco, vamos utilizar 
            o campo value do input, e vamos recuperar a informação que veio do vetor $funcionario_banco.
            Considerando que quando clicarmos no botão de edição, vamos enviar todas as informações do formulário para esta mesma página,
            utilizando o método $_POST, (e recuperando posteriormente na linha 50), vamos armazenar também o id do funcionário, como campo oculto,
            para não perdemos esta informação. -->
            <input type="hidden" name="id" value="<?php echo $funcionario_banco['id']?>">
            Nome: <input type="text" name="nome" value="<?php echo $funcionario_banco['nome'];?>"/>
            Endereço: <input type="text" name="endereco" value="<?php echo $funcionario_banco['endereco'];?>"/>
            Selecione o cargo:
            <select name="cargo" size="1" >
                <option value="dono" <?php echo ($funcionario_banco['cargo']=='dono') ? "selected" : ""; ?>>Dono</option>                
                <option value="gerente" <?php echo ($funcionario_banco['cargo']=='gerente') ? "selected" : ""; ?>>Gerente</option>
                <option value="supervisor" <?php echo ($funcionario_banco['cargo']=='supervisor') ? "selected" : ""; ?>>Supervisor</option>
                <option value="operario" <?php echo ($funcionario_banco['cargo']=='operario') ? "selected" : ""; ?>>Operário</option>
            </select>  
            Data de Admissão:
            <input type="date" name="dataadmissao" value="<?php echo $funcionario_banco['dataadmissao']; ?>"/>
			<a href = "funcionarios.php"/>Voltar para pagina inicial</a>
			<br>
			<br>
            <input type="submit" value="Editar"/>
        </form>
    </body>
</html>
