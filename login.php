<?php

session_start();
include 'db.php';


if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = "";

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_array($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['name'] = $row['full_name'];
            $_SESSION['role'] = $row['role']; 
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>
<?php
$pageTitle = 'Login | HTU Martial Arts';
include 'header.php';
?>
<body class="login-body">
    <div class="u-container u-d-flex u-justify-content-center u-align-items-center u-min-vh-100">
        <div class="login-card">
            <div class="u-text-center u-mb-5">
                <h2 class="text-gold u-fw-bold">MEMBER LOGIN</h2>
                <p class="u-text-secondary">Welcome back to the elite club</p>
            </div>

            <?php if ($error): ?>
                <div class="notice notice--danger u-py-2 u-text-center u-small"><?= $error ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="u-mb-3">
                    <label class="u-text-secondary u-small u-text-uppercase u-fw-bold u-mb-1">Email</label>
                    <input type="email" name="email" class="custom-input" required>
                </div>
                <div class="u-mb-4">
                    <label class="u-text-secondary u-small u-text-uppercase u-fw-bold u-mb-1">Password</label>
                    <input type="password" name="password" class="custom-input" required>
                </div>
                <button type="submit" name="login" class="btn-gold u-w-100 u-py-2">SIGN IN</button>
            </form>

            <div class="u-text-center u-mt-4">
                <p class="u-text-secondary u-small">Not a member? <a href="register.php" class="text-gold u-text-decoration-none">Join Now</a></p>
            </div>
        </div>
   </div>

<?php include 'footer.php'; ?>

</body>
</html>




