<?php
header("Content-Type: application/json");
include '../config/conn.php';




function reg_expense($con)
{

    extract($_POST);
    $blaance = getBalance($con);
    $data = array();

    $sql = "CALL register_expense_sp('',$amount,'$type','$desc','USR001')";
    $result = $con->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();

        if ($row["Message"] == "Denied") {
            $data = array('status' => false, 'message' => 'insufficient Balance🤗😍 and Your Balance is : $' . $blaance);
        } elseif ($row["Message"] == "Registered") {
            $data = array('status' => true, 'message' => 'Expense registered successfully');
        }
    } else {
        $data = array('status' => false, 'message' => 'Error registering expense');
    }
    echo json_encode($data);
}
function update_expense($con)
{

    extract($_POST);
    $blaance = getBalance($con);
    $data = array();

    $sql = "CALL register_expense_sp($id,$amount,'$type','$desc','USR001')";
    $result = $con->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();

        if ($row["Message"] == "Denied") {
            $data = array('status' => false, 'message' => 'insufficient Balance🤗😍 and Your Balance is : $' . $blaance);
        } elseif ($row["Message"] == "Updated") {
            $data = array('status' => true, 'message' => 'Expense Updated  successfully');
        }
    } else {
        $data = array('status' => false, 'message' => 'Error Updating expense');
    }
    echo json_encode($data);
}
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
function load_expense($con)
{
    $data = array();
    $sql = "SELECT * FROM tblexpense";
    $result = $con->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $data = array('status' => true, 'message' => $data);
    } else {
        $data = array('status' => false, 'message' => 'No expense found');
    }
    echo json_encode($data);
}
function getSingleExpense($con)
{
    extract($_POST);
    $data = array();
    $sql = "SELECT * FROM tblexpense WHERE id =$id";
    $result = $con->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        $data = array('status' => true, 'message' => $row);
    } else {
        $data = array('status' => false, 'message' => 'No expense found');
    }
    echo json_encode($data);
}
function getUserStatement($con)
{
    extract($_POST);
    $data = array();
    $sql = "CALL get_user_statement_sp('USR001','$from', '$to')";
    $result = $con->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $data = array('status' => true, 'message' => $data);
    } else {
        $data = array('status' => false, 'message' => 'No expense report found');
    }
    echo json_encode($data);
}


function delete_expense($con)
{
    extract($_POST);
    $data = array();
    $sql = "DELETE FROM tblexpense WHERE id = $id";
    $result = $con->query($sql);
    if ($result) {
        $data = array('status' => true, 'message' => 'Expense deleted successfully');
    } else {
        $data = array('status' => false, 'message' => 'Error deleting expense');
    }
    echo json_encode($data);
}




if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'reg_expense':
            reg_expense($con);
            break;
        case "load_expense":
            load_expense($con);
            break;
        case "delete_expense":
            delete_expense($con);
            break;
        case "getSingleExpense":
            getSingleExpense($con);
            break;
        case "update_expense":
            update_expense($con);
            break;
        case "getUserStatement":
            getUserStatement($con);
            break;
        default:
            echo json_encode(array("status" => false, "message" => "Invalid Function..."));
            break;
    }
} else {
    echo json_encode(array("status" => false, "message" => "Action is required..."));
}
