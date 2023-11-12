<?php
include("dbconnection.php");
$con = dbconnection();
session_start();

$error = array(); // Initialize the error array

if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = md5($_POST['password']);

    // Prepare and execute a query to check if the user already exists
    $select = "SELECT * FROM user WHERE email = ?";
    $stmt = mysqli_prepare($con, $select);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $error[] = 'User already exists';
    } else {
        // Use prepared statement to insert a new user into the database
        $insert = "INSERT INTO user (name, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($con, $insert);
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $password);
        mysqli_stmt_execute($stmt);

        header('Location: login.php'); // Redirect after successful registration
        exit(); // Terminate the script
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <style>
        .error-msg {
            color: red;
            display: block;
            margin-top: 5px;
            text-align: center;
        }
    </style>
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

    <form method="POST" action="">
        <h3>Register</h3>
        <?php
        if (!empty($error)) { // Check if there are any errors to display
            foreach ($error as $errorMsg) {
                echo '<span class="error-msg">' . $errorMsg . '</span>';
            }
        }
        ?>
        <label for="name">Name</label>
        <input type="text" name="name" placeholder="Name" required>

        <label for="email">Email</label>
        <input type="email" name="email" placeholder="Email" required>

        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Password" id="password" required>

        <div class="social">
            <button type="submit" name="register">Register</button>
        </div>
        <p class="mt-3 font-weight-normal">Already have an account? <strong><a href="login.php">Login</a></strong></p>
    </form>

    <!-- Your additional HTML content here -->
</body>
</html>
