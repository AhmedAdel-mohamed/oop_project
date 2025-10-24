<?php
namespace App;

use PDO;
use Exception;

header('Content-Type: application/json');

require_once __DIR__ . '/../vendor/autoload.php';

$repo = new UserRepository();

// Get request method & path
$method = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

$path = str_replace('/api.php', '', parse_url($requestUri, PHP_URL_PATH));
$segments = array_values(array_filter(explode('/', $path)));

try {
    switch ($method) {

        case 'GET':
            if (!empty($segments)) {
                $id = (int) $segments[0];
                $user = $repo->findById($id);

                if ($user) {
                    echo json_encode($user);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'User not found']);
                }
            } else {
                echo json_encode($repo->getAll());
            }
            break;

        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);

            if (!isset($data['name'], $data['email'], $data['password'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing name, email or password']);
                break;
            }

            $success = $repo->create($data['name'], $data['email'], $data['password']);
            echo json_encode(['success' => $success]);
            break;

        case 'PUT':
            if (empty($segments)) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing user ID']);
                break;
            }

            $id = (int)$segments[0];
            $data = json_decode(file_get_contents('php://input'), true);

            $success = $repo->update($id, $data['name'], $data['email']);
            echo json_encode(['success' => $success]);
            break;

        case 'DELETE':
            if (empty($segments)) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing user ID']);
                break;
            }

            $id = (int)$segments[0];
            $success = $repo->delete($id);
            echo json_encode(['success' => $success]);
            break;

        default:
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
