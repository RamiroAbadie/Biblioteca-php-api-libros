<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../utils/responses.php";
require_once __DIR__ . "/../repositories/LibroRepository.php";
require_once __DIR__ . "/../services/LibroService.php";

try {
    $libroRepository = new LibroRepository($pdo);
    $libroService = new LibroService($libroRepository);

    $method = $_SERVER["REQUEST_METHOD"];

    if ($method === "GET") {
        $libros = $libroService->getAllLibros();
        jsonResponse($libros, 200);
        exit;
    }

    jsonResponse([
        "error" => "Método no permitido"
    ], 405);

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