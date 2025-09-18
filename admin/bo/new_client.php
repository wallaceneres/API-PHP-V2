<?php
    defined('ROOT') or die('Acesso inválido');
    require_once('bo/navegacao.php');

    //no caso de existir um post

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        /*
        valiidacao de dados
        - verificar se todos os dados vieramo no post
        - verificar se existe cliente com mesmo nome no banco
        - verificar se existe cliente com o mesmo username
        - inserir o usuario na bd
        - voltar para a pagina inicial
        */

        $error = '';
        $success = '';

        if(!isset($_POST['text_cliente']) || 
        !isset($_POST['text_usuario']) || 
        !isset($_POST['text_senha'])
        )
        {
            $error = "Não foram fornecidos todos os dados";
        }

        if(empty($error))
        {
            $cliente = $_POST['text_cliente'];
            $usuario = $_POST['text_usuario'];
            $senha = $_POST['text_senha'];

            $bd = new database();

            $parametros = [
                ':cliente' => $cliente,
                ':username' => $usuario
            ];

            $resultados = $bd->EXE_QUERY("SELECT * FROM authentication WHERE client_name = :cliente OR username = :username", $parametros);

            if(!empty($resultados)){
                $error = "Já existe um cliente com o mesmo nome ou username";
            }else{
            
                $parametros = [
                ':client_name' => $cliente,
                ':username' => $usuario,
                ':pass' => password_hash($senha, PASSWORD_DEFAULT)
                ];

                $bd->EXE_NON_QUERY("INSERT INTO authentication
                                        VALUES (
                                            0, 
                                            :client_name, 
                                            :username, 
                                            :pass, 
                                            NOW(), 
                                            NOW(), 
                                            null)",
                                            $parametros);

                $success = 'Novo cliente adicionado com sucesso.';
            }
        }
    }
    ?>

<div class="container">
    <div class="row mt-5">
        <div class="col-sm-8 offset-sm-2">

            <form action="?r=new_client" method="post">
                <h3 class="text-center">Novo Cliente</h3>
                <hr>
                <div class="mb-3">
                    <label class="form-label">Cliente:</label>
                    <input type="text" name="text_cliente" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Username:</label>
                    <input type="text" name="text_usuario" id="usuario" class="form-control" readonly required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Senha:</label>
                    <input type="text" name="text_senha" id="senha" class="form-control" readonly required>
                </div>

                <div class="mb3 text-end" onclick="gerarUsuarioPassword()">
                    <button type="button" class="btn btn-primary">Atualizar</button>
                </div>

                <div class="mb-3 text-center">
                    <a href="?r=home" class="btn btn-secondary btn-150">Cancelar</a>
                    <input type="submit" value="Criar" class="btn btn-primary btn-150">
                </div>
            </form>

            <?php if(!empty($error)): ?>
                <p class="alert alert-danger p-2 text-center">
                    <?= $error ?>
                </p>
            <?php endif; ?>

            <?php if(!empty($success)): ?>
                <p class="alert alert-success p-2 text-center">
                    <?= $success ?>
                </p>
                <div class="mt-3 card p-2 bg-light">
                    <p>Cliente:</p><?= $cliente ?>
                    <p>Username:</p><?= $usuario ?>
                    <p>Password:</p><?= $senha ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
<script>
    function gerarUsuarioPassword()
    {
        // definir variaveis
        let client_username = "";
        let client_password = "";
        let charbase ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        let client_username_length = 32;
        let client_password_length = 32;

        //client username
        for(var i = 1; i <= client_username_length; i++)
        {
            client_username += charbase.charAt(Math.floor(Math.random()*charbase.length));
        }

        //client password
        for(var i = 1; i <= client_password_length; i++)
        {
            client_password += charbase.charAt(Math.floor(Math.random()*charbase.length));
        }

        // colocar os valores nos inputs

        document.querySelector("#usuario").value = client_username;

        document.querySelector("#senha").value = client_password;
    }

    //gerar usuario e senha
    gerarUsuarioPassword();
</script>

