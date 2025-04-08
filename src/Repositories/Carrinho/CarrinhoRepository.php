<?php

namespace App\Repositories\Carrinho;

use App\Interface\Carrinho\ICarrinho;
use App\Config\Database;
use App\Model\Carrinho\Carrinho;
use App\Repositories\Traits\Find;

class CarrinhoRepository implements ICarrinho {

    const CLASS_NAME = Carrinho::class;
    const TABLE = 'carrinho';

    use Find;

    protected $conn;
    protected $model;

    public function __construct(){
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new Carrinho();
    }

    public function create(int $usuario_id){
        $carrinho = $this->model->create($usuario_id);

        try{
            $sql = "INSERT INTO ". self::TABLE ."
                set
                    uuid = :uuid,
                    usuarios_id = :usuarios_id
            ";

            $stmt = $this->conn->prepare($sql);

            $create = $stmt->execute([
                ':uuid' => $carrinho->uuid,
                'usuarios_id' => $carrinho->usuarios_id
            ]);

            if(!$create){
                return null;
            }

            return $this->findByUuid($carrinho->uuid);

        }catch(Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function allProductsInCart(int $id){}

    public function addProductInCart(int $id, int $produto_id, int $quantidade){}

    public function removeProductInCart(int $id, int $produto_id, int $quantidade){}

    public function deleteAllProducts(int $id){}

}

