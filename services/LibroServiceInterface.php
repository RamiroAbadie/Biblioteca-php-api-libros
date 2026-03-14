<?php

interface LibroServiceInterface
{
    public function getAllLibros(): array;

    public function getLibroById(int $idLibro): ?array;
}