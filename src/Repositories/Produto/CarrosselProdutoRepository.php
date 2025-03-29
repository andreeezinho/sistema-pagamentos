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
            ORDER BY created_at ASC
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            'produtos_id' => $produto_id
        ]);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::CLASS_NAME);
    }

    public function create(array $data, int $produtos_id, string $dir){
        $imagem = createImage($data['imagem'], $dir);

        $data['imagem'] = $imagem['arquivo_nome'] ?? null;

        $carrossel_produto = $this->model->create($data, $produtos_id);

        try{
            $sql = "INSERT INTO " . self::TABLE . "
                SET
                    uuid = :uuid,
                    nome_arquivo = :nome_arquivo,
                    produtos_id = :produtos_id
            ";

            $stmt = $this->conn->prepare($sql);

            $create = $stmt->execute([
                ':uuid' => $carrossel_produto->uuid,
                ':nome_arquivo' => $carrossel_produto->nome_arquivo,
                ':produtos_id' => $carrossel_produto->produtos_id
            ]);

            if(!$create){
                return null;
            }

            return $this->findByUuid($carrossel_produto->uuid);

        }catch(\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function update(array $data, int $id, int $produtos_id, string $dir){
        if(is_null($data['imagem']['name'])){
            return null;
        }

        $imagem = createImage($data['imagem'], $dir);

        $data['imagem'] = $imagem['arquivo_nome'] ?? null;

        $carrossel_produto = $this->model->create($data, $produtos_id);

        try{
            $sql = "UPDATE " . self::TABLE . "
                SET
                    nome_arquivo = :nome_arquivo
                WHERE
                    id = :id
                AND
                    produtos_id = :produtos_id
            ";

            $stmt = $this->conn->prepare($sql);

            $update = $stmt->execute([
                ':nome_arquivo' => $carrossel_produto->nome_arquivo,
                ':id' => $id,
                ':produtos_id' => $carrossel_produto->produtos_id
            ]);
            
            if(!$update){
                return null;
            }

            return $this->findById($id);

        }catch(\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function delete(string $imagem, int $id, string $dir){
        $delete = removeImage($imagem, $dir);

        if(!$delete){
            return null;
        }

        try{
            $sql = "DELETE FROM " . self::TABLE . "
                WHERE
                    id = :id
            ";

            $stmt = $this->conn->prepare($sql);

            $delete = $stmt->execute([
                ':id' => $id
            ]);

            return $delete;

        }catch(\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }
    
}