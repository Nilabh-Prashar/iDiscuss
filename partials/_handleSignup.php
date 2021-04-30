<?php
$showError = "false";
$showAlert = "false";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require "_dbconnect.php";
    $user_email = $_POST['email'];
    $user_name = $_POST['name'];
    $user_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    // check password or confirm password are same or not

    if ($user_password != $confirm_password) {
        $showError = "Please enter same password in confirm password section";
        header("Location: /iForum/index.php?passwordMatch=true");
        // echo 'Password match?';
        exit;
    }
    // check user exist or not
    $sqlExist = "select * from iusers where  user_email = '$user_email'";
    $result = mysqli_query($conn, $sqlExist);
    $num = mysqli_num_rows($result);
    if ($num > 0) {

        $showError = "User or email already exist !! Please Login";
        header("Location: /iForum/index.php?userExist=true");
            // header("location : iforum/index.php");
    } else {
        $password_hash = password_hash($user_password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO `iusers` (`user_id`, `user_name`, `user_email`, `user_password`, `signin_date`)
                 VALUES ('', '$user_name', '$user_email', '$password_hash', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $showAlert = "Signup Succesfull";
            header("Location: /iForum/index.php?signupSuccess=true");
        } else
            header("Location: /iForum/index.php?signupSuccess=false");
    }
       
    }
?>
