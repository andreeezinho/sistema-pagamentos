<?php

namespace App\Interface\Permissao;

interface IPermissaoUser{
    
    public function allUserPermissions(int $usuario_id);

    public function linkUserPermission(int $usuario_id, int $permissao_id);

    public function unlinkUserPermission(int $usuario_id, int $permissao_id);

    public function findByUuid(string $uuid);

    public function findById(string $id);
}