<?php

namespace App\Models\Carrinho;

use App\Models\Traits\Uuid;

class CarrinhoProduto {

    use Uuid;

    public $id;
    public $uuid;
    public $quantidade;
    public $carrinho_id;
    public $produtos_id;
    public $uuid_produto;
    public $nome;
    public $preco;
    public $imagem;
    public $created_at;
    public $updated_at;

    public function create(array $data, int $carrinho_id, int $produtos_id){
        $carrinhoProduto = new Carrinho();
        $carrinhoProduto->id = $data['id'] ?? null;
        $carrinhoProduto->uuid = $data['uuid'] ?? $this->generateUUID();
        $carrinhoProduto->quantidade = (!isset($data['quantidade']) || $data['quantidade'] == "") ? 1 : $data['quantidade'];
        $carrinhoProduto->carrinho_id = $carrinho_id ?? null;
        $carrinhoProduto->produtos_id = $produtos_id ?? null;
        $carrinhoProduto->created_at = $data['created_at'] ?? null;
        $carrinhoProduto->updated_at = $data['updated_at'] ?? null;
        return $carrinhoProduto;
    }

}