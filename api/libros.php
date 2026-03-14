<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../utils/response.php";

require_once __DIR__ . "/../repositories/LibroRepositoryInterface.php";
require_once __DIR__ . "/../repositories/LibroRepositoryImpl.php";

require_once __DIR__ . "/../services/LibroServiceInterface.php";
require_once __DIR__ . "/../services/LibroServiceImpl.php";

require_once __DIR__ . "/../controllers/LibroController.php";

try {
    $libroRepository = new LibroRepositoryImpl($pdo);
    $libroService = new LibroServiceImpl($libroRepository);
    $libroController = new LibroController($libroService);

    $libroController->handleRequest();

} catch (PDOException $e) {
    jsonResponse([
        "error" => "Error de base de datos",
        "detalle" => $e->getMessage()
    ], 500);

} catch (Exception $e) {
    jsonResponse([
        "error" => "Error interno del servidor",
        "detalle" => $e->getMessage()
    ], 500);
}