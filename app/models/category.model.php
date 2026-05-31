<?php

require_once 'config.php';

function getConnection() {
    $db = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
        DB_USER,
        DB_PASS
    );

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $db;
}

function getCategories() {
    $db = getConnection();

    $query = $db->prepare("SELECT DISTINCT pais FROM equipo ORDER BY pais ASC");
    $query->execute();

    return $query->fetchAll(PDO::FETCH_OBJ);
}

function getTeamsByCountry($pais) {
    $db = getConnection();

    $query = $db->prepare("SELECT * FROM equipo WHERE pais = ? ORDER BY nombre ASC");
    $query->execute([$pais]);

    return $query->fetchAll(PDO::FETCH_OBJ);
}

function addCountryToTeams($pais) {
    $db = getConnection();

    $query = $db->prepare("
        INSERT INTO equipo 
        (nombre, pais, estadio, anio_fundacion, copas_libertadores, director_tecnico, apodo_club)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $query->execute([
        'Equipo nuevo',
        $pais,
        '-',
        0,
        0,
        '-',
        null
    ]);
}

function updateCountry($oldPais, $newPais) {
    $db = getConnection();

    $query = $db->prepare("UPDATE equipo SET pais = ? WHERE pais = ?");
    $query->execute([$newPais, $oldPais]);
}

function deleteCountry($pais) {
    $db = getConnection();

    $query = $db->prepare("DELETE FROM equipo WHERE pais = ?");
    $query->execute([$pais]);
}