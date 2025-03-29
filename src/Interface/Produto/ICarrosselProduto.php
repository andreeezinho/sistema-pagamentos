<?php

namespace App\Interface\Produto;

interface ICarrosselProduto {

    public function allProdutctCarouselImages(int $produto_id);

    public function create(array $data, int $produtos_id, string $dir);

    public function update(array $data, int $id, int $produtos_id, string $dir);

    public function delete(string $imagem, int $id, string $dir);

    public function findByUuid(string $uuid);

    public function findById(string $id);

}