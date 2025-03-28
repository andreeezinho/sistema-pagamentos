<?php

namespace App\Interface\Produto;

interface ICarrosselProduto {

    public function allProdutctCarouselImages(int $produto_id);

    public function create(array $data, string $dir);

    public function update(array $data, int $id, string $dir);

    public function delete(int $id);

    public function findByUuid(string $uuid);

    public function findById(string $id);

}