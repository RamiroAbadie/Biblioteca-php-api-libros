<?php

require_once __DIR__ . "/LibroServiceInterface.php";
require_once __DIR__ . "/../repositories/LibroRepositoryInterface.php";

class LibroServiceImpl implements LibroServiceInterface {
    private LibroRepositoryInterface $libroRepository;

    public function __construct(LibroRepositoryInterface $libroRepository) {
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

    public function getLibroById(int $idLibro): ?array {
        $fila = $this->libroRepository->findBaseDataById($idLibro);

        if ($fila === null) {
            return null;
        }

        $autores = $this->libroRepository->findAutoresByLibroId($idLibro);
        $generos = $this->libroRepository->findGenerosByLibroId($idLibro);
        $editoriales = $this->libroRepository->findEditorialesByLibroId($idLibro);

        return [
            "idLibro" => (int) $fila["id_libro"],
            "titulo" => $fila["titulo"],
            "paginas" => (int) $fila["paginas"],
            "ubicacion" => $fila["ubicacion"],
            "autores" => $autores,
            "generos" => $generos,
            "editoriales" => $editoriales
        ];
    }
}