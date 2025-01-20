<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../controllers/MedicationController.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$controller = new MedicationController();

if ($uri === '/medications' && $method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $files = $_FILES ?? [];
    $controller->create($data, $files);
} elseif (preg_match('/\/medications\/(\d+)/', $uri, $matches) && $method === 'GET') {
    $userId = (int)$matches[1];
    $controller->read($userId);
} elseif (preg_match('/\/medications\/(\d+)/', $uri, $matches) && $method === 'PUT') {
    $id = (int)$matches[1];
    $data = json_decode(file_get_contents('php://input'), true);
    $files = $_FILES ?? [];
    $controller->update($id, $data, $files);
} elseif (preg_match('/\/medications\/(\d+)/', $uri, $matches) && $method === 'DELETE') {
    $id = (int)$matches[1];
    $controller->delete($id);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Endpoint not found']);
}
