<?php
    defined('ROOT') or die('Acesso inválido');
    require_once('bo/navegacao.php');

    $bd = new database();
    $error = '';
    //no caso de existir um post

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {

        $error = '';
        $success = '';

        if(!isset($_POST['text_cliente']) ||
        !isset($_POST['id_client']) || 
        !isset($_POST['text_usuario']) || 
        !isset($_POST['text_senha']) ||
        !isset($_POST['alterar-usuario-e-senha'])
        )
        {
            $error = "Não foram fornecidos todos os dados";
        }

        if(empty($error))
        {
            $alterar_usuario_e_senha = $_POST['alterar-usuario-e-senha'] == 'false' ? false : true;
            $id_client = $_POST['id_client'];
            $cliente = $_POST['text_cliente'];
            $usuario = $_POST['text_usuario'];
            $senha = $_POST['text_senha'];

            $parametros = [
                    ':id_client' => $id_client,
                    ':client_name' => $cliente
                ];

                $resultados = $bd->EXE_QUERY("SELECT * FROM authentication WHERE client_name = :client_name AND id_client <> :id_client", $parametros);
                if (count($resultados) != 0){
                    $error = 'Já existe outro cliente com o mesmo nome';
                }else{

                    $parametros = [
                    'id_client' => $id_client,
                    'client_name' => $cliente
                    ];

                    $bd->EXE_NON_QUERY("UPDATE authentication SET 
                    client_name = :client_name,
                    updated_at = NOW()
                    WHERE id_client = :id_client",$parametros);

                    $success = 'Nome do cliente editado com sucesso';
                }

            if($alterar_usuario_e_senha)
            {
                $parametros = [
                    'usuario' => $usuario,
                    ':senha' => password_hash($senha, PASSWORD_DEFAULT),
                    ':id_client' => $id_client
                ];

                $bd->EXE_NON_QUERY("UPDATE authentication SET 
                    username = :usuario,
                    pass = :senha
                    WHERE id_client = :id_client",$parametros);

                $success = 'Nome do cliente e todos os seus dados foram editados com sucesso';
            }

        }
    }

    if(!isset($_GET['id']) || empty($_GET['id']))
    {
        $error = 'Não foi definido o id do cliente';
    }else{
        $id_client = $_GET['id'];

        $parametros = [
            'id_client' => $id_client
        ];

        $resultados = $bd->EXE_QUERY("SELECT * FROM authentication where id_client = :id_client", $parametros);
        if(count($resultados) != 1){
            $error = "Não existe o cliente selecionado";
        }else{
            $clienteData = $resultados[0];
        }
    }   
?>

<?php if(!empty($error)):?>
    <div class="container">
        <div class="row mt-5">
            <div class="col-sm-6 offset-sm-3">
                <div class="alert alert-danger p-2 text-center">
                    <?=$error ?>
                </div>
                <div class="mt-3 text-center">
                    <a href="index.php" class="btn btn-primary">Voltar</a>
                </div>
            </div>
        </div>
    </div>
<?php else :?>

    <div class="container">
    <div class="row mt-5">
        <div class="col-sm-8 offset-sm-2">

            <form action="?r=edit_client&id=<?=$clienteData['id_client']?>" method="post">

                <input type="hidden" name="alterar-usuario-e-senha" id="alterar-usuario-e-senha" value="false">
                <input type="hidden" name="id_client" value="<?= $clienteData['id_client']?>">
                <h3 class="text-center">Editar Cliente</h3>
                <hr>
                <div class="mb-3">
                    <label class="form-label">Cliente:</label>
                    <input type="text" name="text_cliente" class="form-control" required value="<?= $clienteData['client_name']?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Username:</label>
                    <input type="text" name="text_usuario" id="usuario" class="form-control" required readonly value="<?= $clienteData['username']?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Senha:</label>
                    <input type="text" name="text_senha" id="senha" class="form-control" required readonly placeholder="Senha reservada">
                </div>

                <div class="mb3 text-end" onclick="gerarUsuarioPassword()">
                    <button type="button" class="btn btn-primary">Atualizar</button>
                </div>

                <div class="mb-3 text-center">
                    <a href="?r=home" class="btn btn-secondary btn-150">Cancelar</a>
                    <input type="submit" value="Editar" class="btn btn-primary btn-150">
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

<?php endif ;?>

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
        document.querySelector("#alterar-usuario-e-senha").value = "true";
    }
</script>

