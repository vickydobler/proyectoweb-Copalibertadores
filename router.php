<?php

require_once './app/controllers/EquipoApiController.php';

$resource = $_GET['resource'] ?? '';
$params = explode('/', trim($resource, '/'));

$controller = new EquipoApiController();

if ($params[0] === 'equipos') {
    $id = $params[1] ?? null;

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if ($id) {
                $controller->getById($id);
            } else {
                $controller->getAll();
            }
            break;

        case 'POST':
            if ($id) {
                $controller->methodNotAllowed();
            } else {
                $controller->create();
            }
            break;

        case 'PUT':
            if ($id) {
                $controller->update($id);
            } else {
                $controller->methodNotAllowed();
            }
            break;

        case 'DELETE':
            if ($id) {
                $controller->delete($id);
            } else {
                $controller->methodNotAllowed();
            }
            break;

        default:
            $controller->methodNotAllowed();
            break;
    }
} else {
    $controller->notFound();
}
