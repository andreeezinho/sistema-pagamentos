<?php

namespace App\Interface\Carrinho;

interface ICarrinhoProduto{

    public function allProductsInCart(int $id);

    public function addProductInCart(array $data, int $id, int $produto_id);

    public function removeProductInCart(int $id, int $produto_id, int $quantidade);

    public function deleteAllProducts(int $id, int $usuario_id);

    public function findByUuid(string $uuid);

    public function findById(string $id);
}