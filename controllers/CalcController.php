<?php

require('../classes/Calc.php');

if (isset($_POST['calcNewValue'])) {

    $saldo = 0;

    $moneyValue = $_POST['moneyValue'];
    $descMoney = $_POST['descMoney'];
    $addMoney = isset($_POST['addMoney']) ? $_POST['addMoney'] : '';
    $removeMoney = isset($_POST['removeMoney']) ? $_POST['removeMoney'] : '';

        if ($addMoney == 'add' && $removeMoney != 'remove') {

                if($moneyValue != '' and $descMoney != ''){

                    $add = Calc::AddMoney($moneyValue, $descMoney);

                }else{

                    header('location: http://localhost/FinancY');
                }
            

        }elseif ($removeMoney == 'remove' && $addMoney != 'add') {

            if($moneyValue != '' and $descMoney != ''){

                $remove = Calc::RemoveMoney($moneyValue, $descMoney);

            }else{

                header('location: http://localhost/FinancY');
            }
                
        } elseif ($addMoney == 'add' && $removeMoney == 'remove') {

            echo 'error';
        }
}