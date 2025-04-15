<?php

namespace App\Models\Pagamento;

use App\Models\Traits\Uuid;

class Pagamento {

    use Uuid;

    public $id;
    public $uuid;
    public $id_pix;
    public $codigo;
    public $qr_code;
    public $status;
    public $usuarios_id;
    public $vendas_id;
    public $created_at;
    public $updated_at;

    public function create(array $data, int $usuarios_id, int $vendas_id) : Pagamento {
        $pagamento = new Pagamento();
        $pagamento->id = $data['id'] ?? null;
        $pagamento->uuid = $data['uuid'] ?? $this->generateUUID();
        $pagamento->id_pix = $data['id_pix'] ?? null;
        $pagamento->codigo = $data['codigo'] ?? null;
        $pagamento->qr_code = $data['qr_code'] ?? null;
        $pagamento->status = $data['status'] ?? null;
        $pagamento->usuarios_id = $usuarios_id ?? null;
        $pagamento->vendas_id = $vendas_id ?? null;
        $pagamento->created_at = $data['created_at'] ?? null;
        $pagamento->updated_at = $data['updated_at'] ?? null;
        return $pagamento;
    }

}