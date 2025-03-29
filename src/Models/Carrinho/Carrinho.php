<?php

namespace App\Models\Carrinho;

use App\Models\Traits\Uuid;

class Carrinho {

    use Uuid;

    public $id;
    public $uuid;
    public $total;
    public $usuarios_id;
    public $created_at;
    public $updated_at;

    public function create(array $data, $usuarios_id) : Carrinho {
        $carrinho = new Carrinho();
        $carrinho->id = $data['id'] ?? null;
        $carrinho->uuid = $data['uuid'] ?? $this->generateUUID();
        $carrinho->total = (!isset($data['total']) || $data['total'] == "") ? 0 : $data['total'];
        $carrinho->usuarios_id = $usuarios_id ?? null;
        $carrinho->created_at = $data['created_at'] ?? null;
        $carrinho->updated_at = $data['updated_at'] ?? null;
        return $carrinho;
    }
}