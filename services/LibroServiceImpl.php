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

    public function createLibro(array $data): array
    {
        $this->validateCreateLibroData($data);

        try {
            $this->libroRepository->beginTransaction();

            $idLibro = $this->libroRepository->createLibro($data);

            $this->libroRepository->insertLibroAutores($idLibro, $data["autoresIds"]);
            $this->libroRepository->insertLibroGeneros($idLibro, $data["generosIds"]);
            $this->libroRepository->insertLibroEditoriales($idLibro, $data["editorialesIds"]);

            $this->libroRepository->commit();

            $libroCreado = $this->getLibroById($idLibro);

            if ($libroCreado === null) {
                throw new Exception("No se pudo recuperar el libro creado");
            }

            return $libroCreado;

        } catch (Exception $e) {
            $this->libroRepository->rollBack();
            throw $e;
        }
    }

    private function validateCreateLibroData(array $data): void
    {
        if (!isset($data["titulo"]) || trim($data["titulo"]) === "") {
            throw new InvalidArgumentException("El título es obligatorio");
        }

        if (!isset($data["paginas"]) || !is_numeric($data["paginas"]) || (int)$data["paginas"] <= 0) {
            throw new InvalidArgumentException("La cantidad de páginas debe ser un número mayor a 0");
        }

        if (!isset($data["ubicacionId"]) || !is_numeric($data["ubicacionId"]) || (int)$data["ubicacionId"] <= 0) {
            throw new InvalidArgumentException("La ubicación es obligatoria");
        }

        if (!isset($data["autoresIds"]) || !is_array($data["autoresIds"]) || count($data["autoresIds"]) === 0) {
            throw new InvalidArgumentException("Debe incluir al menos un autor");
        }

        if (!isset($data["generosIds"]) || !is_array($data["generosIds"]) || count($data["generosIds"]) === 0) {
            throw new InvalidArgumentException("Debe incluir al menos un género");
        }

        if (!isset($data["editorialesIds"]) || !is_array($data["editorialesIds"]) || count($data["editorialesIds"]) === 0) {
            throw new InvalidArgumentException("Debe incluir al menos una editorial");
        }
    }

    public function deleteLibro(int $idLibro): void {
        $libroExistente = $this->libroRepository->findBaseDataById($idLibro);

        if ($libroExistente === null) {
            throw new InvalidArgumentException("El libro que intenta eliminar no existe");
        }

        try {
            $this->libroRepository->beginTransaction();

            $this->libroRepository->deleteLibroAutores($idLibro);
            $this->libroRepository->deleteLibroGeneros($idLibro);
            $this->libroRepository->deleteLibroEditoriales($idLibro);
            $this->libroRepository->deleteLibroById($idLibro);

            $this->libroRepository->commit();

        } catch (Exception $e) {
            $this->libroRepository->rollBack();
            throw $e;
        }
    }
}