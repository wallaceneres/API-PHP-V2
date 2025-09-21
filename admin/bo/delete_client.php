<?php
    defined('ROOT') or die('Acesso inválido');
    require_once('bo/navegacao.php');
?>

<?php
    $error = '';
    if(!isset($_GET['id']) || empty($_GET['id']))
    {
        $error = 'Não foi definido o cliente a ser excluido';
    }

    if(empty($error)){

        $id_client = $_GET['id'];

        $bd = new database();
        $parametros = [
            ':id_client' => $id_client
        ];

        $resultados = $bd->EXE_QUERY("SELECT *
                            FROM authentication WHERE id_client = :id_client",
                            $parametros);

        if(empty($resultados))
        {
            $error = "Não existe o registro indicado";
        }   

    }
 
?>

<?php if(!empty($error)) :?>
    <div class="row my-5">
        <div class="col-sm-6 offset-sm-3 text-center">
            <p class="alert alert-danger"><?=$error?></p>
            <a href="index.php" class="btn btn-primary">Voltar</a>
        </div>
    </div>
<?php else: ?>
    <div class="row my-5">
        <div class="col-sm-6 offset-3 text-center">
            <p>Pretende elimitar o registro?</p>
            <p>Cliente: <?= $resultados[0]['client_name']?></p>
            <p>Usuario: <?= $resultados[0]['username']?></p>

            <div class="mt-3">
                <a href="index.php" class="btn btn-primary">Não</a>
                <a href="?r=cliente_delete_ok&id=<?= $resultados[0]['id_client']?>" class="btn btn-danger">Sim</a>

            </div>
        </div>
    </div>
<?php endif; ?>