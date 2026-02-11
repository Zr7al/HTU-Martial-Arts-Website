<?php

session_start();
include 'db.php';

$error = "";
$success = "";

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    
    $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
    if(mysqli_num_rows($check) > 0){
        $error = "Email already registered.";
    } else {
        $query = "INSERT INTO users (full_name, email, password, role) VALUES ('$name', '$email', '$password', 'member')";
        if(mysqli_query($conn, $query)){
            header("Location: login.php");
            exit();
        } else {
            $error = "Registration failed.";
        }
    }
}
?>
<?php
$pageTitle = 'Register | HTU Martial Arts';
include 'header.php';
?>
<body class="login-body">
    <div class="u-container u-d-flex u-justify-content-center u-align-items-center u-min-vh-100">
        <div class="login-card">
            <div class="u-text-center u-mb-4">
                <h2 class="text-gold u-fw-bold">CREATE ACCOUNT</h2>
                <p class="u-text-secondary">Begin your journey today</p>
            </div>

            <?php if ($error): ?>
                <div class="notice notice--danger u-py-2 u-text-center u-small"><?= $error ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="u-mb-3">
                    <label class="u-text-secondary u-small u-text-uppercase u-fw-bold u-mb-1">Full Name</label>
                    <input type="text" name="name" class="custom-input" required>
                </div>
                <div class="u-mb-3">
                    <label class="u-text-secondary u-small u-text-uppercase u-fw-bold u-mb-1">Email</label>
                    <input type="email" name="email" class="custom-input" required>
                </div>
                <div class="u-mb-4">
                    <label class="u-text-secondary u-small u-text-uppercase u-fw-bold u-mb-1">Password</label>
                    <input type="password" name="password" class="custom-input" required>
                </div>
                <button type="submit" name="register" class="btn-gold u-w-100 u-py-2">SIGN UP</button>
            </form>

            <div class="u-text-center u-mt-4">
                <p class="u-text-secondary u-small">Already have an account? <a href="login.php" class="text-gold u-text-decoration-none">Login</a></p>
            </div>
        </div>
    </div>

</body>
</html>





