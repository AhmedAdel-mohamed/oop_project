<?php
namespace App;

use PDO;

// require_once __DIR__ . '/Database.php';
class UserRepository
{
private PDO $pdo;

public function __construct()
{
    $this->pdo = Database::getConnection();
}

    // 🟢 1. إحضار كل المستخدمين

    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM users ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🟢 2. إحضار مستخدم واحد بالـ ID

    public function findById(int $id) : ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([ $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    // 🟢 3. إنشاء مستخدم جديد

    public function create(string $name, string $email, string $password): bool
{
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    return $stmt->execute([$name, $email, $hash]);
}

 // 🟢 4. تعديل بيانات مستخدم

 public function update(int $id, string $name, string $email): bool
 {
     $stmt = $this->pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
     return $stmt->execute([$name, $email, $id]);
 }

 // 🟢 5. حذف مستخدم

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

}


?>