<?php

namespace App\Interface\Venda;

interface IVenda {

    public function allUserSales(array $params, int $usuarios_id);

    public function create(array $data, int $usuarios_id);

    public function updateStatus(int $id, string $status);

    public function delete(int $id);

    public function findByUuid(string $uuid);

    public function findById(string $id);

    public function findByUserId(string $usuarios_id);

}