<?php
session_start();
$conn = new mysqli("localhost", "root", "", "online_store");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE username='$username'");
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: products.php");
        }
    } else {
        $error_message = "اسم المستخدم أو كلمة المرور غير صحيحة.";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="d-flex align-items-center justify-content-center vh-100">
    <div class="card shadow" style="width: 400px;">
        <div class="card-body">
            <h3 class="card-title text-center">تسجيل الدخول</h3>
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger"><?= $error_message ?></div>
            <?php endif; ?>
            <form action="login.php" method="post">
                <div class="form-group">
                    <label>اسم المستخدم:</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>كلمة المرور:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">دخول</button>
                <p class="text-center mt-3">ليس لديك حساب؟ <a href="register.php">إنشاء حساب جديد</a></p>
            </form>
        </div>
    </div>
</body>
</html>
