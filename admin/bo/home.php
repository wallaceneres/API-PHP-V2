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
                <div class="row">
                    <div class="col-sm-6">
                        <h3>Clientes da API</h3>
                    </div>
                    <div class="col-sm-6 text-end">
                        <a href="?r=new_client" class="btn btn-primary btn-sm">+ Cliente</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
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
        </div>
    </div>