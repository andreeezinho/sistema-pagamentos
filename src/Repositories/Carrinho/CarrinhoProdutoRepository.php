<?php

namespace App\Repositories\Carrinho;

use App\Interface\Carrinho\ICarrinhoProduto;
use App\Config\Database;
use App\Models\Carrinho\CarrinhoProduto;
use App\Repositories\Traits\Find;

class CarrinhoProdutoRepository implements ICarrinhoProduto {

    const CLASS_NAME = CarrinhoProduto::class;
    const TABLE = 'carrinho_produto';

    use Find;

    protected $conn;
    protected $model;

    public function __construct(){
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new CarrinhoProduto();
    }

}