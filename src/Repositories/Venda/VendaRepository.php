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

    public function allUserSales(array $params, int $usuarios_id){
        $sql = "SELECT * FROM " . self::TABLE;
    
        $conditions = [];
        $bindings = [];
    
        if(isset($params['situacao']) && $params['situacao'] != ""){
            $conditions[] = "situacao = :situacao";
            $bindings[':situacao'] = $params['situacao'];
        }

        if(isset($params['data']) && $params['data'] != ""){
            $conditions[] = "date_format(created_at, '%d/%m/%Y') = date_format(:data, '%d/%m/%Y')";
            $bindings[':data'] = $params['data'];
        }

        $sql .= " WHERE usuarios_id = :usuarios_id ";
    
        if(count($conditions) > 0) {
            $sql .= " AND " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($sql);
        
        $bindings = array_merge($bindings, [':usuarios_id' => $usuarios_id]);

        $stmt->execute($bindings);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::CLASS_NAME);
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
            $sql = "UPDATE " . self::TABLE . "
                SET
                    situacao = 'cancelada'
                WHERE
                    id = :id
            ";

            $stmt = $this->conn->prepare($sql);

            $delete = $stmt->execute([
                ':id' => $id
            ]);

            return $delete;

        }catch(\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }
}