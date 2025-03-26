<?php

namespace App\Controllers\Produto;

use App\Request\Request;
use App\Controllers\Controller;
use App\Repositories\Produto\ProdutoRepository;

class ProdutoController extends Controller {

    protected $produtoRepository;

    public function __construct(){
        parent::__construct();
        $this->produtoRepository = new ProdutoRepository();
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

        $create = $this->produtoRepository->create($data);

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

        return $this->router->view('produto/edit', [
            'produto' => $produto
        ]);
    }

    public function update(Request $request, $uuid){
        $produto = $this->produtoRepository->findByUuid($uuid);

        if(!$produto){
            return $this->router->redirect('produtos');
        }

        $data = $request->getBodyParams();

        $update = $this->produtoRepository->update($data, $produto->id);

        if(is_null($update)){
            return $this->router->view('produto/edit', [
                'produto' => $produto,
                'erro' => 'Não foi possível editar o produto'
            ]);
        }

        return $this->router->redirect('produtos');
    }

}