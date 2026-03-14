<?php

require_once __DIR__ . "/../services/LibroServiceInterface.php";
require_once __DIR__ . "/../utils/response.php";

class LibroController {
    private LibroServiceInterface $libroService;

    public function __construct(LibroServiceInterface $libroService) {
        $this->libroService = $libroService;
    }

    public function handleRequest(): void {
        $method = $_SERVER["REQUEST_METHOD"];

        if ($method === "GET") {
            $libros = $this->libroService->getAllLibros();
            jsonResponse($libros, 200);
            return;
        }

        jsonResponse([
            "error" => "Método no permitido"
        ], 405);
    }
}