<?php
include "../app/config.php";
include "../app/helper.php";
$resp = []; // empty array
$email = $_POST['email'];
$password = $_POST['password']; 

if ($email != "" && $password != "") {
    $encPass = md5($password);
    $sel = "SELECT * FROM admins WHERE email ='$email' AND password = '$encPass'";
    $exe = mysqli_query($conn, $sel);
    $fetch = mysqli_fetch_assoc($exe);
    if ($fetch['id'] != "") {
        // next step
        $_SESSION['admin_id'] = $fetch['id'];
        $_SESSION['admin_name'] = $fetch['name'];
        $resp['msg'] = "Login successfull";
        $resp['status'] = 1;
    } else {
        $resp['msg'] = "Invalid credentails";
        $resp['status'] = 0;
    }
} else {
    $resp['msg'] = "Please fill all the required fields";
    $resp['status'] = 0;
}

// p($resp);
echo json_encode($resp);
