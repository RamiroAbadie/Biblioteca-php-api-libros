<?php

interface LibroServiceInterface
{
    public function getAllLibros(): array;

    public function getLibroById(int $idLibro): ?array;

    public function createLibro(array $data): array;
}