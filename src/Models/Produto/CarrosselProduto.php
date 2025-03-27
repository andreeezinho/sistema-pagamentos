<?php

namespace App\Models\Produto;

use App\Models\Traits\Uuid;

class CarrosselProduto {

    use Uuid;

    public $id;
    public $uuid;
    public $nome_arquivo;
    public $produtos_id;
    public $created_at;
    public $updated_at;

    public function create(array $data) : CarrosselProduto{
        $carrossel_produto = new CarrosselProduto();
        $carrossel_produto->id = $data['id'] ?? null;
        $carrossel_produto->uuid = $data['uuid'] ?? $this->generateUUID();
        $carrossel_produto->nome = $data['nome_arquivo'] ?? null;
        $carrossel_produto->produtos_id = $data['produtos_id'] ?? null;
        $carrossel_produto->created_at = $data['created_at'] ?? null;
        $carrossel_produto->updated_at = $data['updated_at'] ?? null;
        return $carrossel_produto;
    }

}