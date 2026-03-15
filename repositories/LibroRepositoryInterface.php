<?php

interface LibroRepositoryInterface
{
    public function findAllBaseData(): array;

    public function findBaseDataById(int $idLibro): ?array;

    public function findAutoresByLibroId(int $idLibro): array;

    public function findGenerosByLibroId(int $idLibro): array;

    public function findEditorialesByLibroId(int $idLibro): array;

    public function createLibro(array $data): int;

    public function insertLibroAutores(int $idLibro, array $autoresIds): void;

    public function insertLibroGeneros(int $idLibro, array $generosIds): void;

    public function insertLibroEditoriales(int $idLibro, array $editorialesIds): void;

    public function deleteLibroAutores(int $idLibro): void;

    public function deleteLibroGeneros(int $idLibro): void;

    public function deleteLibroEditoriales(int $idLibro): void;

    public function deleteLibroById(int $idLibro): void;

    public function beginTransaction(): void;

    public function commit(): void;

    public function rollBack(): void;
}