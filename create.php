<?php
include "Main_cnn.php";
if (isset($_POST['name']) && isset($_POST['uname']) && isset($_POST['password']) && isset($_POST['password2'])){
  function validate($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }
  $name = validate($_POST['name']);
  $uname = validate($_POST['uname']);
  $pass = validate($_POST['password']);
  $pass2 = validate($_POST['password2']);
  $check_username = mysqli_query($conn, "SELECT * FROM users WHERE user_name = '$uname'");

  if (empty($name))
  {
      header("Location: signup.php?error=name is required");
      exit();
  }
  else if(preg_match("/[0-9]/i", $name))
  {
    header("Location: signup.php?error=Name can't contain number");
    exit();
  }

  else if (empty($uname))
  {
      header("Location: signup.php?error=username is required");
      exit();
  }
  else if(mysqli_num_rows($check_username) > 0){
    header("Location: signup.php?error=Username already exsits");
    exit();
  }
  else if (empty($pass))
  {
      header("Location: signup.php?error=Password is required");
      exit();
  }
  else if (empty($pass2))
  {
    header("Location: signup.php?error=Re-enter Password is required");
    exit();
  }
  else if ($pass != $pass2){
    header("Location: signup.php?error=Password must be the same");
    exit();
  }
  else if (strlen($pass) < 8)
  {
    header("Location: signup.php?error=Password Must be at least 8 characters");
    exit();
  }
  else if(! preg_match("/[a-z]/i", $pass))
  {
    header("Location: signup.php?error=Password Must contain at least one letter");
    exit();
  }
  else if(! preg_match("/[0-9]/i", $pass))
  {
    header("Location: signup.php?error=Password Must contain at least one number");
    exit();
  }
  else
  {
    $sql = "INSERT INTO users (name, user_name, password) VALUES ('$name', '$uname', '$pass');";
    mysqli_query($conn, $sql);
    header("Location: signin.php?Login=Account Created");
    exit();
  }
}
