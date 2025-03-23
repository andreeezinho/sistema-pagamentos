<?php

namespace App\Controllers\Home;

use App\Request\Request;
use App\Config\Auth;
use App\Controllers\Controller;
use App\Repositories\User\UserRepository;

class HomeController extends Controller {

    public function index(Request $request){
        return $this->router->view('home/index', []);
    }

}