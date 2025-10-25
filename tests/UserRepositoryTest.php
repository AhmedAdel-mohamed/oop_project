<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use App\UserRepository;
use App\Database;

// require_once __DIR__ . '/../src/UserRepository.php';
// require_once __DIR__ . '/../src/Database.php';

class UserRepositoryTest extends TestCase
{
    private $repo;
    private $pdo;

    protected function setUp(): void
    {
        // ✅ استخدام الـ Database الحقيقي
        $this->pdo = Database::getConnection();

        // ✅ تفريغ الجدول قبل كل Test
        $this->pdo->exec("TRUNCATE TABLE users");

        $this->repo = new UserRepository();
    }

    public function testCreateUser()
    {
        $result = $this->repo->create('Ahmed', 'ahmed@example.com', '1234');
        $this->assertTrue($result);
    }

    public function testGetAllUsers()
    {
        $this->repo->create('Ali', 'ali@example.com', '1234');
        $this->repo->create('Sara', 'sara@example.com', '1234');

        $users = $this->repo->getAll();
        $this->assertCount(2, $users);
    }

    public function testFindById()
    {
        $this->repo->create('Omar', 'omar@example.com', '1234');
        $user = $this->repo->getAll()[0];

        $found = $this->repo->findById($user['id']);
        $this->assertEquals('Omar', $found['name']);
    }

    public function testUpdateUser()
    {
        $this->repo->create('Mona', 'mona@example.com', '1234');
        $user = $this->repo->getAll()[0];

        $this->repo->update($user['id'], 'Mona Updated', 'mona@new.com');

        $updated = $this->repo->findById($user['id']);
        $this->assertEquals('Mona Updated', $updated['name']);
    }

    public function testDeleteUser()
    {
        $this->repo->create('Nada', 'nada@example.com', '1234');
        $user = $this->repo->getAll()[0];

        $this->repo->delete($user['id']);
        $deleted = $this->repo->findById($user['id']);

        $this->assertNull($deleted);
    }
}
