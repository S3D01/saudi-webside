<?php
session_start();
include '../config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($password === $user['password']) {
            $_SESSION['admin'] = $username;
            header('Location: dashboard.php');
            exit();
        } else {
            $error = 'اسم المستخدم أو كلمة المرور غير صحيحة';
        }
    } else {
        $error = 'اسم المستخدم أو كلمة المرور غير صحيحة';
    }
    
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تسجيل دخول المشرف</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<nav class="navbar">
    <div class="nav-brand">
        <a href="#">لوحة المشرف</a>
    </div>
    <ul class="nav-links">
        <li><a href="../index.php">الصفحة الرئيسية</a></li>
        <li><a href="#">زيارة الموقع</a></li>
    </ul>
</nav>

<div class="login-container">
    <div class="login-box">
        <h2>تسجيل دخول المشرف</h2>

        <?php if ($error): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <label>اسم المستخدم</label>
            <input type="text" name="username" placeholder="admin" required>

            <label>كلمة المرور</label>
            <input type="password" name="password" placeholder="••••••" required>

            <button type="submit">دخول</button>
        </form>
    </div>
</div>

<script src="../js/main.js"></script>
</body>
</html>