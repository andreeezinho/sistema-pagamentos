<?php

namespace App\Repositories\Protudo;

use App\Interface\Produto\IProduto;
use App\Config\Database;
use App\Models\Produto\Produto;
use App\Repositories\Traits\Find;

class ProdutoRepository implements IProduto{

    const CLASS_NAME = Produto::class;
    const TABLE = 'produtos';

    use Find;

    public $conn;
    public $model;

    public function __construct(){
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new Produto();
    }

    public function all(){}
}