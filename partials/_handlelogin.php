<?php
$showError = false;
$login = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require "_dbconnect.php";
    $user_email = $_POST['email'];
    $user_password = $_POST['password'];
    $sql = "select * from iusers where user_email = '$user_email'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($user_password, $row['user_password'])) {
                $login = true;
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['user_email'] = $user_email;
                $_SESSION['user_name'] = $row['user_name'];
                header("Location: /iforum/index.php?login=true");
            } else {
                $showError = "bad credentials";
                header("Location: /iforum/index.php?loginPassword=false");
            }
        }
    } else
        $showError = "bad credentials";
        echo var_dump($num);
        // header("Location: /iforum/index.php?loginUser=false");
}

?>