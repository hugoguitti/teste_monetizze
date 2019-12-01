<?php
require_once "Sorteio.php";

$sorteioRealizado = false;
$mensagemErro = "";
if ($_POST) {        
    try {
        $sorteio = new Sorteio($_POST["quantidadeDezenas"], $_POST["numeroJogos"]);
        $sorteio->preencheJogos();
        $sorteio->sorteiaResultado();
        $sorteioRealizado = true;
    } catch (Exception $erro) { 
        $mensagemErro = $erro->getMessage();
    }
}
?> 

<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        
        <style>
            body {
                background-color: lightgray;
            }
            .card {
                margin: 1em;
            }
            th {
                text-align: center;
            }
        </style>
    </head>
    <body>
        <form method="post">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Sorteio</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="numeroJogos" class="control-label">Número de jogos</label>
                                <input type="number" id="numeroJogos" name="numeroJogos" required class="form-control" value="<?php echo $_POST["numeroJogos"]; ?>">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="quantidadeDezenas" class="control-label">Quantidade de dezenas</label>
                                <input type="number" id="quantidadeDezenas" name="quantidadeDezenas" required class="form-control" value="<?php echo $_POST["quantidadeDezenas"]; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-end">
                        <div class="">
                            <button class="btn btn-primary">Sortear</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <?php
        if ($sorteioRealizado) {      
        ?>  
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Resultado</h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-sm">
                        <thead>
                            <tr class="table-active">
                                <th colspan="6" class="table-active">Dezenas sorteadas</th>
                            </tr>
                            <tr>
                                <th class="table-active">#1</th>
                                <th class="table-active">#2</th>
                                <th class="table-active">#3</th>
                                <th class="table-active">#4</th>
                                <th class="table-active">#5</th>
                                <th class="table-active">#6</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                foreach ($sorteio->getResultado() as $dezena) {
                                ?>
                                    <td><?php echo $dezena; ?></td>
                                <?php
                                }
                                ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Jogos sorteados</h2>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered table-hover table-sm">
                        <thead>
                            <tr class="table-active">
                                <th class="table-active" rowspan="2">Jogo Nº</th>
                                <th class="table-active" colspan="<?php echo $sorteio->getQuantidadeDezenas(); ?>">Dezenas sorteadas</th>
                                <th class="table-active" rowspan="2">Número de acertos</th>
                            </tr>
                            <tr>
                                <?php
                                for ($i = 0; $i < $sorteio->getQuantidadeDezenas(); $i++) {
                                ?>
                                    <th class='table-active'><?php echo "#".($i+1); ?></th>
                                <?php
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($sorteio->confereJogos() as $numeroJogo => $jogo) {
                            ?>
                                <tr>
                                    <td>
                                        <?php echo $numeroJogo+1; ?>
                                    </td>
                                    <?php
                                    foreach ($jogo["dezenas"] as $dezena) {
                                    ?>
                                        <td>
                                            <?php echo $dezena; ?>
                                        </td>
                                    <?php
                                    }
                                    ?>
                                    <td>
                                        <?php echo $jogo["quantidadeAcertos"]; ?>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php
        } else if ($mensagemErro) {
        ?>
            <div class="alert alert-warning" role="alert">
                <?php echo $mensagemErro; ?>
            </div>
        <?php
        }
        ?>
    </body>
</html>