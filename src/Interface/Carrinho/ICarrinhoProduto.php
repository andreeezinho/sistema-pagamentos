<?php

namespace App\Interface\Carrinho;

interface ICarrinhoProduto{

    public function findProduct(int $carrinho_id, int $produtos_id);

    public function allProductsInCart(int $id);

    public function addProductInCart(array $data, int $id, int $produto_id);

    public function sumProductQuantity(int $id, int $produto_id, int $quantidade);

    public function subtractProductQuantity(int $id, int $produto_id, int $quantidade);

    public function removeProductInCart(int $id, int $produto_id);

    public function deleteAllProducts(int $id, int $usuario_id);

    public function findByUuid(string $uuid);

    public function findById(int $id);

    public function findByUserId(int $usuario_id);
}