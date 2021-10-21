<?php
   
    include "conexao.php";
 
    //Recuperamos o id enviado pelo método get, na página de cadastro.
    remover_funcionario($conexao, $_GET['id']);
    
    //Retorna para a página incial
    header('Location: index.php');
