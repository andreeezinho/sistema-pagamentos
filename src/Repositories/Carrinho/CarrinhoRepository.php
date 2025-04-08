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

    public function create(int $usuario_id){}

    public function allProductsInCart(int $id){}

    public function addProductInCart(int $id, int $produto_id, int $quantidade){}

    public function removeProductInCart(int $id, int $produto_id, int $quantidade){}

    public function deleteAllProducts(int $id){}

}

