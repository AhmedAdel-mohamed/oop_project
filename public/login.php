<?php
// require_once __DIR__ . '/../src/Database.php';
// require_once __DIR__ . '/../src/AuthService.php';
namespace App;

use PDO;

$pdo = (new Database())->getConnection();
$auth = new AuthService($pdo);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($auth->login($email, $password)) {
        header('Location: index.php'); // بعد النجاح نروح الصفحة الرئيسية
        exit;
    } else {
        $error = '❌ البريد الإلكتروني أو كلمة المرور غير صحيحة';
    }
}


?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول</title>
    <style>
        body {
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f2f2f2;
        }
        form {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            width: 300px;
        }
        input {
            width: 100%;
            margin-bottom: 10px;
            padding: 8px;
        }
        button {
            width: 100%;
            padding: 8px;
            background: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        p.error { color: red; }
    </style>
</head>
<body>

<form method="POST">
    <h2>تسجيل الدخول</h2>
    <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <input type="email" name="email" placeholder="البريد الإلكتروني" required>
    <input type="password" name="password" placeholder="كلمة المرور" required>
    <button type="submit">دخول</button>
</form>

</body>
</html>
