<?php

namespace App\Models\Venda;

use App\Models\Traits\Uuid;

class VendaProduto {

    use Uuid;

    public $id;
    public $uuid;
    public $quantidade;
    public $vendas_id;
    public $produtos_id;
    public $uuid_produto;
    public $nome;
    public $preco;
    public $imagem;
    public $created_at;
    public $updated_at;

    public function create($data, int $vendas_id){
        $vendaProduto = new VendaProduto();
        $vendaProduto->id = $data->id ?? null;
        $vendaProduto->uuid = $data->uuid ?? $this->generateUUID();
        $vendaProduto->quantidade = (!isset($data->quantidade) || $data->quantidade == "") ? 1 : $data->quantidade;
        $vendaProduto->vendas_id = $vendas_id ?? null;
        $vendaProduto->produtos_id = $data->produtos_id ?? null;
        $vendaProduto->created_at = $data->created_at ?? null;
        $vendaProduto->updated_at = $data->updated_at ?? null;
        return $vendaProduto;
    }

}