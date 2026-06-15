<?php

require_once './config.php';

class EquipoModel {
    private $db;

    public function __construct() {
        $this->db = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
            DB_USER,
            DB_PASS
        );

        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getAll($pais = null) {
        if ($pais) {
            $query = $this->db->prepare("SELECT * FROM equipo WHERE pais = ? ORDER BY nombre ASC");
            $query->execute([$pais]);
        } else {
            $query = $this->db->prepare("SELECT * FROM equipo ORDER BY nombre ASC");
            $query->execute();
        }

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getById($id) {
        $query = $this->db->prepare("SELECT * FROM equipo WHERE id_equipo = ?");
        $query->execute([$id]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function insert($nombre, $pais, $estadio, $anio_fundacion, $copas_libertadores, $director_tecnico, $apodo_club) {
        $query = $this->db->prepare("
            INSERT INTO equipo
            (nombre, pais, estadio, anio_fundacion, copas_libertadores, director_tecnico, apodo_club)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $query->execute([
            $nombre,
            $pais,
            $estadio,
            $anio_fundacion,
            $copas_libertadores,
            $director_tecnico,
            $apodo_club
        ]);

        return $this->db->lastInsertId();
    }

    public function update($id, $nombre, $pais, $estadio, $anio_fundacion, $copas_libertadores, $director_tecnico, $apodo_club) {
        $query = $this->db->prepare("
            UPDATE equipo
            SET nombre = ?, pais = ?, estadio = ?, anio_fundacion = ?,
                copas_libertadores = ?, director_tecnico = ?, apodo_club = ?
            WHERE id_equipo = ?
        ");

        $query->execute([
            $nombre,
            $pais,
            $estadio,
            $anio_fundacion,
            $copas_libertadores,
            $director_tecnico,
            $apodo_club,
            $id
        ]);
    }

    public function delete($id) {
        $query = $this->db->prepare("DELETE FROM equipo WHERE id_equipo = ?");
        $query->execute([$id]);
    }
}
