<?php

namespace App\Models\Permissao;

use App\Models\Traits\Uuid;

class Permissao {

    use Uuid;

    public $id;
    public $uuid;
    public $nome;
    public $descricao;
    public $ativo;
    public $created_at;
    public $updated_at;

    public function create(array $data) : Permissao {
        $permissao = new Permissao();
        $permissao->id = $data['id'] ?? null;
        $permissao->uuid = $data['uuid'] ?? $this->generateUUID();
        $permissao->nome = $data['nome'] ?? null;
        $permissao->descricao = $data['descricao'] ?? null;
        $permissao->ativo = ($data['ativo'] == "") ? 1 : $data['ativo'];
        $permissao->created_at = $data['created_at'] ?? null;
        $permissao->updated_at = $data['updated_at'] ?? null;
        return $permissao;
    }

}