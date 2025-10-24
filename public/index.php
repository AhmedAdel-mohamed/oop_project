<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>لوحة التحكم</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 30px;
        }
        a {
            background: #ff4d4d;
            color: white;
            padding: 8px 14px;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>
</head>
<body>

<h1>مرحبًا <?= htmlspecialchars($_SESSION['user']['name']) ?> 👋</h1>
<p>أنت الآن داخل النظام.</p>

<a href="logout.php">تسجيل الخروج</a>

</body>
</html>
