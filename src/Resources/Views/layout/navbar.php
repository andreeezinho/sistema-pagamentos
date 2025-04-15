<nav class="navbar navbar-expand-md navbar-dark bg-success px-0 px-md-5">
    <div class="container-fluid">
        <a class="navbar-brand ml-5" href="/">
            <img src="<?= URL_SITE ?>/public/img/site/logo.png" alt="Logo" class="logo">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">    
            </ul>

            <ul class="navbar-nav d-flex">
                <li class="nav-item dropdown d-block d-md-none">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown-usuario" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?= URL_SITE ?>/public/img/user/icons/<?= $_SESSION['user']->icone ?>" alt="User Icone" class="user-icone rounded-circle">
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdown-usuario">
                        <li><a class="dropdown-item" href="/perfil">Perfil</a></li>
                        <li><a class="dropdown-item" href="/logout">Sair</a></li>
                    </ul>
                </li>

                <li class="nav-item d-none d-md-block">
                    <a href="/dashboard" class="nav-link">Home</a>
                </li>

                <li class="nav-item dropdown">
                    <span class="nav-link dropdown-toggle" href="#" id="dropdown-usuarios" data-bs-toggle="dropdown" aria-expanded="false">Site</span>
                    <ul class="dropdown-menu" aria-labelledby="dropdown-usuarios">
                        <li><a class="dropdown-item" href="/usuarios">Usuarios</a></li>
                        <li><a class="dropdown-item" href="/permissoes">Permissões</a></li>
                        <li><a class="dropdown-item" href="#">Clientes</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown d-none d-md-block me-5">
                    <span class="nav-link dropdown-toggle" href="#" id="dropdown-usuario" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?= URL_SITE ?>/public/img/user/icons/<?= $_SESSION['user']->icone ?>" alt="User Icone" class="user-icone rounded-circle">
                    </span>
                    <ul class="dropdown-menu" aria-labelledby="dropdown-usuario">
                        <li><a class="dropdown-item" href="/perfil">Perfil</a></li>
                        <li><a class="dropdown-item" href="/logout">Sair</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>