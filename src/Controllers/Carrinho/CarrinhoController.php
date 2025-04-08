<?php

namespace App\Controllers\Carrinho;

use App\Request\Request;
use App\Config\Auth;
use App\Controllers\Controller;
use App\Repositories\Carrinho\CarrinhoRepository;
use App\Repositories\User\UserRepository;

class CarrinhoController extends Controller {

    protected $carrinhoRepository;
    protected $auth;

    public function __construct(){
        parent::__construct();
        $this->carrinhoRepository = new CarrinhoRepository();
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

        return $this->router->view('carrinho/index', [
            'user' => $user,
            'carrinhoProduto' => 'existe'
        ]);
    }

    public function finish(Request $request){}

}