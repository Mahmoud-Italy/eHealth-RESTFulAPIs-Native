<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../helpers/imageHelper.php';

use App\Config\Database;
use App\Helpers\ImageHelper;

class Medication
{
    public static function create(array $data, array $files)
    {
        $targetDir = __DIR__ . '/../uploads/images';
        $imagePath = null;

        if (isset($files['image']) && !empty($files['image']['tmp_name'])) {
            $imagePath = ImageHelper::processImage($files['image'], $targetDir);

            if (!$imagePath) {
                return ['error' => 'Invalid image upload'];
            }
        }

        $query = "INSERT INTO medications (user_id, name, started_at, dosage, note, image_path) 
                  VALUES (:user_id, :name, :started_at, :dosage, :note, :image_path)";

        $params = [
            ':user_id' => $data['user_id'],
            ':name' => $data['name'],
            ':started_at' => $data['started_at'],
            ':dosage' => $data['dosage'],
            ':note' => $data['note'] ?? null,
            ':image_path' => $imagePath
        ];

        return Database::execute($query, $params);
    }

    public static function getAllByUser(int $userId)
    {
        $query = "SELECT * FROM medications WHERE user_id = :user_id";
        $params = [':user_id' => $userId];

        return Database::fetchAll($query, $params);
    }

    public static function update(int $id, array $data, array $files)
    {
        $targetDir = __DIR__ . '/../uploads/images';
        $imagePath = null;

        if (isset($files['image']) && !empty($files['image']['tmp_name'])) {
            $imagePath = ImageHelper::processImage($files['image'], $targetDir);

            if (!$imagePath) {
                return ['error' => 'Invalid image upload'];
            }
        }

        $query = "UPDATE medications 
                  SET name = :name, started_at = :started_at, dosage = :dosage, note = :note, image_path = :image_path 
                  WHERE id = :id";

        $params = [
            ':id' => $id,
            ':name' => $data['name'],
            ':started_at' => $data['started_at'],
            ':dosage' => $data['dosage'],
            ':note' => $data['note'] ?? null,
            ':image_path' => $imagePath
        ];

        return Database::execute($query, $params);
    }

    public static function delete(int $id)
    {
        $query = "DELETE FROM medications WHERE id = :id";
        $params = [':id' => $id];

        return Database::execute($query, $params);
    }
}
