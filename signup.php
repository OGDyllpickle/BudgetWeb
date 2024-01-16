<!DOCTYPE html>
<html>
<head>
  <title>Sign Up</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <form action="create.php" method="post">
  <h2>Sign Up</h2>

  <?php if (isset($_GET['error'])) { ?>
    <p class="error"><?php echo $_GET['error']; ?></p>
  <?php } ?>

  <label>Name</label>
  <input type="text" name="name" placeholder="Name"><br>

  <label>Username</label>
  <input type="text" name="uname" placeholder="Username"><br>

  <label>Password</label>
  <input type="password" name="password" placeholder="Password"><br>

  <label>Re-enter Password</label>
  <input type="password" name="password2" placeholder="Re-enter"><br>
  <a href="signin.php" class="button-S">
    <button type="button">Back</button>
  </a>
  <button type="submit">Confirm</button>



</form>



</body>
</html>
