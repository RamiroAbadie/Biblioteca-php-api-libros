<?php

require_once __DIR__ . "/../services/LibroServiceInterface.php";
require_once __DIR__ . "/../utils/responses.php";

class LibroController {
    private LibroServiceInterface $libroService;

    public function __construct(LibroServiceInterface $libroService) {
        $this->libroService = $libroService;
    }

    public function handleRequest(): void {
        $method = $_SERVER["REQUEST_METHOD"];

        if ($method === "GET") {
            if (isset($_GET["id"])) {
                $idLibro = (int) $_GET["id"];

                if ($idLibro <= 0) {
                    jsonResponse([
                        "error" => "El id debe ser un número mayor a 0"
                    ], 400);
                    return;
                }

                $libro = $this->libroService->getLibroById($idLibro);

                if ($libro === null) {
                    jsonResponse([
                        "error" => "Libro no encontrado"
                    ], 404);
                    return;
                }

                jsonResponse($libro, 200);
                return;
            }

            $libros = $this->libroService->getAllLibros();
            jsonResponse($libros, 200);
            return;
        }

        if ($method === "POST") {
            $rawBody = file_get_contents("php://input");
            $data = json_decode($rawBody, true);

            if (!is_array($data)) {
                jsonResponse([
                    "error" => "El body debe ser un JSON válido"
                ], 400);
                return;
            }

            $libroCreado = $this->libroService->createLibro($data);

            jsonResponse($libroCreado, 201);
            return;
        }

        if ($method === "DELETE") {
            if (!isset($_GET["id"])) {
                jsonResponse([
                    "error" => "Debe informar el id del libro a eliminar"
                ], 400);
                return;
            }

            $idLibro = (int) $_GET["id"];

            if ($idLibro <= 0) {
                jsonResponse([
                    "error" => "El id debe ser un número mayor a 0"
                ], 400);
                return;
            }

            $this->libroService->deleteLibro($idLibro);

            jsonResponse([
                "mensaje" => "Libro eliminado correctamente"
            ], 200);
            return;
        }

        jsonResponse([
            "error" => "Método no permitido"
        ], 405);
    }
}