<?php

interface LibroRepositoryInterface
{
    public function findAllBaseData(): array;

    public function findAutoresByLibroId(int $idLibro): array;

    public function findGenerosByLibroId(int $idLibro): array;

    public function findEditorialesByLibroId(int $idLibro): array;
}