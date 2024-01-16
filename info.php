<?php
// Include the database connection from "Main_cnn.php"
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
        // Use prepared statements to prevent SQL injection
        $sql = "SELECT name FROM users WHERE user_name = ? AND password = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $uname, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($resultCheck = mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $userName = $row['name'];
                //echo "Welcome, " . $userName . "<br>";
            }
        } else {
          header("Location: signin.php?error=Incorrect credentials");
          exit();
        }
    }
} else {
  header("Location: signin.php?error=Username and password are required");
  exit();
}

$month = date("m");

// Your SQL query (make sure to sanitize or use prepared statements for security)
$sql = "SELECT users.name, users.user_name AS uname, Banking.id AS Banking_id, IFNULL(Banking.Saving, 0) AS Saving, IFNULL(Banking.Credit, 0) AS Credit, IFNULL(Banking.Checking, 0) AS Checking, Banking.Month AS Month
        FROM users
        JOIN Banking ON users.user_name = Banking.id
        WHERE users.user_name = '$uname' AND Banking.id = '$uname' AND Banking.Month = $month";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);
$Total = 0;
$Credit = 0;
$Saving = 0;
$Checking = 0;
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
  </div>
</div>
</html>
