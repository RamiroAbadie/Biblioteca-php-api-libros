<?php

require_once __DIR__ . "/LibroServiceInterface.php";
require_once __DIR__ . "/../repositories/LibroRepository.php";

class LibroServiceImpl implements LibroServiceInterface {
    private LibroRepository $libroRepository;

    public function __construct(LibroRepository $libroRepository) {
        $this->libroRepository = $libroRepository;
    }

    public function getAllLibros(): array {
        $filas = $this->libroRepository->findAllBaseData();

        $libros = [];

        foreach ($filas as $fila) {
            $idLibro = (int) $fila["id_libro"];

            $autores = $this->libroRepository->findAutoresByLibroId($idLibro);
            $generos = $this->libroRepository->findGenerosByLibroId($idLibro);
            $editoriales = $this->libroRepository->findEditorialesByLibroId($idLibro);

            $libros[] = [
                "idLibro" => $idLibro,
                "titulo" => $fila["titulo"],
                "paginas" => (int) $fila["paginas"],
                "ubicacion" => $fila["ubicacion"],
                "autores" => $autores,
                "generos" => $generos,
                "editoriales" => $editoriales
            ];
        }

        return $libros;
    }
}