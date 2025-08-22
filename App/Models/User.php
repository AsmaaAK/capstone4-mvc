<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class User
{
    public static function create(array $data): int
    {
        $sql = "INSERT INTO users (name,email,password,role,location,skills,availability_start,availability_end)
                VALUES (:name,:email,:password,:role,:location,:skills,:availability_start,:availability_end)";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->execute([
            ':name'               => $data['name'],
            ':email'              => $data['email'],
            ':password'           => password_hash($data['password'], PASSWORD_DEFAULT),
            ':role'               => $data['role'], // 'admin' or 'volunteer'
            ':location'           => $data['location'] ?? null,
            ':skills'             => isset($data['skills']) ? json_encode(array_values($data['skills'])) : null,
            ':availability_start' => $data['availability_start'] ?? null,
            ':availability_end'   => $data['availability_end'] ?? null,
        ]);
        return (int) Database::pdo()->lastInsertId();
    }

    public static function findByEmail(string $email): ?array
    {
        $stmt = Database::pdo()->prepare("SELECT * FROM users WHERE email=:email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::pdo()->prepare("SELECT * FROM users WHERE id=:id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function all(): array
    {
        $q = Database::pdo()->query("SELECT id,name,email,role,location,skills,availability_start,availability_end,created_at FROM users ORDER BY id DESC");
        return $q->fetchAll();
    }

    public static function update(int $id, array $data): bool
    {
        $fields = [
            'name'               => 'name = :name',
            'email'              => 'email = :email',
            'password'           => 'password = :password',
            'role'               => 'role = :role',
            'location'           => 'location = :location',
            'skills'             => 'skills = :skills',
            'availability_start' => 'availability_start = :availability_start',
            'availability_end'   => 'availability_end = :availability_end',
        ];
        $set = [];
        $params = [':id' => $id];

        foreach ($fields as $key => $expr) {
            if (array_key_exists($key, $data)) {
                $set[] = $expr;
                if ($key === 'password') {
                    $params[":$key"] = password_hash($data[$key], PASSWORD_DEFAULT);
                } elseif ($key === 'skills' && is_array($data['skills'])) {
                    $params[":$key"] = json_encode(array_values($data['skills']));
                } else {
                    $params[":$key"] = $data[$key];
                }
            }
        }

        if (!$set) return false;

        $sql = "UPDATE users SET " . implode(', ', $set) . " WHERE id = :id";
        $stmt = Database::pdo()->prepare($sql);
        return $stmt->execute($params);
    }

    public static function delete(int $id): bool
    {
        $stmt = Database::pdo()->prepare("DELETE FROM users WHERE id=:id");
        return $stmt->execute([':id' => $id]);
    }
}
