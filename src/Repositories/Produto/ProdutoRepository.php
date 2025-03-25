<?php

namespace App\Repositories\Produto;

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

    public function all(array $params = []){
        $sql = "SELECT * FROM " . self::TABLE;

        $conditions = [];
        $bindings = [];
    
        if(isset($params['nome']) && !empty($params['nome'])){
            $conditions[] = "nome LIKE :nome";
            $bindings[':nome'] = "%" . $params['nome'] . "%" ;
        }

        if(isset($params['preco']) && !empty($params['preco'])){
            $conditions[] = "preco <= :preco";
            $bindings[':preco'] = number_format($params['preco'],2,".",".");
        }

        if(isset($params['ativo']) && $params['ativo'] != ""){
            $conditions[] = "ativo = :ativo";
            $bindings[':ativo'] = $params['ativo'];
        }

        if(count($conditions) > 0){
            $sql .= " WHERE " . implode(" AND " . $conditions);
        }

        $sql .= " ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute($bindings);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::CLASS_NAME);
    }

    public function create(array $data){
        $produto = $this->model->create($data);

        try{
            $sql = "INSERT INTO " . self::TABLE . "
                SET
                    uuid = :uuid,
                    nome = :nome,
                    descricao = :descricao,
                    codigo = :codigo,
                    preco = :preco,
                    estoque = :estoque,
                    ativo = :ativo,
                    imagem = :imagem
            ";

            $stmt = $this->conn->prepare($sql);

            $create = $stmt->execute([
                ':uuid' => $produto->uuid,
                ':nome' => $produto->nome,
                ':descricao' => $produto->descricao,
                ':codigo' => $produto->codigo,
                ':preco' => $produto->preco,
                ':estoque' => $produto->estoque,
                ':ativo' => $produto->ativo,
                ':imagem' => $produto->imagem
            ]);

            if(!$create){
                return null;
            }

            return $this->findByUuid($produto->uuid);

        }catch(\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function update(array $data, int $id){}

    public function delete(int $id){}
}