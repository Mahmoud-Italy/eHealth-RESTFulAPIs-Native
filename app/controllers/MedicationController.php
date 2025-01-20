<?php

require_once 'models/Medication.php';

class MedicationController
{
    /**
     * Create a new medication.
     */
    public function create(array $data, array $files)
    {
        // Validate required fields
        if (empty($data['user_id']) || empty($data['name']) || empty($data['started_at']) || empty($data['dosage'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields: user_id, name, started_at, dosage']);
            return;
        }

        // Call the Medication model to create
        $result = Medication::create($data, $files);

        if (is_array($result) && isset($result['error'])) {
            http_response_code(400);
            echo json_encode($result);
        } else {
            http_response_code(201);
            echo json_encode(['message' => 'Medication created successfully']);
        }
    }

    /**
     * Retrieve all medications for a user.
     */
    public function read(int $userId)
    {
        $result = Medication::getAllByUser($userId);

        if ($result) {
            http_response_code(200);
            echo json_encode($result);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'No medications found for the specified user']);
        }
    }

    /**
     * Update an existing medication.
     */
    public function update(int $id, array $data, array $files)
    {
        // Validate required fields
        if (empty($data['name']) || empty($data['started_at']) || empty($data['dosage'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields: name, started_at, dosage']);
            return;
        }

        // Call the Medication model to update
        $result = Medication::update($id, $data, $files);

        if (is_array($result) && isset($result['error'])) {
            http_response_code(400);
            echo json_encode($result);
        } else {
            http_response_code(200);
            echo json_encode(['message' => 'Medication updated successfully']);
        }
    }

    /**
     * Delete a medication.
     */
    public function delete(int $id)
    {
        $result = Medication::delete($id);

        if ($result) {
            http_response_code(200);
            echo json_encode(['message' => 'Medication deleted successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Medication not found or could not be deleted']);
        }
    }
}
