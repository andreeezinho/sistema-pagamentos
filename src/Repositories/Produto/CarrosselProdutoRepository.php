<?php

namespace App\Repositories\Produto;

use App\Interface\Produto\ICarrosselProduto;
use App\Config\Database;
use App\Models\Produto\CarrosselProduto;
use App\Repositories\Traits\Find;

class CarrosselProdutoRepository implements ICarrosselProduto{

    const CLASS_NAME = CarrosselProduto::class;
    const TABLE = 'carrossel_produtos';

    use Find;

    public $conn;
    public $model;

    public function __construct(){
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new CarrosselProduto();
    }

    public function allProdutctCarouselImages(int $produto_id){
        $sql = "SELECT * FROM " . self::TABLE . "
            WHERE 
                produtos_id = :produtos_id
            ORDER BY created_at DESC
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            'produtos_id' => $produto_id
        ]);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::CLASS_NAME);
    }

    public function create(array $data, string $dir){}

    public function update(array $data, int $id, string $dir){}

    public function delete(int $id){}

    public function findByUuid(string $uuid){}

    public function findById(string $id){}

}