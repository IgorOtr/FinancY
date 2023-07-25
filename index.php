<?php
    require ('model/connection.php');

    /*SELECT para listar as transferências mais recentes*/

        $listT = $conn->prepare(
            "SELECT valor, descrip, data_transicao, acao
            FROM transacoes
            WHERE id_user = :id_user
            ORDER BY id DESC
            LIMIT 3"
        );

        $listT->bindValue(':id_user', 1);    
        $listT->execute();
        $selectedData = $listT->fetchAll();

    /*SELECT para listar o saldo*/

    $listSaldo = $conn->prepare(
        "SELECT saldo
        FROM user_saldo
        WHERE id_user = :id_user"
    );

    $listSaldo->bindValue(':id_user', 1);   
    $listSaldo->execute();
    $selectedSaldo = $listSaldo->fetchAll();

    foreach ($selectedSaldo as $actualySaldo) {
        $actualySaldo['saldo'];
    }
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <title>FinancY</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <div class="collapse navbar-collapse justify-content-center" id="navbarCenteredExample">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Github</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Histórico</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid main__container">
        <div class="row main__row">
            <div class="col-md-6 left__side">
                <div class="box__left__side">
                    <h1>Bem-vindo ao FinancY</h1>
                    <h5>O lugar onde o seu "din-din" tem valor!</h5>
                    <p>
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nihil, necessitatibus. Recusandae quis
                        illum repudiandae suscipit est eveniet, deleniti rem aperiam officia odit perspiciatis ab
                        debitis totam sequi non autem dolorum quasi, id veniam. Eaque, deserunt? Odio voluptatum vel
                        aliquid ratione?
                    </p>

                    <a class="button_slide slide_right" href="" target="_blank">Saiba mais</a>
                </div>
            </div>
            <div class="col-md-6 right__side">
                <div class="box__right__side">
                    <img src="public/images/money.png" alt="">
                </div>
            </div>
        </div>
    </div>

    <div class="container form__container">
        <div class="row text-center mb-3">
            <div class="col-md-12">
                <h4>
                    Faça o seu controle
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6" id="borderCol">
                <div class="box__form">
                    <form action="http://localhost/FinancY/controllers/CalcController.php" method="post">
                        <div class="mb-3">
                            <label class="form-label" for="">Valor em R$:</label>
                            <input class="form-control" type="number" name="moneyValue">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="">Descrição da transação:</label>
                            <input class="form-control" type="text" name="descMoney">
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input name="addMoney" class="form-check-input" type="checkbox" value="add"
                                        id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">Ganhei dinheiro!</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input name="removeMoney" class="form-check-input" type="checkbox" value="remove"
                                        id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">Perdi dinheiro!</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input class="btn btn-primary" name="calcNewValue" type="submit" value="Calcular">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <?php
                    foreach ($selectedData as $caracTr) {
                        $trValor = $caracTr['valor'];
                        $trDescrip = $caracTr['descrip'];
                        $trDate = $caracTr['data_transicao'];
                        $trDate = date('d/m/Y', strtotime($trDate));
                        $trAction = $caracTr['acao'];

                            if($trAction == 'add') {
                                $actionClass = 'add';
                            }elseif($trAction == 'remove'){
                                $actionClass = 'remove';
                            }else{
                                $actionClass = '';
                            }
                ?>
                <div class="mb-2 text-end <?php echo $actionClass?>">
                    <h4>R$ <?php echo $trValor?>,00</h4>
                    <p><?php echo $trDescrip.' '.'('.$trDate.')'?></p>
                </div>

                <?php }?>
            </div>
        </div>
        <div style="border-top: 1px solid #00c92b;" class="row mt-3">
            <div class="col-md-6 mt-3">
                <h4>Saldo atual:</h4>
            </div>
            <div class="col-md-6 mt-3 text-end">
                <h4><?php echo 'R$ '.$actualySaldo['saldo'].',00';?></h4>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>