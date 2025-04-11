<?php

namespace App\Interface\Carrinho;

interface ICarrinho{

    public function create(int $usuario_id);

    public function delete(int $id);

    public function findByUuid(string $uuid);

    public function findById(string $id);

    public function findByUserId(string $usuarios_id);
}