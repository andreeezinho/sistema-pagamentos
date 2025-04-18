<?php

namespace App\Controllers\Produto;

use App\Request\Request;
use App\Controllers\Controller;
use App\Repositories\Produto\ProdutoRepository;
use App\Repositories\Produto\CarrosselProdutoRepository;

class ProdutoController extends Controller {

    protected $produtoRepository;
    protected $carrosselProdutoRepository;

    public function __construct(){
        parent::__construct();
        $this->produtoRepository = new ProdutoRepository();
        $this->carrosselProdutoRepository = new CarrosselProdutoRepository();
    }

    public function index(Request $request){
        $params = $request->getQueryParams();

        $produtos = $this->produtoRepository->all($params);

        return $this->router->view('produto/index', [
            'produtos' => $produtos
        ]);
    }

    public function create(Request $request){
        return $this->router->view('produto/create', []);
    }

    public function store(Request $request){
        $data = $request->getBodyParams();

        if(isset($_FILES['imagem'])){
            $data['imagem'] = $_FILES['imagem'];
        }

        $dir = "/produto";

        $create = $this->produtoRepository->create($data, $dir);

        if(is_null($create)){
            return $this->router->view('produto/create', [
                'erro' => 'Não foi possível cadastrar o produto'
            ]);
        }

        return $this->router->redirect('produtos');
    }

    public function edit(Request $request, $uuid){
        $produto = $this->produtoRepository->findByUuid($uuid);

        if(!$produto){
            return $this->router->redirect('');
        }

        $carrossel_produto = $this
            ->carrosselProdutoRepository
            ->allProdutctCarouselImages($produto->id);

        return $this->router->view('produto/edit', [
            'produto' => $produto,
            'carrossel_produto' => $carrossel_produto
        ]);
    }

    public function update(Request $request, $uuid){
        $produto = $this->produtoRepository->findByUuid($uuid);

        if(!$produto){
            return $this->router->redirect('produtos');
        }

        $data = $request->getBodyParams();

        if(isset($_FILES['imagem'])){
            $data['imagem'] = $_FILES['imagem'];
        }

        $dir = "/produto";

        $update = $this->produtoRepository->update($data, $produto->id, $dir);

        if(is_null($update)){
            return $this->router->view('produto/edit', [
                'produto' => $produto,
                'erro' => 'Não foi possível editar o produto'
            ]);
        }

        return $this->router->redirect('produtos');
    }

    public function destroy(Request $request, $uuid){
        $produto = $this->produtoRepository->findByUuid($uuid);

        if(!$produto){
            return $this->router->redirect('produtos');
        }

        $delete = $this->produtoRepository->delete($produto->id);

        if(!$delete){
            return $this->router->redirect('');
        }
        
        return $this->router->redirect('produtos');
    }

}