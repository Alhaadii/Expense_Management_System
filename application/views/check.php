<?php
include "../config/conn.php";


function getBalance($con): float
{
    $sql = "SELECT get_user_balance_fn('USR001') as balance";
    $result = $con->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        $balance = $row['balance'];
        return $balance;
    }
}

echo getBalance($con);
