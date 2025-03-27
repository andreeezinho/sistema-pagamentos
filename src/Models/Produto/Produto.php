<?php

namespace App\Models\Produto;

use App\Models\Traits\Uuid;

class Produto {

    use Uuid;

    public $id;
    public $uuid;
    public $nome;
    public $descricao;
    public $codigo;
    public $preco;
    public $estoque;
    public $ativo;
    public $imagem;
    public $created_at;
    public $updated_at;

    public function create(array $data) : Produto{
        $produto = new Produto();
        $produto->id = $data['id'] ?? null;
        $produto->uuid = $data['uuid'] ?? $this->generateUUID();
        $produto->nome = $data['nome'] ?? null;
        $produto->descricao = $data['descricao'] ?? null;
        $produto->codigo = $data['codigo'] ?? null;
        $produto->preco = $data['preco'] ?? 0;
        $produto->estoque = (!isset($data['estoque']) || $data['estoque'] == "") ? 1 : $data['estoque'];
        $produto->ativo = (!isset($data['ativo']) || $data['ativo'] == "") ? 1 : $data['ativo'];
        $produto->imagem = (!isset($data['imagem']) || $data['imagem'] == "") ? 'default.png' : $data['imagem'];
        $produto->created_at = $data['created_at'] ?? null;
        $produto->updated_at = $data['updated_at'] ?? null;
        return $produto;
    }

    public function update(array $data, Produto $produto) : Produto {
        $produto->nome = $data['nome'] ?? $produto->nome;
        $produto->descricao = $data['descricao'] ?? $produto->descricao;
        $produto->codigo = $data['codigo'] ?? $produto->codigo;
        $produto->preco = $data['preco'] ?? $produto->preco;
        $produto->estoque = $data['estoque'] ?? $produto->estoque;
        $produto->ativo = $data['ativo'] ?? $produto->ativo;
        $produto->imagem = $data['imagem'] ?? $produto->imagem;

        return $produto;
    }
}