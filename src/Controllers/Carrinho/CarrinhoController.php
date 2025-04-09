<?php

namespace App\Controllers\Carrinho;

use App\Request\Request;
use App\Config\Auth;
use App\Controllers\Controller;
use App\Repositories\Carrinho\CarrinhoRepository;
use App\Repositories\Carrinho\CarrinhoProdutoRepository;
use App\Repositories\User\UserRepository;

class CarrinhoController extends Controller {

    protected $carrinhoRepository;
    protected $carrinhoProdutoRepository;
    protected $auth;

    public function __construct(){
        parent::__construct();
        $this->carrinhoRepository = new CarrinhoRepository();
        $this->carrinhoProdutoRepository = new CarrinhoProdutoRepository();
        $this->auth = new Auth();
    }

    public function index(Request $request){
        $user = $this->auth->user();

        $carrinho = $this->carrinhoRepository->findByUserId($user->id);

        if(!$carrinho){
            return $this->router->view('carrinho/index', [
                'user' => $user,
                'carrinhoProduto' => null //ou 0
            ]);
        }

        $carrinhoProduto = $this->carrinhoProdutoRepository->allProductsInCart($carrinho->id);

        return $this->router->view('carrinho/index', [
            'user' => $user,
            'carrinhoProduto' => $carrinhoProduto
        ]);
    }

    public function finish(Request $request){}

}