<?php

namespace App\Repositories\Venda;

use App\Interface\Venda\IVenda;
use App\Config\Database;
use App\Models\Venda\Venda;
use App\Repositories\Traits\Find;

class VendaRepository implements IVenda {

    const CLASS_NAME = Venda::class;
    const TABLE = 'vendas';

    use Find;

    protected $conn;
    protected $model;

    public function __construct(){
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new Venda();
    }

    public function create(array $data, int $usuarios_id){
        $venda = $this->model->create($data, $usuarios_id);

        try{
            $sql = "INSERT INTO " . self::TABLE . "
                SET
                    uuid = :uuid,
                    desconto = :desconto,
                    enderecos_id = :enderecos_id,
                    usuarios_id = :usuarios_id,
                    total = :total
            ";

            $stmt = $this->conn->prepare($sql);

            $create = $stmt->execute([
                ':uuid' => $venda->uuid,
                ':desconto' => $venda->desconto,
                ':enderecos_id' => $venda->enderecos_id,
                ':usuarios_id' => $venda->usuarios_id,
                ':total' => $venda->total
            ]);

            if(!$create){
                return null;
            }

            return $this->findByUuid($venda->uuid);

        }catch(\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function delete(int $id){
        try{
            $sql = "DELETE FROM " . self::TABLE . "
                WHERE
                    id = :id
            ";

            $stmt = $this->conn->prepare($sql);

            $create = $stmt->execute([
                ':id' => $id
            ]);

            return $create;

        }catch(\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }
}