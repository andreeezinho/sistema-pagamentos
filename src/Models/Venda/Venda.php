<?php

namespace App\Models\Venda;

use App\Models\Traits\Uuid;

class Venda {

    use Uuid;

    public $id;
    public $uuid;
    public $desconto;
    public $enderecos_id;
    public $usuarios_id;
    public $total;
    public $situacao;
    public $created_at;
    public $updated_at;

    public function create(array $data, int $usuarios_id){
        $venda = new Venda();
        $venda->id = $data['id'] ?? null;
        $venda->uuid = $data['uuid'] ?? $this->generateUUID();
        $venda->desconto = (!isset($data['desconto']) || $data['desconto'] == "") ? 0 : $data['desconto'];
        $venda->enderecos_id = $data['endereco'] ?? null;
        $venda->usuarios_id = $usuarios_id ?? null;
        $venda->total = $data['total'] ?? null;
        $venda->situacao = $data['situacao'] ?? 'aguardando pagamento';
        $venda->created_at = $data['created_at'] ?? null;
        $venda->updated_at = $data['updated_at'] ?? null;
        return $venda;
    }

}