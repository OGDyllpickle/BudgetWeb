<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="style.css?v=1">
</head>
<body>

  <form action="data.php" method="post">
    <h2>Login</h2>

    <?php if (isset($_GET['error'])) { ?>
      <p class="error"><?php echo $_GET['error']; ?></p>
    <?php } ?>

    <?php if (isset($_GET['Login'])) { ?>
      <p class="Login"><?php echo $_GET['Login']; ?></p>
    <?php } ?>

    <label>User Name</label>
    <input type="text" name="uname" placeholder="User Name"><br>

    <label>Password</label>
    <input type="password" name="password" placeholder="Password"><br>

    <button type="submit">Login</button>
    <a href="signup.php" class="button-S">
      <button type="button"> Sign Up</button>
    </a>

  </form>

</body>
</html>
