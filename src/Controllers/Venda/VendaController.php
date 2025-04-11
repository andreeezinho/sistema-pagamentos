<?php

namespace App\Controllers\Venda;

use App\Request\Request;
use App\Config\Auth;
use App\Controllers\Controller;
use App\Repositories\Venda\VendaRepository;
use App\Repositories\Venda\VendaProdutoRepository;

class VendaController extends Controller {

    protected $vendaRepository;
    protected $vendaProdutoRepository;
    protected $auth;

    public function __construct(){
        parent::__construct();
        $this->vendaRepository = new VendaRepository();
        $this->vendaProdutoRepository = new VendaProdutoRepository();
        $this->auth = new Auth();
    }

    public function index(Request $request){
        return $this->router->view('venda/index', []);
    }

}