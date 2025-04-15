<?php

namespace App\Controllers\Venda;

use App\Request\Request;
use App\Config\Auth;
use App\Controllers\Controller;
use App\Repositories\Pagamento\PagamentoRepository;
use App\Repositories\Venda\VendaRepository;
use App\Services\GerarPagamento;

class VendaController extends Controller {

    protected $pagamentoRepository;
    protected $vendaRepository;
    protected $auth;
    protected $payment;

    public function __construct(){
        parent::__construct();
        $this->pagamentoRepository = new PagamentoRepository();
        $this->vendaRepository = new VendaRepository();
        $this->auth = new Auth();
        $this->payment = new GerarPagamento();
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