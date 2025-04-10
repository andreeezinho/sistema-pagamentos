<?php

namespace App\Repositories\Carrinho;

use App\Interface\Carrinho\ICarrinhoProduto;
use App\Config\Database;
use App\Models\Carrinho\CarrinhoProduto;
use App\Repositories\Traits\Find;
use App\Repositories\Carrinho\CarrinhoRepository;

class CarrinhoProdutoRepository implements ICarrinhoProduto {

    const CLASS_NAME = CarrinhoProduto::class;
    const TABLE = 'carrinho_produto';

    use Find;

    protected $conn;
    protected $model;
    protected $carrinhoRepository;

    public function __construct(){
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new CarrinhoProduto();
        $this->carrinhoRepository = new CarrinhoRepository();
    }

    public function findProduct(int $carrinho_id, int $produtos_id){
        $sql = "SELECT * FROM " . self::TABLE . " 
            WHERE 
                carrinho_id = :carrinho_id
            AND
                produtos_id = :produtos_id
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':carrinho_id' => $carrinho_id,
            ':produtos_id' => $produtos_id
        ]);

        $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::CLASS_NAME);
        $result = $stmt->fetch();

        if(is_null($result)){
            return null;
        }

        return $result;
    }

    public function allProductsInCart(int $id){
        $sql = "SELECT cp.*, 
                c.id as carrinho_id,
                p.uuid as uuid_produto, p.nome as nome, p.preco as preco, p.imagem as imagem
            FROM " . self::TABLE . " cp
            JOIN carrinho c
                ON carrinho_id = c.id
            JOIN produtos p
                ON produtos_id = p.id
            WHERE c.id = :carrinho_id
            ORDER BY cp.created_at ASC
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':carrinho_id' => $id
        ]);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::CLASS_NAME);
    }

    public function addProductInCart(array $data, int $id, int $produto_id){
        $carrinhoProduto = $this->model->create($data, $id, $produto_id);

        try{
            $sql = "INSERT INTO ". self::TABLE . "
                SET
                    uuid = :uuid,
                    quantidade = :quantidade,
                    carrinho_id = :carrinho_id,
                    produtos_id = :produtos_id
            ";

            $stmt = $this->conn->prepare($sql);

            $create = $stmt->execute([
                ':uuid' => $carrinhoProduto->uuid,
                ':quantidade' => $carrinhoProduto->quantidade,
                ':carrinho_id' => $carrinhoProduto->carrinho_id,
                ':produtos_id' => $carrinhoProduto->produtos_id
            ]);

            if(!$create){
                return null;
            }

            return $this->findByUuid($carrinhoProduto->uuid);

        }catch (\Throwable $th) {
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function sumProductQuantity(int $id, int $produto_id, int $quantidade){
        $quantidade += 1;

        try{
            $sql = "UPDATE " . self::TABLE . "
                SET
                    quantidade = :quantidade
                WHERE
                    carrinho_id = :carrinho_id
                AND
                    produtos_id = :produtos_id
            ";

            $stmt = $this->conn->prepare($sql);

            $sum = $stmt->execute([
                ':quantidade' => $quantidade,
                ':carrinho_id' => $id,
                ':produtos_id' => $produto_id
            ]);

            if(!$sum){
                return null;
            }

            return $quantidade;

        }catch (\Throwable $th) {
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function subtractProductQuantity(int $id, int $produto_id, int $quantidade){
        $quantidade -= 1;

        try{
            $sql = "UPDATE " . self::TABLE . "
                SET
                    quantidade = :quantidade
                WHERE
                    carrinho_id = :carrinho_id
                AND
                    produtos_id = :produtos_id
            ";

            $stmt = $this->conn->prepare($sql);

            $subtract = $stmt->execute([
                ':quantidade' => $quantidade,
                ':carrinho_id' => $id,
                ':produtos_id' => $produto_id
            ]);

            if(!$subtract){
                return null;
            }

            return $quantidade;

        }catch (\Throwable $th) {
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function removeProductInCart(int $id, int $produto_id){
        try{
            $sql = "DELETE FROM ". self::TABLE . "
                WHERE 
                    carrinho_id = :carrinho_id
                AND
                    produtos_id = :produtos_id
            ";

            $stmt = $this->conn->prepare($sql);

            $delete = $stmt->execute([
                ':carrinho_id' => $id,
                ':produtos_id' => $produto_id
            ]);

            return $delete;

        }catch (\Throwable $th) {
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function deleteAllProducts(int $id, int $usuario_id){}

}