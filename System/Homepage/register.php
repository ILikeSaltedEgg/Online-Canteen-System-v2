<?php
include 'db_connection.php'; // Connect to the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash password for security
    $role = 'customer'; // Default role

    // Check if email already exists
    $check_email = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $check_email->store_result();

    if ($check_email->num_rows > 0) {
        echo "<script>alert('Email already exists! Try another one.');</script>";
    } else {
        // Insert user into the database
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssss", $name, $email, $password, $role);
        
        if ($stmt->execute()) {
            echo "<script>alert('Registration successful! You can now login.'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Error in registration. Try again.');</script>";
        }
        $stmt->close();
    }
    $check_email->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="../../Styles/register.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <div class="register-container">
        <div class="register-image">
            <img src="https://img.freepik.com/premium-vector/secure-login-form-page-with-password-computer-padlock-3d-vector-icon-cartoon-minimal-style_365941-1119.jpg?semt=ais_hybrid" alt="Login Image">
        </div>
        <div class="register-form">
            <h2>Register</h2>
            <?php if (isset($error)): ?>
            <p class="error"><?= $error ?></p>
            <?php elseif (isset($success)): ?>
                <p class="success"><?= $success ?></p>
            <?php endif; ?>
            <div class="flip-card__back">
                     <div class="title">Sign up</div>
                     <form class="flip-card__form" action="" method="POST">
                        <input class="flip-card__input" placeholder="Name" type="name">
                        <input class="flip-card__input" name="email" placeholder="Email" type="email">
                        <input class="flip-card__input" name="password" placeholder="Password" type="password">
                        <button class="flip-card__btn">Confirm!</button>
                     </form>
                  </div>
        </div>
    </div>

</body>
</html>