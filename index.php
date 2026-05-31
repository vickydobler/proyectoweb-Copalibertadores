<?php

require_once './app/controllers/category.controller.php';

$action = $_GET['action'] ?? 'home';

switch ($action) {

    case 'home':
        showHome();
        break;

    case 'categorias':
        showCategories();
        break;

    case 'categoria':
        showTeamsByCategory();
        break;

    case 'admin-categorias':
        showAdminCategories();
        break;

    case 'agregar-categoria':
        addCategory();
        break;

    case 'editar-categoria':
        editCategory();
        break;

    case 'eliminar-categoria':
        deleteCategory();
        break;

    default:
        showHome();
        break;
}