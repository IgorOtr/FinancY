<?php

class Calc
{
    public static function AddMoney($moneyValue, $descMoney)
    {
        require ('../model/connection.php');
        
        $select_saldo = $conn->prepare(
            "SELECT saldo 
            FROM user_saldo 
            WHERE id_user = 1"
        );
        $select_saldo->execute();
        $result = $select_saldo->fetchAll();

            foreach ($result as $saldo) {
                $actualySaldo = $saldo['saldo'];
            }

                $newTransaction = $conn->prepare(
                    "INSERT INTO transacoes 
                    (id_user, valor, descrip, acao) 
                    VALUES (:id_user, :valor, :descrip, :acao)"
                );

                $newTransaction->bindValue(':id_user', '1');
                $newTransaction->bindValue(':valor', $moneyValue);
                $newTransaction->bindValue(':descrip', $descMoney);
                $newTransaction->bindValue(':acao', 'add');
                $newTransaction->execute();

            $newSaldo = $actualySaldo + $moneyValue;

                $updateSaldo = $conn->prepare(
                "UPDATE user_saldo
                SET saldo = :novoSaldo
                WHERE
                id_user = :id_user");

                $updateSaldo->bindValue(':novoSaldo', $newSaldo);
                $updateSaldo->bindValue(':id_user', 1);
                $success = $updateSaldo->execute();

                    if ($success) {
                        header('Location: http://localhost/FinancY/index.php?s=add_success');
                    }

    }

    public static function RemoveMoney($moneyValue, $descMoney)
    {
        require ('../model/connection.php');

        $select_saldo = $conn->prepare(
            "SELECT saldo 
            FROM user_saldo 
            WHERE id_user = 1"
        );
        $select_saldo->execute();
        $result = $select_saldo->fetchAll();

        foreach ($result as $saldo) {
            $actualySaldo = $saldo['saldo'];
        }

            if ($moneyValue > $actualySaldo) {
                echo 'Saldo insuficiente';
            }else {

                $newSaldo = $actualySaldo - $moneyValue;

                $newTransaction = $conn->prepare(
                    "INSERT INTO transacoes 
                    (id_user, valor, descrip, acao) 
                    VALUES (:id_user, :valor, :descrip, :acao)"
                );

                $newTransaction->bindValue(':id_user', '1');
                $newTransaction->bindValue(':valor', $moneyValue);
                $newTransaction->bindValue(':descrip', $descMoney);
                $newTransaction->bindValue(':acao', 'remove');
                $newTransaction->execute();

                $updateSaldo = $conn->prepare(
                "UPDATE user_saldo
                SET saldo = :novoSaldo
                WHERE
                id_user = :id_user");

                $updateSaldo->bindValue(':novoSaldo', $newSaldo);
                $updateSaldo->bindValue(':id_user', 1);
                $success = $updateSaldo->execute();

                    if ($success) {
                        header('Location: http://localhost/FinancY/index.php?s=remove_success');
                    }
            }
    }
}