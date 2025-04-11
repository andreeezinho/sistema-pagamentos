<?php

namespace App\Interface\Venda;

interface IVendaProduto {

    public function transferAllCartProduct($carrinhoProdutos, int $vendas_id);

    public function findByUuid(string $uuid);

    public function findById(string $id);

}