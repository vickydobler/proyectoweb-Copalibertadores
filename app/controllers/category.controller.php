<?php

require_once __DIR__ . '/../models/category.model.php';

function showHome() {
    require __DIR__ . '/../views/home.phtml';
}

function showCategories() {
    $categories = getCategories();

    require __DIR__ . '/../views/categories.phtml';
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