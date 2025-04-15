<?php

namespace App\Interface\Pagamento;

interface IPagamento{
    
    public function findSalePayment(int $usuarios_id, int $vendas_id);

    public function create(array $data, int $usuarios_id, int $vendas_id);

    public function update(int $id, array $data);

    public function updateStatus(int $id, string $status);

    public function findByUuid(string $uuid);

    public function findById(string $id);
}