<?php

namespace App\Controllers\Home;

use App\Request\Request;
use App\Config\Auth;
use App\Controllers\Controller;
use App\Repositories\Produto\ProdutoRepository;

class HomeController extends Controller {

    protected $produtoRepository;

    public function __construct(){
        parent::__construct();
        $this->produtoRepository = new ProdutoRepository();
    }

    public function index(Request $request){
        $params = $request->getQueryParams();
        $params = array_merge($params, ['ativo' => 1, 'estoque' => 1]);

        $produtos = $this->produtoRepository->all($params);

        return $this->router->view('home/index', [
            'produtos' => $produtos
        ]);
    }

}