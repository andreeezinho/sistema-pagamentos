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

    public function findSalePayment(int $usuarios, int $vendas_id){
        try {
            $sql = "SELECT * FROM " . self::TABLE . "
                WHERE
                    usuarios_id = :usuarios_id
                AND
                    vendas_id = :vendas_id
            ";  
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function create(array $data, int $usuarios_id, int $vendas_id){}

    public function update(array $data, int $usuarios_id, int $vendas_id){}

    public function delete(int $id){}

}