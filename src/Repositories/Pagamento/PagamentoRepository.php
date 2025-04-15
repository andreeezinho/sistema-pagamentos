<?php

namespace App\Repositories\Pagamento;

use App\Interface\Pagamento\IPagamento;
use App\Config\Database;
use App\Models\Pagamento\Pagamento;
use App\Repositories\Traits\Find;

class PagamentoRepository implements IPagamento {

    const CLASS_NAME = Pagamento::class;
    const TABLE = 'pagamentos';

    use Find;

    protected $conn;
    protected $model;

    public function __construct(){
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new Pagamento();
    }

    public function findSalePayment(int $usuarios_id, int $vendas_id){
        try{
            $sql = "SELECT * FROM " . self::TABLE . "
                WHERE
                    usuarios_id = :usuarios_id
                AND
                    vendas_id = :vendas_id
            ";  

            $stmt = $this->conn->prepare($sql);

            $result = $stmt->execute([
                ':usuarios_id' => $usuarios_id,
                ':vendas_id' => $vendas_id
            ]);

            $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::CLASS_NAME);
            $result = $stmt->fetch();

            if(is_null($result)){
                return null;
            }

            return $result;

        }catch(\Throwable $th) {
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function create(array $data, int $usuarios_id, int $vendas_id){
        $pagamento = $this->model->create($data, $usuarios_id, $vendas_id);

        try{
            $sql = "INSERT INTO " . self::TABLE . "
                SET
                    uuid = :uuid,
                    id_pix = :id_pix,
                    codigo = :codigo,
                    qr_code = :qr_code,
                    status = :status,
                    usuarios_id = :usuarios_id,
                    vendas_id = :vendas_id
            ";

            $stmt = $this->conn->prepare($sql);

            $create = $stmt->execute([
                ':uuid' => $pagamento->uuid,
                ':id_pix' => $pagamento->id_pix,
                ':codigo' => $pagamento->codigo,
                ':qr_code' => $pagamento->qr_code,
                ':status' => $pagamento->status,
                ':usuarios_id' => $pagamento->usuarios_id,
                ':vendas_id' => $pagamento->vendas_id
            ]);

            if(!$create){
                return null;
            }

            return $this->findByUuid($pagamento->uuid);

        }catch(\Throwable $th) {
            return $th;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function update(int $id, array $data){
        $pagamento = $this->model->update($data);

        try{
            $sql = "UPDATE " . self::TABLE . "
                SET
                    id_pix = :id_pix,
                    codigo = :codigo,
                    qr_code = :qr_code,
                    status = :status
                WHERE
                    id = :id
            ";

            $stmt = $this->conn->prepare($sql);

            $update = $stmt->execute([
                ':id_pix' => $pagamento->id_pix,
                ':codigo' => $pagamento->codigo,
                ':qr_code' => $pagamento->qr_code,
                ':status' => $pagamento->status,
                ':id' => $id
            ]);

            if(!$update){
                return null;
            }

            return $this->findById($id);

        }catch(\Throwable $th){
            return $th;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function updateStatus(int $id){
        try{
            $sql = "UPDATE " . self::TABLE . "
                SET
                    status = cancelled
                WHERE
                    id = :id
            ";

            $stmt = $this->conn->prepare($sql);

            $update = $stmt->execute([
                ':id' => $id
            ]);

            if(!$update){
                return null;
            }

            return $this->findById($id);

        }catch(\Throwable $th){
            return $th;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

}