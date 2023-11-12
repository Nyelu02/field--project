<?php
include("dbconnection.php");
$con = dbconnection();
session_start();

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $pass = md5($_POST['password']); // Note: MD5 is not recommended for password hashing

    $select = "SELECT *
               FROM user
               WHERE email = '$email' AND password = '$pass'";

    $result = mysqli_query($con, $select);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $id = $row['id'];

        $_SESSION['email'] = $email;
        $_SESSION['id'] = $id;

        header('Location: dashboard.php'); 
        exit();
    } else {
        $error[] = 'Incorrect email or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
 
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar background">
        <div class="logo">
            <img src="images/logo.png" alt="Logo">
        </div>
        <ul class="nav-list">
            <li><a class="active" href="index.php"><i class="fa fa-fw fa-home"></i> Home</a></li>
            <li><a href="#">About us</a></li>
            <li><a href="register.php">Register</a></li>
            <li><a href="login.php"><i class="fa fa-fw fa-user"></i> Login</a></li>
        </ul>
    </nav>

    <form method="POST">
        <h3>Login</h3>
        <?php
        if (!empty($error)) { // Check if there are any errors to display
            foreach ($error as $errorMsg) {
                echo '<span class="error-msg">' . $errorMsg . '</span>';
            }
        }
        ?>
        <label for="username">Username</label>
        <input type="text" name="email" placeholder="Email" id="username">

        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Password" id="password">
        
        <div class="social">
          <button type="submit" name="login">Log In</button>
        </div>
        <p class="mt-3 font-weight-normal">Don't have an account? <strong><a href="register.php">Register Now</a></strong></p>
    </form>
</body>
</html>
