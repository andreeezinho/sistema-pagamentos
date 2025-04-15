<?php

namespace App\Controllers\Venda;

use App\Request\Request;
use App\Config\Auth;
use App\Controllers\Controller;
use App\Repositories\Venda\VendaRepository;
use App\Repositories\Venda\VendaProdutoRepository;
use App\Services\GerarPagamento;

class VendaController extends Controller {

    protected $vendaRepository;
    protected $vendaProdutoRepository;
    protected $auth;
    protected $payment;

    public function __construct(){
        parent::__construct();
        $this->vendaRepository = new VendaRepository();
        $this->vendaProdutoRepository = new VendaProdutoRepository();
        $this->auth = new Auth();
        $this->payment = new GerarPagamento();
    }

    public function index(Request $request){
        $user = $this->auth->user();

        $params = $request->getQueryParams();

        $vendas = $this->vendaRepository->allUserSales($params, $user->id);

        return $this->router->view('venda/index', [
            'vendas' => $vendas
        ]);
    }

    public function details(Request $request, $uuid){
        $user = $this->auth->user();
        
        $venda = $this->vendaRepository->findByUuid($uuid);

        if(!$venda){
            return $this->router->redirect('');
        }

        if($venda->usuarios_id != $user->id){
            return $this->router->redirect('');
        }

        $produtos = $this->vendaProdutoRepository->allProductsInSale($venda->id);

        return $this->router->view('venda/detalhes/index', [
            'venda' => $venda,
            'produtos' => $produtos
        ]);
    }

    public function cancel(Request $request, $uuid){
        $user = $this->auth->user();
        
        $venda = $this->vendaRepository->findByUuid($uuid);

        if(!$venda){
            return $this->router->redirect('');
        }

        if($venda->usuarios_id != $user->id){
            return $this->router->redirect('');
        }

        $cancel = $this->vendaRepository->delete($venda->id);

        if(!$cancel){
            return $this->router->redirect('compras');
        }

        return $this->router->redirect('compras');
    }

    public function generatePayment(Request $request, $uuid){
        $user = $this->auth->user();
        
        $venda = $this->vendaRepository->findByUuid($uuid);

        if(!$venda){
            return $this->router->redirect('');
        }

        if($venda->usuarios_id != $user->id){
            return $this->router->redirect('');
        }

        $payment = $this->payment->generatePayment("pix", $venda->total, $user->email);

        dd($payment);
    }

}