<?php

namespace App\Controllers\Carrinho;

use App\Request\Request;
use App\Config\Auth;
use App\Controllers\Controller;
use App\Repositories\Carrinho\CarrinhoRepository;
use App\Repositories\Carrinho\CarrinhoProdutoRepository;
use App\Repositories\Produto\ProdutoRepository;
use App\Repositories\User\UserRepository;

class CarrinhoController extends Controller {

    protected $carrinhoRepository;
    protected $carrinhoProdutoRepository;
    protected $produtoRepository;
    protected $auth;

    public function __construct(){
        parent::__construct();
        $this->carrinhoRepository = new CarrinhoRepository();
        $this->carrinhoProdutoRepository = new CarrinhoProdutoRepository();
        $this->produtoRepository = new ProdutoRepository();
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

    public function addProductInCart(Request $request, $produto_uuid){
        $user = $this->auth->user();

        $carrinho = $this->carrinhoRepository->findByUserId($user->id);
        
        if(!$carrinho){
            return $this->router->view('carrinho/index', [
                'user' => $user,
                'carrinhoProduto' => null
            ]);
        }

        $produto = $this->produtoRepository->findByUuid($produto_uuid);

        if(!$produto){
            return $this->router->redirect('');
        }
        
        $data = $request->getBodyParams();

        $carrinhoProduto = $this->carrinhoProdutoRepository->addProductInCart($data, $carrinho->id, $produto->id);

        if(is_null($carrinhoProduto)){
            return $this->router->redirect('');
        }

        return $this->router->redirect('carrinho');
    }

    public function sumProductQuantity(Request $request, $produto_uuid){
        $user = $this->auth->user();

        $carrinho = $this->carrinhoRepository->findByUserId($user->id);
        
        if(!$carrinho){
            return $this->router->view('carrinho/index', [
                'user' => $user,
                'carrinhoProduto' => null
            ]);
        }

        $produto = $this->produtoRepository->findByUuid($produto_uuid);

        if(!$produto){
            return $this->router->redirect('');
        }

        $produtoCarrinho = $this->carrinhoProdutoRepository->findProduct($carrinho->id, $produto->id);

        $sum = $this->carrinhoProdutoRepository->sumProductQuantity($carrinho->id, $produto->id, $produtoCarrinho->quantidade);

        if(is_null($sum)){
            return $this->router->redirect('');
        }

        return $this->router->redirect('carrinho');
    }

    public function subtractProductQuantity(Request $request, $produto_uuid){
        $user = $this->auth->user();

        $carrinho = $this->carrinhoRepository->findByUserId($user->id);
        
        if(!$carrinho){
            return $this->router->view('carrinho/index', [
                'user' => $user,
                'carrinhoProduto' => null
            ]);
        }

        $produto = $this->produtoRepository->findByUuid($produto_uuid);

        if(!$produto){
            return $this->router->redirect('');
        }

        $produtoCarrinho = $this->carrinhoProdutoRepository->findProduct($carrinho->id, $produto->id);

        if($produtoCarrinho->quantidade == 1){
            $this->deleteProduct($request, $produto->uuid);
        }

        $subtract = $this->carrinhoProdutoRepository->subtractProductQuantity($carrinho->id, $produto->id, $produtoCarrinho->quantidade);

        if(is_null($subtract)){
            return $this->router->redirect('');
        }

        return $this->router->redirect('carrinho');
    }

    public function deleteProduct(Request $request, $produto_uuid){
        $user = $this->auth->user();

        $carrinho = $this->carrinhoRepository->findByUserId($user->id);

        if(!$carrinho){
            return $this->router->view('carrinho/index', [
                'user' => $user,
                'carrinhoProduto' => null
            ]);
        }

        $produto = $this->produtoRepository->findByUuid($produto_uuid);

        if(!$produto){
            return $this->router->redirect('');
        }

        $carrinhoProduto = $this->carrinhoProdutoRepository->allProductsInCart($carrinho->id);

        $delete = $this->carrinhoProdutoRepository->removeProductInCart($carrinho->id, $produto->id);

        if(!$delete){
            return $this->router->view('carrinho/index', [
                'user' => $user,
                'carrinhoProduto' => $carrinhoProduto,
                'erro' => 'Não foi possível deletar produto do carrinho'
            ]);   
        }

        return $this->router->redirect('carrinho');
    }

}