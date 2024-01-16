<?php

include "Main_cnn.php";
if(isset($_POST['semail']) && isset($_POST['uname']) && isset($_POST['password'])){
  function validate($data){
    $data = trim($data);
    return $data;
  }
  $semail = validate($_POST['semail']);
  $password = $_POST['password'];
  $uname = $_POST['uname'];
if(empty($semail)){
  $var = '1';
}
else{
  $var = '2';
  $sql = "UPDATE users SET email = '$semail' WHERE user_name = '$uname'";
  mysqli_query($conn, $sql);
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
        <input type="hidden" name="password" value="<?php echo $password?>" >
        <input type="hidden" name="var" value="<?php echo $var?>" >
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
