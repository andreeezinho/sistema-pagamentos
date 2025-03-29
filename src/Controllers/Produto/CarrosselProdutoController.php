<?php

namespace App\Controllers\Produto;

use App\Request\Request;
use App\Controllers\Controller;
use App\Repositories\Produto\CarrosselProdutoRepository;
use App\Repositories\Produto\ProdutoRepository;

class CarrosselProdutoController extends Controller {

    protected $carrosselProdutoRepository;
    protected $produtoRepository;

    public function __construct(){
        parent::__construct();
        $this->carrosselProdutoRepository = new CarrosselProdutoRepository();
        $this->produtoRepository = new ProdutoRepository();
    }

    public function index(Request $request, $produto_uuid){
        $produto = $this->produtoRepository->findByUuid($produto_uuid);

        if(!$produto){
            return $this->router->redirect('produtos');
        }

        $carrossel_produto = $this  
            ->carrosselProdutoRepository
            ->allProdutctCarouselImages($produto->id);

        return $this->router->view('produto/carrossel/index', [
            'produto' => $produto,
            'carrossel_produto' => $carrossel_produto
        ]);
    }

    public function store(Request $request, $produto_uuid){
        $data = $request->getBodyParams();

        if(isset($_FILES['imagem'])){
            $data['imagem'] = $_FILES['imagem'];
        }

        $dir = "/produto/carrossel";

        $produto = $this->produtoRepository->findByUuid($produto_uuid);

        if(!$produto){
            return $this->router->view('produto/edit', [
                'produto' => $produto,
                'erro' => 'Não foi possível encontrar o produto'
            ]);
        }

        $carrossel_produto = $this
            ->carrosselProdutoRepository->create($data, $produto->id, $dir);

        if(is_null($carrossel_produto)){
            return $this->router->view('produto/edit', [
                'produto' => $produto,
                'erro' => 'Não foi possível adicionar a imagem do produto'
            ]);
        }

        return $this->router->redirect('produtos/'.$produto_uuid.'/editar');
    }

    public function update(Request $request, $uuid){
        $carrossel_produto = $this->carrosselProdutoRepository->findByUuid($uuid);

        if(!$carrossel_produto){
            return $this->router->view('produto/edit', [
                'produto' => $produto,
                'erro' => 'Não carrossel não encontrado'
            ]);
        }

        $produto = $this->produtoRepository->findById($carrossel_produto->produtos_id);

        if(!$produto){
            return $this->router->view('produto/edit', [
                'produto' => $produto,
                'erro' => 'Não carrossel não encontrado'
            ]);
        }

        $data = $request->getBodyParams();

        if(isset($_FILES['imagem'])){
            $data['imagem'] = $_FILES['imagem'];
        }

        $dir = "/produto/carrossel";

        $update = $this
            ->carrosselProdutoRepository
            ->update(
                $data, 
                $carrossel_produto->id, 
                $carrossel_produto->produtos_id, 
                $dir
            );

        if(is_null($update)){
            return $this->router->view('produto/edit', [
                'produto' => $produto,
                'erro' => 'Não foi possível editar a imagem'
            ]);
        }

        return $this->router->redirect('produtos/'. $produto->uuid .'/editar');

    }

    public function destroy(Request $request, $uuid){
        $carrossel_produto = $this->carrosselProdutoRepository->findByUuid($uuid);

        if(!$carrossel_produto){
            return $this->router->view('produto/edit', [
                'produto' => $produto,
                'erro' => 'Não carrossel não encontrado'
            ]);
        }

        $dir = "/produto/carrossel";
        
        $delete = $this
            ->carrosselProdutoRepository
            ->delete(
                $carrossel_produto->nome_arquivo, 
                $carrossel_produto->id, 
                $dir
            );

        if(is_null($delete)){
            return $this->router->view('produto/edit', [
                'erro' => 'Não carrossel não encontrado'
            ]);
        }

        return $this->router->redirect('produtos');

    }

}