<?php
include "Main_cnn.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = validate($_POST['uname']);
    $password = validate($_POST['password']);

    if (empty($uname) || empty($password)) {
        header("Location: signin.php?error=Username and password are required");
        exit();
    } else {
        $sql = "SELECT name FROM users WHERE user_name = ? AND password = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $uname, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($resultCheck = mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $Name = $row['name'];
        } else {
            header("Location: signin.php?error=Incorrect credentials");
            exit();
        }
    }
} else {
    header("Location: signin.php?error=Username and password are required");
    exit();
}

$sql = "SELECT users.name, IFNULL(users.email, 'None') AS email, users.user_name AS uname
        FROM users
        WHERE users.user_name = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $uname);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$resultCheck = mysqli_num_rows($result);

if ($resultCheck > 0) {
    $row = mysqli_fetch_assoc($result);
    $uid = $row['pid'];
    //Create Email Varible Here Should fix the issue if not run a debuging test

} else {
    $uid = "N/A";
}
?>



<!DOCTYPE html>


<html>




<head>
  <link rel="stylesheet" type="text/css" href="color.css">
  <title>Profile</title>
</head>
<div class="interface">
  <div class="tab">
    <div class="dashboard">
          <form action="profile.php#profile" method="post">
              <input type="hidden" name="uname" value="<?php echo $uname ?>">
              <input type="hidden" name="password" value="<?php echo $password?>" >
              <input type="hidden" name="var" value='0'>
              <input type="hidden" name="var2" value='0'>
              <button type="submit">Profile</button>
          </form>
    </div>
    <div class="dashboard">
      <form action="info.php#Profile" method="post">
          <input type="hidden" name="uname" value="<?php echo $uname ?>">
          <input type="hidden" name="password" value="<?php echo $password?>" >
          <button type="submit">Info</button>
      </form>
    </div>
    <div class="dashboard">
      <form action="data.php" method="post">
          <input type="hidden" name="uname" value="<?php echo $uname ?>">
          <input type="hidden" name="password" value="<?php echo $password?>" >
          <button type="submit">Back</button>
      </form>
    </div>
  </div>
  <div class="border">
    <div class="name">
      <h1>Name</h1>
      <p><?php echo $Name?></p>
    </div>
      <div class="uname">
        <h1> Username </h1>
        <p><?php echo $uname?></p>
      </div>
      <div class="Email">
        <h1> Email </h1>
        <?php
        if ($resultCheck > 0) {
          $email = $row['email']; // Use the email directly from the fetched row
          $displayEmail = ($email == 'None') ? 'N/A' : $email;
          echo '<p>' . $displayEmail . '</p>';
        } else {
          echo '<p>None</p>';
        }
        ?>
        <form action="semail.php" method="post">
          <label for="userInput">New Email?:</label>
          <input type="text" name="semail" placeholder="Type something...">
          <input type="hidden" name="uname" value="<?php echo $uname ?>">
          <input type="hidden" name="password" value="<?php echo $password?>" >
          <button type="submit">Confirm</button>
        </form>
        <div class="line">
          <?php if($_POST['var'] == 1){
            echo "<p>Can't leave empty.</p>";
          }
          else if($_POST['var'] ==0){

          }
          else{
            echo "<p>Email Created.</p>";
          }
          ?>
        </div>
      </div>
      <div class="id">
        <h1> User ID </h1>
        <p> <?php echo $uid; ?> </p>
      </div>
      <div class="change-password">
        <h1> Change Password</h1>
        <form action="spass.php" method="post">
          <label for="userInput"></label>
          <input type="password" name="Current" placeholder="Current Password">
          <br>
          <input type="password" name="New" placeholder="New Password">
          <br>
          <input type="password" name="RNew" placeholder="Repeat New Password">
          <input type="hidden" name="uname" value="<?php echo $uname ?>">
          <input type="hidden" name="password" value="<?php echo $password?>" >
          <br>
          <button type="submit">Confirm</button>
        </form>
        <div class="line">
          <?php
          if($_POST['var2'] == 1){
            echo "<p>Can't leave empty.</p>";
          }
          else if($_POST['var2'] ==0){

          }
          else if($_POST['var2'] == 2){
            echo "<p>Password does not match current</p>";

          }
          else if($_POST['var2'] == 3){
            echo "<p>New password not same.</p>";
          }
          else if($_POST['var2'] == 4){
            echo "<p>Password Must be 8 Charcters Long.</p>";
          }
          else if($_POST['var2'] == 5){
            echo "<p>Password Must Contain at least one letter.</p>";
          }
          else if($_POST['var2'] == 6){
            echo "<p>Password Must Contain one number.</p>";
          }
          else{
            echo "<p>Password Changed.</p>";
          }
          ?>
        </div>
      </div>



  </div>
</div>
</html>
