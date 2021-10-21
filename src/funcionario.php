<?php 
    include "conexao.php";
    include "ajudantes.php";
    
    if(isset($_FILES['anexo'])){
        $funcionario_id = $_POST['funcionario_id'];
        if(tratar_anexo($_FILES['anexo'])){
            $anexo = array();
            $anexo['funcionario_id'] = $funcionario_id;
            $anexo['nome'] = $_FILES['anexo']['name'];
            $anexo['arquivo'] = $_FILES['anexo']['name'];
        
            gravar_anexo($conexao, $anexo);
        }
    }//Final do IF
    
    $funcionario  = buscar_funcionario($conexao, $_GET['id']);
    $anexos = buscar_anexos($conexao, $_GET['id']);
?>
<!-- Formulário e Tabela para cadastro e listagem de funcionários!-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cadastro de Funcionários</title>
        <link rel="stylesheet" href="funcionarios.css" type="text/css" />
    </head>
    <body>
        <h1>Funcionário: <?php echo $funcionario['nome']; ?></h1>
        <p> 
            <a href="index.php">Voltar para a lista de tarefas</a>
        </p>
        <p>
            <strong>Endereço:</strong>
            <?php echo $funcionario['endereco']; ?>
        </p>
        <p>
            <strong>Cargo:</strong>
            <?php echo $funcionario['cargo']; ?>
        </p>
        <p>
            <strong>Data de Admissão:</strong>
            <?php echo traduz_admissao_para_exibir($funcionario['dataadmissao']); ?>
        </p>
        <h2>Anexos</h2>        
        <!-- Formulário para um novo anexo -->
        <form action="" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Novo anexo</legend>
                <input type="hidden" name="funcionario_id" 
                       value="<?php echo $funcionario['id']; ?>">
                <label>
                    <input type="file" name="anexo" 
                     required="Você deve selecionar um arquivo para enviar!" />
                </label>
                <input type="submit" value="Cadastrar" />
            </fieldset>
        </form>
        <?php if(count($anexos)>0): ?>
        <table>
            <tr>
                <th>Arquivo</th>
                <th>Opções</th>
            </tr>
            <?php foreach($anexos as $anexo): ?>    
            <tr>
                <td><?php echo $anexo['nome']; ?></td>
                <td>
                    <a href="anexos/<?php echo $anexo['arquivo'];?>">
                        Download
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
        <p>Não há anexos para esta tarefa.</p>
        <?php endif; ?>
        </body>
</html>
