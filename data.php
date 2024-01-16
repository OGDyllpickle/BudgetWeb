<?php
// Include the database connection from "Main_cnn.php"
include "Main_cnn.php";
// Your SQL UPDATE statement
$sql = "UPDATE Total
SET
    CRT = IFNULL((SELECT SUM(Banking.Credit) FROM Banking WHERE Banking.id = Total.id), 0),
    CH = IFNULL((SELECT SUM(Banking.Checking) FROM Banking WHERE Banking.id = Total.id), 0),
    ST = IFNULL((SELECT SUM(Banking.Saving) FROM Banking WHERE Banking.id = Total.id), 0);";

// Execute the query
$result = mysqli_query($conn, $sql);
if (!$result) {
    die('Error: ' . mysqli_error($conn));
}



$result = mysqli_query($conn, $sql);
if (!$result) {
   die('Error: ' . mysqli_error($conn));
}


// Close the database connection
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
$sql = "SELECT users.name, users.user_name AS uname, Banking.id AS Banking_id, IFNULL(Banking.Saving, 0) AS Saving, IFNULL(Banking.Credit, 0) AS Credit, IFNULL(Banking.Checking, 0) AS Checking, Banking.Month AS Month, IFNULL(Total.ST, 0) as ST, IFNULL(Total.CH, 0) As CH, IFNULL(Total.CRT, 0) as CRT
     FROM users
     JOIN Banking ON users.user_name = Banking.id
     JOIN Total ON users.user_name = Total.id
     WHERE users.user_name = '$uname'";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);
$Total = 0;
$Credit = 0;
$Saving = 0;
$Checking = 0;
$CRT = 0;
$ST = 0;
$CH = 0;

if ($resultCheck > 0){
  $row = mysqli_fetch_assoc($result);
    $CRT = $row['CRT'];
    $ST = $row['ST'];
    $CH = $row['CH'];
}



?>


<!DOCTYPE html>
<html>
<head>
    <title>Open Budgeting</title>
    <link rel="stylesheet" type="text/css" href="color.css?v=1">
</head>

        <div class="navbar">
          <div class="object">
            <form action="profile.php" method="post">
                <input type="hidden" name="uname" value="<?php echo $uname ?>">
                <input type="hidden" name="password" value="<?php echo $password?>" >
                <input type="hidden" name="var" value='0'>
                <button type="submit">Profile</button>
            </form>

          </div>
                <div class="date">
                    <?php
                    // Get and display the current date
                    echo date("m / d / Y");
                    ?>
                </div>
          <div class="object">
                <form action="B.Logout.php" method="post">
                    <input type="hidden" name="uname" value="<?php echo $uname ?>">
                    <input type="hidden" name="password" value="<?php echo $password?>" >
                    <button type="submit">LogOut</button>
                </form>
          </div>
        </div>



        <div class="interface">
          <div class="tab">
            <div class="dashboard">
                  <form action="data.php" method="post">
                      <input type="hidden" name="uname" value="<?php echo $uname ?>">
                      <input type="hidden" name="password" value="<?php echo $password?>" >
                      <input type="hidden" name="var" value='0'>
                      <input type="hidden" name="var2" value='0'>
                      <button type="submit">Graph</button>
                  </form>
            </div>
            <div class="dashboard">
                  <form action="credit.php" method="post">
                      <input type="hidden" name="uname" value="<?php echo $uname ?>">
                      <input type="hidden" name="password" value="<?php echo $password?>" >
                      <input type="hidden" name="var" value='0'>
                      <input type="hidden" name="var2" value='0'>
                      <button type="submit">Credit</button>
                  </form>
            </div>
            <div class="dashboard">
                  <form action="saving.php" method="post">
                      <input type="hidden" name="uname" value="<?php echo $uname ?>">
                      <input type="hidden" name="password" value="<?php echo $password?>" >
                      <input type="hidden" name="var" value='0'>
                      <input type="hidden" name="var2" value='0'>
                      <button type="submit">Saving</button>
                  </form>
            </div>
            <div class="dashboard">
                  <form action="checking.php" method="post">
                      <input type="hidden" name="uname" value="<?php echo $uname ?>">
                      <input type="hidden" name="password" value="<?php echo $password?>" >
                      <input type="hidden" name="var" value='0'>
                      <input type="hidden" name="var2" value='0'>
                      <button type="submit">Checking</button>
                  </form>
            </div>
          </div>
          <div class="border">
            <div class="box1">
              <div class="box2">
                <h1> Total </h1>
              </div>
              <div class="box2">
                <h1> $<?php echo $ST + $CH- $CRT ?> </h1>
              </div>

            </div>

            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
              <script type="text/javascript">
                google.charts.load('current', {'packages': ['corechart']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                  var data = google.visualization.arrayToDataTable([
                    ['Category', 'Amount'],
                    ['Saving', <?php echo $ST ?>],
                    ['Credit', <?php echo $CRT ?>],
                    ['Checking', <?php echo $CH ?>]
                  ]);

                  var options = {
                    title: 'Financial Data',
                    is3D: true,
                    backgroundColor: '#A5C9CA' // Set the desired background color here
                  };

                  var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
                  chart.draw(data, options);
                }
            </script>


              <div id="piechart_3d" style="width: 100%; height: 600px;"></div>





          </div>
        </div>



</html>
