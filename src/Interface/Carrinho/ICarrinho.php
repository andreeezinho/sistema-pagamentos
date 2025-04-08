<?php

namespace App\Interface\Carrinho;

interface ICarrinho{
    
    public function create(int $usuario_id);

    public function allProductsInCart(int $id);

    public function addProductInCart(int $id, int $produto_id, int $quantidade);

    public function removeProductInCart(int $id, int $produto_id, int $quantidade);

    public function deleteAllProducts(int $id);

    public function findByUuid(string $uuid);

    public function findById(string $id);
}