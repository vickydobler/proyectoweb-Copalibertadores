<?php

require_once __DIR__ . '/../models/category.model.php';

function showHome() {
    require __DIR__ . '/../views/home.phtml';
}

function showCategories() {
    $teams = getTeams();

    require __DIR__ . '/../views/categories.phtml';
}

function showAddTeam() {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'] ?? '';
        $pais = $_POST['pais'] ?? '';
        $estadio = $_POST['estadio'] ?? '';
        $anio_fundacion = $_POST['anio_fundacion'] ?? 0;
        $copas_libertadores = $_POST['copas_libertadores'] ?? 0;
        $director_tecnico = $_POST['director_tecnico'] ?? '';
        $apodo_club = $_POST['apodo_club'] ?? null;

        if (!empty($nombre) && !empty($pais) && !empty($estadio) && !empty($director_tecnico)) {
            addTeam($nombre, $pais, $estadio, $anio_fundacion, $copas_libertadores, $director_tecnico, $apodo_club);
        }

        header('Location: index.php?action=categorias');
        exit;
    }

    require __DIR__ . '/../views/teamForm.phtml';
}

function showTeamsByCategory() {
    $pais = $_GET['pais'] ?? null;

    if (!$pais) {
        echo "No se seleccionó una categoría";
        return;
    }

    $teams = getTeamsByCountry($pais);

    require __DIR__ . '/../views/teamsByCategory.phtml';
}

function showAdminCategories() {
    $categories = getCategories();

    require __DIR__ . '/../views/adminCategories.phtml';
}

function addCategory() {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pais = $_POST['pais'];

        if (!empty($pais)) {
            addCountryToTeams($pais);
        }

        header('Location: index.php?action=admin-categorias');
        exit;
    }

    $category = null;

    require __DIR__ . '/../views/categoryForm.phtml';
}

function editCategory() {
    $pais = $_GET['pais'] ?? null;

    if (!$pais) {
        echo "Categoría no encontrada";
        return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $newPais = $_POST['pais'];

        updateCountry($pais, $newPais);

        header('Location: index.php?action=admin-categorias');
        exit;
    }

    $category = $pais;

    require __DIR__ . '/../views/categoryForm.phtml';
}

function deleteCategory() {
    $pais = $_GET['pais'] ?? null;

    if ($pais) {
        deleteCountry($pais);
    }

    header('Location: index.php?action=admin-categorias');
    exit;
}