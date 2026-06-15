<?php

require_once __DIR__ . '/../models/EquipoModel.php';
require_once __DIR__ . '/../views/JSONView.php';

class EquipoApiController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new EquipoModel();
        $this->view = new JSONView();
    }

    public function getAll() {
        $pais = $_GET['pais'] ?? null;

        $equipos = $this->model->getAll($pais);

        $this->view->response($equipos, 200);
    }

    public function getById($id) {
        if (!$this->validId($id)) {
            $this->view->response(["error" => "El ID debe ser numerico"], 400);
            return;
        }

        $equipo = $this->model->getById($id);

        if (!$equipo) {
            $this->view->response(["error" => "Equipo no encontrado"], 404);
            return;
        }

        $this->view->response($equipo, 200);
    }

    public function create() {
        $data = $this->getBody();

        if (!$data) {
            $this->view->response(["error" => "JSON invalido"], 400);
            return;
        }

        if (!$this->hasRequiredData($data)) {
            $this->view->response(["error" => "Faltan datos obligatorios"], 400);
            return;
        }

        $id = $this->model->insert(
            $data->nombre,
            $data->pais,
            $data->estadio,
            $data->anio_fundacion,
            $data->copas_libertadores,
            $data->director_tecnico,
            $data->apodo_club ?? null
        );

        $nuevoEquipo = $this->model->getById($id);

        $this->view->response($nuevoEquipo, 201);
    }

    public function update($id) {
        if (!$this->validId($id)) {
            $this->view->response(["error" => "El ID debe ser numerico"], 400);
            return;
        }

        $equipo = $this->model->getById($id);

        if (!$equipo) {
            $this->view->response(["error" => "Equipo no encontrado"], 404);
            return;
        }

        $data = $this->getBody();

        if (!$data) {
            $this->view->response(["error" => "JSON invalido"], 400);
            return;
        }

        if (!$this->hasRequiredData($data)) {
            $this->view->response(["error" => "Faltan datos obligatorios"], 400);
            return;
        }

        $this->model->update(
            $id,
            $data->nombre,
            $data->pais,
            $data->estadio,
            $data->anio_fundacion,
            $data->copas_libertadores,
            $data->director_tecnico,
            $data->apodo_club ?? null
        );

        $equipoActualizado = $this->model->getById($id);

        $this->view->response($equipoActualizado, 200);
    }

    public function delete($id) {
        if (!$this->validId($id)) {
            $this->view->response(["error" => "El ID debe ser numerico"], 400);
            return;
        }

        $equipo = $this->model->getById($id);

        if (!$equipo) {
            $this->view->response(["error" => "Equipo no encontrado"], 404);
            return;
        }

        $this->model->delete($id);

        $this->view->response(["mensaje" => "Equipo eliminado correctamente"], 200);
    }

    public function notFound() {
        $this->view->response(["error" => "Recurso no encontrado"], 404);
    }

    public function methodNotAllowed() {
        $this->view->response(["error" => "Metodo no permitido"], 405);
    }

    private function getBody() {
        $body = file_get_contents("php://input");
        return json_decode($body);
    }

    private function validId($id) {
        return isset($id) && is_numeric($id) && $id > 0;
    }

    private function hasRequiredData($data) {
        return !empty($data->nombre)
            && !empty($data->pais)
            && !empty($data->estadio)
            && isset($data->anio_fundacion)
            && isset($data->copas_libertadores)
            && !empty($data->director_tecnico);
    }
}