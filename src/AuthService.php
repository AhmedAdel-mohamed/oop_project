<?php
namespace App;

use PDO;

class AuthService 
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        session_start();
    }
    // ✅ تسجيل الدخول

    public function login(string $email, string $password): bool
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
                // لو المستخدم مش موجود أو الباسورد غلط
        if ($user || !password_verify($password, $user['password'])) {
           
            return false;
        }
                // ✅ حفظ بياناته في السيشن
        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
             'name' => $user['name']
            
    ];
        return true;
    }

    // ✅ تسجيل الخروج

    public function logout(): void
    {
        session_destroy();
    }

    // ✅ التحقق إذا المستخدم مسجل دخول

     public function isLoggedIn(): bool
    {
        return isset($_SESSION['user']);
    }

    // ✅ الحصول على المستخدم الحالي

   public function currentUser(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

}


?>