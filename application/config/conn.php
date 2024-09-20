<?php

$con = new mysqli("localhost", "root", "", "expense");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} else {
    // echo "Connected successfully";
}
