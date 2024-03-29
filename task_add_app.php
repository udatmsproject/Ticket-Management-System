<?php

include 'include/db.php';

$sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
socket_connect($sock, "8.8.8.8", 53);
socket_getsockname($sock, $name); // $name passed by reference

$localAddr = $name;

date_default_timezone_set('Asia/Colombo');
$string = date("Y-m-d");
$date = DateTime::createFromFormat("Y-m-d", $string);
$date = date_format($date, 'Y-m-d H:i:s');

$name = $_POST['name'];
$emp_code = $_POST['emp_code'];
$designation = $_POST['designation'];
$division = $_POST['division'];
$ext = $_POST['ext'];
$issue = $_POST['issue'];
$cat_issue = $_POST['cat_issue'];
$asst_code = $_POST['asst_code'];
$priority = $_POST['priority'];
$status = "Approval Required";

$query = "INSERT INTO task(assigned_by, emp_code, assigned_date, issue, category, status, designation, division, extension_no, priority, asset_code, ip_address) VALUES('$name','$emp_code','$date','$issue','$cat_issue','$status','$designation','$division','$ext','$priority','$asst_code','$localAddr')";
$querylog_taskadd = "INSERT INTO log(log_emp_code, log_date_time, log_action) VALUES('$emp_code', '$date', 'New ticket added by $name in $division')";

$random_id_before = rand(1000, 100000000);
$random_id = $emp_code+$random_id_before;

$query_ticket_notify = "INSERT INTO notify_ao(random_id, assigned_by_ao_notify, issue_ao_notify, designation_ao_notify, division_ao_notify) VALUES('$random_id', '$name', '$issue', '$designation', '$division')";

if (isset($con)) {
    $create_query_ticket_notify = mysqli_query($con, $query_ticket_notify);
}

if (!empty($con)) {
    $create_query = mysqli_query($con, $query);
}
$create_querylog_taskadd = mysqli_query($con, $querylog_taskadd);

if ($create_query) {

    echo '<meta http-equiv=Refresh content="0;url=ticket_success.php">';

} else {
    echo " <div class='alert alert-solid-danger alert-bold'>";
    echo("Error : " . mysqli_error($con));
    echo " </div>";
}


?>
