<?php

include 'include/db.php';

date_default_timezone_set('Asia/Colombo');

$string = date("Y-m-d");
$date = DateTime::createFromFormat("Y-m-d", $string);
$date = date_format($date, 'Y-m-d H:i:s');
$logged_user_id = $_POST['logged_user_id'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$empCode = $_POST['empCode'];
$email = $_POST['email'];
$acc_type = $_POST['permissions'];
$password = $_POST['password'];
$status = "Active";
$title = $_POST['title'];
$division = $_POST['division'];
$hash = password_hash($password, PASSWORD_DEFAULT);

$query_check_e = "SELECT * FROM user WHERE email = '$email' or employeeCode = '$empCode'";
$run_query_check_e = mysqli_query($con, $query_check_e);

$count_email = mysqli_num_rows($run_query_check_e);

if ($count_email != 0) {

    echo 2;
    return false;

} else {

    $query = "INSERT INTO user(firstName, lastName, employeeCode, email, acc_type, password, date_created, status, title, division) VALUES('$firstName','$lastName','$empCode','$email','$acc_type','$hash','$date','$status','$title','$division')";

    $string = date("Y-m-d");
    $date = DateTime::createFromFormat("Y-m-d", $string);
    $date = date_format($date, 'Y-m-d H:i:s');
    $query_log_user_add = "INSERT INTO log(log_userID, log_date_time, log_action) VALUES('$logged_user_id', '$date', 'User ID: $logged_user_id Added a new user (Acc Type: $acc_type) named $firstName $lastName with Employee Code: $empCode')";
    $create_query_query_log_user_add = mysqli_query($con, $query_log_user_add);

    $create_query = mysqli_query($con, $query);

    if ($create_query) {

        echo 1;

    } else {

        echo 0;

    }

}

?>