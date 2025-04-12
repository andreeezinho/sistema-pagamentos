<?php

namespace App\Interface\Venda;

interface IVendaProduto {

    public function allProductsInSale(int $venda_id);

    public function transferAllCartProduct(array $carrinhoProdutos, int $vendas_id);

    public function findByUuid(string $uuid);

    public function findById(string $id);

}