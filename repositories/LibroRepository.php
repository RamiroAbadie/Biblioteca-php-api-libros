<?php

class LibroRepository {
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
}