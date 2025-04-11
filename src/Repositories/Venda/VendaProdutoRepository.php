<?php

namespace App\Repositories\Venda;

use App\Interface\Venda\IVendaProduto;
use App\Config\Database;
use App\Models\Venda\VendaProduto;
use App\Repositories\Traits\Find;

class VendaProdutoRepository implements IVendaProduto {

    const CLASS_NAME = VendaProduto::class;
    const TABLE = 'venda_produto';

    use Find;

    protected $conn;
    protected $model;

    public function __construct(){
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new VendaProduto();
    }

    public function transferAllCartProduct($carrinhoProdutos, $venda_id){
        if(count($carrinhoProdutos) < 0){
            return null;
        }

        try{
            foreach($carrinhoProdutos as $produtos){
                $vendaProduto = $this->model->create($produtos, $venda_id);

                $sql = "INSERT INTO " . self::TABLE . "
                    SET
                        uuid = :uuid,
                        quantidade = :quantidade,
                        vendas_id = :vendas_id,
                        produtos_id = :produtos_id
                ";

                $stmt = $this->conn->prepare($sql);

                $create = $stmt->execute([
                    ':uuid' => $vendaProduto->uuid,
                    ':quantidade' => $vendaProduto->quantidade,
                    ':vendas_id' => $vendaProduto->vendas_id,
                    ':produtos_id' => $vendaProduto->produtos_id,
                ]);

                if(!$create){
                    return null;
                }
            }

            return true;

        }catch(\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

}