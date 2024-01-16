<?php
include "Main_cnn.php";

if (isset($_POST['uname']) && isset($_POST['password']) && isset($_POST['Current']) && isset($_POST['New']) && isset($_POST['RNew'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $Current = validate($_POST['Current']);
    $New = validate($_POST['New']);
    $RNew = validate($_POST['RNew']);
    $password = $_POST['password'];
    $uname = $_POST['uname'];

    $var2 = ''; // Initialize $var2

    if (empty($Current) || empty($New) || empty($RNew)) {
        $var2 = '1';
    } else if ($Current != $password) {
        $var2 = '2';
    } else if ($New != $RNew) {
        $var2 = '3';
    } else {
        if (strlen($RNew) < 8) {
            $var2 = '4';
        } else if (!preg_match("/[a-zA-Z]/", $RNew)) {
            $var2 = '5';
        } else if (!preg_match("/[0-9]/", $RNew)) {
            $var2 = '6';
        } else {
            $var2 = '7';
            $sql = "UPDATE users SET password = '$RNew' WHERE user_name = '$uname'";
            mysqli_query($conn, $sql);
        }
    }
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

    <form id="myForm" action="profile.php" method="post">
        <input type="hidden" name="uname" value="<?php echo $uname ?>">
        <input type="hidden" name="password" value="<?php echo $password ?>" >
        <input type="hidden" name="var2" value="<?php echo $var2 ?>" >
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
