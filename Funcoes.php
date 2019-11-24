<?php
    //Recebe parametro de opção
    $op = filter_input(INPUT_GET, 'op', FILTER_SANITIZE_NUMBER_INT);

    /**
     * $op = 1 == Listar todos os cadastros 
     * $op = 2 == Inserir Cadastro
     * $op = 3 == Alterar Cadastro
     * $op = 4 == Excluir Cadastro
     * $op = 5 == Retornar todos os usuários em Tabela em HTML
     */

    switch ($op){
        case 1: //Listar todos os cadastros
            //Define a query
            $query = '
                select
                    id,
                    nome, 
                    endereco,
                    telefone,
                    email
                from
                    cadastros
            ';
            //Abre Conexão com BD
            $pdo = Conectar(); 

            //Prepara a query
            $stm = $pdo->prepare($query); 

            //Executa a query
            $stm->execute();

            //Define um objeto com o retorno da consulta
            $results = $stm->fetchAll(PDO::FETCH_OBJ);

            //Fecha a Conexão com BD
            $pdo = null;

            //Retorna json com base no objeto da consulta
            echo (json_encode($results)); 
        break;

        case 2: //Inserir Cadastro
            //Recebe parametros enviados
            $nome     = filter_input(INPUT_GET, 'nome',     FILTER_SANITIZE_STRING);
            $endereco = filter_input(INPUT_GET, 'endereco', FILTER_SANITIZE_STRING);
            $telefone = filter_input(INPUT_GET, 'telefone', FILTER_SANITIZE_STRING);
            $email    = filter_input(INPUT_GET, 'email',    FILTER_SANITIZE_STRING);

            //Define a query
            $query = '
                insert into cadastros
                    (
                        nome, 
                        endereco,
                        telefone,
                        email
                    )
                values
                    (
                        :param_nome, 
                        :param_endereco,
                        :param_telefone,
                        :param_email
                    )
            ';

            //Abre Conexão com BD
            $pdo = Conectar(); 

            //Prepara a query
            $stm = $pdo->prepare($query);

            //Define os parametos
            $stm->bindParam(':param_nome',     $nome);
            $stm->bindParam(':param_endereco', $endereco);
            $stm->bindParam(':param_telefone', $telefone);
            $stm->bindParam(':param_email',    $email);
            
            //Executa a query e salva posição em status
            $status = $stm->execute();

            //Fecha a Conexão com BD
            $pdo = null;

            //Verifica Status
            if ($status) {
                //Se Verdadeiro, salva informação de sucesso
                $ret = array('status' => $status, 'info' => 'Cadastro inserido com sucesso');
            } else {
                //Se Falso, salva informação de erro
                $ret = array('status' => $status, 'info' => 'Ocorreu um erro ao inserir o cadastro');
            }

            //Retorna json com a variavel $ret
            echo json_encode($ret);
        break;

        case 3: //Alterar Cadastro
            //Recebe parametros enviados
            $id       = filter_input(INPUT_GET, 'id',       FILTER_SANITIZE_NUMBER_INT);
            $nome     = filter_input(INPUT_GET, 'nome',     FILTER_SANITIZE_STRING);
            $endereco = filter_input(INPUT_GET, 'endereco', FILTER_SANITIZE_STRING);
            $telefone = filter_input(INPUT_GET, 'telefone', FILTER_SANITIZE_STRING);
            $email    = filter_input(INPUT_GET, 'email',    FILTER_SANITIZE_STRING);

            //Define a query
            $query = '
                update
                    cadastros
                set
                    nome     = :param_nome, 
                    endereco = :param_endereco,
                    telefone = :param_telefone,
                    email    = :param_email
                where
                    id = :param_id
            ';

            //Abre Conexão com BD
            $pdo = Conectar(); 

            //Prepara a query
            $stm = $pdo->prepare($query);

            //Define os parametos
            $stm->bindParam(':param_nome',     $nome);
            $stm->bindParam(':param_endereco', $endereco);
            $stm->bindParam(':param_telefone', $telefone);
            $stm->bindParam(':param_email',    $email);
            $stm->bindParam(':param_id',       $id);
            
            //Executa a query e salva posição em status
            $status = $stm->execute();

            //Fecha a Conexão com BD
            $pdo = null;

            //Verifica Status
            if ($status) {
                //Se Verdadeiro, salva informação de sucesso
                $ret = array('status' => $status, 'info' => 'Cadastro alterado com sucesso');
            } else {
                //Se Falso, salva informação de erro
                $ret = array('status' => $status, 'info' => 'Ocorreu um erro ao alterar o cadastro');
            }

            //Retorna json com a variavel $ret
            echo json_encode($ret);
        break;
        
        case 4: //Excluir Cadastro
            //Recebe parametros enviados
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

            //Define a query
            $query = '
                delete from 
                    cadastros
                where
                    id = :param_id
            ';

            //Abre Conexão com BD
            $pdo = Conectar(); 

            //Prepara a query
            $stm = $pdo->prepare($query);

            //Define os parametos
            $stm->bindParam(':param_id', $id);
            
            //Executa a query e salva posição em status
            $status = $stm->execute();

            //Fecha a Conexão com BD
            $pdo = null;

            //Verifica Status
            if ($status) {
                //Se Verdadeiro, salva informação de sucesso
                $ret = array('status' => $status, 'info' => 'Cadastro excluido com sucesso');
            } else {
                //Se Falso, salva informação de erro
                $ret = array('status' => $status, 'info' => 'Ocorreu um erro ao excluir o cadastro');
            }

            //Retorna json com a variavel $ret
            echo json_encode($ret);
        break;

        case 5: //Retornar todos os usuários em Tabela em HTML
            //Define a query
            $query = '
                select
                    id,
                    nome, 
                    endereco,
                    telefone,
                    email
                from
                    cadastros
            ';
            //Abre Conexão com BD
            $pdo = Conectar(); 

            //Prepara a query
            $stm = $pdo->prepare($query); 

            //Define os parametos
            //$stm->bindParam(':param', $var); 
            
            //Executa a query
            $stm->execute();

            //Define um objeto com o retorno da consulta
            $results = $stm->fetchAll(PDO::FETCH_OBJ);

            //Fecha a Conexão com BD
            $pdo = null;

            $ret_table = "
                <table id='tabela-retorno-cadastro'>
                    <tr>
                        <td>
                            ID
                        </td>
                        <td>
                            NOME
                        </td>
                        <td>
                            ENDERECO
                        </td>
                        <td>
                            TELEFONE
                        </td>
                        <td>
                            EMAIL
                        </td>
                    </tr>
            ";

            foreach($results as $cadastro){
                $ret_table .= "
                    <tr>
                        <td>
                            ".$cadastro->id."
                        </td>
                        <td>
                            ".$cadastro->nome."
                        </td>
                        <td>
                            ".$cadastro->endereco."
                        </td>
                        <td>
                            ".$cadastro->telefone."
                        </td>
                        <td>
                            ".$cadastro->email."
                        </td>
                    </tr>
                ";
            }
            $ret_table .= "</table>";

            //Retorna variavel $ret_table
            echo $ret_table; 
        break;
    }

    //Função para conexão com BD
    function Conectar(){
        try{ 
            $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'); 
            $con = new PDO("mysql:host=localhost; dbname=exemplo_php;", "root", "admin123", $options); 
            return $con; 
        } 
        catch (Exception $e){ 
            echo 'Erro: '.$e->getMessage(); 
            return null;
        }
    }