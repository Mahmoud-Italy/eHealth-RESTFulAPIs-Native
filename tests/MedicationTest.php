<?php

use PHPUnit\Framework\TestCase;

class MedicationTest extends TestCase
{
    public function testCreateMedication()
    {
        $data = [
            'user_id' => 1,
            'name' => 'Aspirin',
            'started_at' => '2025-01-20',
            'dosage' => 2,
            'note' => 'Take after meals',
        ];

        $result = Medication::create($data, []);
        $this->assertTrue($result); // Assuming Medication::create returns true on success
    }

    public function testReadMedications()
    {
        $userId = 1;
        $result = Medication::getAllByUser($userId);

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
    }

    public function testUpdateMedication()
    {
        $id = 1;
        $data = [
            'name' => 'Ibuprofen',
            'started_at' => '2025-01-21',
            'dosage' => 1,
            'note' => 'Once daily',
        ];

        $result = Medication::update($id, $data, []);
        $this->assertTrue($result); // Assuming Medication::update returns true on success
    }

    public function testDeleteMedication()
    {
        $id = 1;
        $result = Medication::delete($id);

        $this->assertTrue($result); // Assuming Medication::delete returns true on success
    }
}
