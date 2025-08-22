<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

class Event
{
    public static function create(array $data): int
    {
        $sql = "INSERT INTO events (title,description,location,required_skills,start_time,end_time,created_by)
                VALUES (:title,:description,:location,:required_skills,:start_time,:end_time,:created_by)";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->execute([
            ':title'           => $data['title'],
            ':description'     => $data['description'] ?? null,
            ':location'        => $data['location'],
            ':required_skills' => isset($data['required_skills']) ? json_encode(array_values($data['required_skills'])) : null,
            ':start_time'      => $data['start_time'],
            ':end_time'        => $data['end_time'],
            ':created_by'      => $data['created_by'] ?? null,
        ]);
        return (int) Database::pdo()->lastInsertId();
    }

    public static function all(): array
    {
        $q = Database::pdo()->query("SELECT * FROM events ORDER BY start_time ASC");
        return $q->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::pdo()->prepare("SELECT * FROM events WHERE id=:id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function update(int $id, array $data): bool
    {
        $fields = [
            'title'           => 'title = :title',
            'description'     => 'description = :description',
            'location'        => 'location = :location',
            'required_skills' => 'required_skills = :required_skills',
            'start_time'      => 'start_time = :start_time',
            'end_time'        => 'end_time = :end_time',
        ];
        $set = [];
        $params = [':id' => $id];

        foreach ($fields as $key => $expr) {
            if (array_key_exists($key, $data)) {
                $set[] = $expr;
                if ($key === 'required_skills' && is_array($data['required_skills'])) {
                    $params[":$key"] = json_encode(array_values($data['required_skills']));
                } else {
                    $params[":$key"] = $data[$key];
                }
            }
        }

        if (!$set) return false;

        $sql = "UPDATE events SET " . implode(', ', $set) . " WHERE id = :id";
        $stmt = Database::pdo()->prepare($sql);
        return $stmt->execute($params);
    }

    public static function delete(int $id): bool
    {
        $stmt = Database::pdo()->prepare("DELETE FROM events WHERE id=:id");
        return $stmt->execute([':id' => $id]);
    }
}
