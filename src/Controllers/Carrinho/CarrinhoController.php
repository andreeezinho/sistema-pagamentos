<?php

namespace App\Controllers\Carrinho;

use App\Request\Request;
use App\Config\Auth;
use App\Controllers\Controller;
use App\Repositories\Carrinho\CarrinhoRepository;
use App\Repositories\Carrinho\CarrinhoProdutoRepository;
use App\Repositories\Produto\ProdutoRepository;
use App\Repositories\Venda\VendaRepository;
use App\Repositories\Venda\VendaProdutoRepository;

class CarrinhoController extends Controller {

    protected $carrinhoRepository;
    protected $carrinhoProdutoRepository;
    protected $produtoRepository;
    protected $vendaRepository;
    protected $vendaProdutoRepository;
    protected $auth;

    public function __construct(){
        parent::__construct();
        $this->carrinhoRepository = new CarrinhoRepository();
        $this->carrinhoProdutoRepository = new CarrinhoProdutoRepository();
        $this->produtoRepository = new ProdutoRepository();
        $this->vendaRepository = new VendaRepository();
        $this->vendaProdutoRepository = new VendaProdutoRepository();
        $this->auth = new Auth();
    }

    public function index(Request $request){
        $user = $this->auth->user();

        $carrinho = $this->carrinhoRepository->findByUserId($user->id);

        if(!$carrinho){
            return $this->router->view('carrinho/index', [
                'user' => $user,
                'carrinhoProduto' => false
            ]);
        }

        $carrinhoProduto = $this->carrinhoProdutoRepository->allProductsInCart($carrinho->id);

        $totalPrice = countTotalPriceWithDiscount($carrinhoProduto);

        return $this->router->view('carrinho/index', [
            'user' => $user,
            'total' => $totalPrice,
            'carrinhoProduto' => $carrinhoProduto
        ]);
    }

    public function finish(Request $request){
        $user = $this->auth->user();

        $carrinho = $this->carrinhoRepository->findByUserId($user->id);
        
        if(!$carrinho){
            return $this->router->redirect('carrinho');
        }

        $carrinhoProduto = $this->carrinhoProdutoRepository->allProductsInCart($carrinho->id);

        $data = $request->getBodyParams();

        $totalPrice = countTotalPriceWithDiscount($carrinhoProduto, $data['desconto']);

        $data = array_merge($data, ['total' => $totalPrice]);

        $venda = $this->vendaRepository->create($data, $user->id);

        if(is_null($venda)){
            return $this->router->redirect('');
        }

        $vendaProduto = $this->vendaProdutoRepository->transferAllCartProduct($carrinhoProduto, $venda->id);

        if(is_null($vendaProduto)){
            return $this->router->redirect('');
        }

        $deleteProductsInCart = $this->carrinhoProdutoRepository->deleteAllProducts($carrinho->id);

        if(!$deleteProductsInCart){
            return $this->router->redirect('');
        }

        $deleteCart = $this->carrinhoRepository->delete($carrinho->id);

        if(!$deleteCart){
            return $this->router->redirect('');
        }

        return $this->router->redirect('minhas-compras/'.$venda->uuid);
    }

    public function addProductInCart(Request $request, $produto_uuid){
        $user = $this->auth->user();

        $carrinho = $this->carrinhoRepository->findByUserId($user->id);
        
        if(!$carrinho){
            $carrinho = $this->carrinhoRepository->create($user->id);

            if(is_null($carrinho)){
                return $this->router->redirect('');
            }
        }

        $produto = $this->produtoRepository->findByUuid($produto_uuid);

        if(!$produto){
            return $this->router->redirect('');
        }
        
        $data = $request->getBodyParams();

        if($this->carrinhoProdutoRepository->findProduct($carrinho->id, $produto->id)){
            $this->sumProductQuantity($request, $produto->uuid);
        }

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
            return $this->router->redirect('carrinho');
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
            return $this->router->redirect('carrinho');
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
            return $this->router->redirect('carrinho');
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

        if(count($carrinhoProduto) <= 1){
            $deleteCarrinho = $this->carrinhoRepository->delete($carrinho->id);

            if(!$deleteCarrinho){
                return $this->router->redirect('');
            }

            return $this->router->redirect('carrinho');
        }

        return $this->router->redirect('carrinho');
    }

}