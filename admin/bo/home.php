<?php
    defined('ROOT') or die('Acesso inválido');
    require_once('bo/navegacao.php');
    ?>

    <?php
        //recolhe os dados das aplicacoes clientes da API

        $db = new database();

        $clientes_da_api = $db->EXE_QUERY("SELECT * FROM authentication");
    ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col">
            
                <h3>Clientes da API</h3>
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th>Cliente</th>
                            <th>Chave</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($clientes_da_api as $cliente_da_api): ?>
                            <tr>
                                <td><?= $cliente_da_api['client_name'] ?></td>
                                <td><?= $cliente_da_api['username'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>