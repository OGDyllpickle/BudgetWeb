<?php
session_start(); // Start the session

include "Main_cnn.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);

    if (empty($uname) || empty($pass)) {
        header("Location: signin.php?error=Username and password are required");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE user_name='$uname' AND password = '$pass'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['id'] = $row['id'];
            header("Location: ../Home/Home.php");
            exit();
        } else {
            header("Location: signin.php?error=Incorrect credentials");
            exit();
        }
    }
} else {
    header("Location: signin.php?error=Username and password are required");
    exit();
}
?>
