<?php

namespace App\Interface\Produto;

interface IProduto{
    
    public function all(array $params = []);

    public function create(array $data);

    public function update(array $data, int $id);

    public function delete(int $id);

    public function findByUuid(string $uuid);

    public function findById(string $id);
}