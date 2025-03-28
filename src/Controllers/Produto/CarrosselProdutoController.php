<?php

namespace App\Controllers\Produto;

use App\Request\Request;
use App\Controllers\Controller;
use App\Repositories\Produto\CarrosselProdutoRepository;

class CarrosselProdutoController extends Controller {

    protected $carrosselProdutoRepository;

    public function __construct(){
        parent::__construct();
        $this->carrosselProdutoRepository = new CarrosselProdutoRepository();
    }

}