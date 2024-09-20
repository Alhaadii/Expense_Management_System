<?php
header("Content-Type: application/json");
include '../config/conn.php';




function reg_user($con)
{

    extract($_POST);
    $errorArray = array();
    $data = array();

    $newId = generateUserId($con);
    $file_name = $_FILES['image']['name'];
    $file_type = $_FILES['image']['type'];
    $file_size = $_FILES['image']['size'];

    $allowedImages = ["image/jpg", "image/jpeg", "image/png"];
    $maxSize = 5 * 1024 * 1024;

    $saveName = $newId . ".png";

    if (in_array($file_type, $allowedImages)) {
        if ($file_size > $maxSize) {
            $errorArray[] = "Files Sizes must be less than: " . $maxSize / 1024 * 2;
        }
    } else {
        $errorArray[] = "This File isnot allowed";
    }


    if (count($errorArray) <= 0) {
        $sql = "INSERT INTO `users`(`id`, `username`, `password`, `image`) VALUES ('$newId', '$username',MD5('$password'), '$saveName')";

        $result = $con->query($sql);

        if ($result) {

            move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $saveName);

            $data = array('status' => true, 'message' => 'User registered successfully');
        } else {
            $data = array('status' => false, 'message' => $con->error);
        }
    } else {
        $data = array('status' => false, 'message' => $errorArray);
    }
    echo json_encode($data);
}
function update_user($con)
{

    extract($_POST);

    $data = array();



    if (!empty(isset($_FILES['image']['name']))) {


        $errorArray = array();
        $file_name = $_FILES['image']['name'];
        $file_type = $_FILES['image']['type'];
        $file_size = $_FILES['image']['size'];

        $allowedImages = ["image/jpg", "image/jpeg", "image/png"];
        $maxSize = 15 * 1024 * 1024;

        $saveName = $id . ".png";


        if (in_array($file_type, $allowedImages)) {
            if ($file_size > $maxSize) {
                $errorArray[] = "Files Sizes must be less than: " . $maxSize / 1024 * 2;
            }
        } else {
            $errorArray[] = "This File isnot allowed";
        }


        if (count($errorArray) <= 0) {
            $sql = "UPDATE `users` SET username ='$username', password=MD5('$password'), image='$saveName' WHERE id = '$id'";

            $result = $con->query($sql);

            if ($result) {

                move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $saveName);

                $data = array('status' => true, 'message' => 'User Updated successfully');
            } else {
                $data = array('status' => false, 'message' => $con->error);
            }
        } else {
            $data = array('status' => false, 'message' => $errorArray);
        }
    } else {
        $sql = "UPDATE `users` SET  username ='$username', password=MD5('$password') WHERE id = '$id'";

        $result = $con->query($sql);

        if ($result) {

            $data = array('status' => true, 'message' => 'User updated successfully');
        } else {
            $data = array('status' => false, 'message' => $con->error);
        }
    }


    echo json_encode($data);
}






function load_users($con)
{
    $data = array();
    $sql = "SELECT * FROM users";
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
function generateUserId($con)
{
    $newId = '';
    $data = array();
    $sql = "SELECT * FROM users ORDER BY users.id DESC LIMIT 1";
    $result = $con->query($sql);
    if ($result) {
        $num_of_rows = $result->num_rows;
        if ($num_of_rows > 0) {
            $row = $result->fetch_assoc();
            $newId = ++$row['id'];
        } else {
            $newId = 'USR001';
        }
    } else {
        $data = array('status' => false, 'message' => 'No User found');
        echo json_encode($data);
    }
    return $newId;
}
function getSingleUser($con)
{
    extract($_POST);
    $data = array();
    $sql = "SELECT * FROM users WHERE id ='$id'";
    $result = $con->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        $data = array('status' => true, 'message' => $row);
    } else {
        $data = array('status' => false, 'message' => 'No User found');
    }
    echo json_encode($data);
}


function delete_User($con)
{
    extract($_POST);
    $data = array();
    $sql = "DELETE FROM users WHERE id = '$id'";
    $result = $con->query($sql);
    if ($result) {
        $data = array('status' => true, 'message' => 'User deleted successfully');
    } else {
        $data = array('status' => false, 'message' => 'Error deleting User');
    }
    echo json_encode($data);
}




if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'reg_user':
            reg_user($con);
            break;
        case "load_users":
            load_users($con);
            break;
        case "delete_User":
            delete_User($con);
            break;
        case "getSingleUser":
            getSingleUser($con);
            break;
        case "update_user":
            update_user($con);
            break;
        case "generateUserId":
            generateUserId($con);
            break;
        default:
            echo json_encode(array("status" => false, "message" => "Invalid Function..."));
            break;
    }
} else {
    echo json_encode(array("status" => false, "message" => "Action is required..."));
}
