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
    $which = $_POST['which'];
    $amount = $_POST['amount'];
    $reason = $_POST['reason'];
    $month = $_POST['month'];
    $leave = "N/A";

    if ($which == 1) {
        $leave = "saving.php";
        $sql = "INSERT INTO `Banking` (`NU`, `id`, `Reason`, `Month`, `Saving`, `Checking`, `Credit`) VALUES (NULL, '$uname', '$reason', '$month', '$amount', '0', '0')";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            die('Error: ' . mysqli_error($conn));
        }
    } else if ($which == 2) {
        $leave = "checking.php";
        $sql = "INSERT INTO `Banking` (`NU`, `id`, `Reason`, `Month`, `Saving`, `Checking`, `Credit`) VALUES (NULL, '$uname', '$reason', '$month', '0', '$amount', '0')";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            die('Error: ' . mysqli_error($conn));
        }
    } else if ($which == 3) {
        $leave = "credit.php";
        $sql = "INSERT INTO `Banking` (`NU`, `id`, `Reason`, `Month`, `Saving`, `Checking`, `Credit`) VALUES (NULL, '$uname', '$reason', '$month', '0', '0', '$amount')";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            die('Error: ' . mysqli_error($conn));
        }
    }
} else {
    header("Location: signin.php?error=Username and password are required");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Form on Page Load</title>
</head>
<body>

    <form id="myForm" action="<?php echo $leave; ?>" method="post">
        <input type="hidden" name="uname" value="<?php echo $uname; ?>">
        <input type="hidden" name="password" value="<?php echo $password; ?>" >
    </form>

    <script>
        window.onload = function() {
            // Get the form element
            var myForm = document.getElementById('myForm');

            // Submit the form
            myForm.submit();
        };
    </script>

</body>
</html>
