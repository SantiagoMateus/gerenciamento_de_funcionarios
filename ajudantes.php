<?php

    function traduz_admissao_para_exibir($data){
        if($data == "" OR $data == "0000-00-00"){
            return "";
        }
        $dados = explode("-", $data);
        $data_exibir = "{$dados[2]}/{$dados[1]}/{$dados[0]}";
        return $data_exibir;
    }

    function tratar_anexo($anexo){
        $padrao = '/^.+(\.pdf|\.zip)$/';
        $resultado = preg_match($padrao, $anexo['name']);
            
        if(! $resultado)
            return false;
        move_uploaded_file($anexo['tmp_name'], "anexos/{$anexo['name']}");
        //echo unlink("anexos/{$anexo['name']}");
        return true;
    }
    
    