<?php

namespace App\Controllers\Venda;

use App\Request\Request;
use App\Config\Auth;
use App\Controllers\Controller;
use App\Repositories\Venda\VendaRepository;
use App\Repositories\Pagamento\PagamentoRepository;
use App\Repositories\Venda\VendaProdutoRepository;
use App\Services\GerarPagamento;

class VendaController extends Controller {

    protected $vendaRepository;
    protected $pagamentoRepository;
    protected $vendaProdutoRepository;
    protected $auth;
    protected $payment;

    public function __construct(){
        parent::__construct();
        $this->vendaRepository = new VendaRepository();
        $this->pagamentoRepository = new PagamentoRepository();
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

        $payment = $this->pagamentoRepository->findSalePayment($user->id, $venda->id);

        if(!$payment){
            return $this->router->view('venda/detalhes/index', [
                'venda' => $venda,
                'produtos' => $produtos,
                'pagamento' => false
            ]);
        }

        $status = $this->payment->getPaymentStatus($payment->id_pix);

        if($status == "cancelled"){
            $generatePayment = $this->payment->generatePayment("pix", $venda->total, $user->email);

            if(is_null($generatePayment)){
                return $this->router->redirect('compras');
            }

            $payment = $this->pagamentoRepository->update($payment->id, $generatePayment);

            if(is_null($payment)){
                return $this->router->view('venda/detalhes/index', [
                    'venda' => $venda,
                    'produtos' => $produtos,
                    'pagamento' => false
                ]);
            }
        }

        if($status == "approved"){
            $payment = $this->pagamentoRepository->updateStatus($payment->id, "approved");

            if(is_null($payment)){
                return $this->router->view('venda/detalhes/index', [
                    'venda' => $venda,
                    'produtos' => $produtos,
                    'pagamento' => false
                ]);
            }

            $update = $this->vendaRepository->updateStatus($venda->id, "concluida");
        }

        return $this->router->view('venda/detalhes/index', [
            'venda' => $venda,
            'produtos' => $produtos,
            'pagamento' => $payment
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

}