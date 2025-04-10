<?php

//importar
use App\Config\Router;
use App\Config\Auth;
use App\Controllers\User\UserController;
use App\Controllers\NotFound\NotFoundController;
use App\Controllers\Dashboard\DashboardController;
use App\Controllers\Permissao\PermissaoController;
use App\Controllers\Permissao\PermissaoUserController;
use App\Controllers\User\UserPerfilController;
use App\Controllers\Home\HomeController;
use App\Controllers\Produto\ProdutoController;
use App\Controllers\Produto\CarrosselProdutoController;
use App\Controllers\Carrinho\CarrinhoController;

//instanciar
$router = new Router();
$auth = new Auth();
$userController = new UserController();
$notFoundController = new NotFoundController();
$dashboardController = new DashboardController();
$permissaoController = new PermissaoController();
$permissaoUserController = new PermissaoUserController();
$userPerfilController = new UserPerfilController();
$homeController = new HomeController();
$produtoController = new ProdutoController();
$carrosselProdutoController = new CarrosselProdutoController();
$carrinhoController = new CarrinhoController();

//rotas

//not-found
$router->create("GET", "/404", [$notFoundController, 'index'], null);

//home
$router->create("GET", "/", [$homeController, 'index'], null);

//login e logout
$router->create("GET", "/login", [$userController, 'login'], null);
$router->create("POST", "/login", [$userController, 'auth'], null);
$router->create("GET", "/logout", [$userController, 'logout'], $auth);

//dashboard
$router->create("GET", "/dashboard", [$dashboardController, 'index'], $auth);

//usuarios
$router->create("GET", "/usuarios", [$userController, 'index'], $auth);
$router->create("GET", "/usuarios/cadastro", [$userController, 'create'], $auth);
$router->create("POST", "/usuarios/cadastro", [$userController, 'store'], $auth);
$router->create("GET", "/usuarios/{uuid}/editar", [$userController, 'edit'], $auth);
$router->create("POST", "/usuarios/{uuid}/editar", [$userController, 'update'], $auth);
$router->create("POST", "/usuarios/{uuid}/deletar", [$userController, 'destroy'], $auth);

//permissoes
$router->create("GET", "/permissoes", [$permissaoController, 'index'], $auth);
$router->create("GET", "/permissoes/cadastro", [$permissaoController, 'create'], $auth);
$router->create("POST", "/permissoes/cadastro", [$permissaoController, 'store'], $auth);
$router->create("GET", "/permissoes/{uuid}/editar", [$permissaoController, 'edit'], $auth);
$router->create("POST", "/permissoes/{uuid}/editar", [$permissaoController, 'update'], $auth);
$router->create("POST", "/permissoes/{uuid}/deletar", [$permissaoController, 'destroy'], $auth);

//permissao_user
$router->create("GET", "/usuarios/{uuid}/permissoes", [$permissaoUserController, 'index'], $auth);
$router->create("POST", "/usuarios/{uuid}/vincular", [$permissaoUserController, 'create'], $auth);
$router->create("POST", "/usuarios/{usuario_uuid}/desvincular/{permissao_uuid}", [$permissaoUserController, 'destroy'], $auth);

//perfil usuario
$router->create("GET", "/perfil", [$userPerfilController, 'index'], $auth);
$router->create("POST", "/perfil/icone", [$userPerfilController, 'updateIcone'], $auth);
$router->create("POST", "/perfil/editar", [$userPerfilController, 'updateDados'], $auth);
$router->create("POST", "/perfil/senha", [$userPerfilController, 'updateSenha'], $auth);
$router->create("POST", "/perfil/deletar", [$userPerfilController, 'destroy'], $auth);

//produtos
$router->create("GET", "/produtos", [$produtoController, 'index'], $auth);
$router->create("GET", "/produtos/cadastro", [$produtoController, 'create'], $auth);
$router->create("POST", "/produtos/cadastro", [$produtoController, 'store'], $auth);
$router->create("GET", "/produtos/{uuid}/editar", [$produtoController, 'edit'], $auth);
$router->create("POST", "/produtos/{uuid}/editar", [$produtoController, 'update'], $auth);
$router->create("POST", "/produtos/{uuid}/deletar", [$produtoController, 'destroy'], $auth);

//carrossel-produto
$router->create("GET", "/carrossel-produtos/{produto_uuid}", [$carrosselProdutoController, 'index'], $auth);
$router->create("POST", "/carrossel-produtos/{produto_uuid}/adicionar", [$carrosselProdutoController, 'store'], $auth);
$router->create("POST", "/carrossel-produtos/{uuid}/editar", [$carrosselProdutoController, 'update'], $auth);
$router->create("POST", "/carrossel-produtos/{uuid}/remover", [$carrosselProdutoController, 'destroy'], $auth);

//carrinho
$router->create("GET", "/carrinho", [$carrinhoController, 'index'], $auth);
$router->create("GET", "/carrinho/finalizar", [$carrinhoController, 'finish'], $auth);

//carrinho-produto
$router->create("POST", "/carrinho/produto/{produto_uuid}/adicionar", [$carrinhoController, 'addProductInCart'], $auth);
$router->create("POST", "/carrinho/produto/{produto_uuid}/subtrair", [$carrinhoController, 'subtractProductQuantity'], $auth);
$router->create("POST", "/carrinho/produto/{produto_uuid}/acrescentar", [$carrinhoController, 'sumProductQuantity'], $auth);
$router->create("POST", "/carrinho/produto/{produto_uuid}/remover", [$carrinhoController, 'deleteProduct'], $auth);

return $router;