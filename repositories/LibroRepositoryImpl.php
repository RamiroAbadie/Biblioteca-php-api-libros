<?php
require_once __DIR__ . "/LibroRepositoryInterface.php";

class LibroRepositoryImpl implements LibroRepositoryInterface {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function findAllBaseData(): array {
        $sql = "
            SELECT 
                l.id_libro,
                l.titulo,
                l.paginas,
                u.referencia AS ubicacion
            FROM libro l
            INNER JOIN ubicacion u ON l.id_ubicacion = u.id_ubicacion
            ORDER BY l.id_libro
        ";

        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findBaseDataById(int $idLibro): ?array {
        $sql = "
            SELECT 
                l.id_libro,
                l.titulo,
                l.paginas,
                u.referencia AS ubicacion
            FROM libro l
            INNER JOIN ubicacion u ON l.id_ubicacion = u.id_ubicacion
            WHERE l.id_libro = ?
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idLibro]);

        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        return $fila ?: null;
    }

    public function findAutoresByLibroId(int $idLibro): array {
        $sql = "
            SELECT a.nombre
            FROM libro_autor la
            INNER JOIN autor a ON la.id_autor = a.id_autor
            WHERE la.id_libro = ?
            ORDER BY a.nombre
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idLibro]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function findGenerosByLibroId(int $idLibro): array {
        $sql = "
            SELECT g.descripcion
            FROM libro_genero lg
            INNER JOIN genero g ON lg.id_genero = g.id_genero
            WHERE lg.id_libro = ?
            ORDER BY g.descripcion
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idLibro]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function findEditorialesByLibroId(int $idLibro): array {
        $sql = "
            SELECT e.nombre
            FROM libro_editorial le
            INNER JOIN editorial e ON le.id_editorial = e.id_editorial
            WHERE le.id_libro = ?
            ORDER BY e.nombre
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idLibro]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function createLibro(array $data): int {
        $sql = "
            INSERT INTO libro (titulo, id_ubicacion, paginas)
            VALUES (?, ?, ?)
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $data["titulo"],
            $data["ubicacionId"],
            $data["paginas"]
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function insertLibroAutores(int $idLibro, array $autoresIds): void {
        $sql = "
            INSERT INTO libro_autor (id_libro, id_autor)
            VALUES (?, ?)
        ";

        $stmt = $this->pdo->prepare($sql);

        foreach ($autoresIds as $idAutor) {
            $stmt->execute([$idLibro, $idAutor]);
        }
    }

    public function insertLibroGeneros(int $idLibro, array $generosIds): void {
        $sql = "
            INSERT INTO libro_genero (id_libro, id_genero)
            VALUES (?, ?)
        ";

        $stmt = $this->pdo->prepare($sql);

        foreach ($generosIds as $idGenero) {
            $stmt->execute([$idLibro, $idGenero]);
        }
    }

    public function insertLibroEditoriales(int $idLibro, array $editorialesIds): void {
        $sql = "
            INSERT INTO libro_editorial (id_libro, id_editorial)
            VALUES (?, ?)
        ";

        $stmt = $this->pdo->prepare($sql);

        foreach ($editorialesIds as $idEditorial) {
            $stmt->execute([$idLibro, $idEditorial]);
        }
    }

    public function beginTransaction(): void {
        $this->pdo->beginTransaction();
    }

    public function commit(): void {
        $this->pdo->commit();
    }

    public function rollBack(): void {
        if ($this->pdo->inTransaction()) {
            $this->pdo->rollBack();
        }
    }
}