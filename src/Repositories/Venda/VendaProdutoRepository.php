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

    public function allProductsInSale($venda_id){
        $sql = "SELECT vp.*,
                v.id as vendas_id,
                p.uuid as uuid_produto, p.nome as nome, p.preco as preco, p.imagem as imagem
            FROM " . self::TABLE . " vp 
            JOIN vendas v
                ON vendas_id = v.id
            JOIN produtos p
                ON produtos_id = p.id
            WHERE v.id = :vendas_id
            ORDER BY vp.created_at ASC
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':vendas_id' => $venda_id
        ]);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::CLASS_NAME);
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