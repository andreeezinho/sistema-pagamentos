<?php
    require_once __DIR__ . '/../layout/top.php';
?>

    <form action="/produtos/<?= $produto->uuid ?>/editar" method="POST" enctype="multipart/form-data">
        <label for="imagem">
            <img src="/public/img/produto/<?= $produto->imagem ?>" alt="imagem" id="preview" width="100px">
        </label>
        <input type="file" name="imagem" id="imagem" placeholder="imagem">
        <input type="text" name="nome" placeholder="nome" value="<?= $produto->nome ?>">
        <input type="text" name="descricao" placeholder="descricao" value="<?= $produto->descricao ?>">
        <input type="text" name="codigo" placeholder="codigo" value="<?= $produto->codigo ?>">
        <input type="number" name="preco" placeholder="preco" value="<?= $produto->preco ?>">
        <input type="number" name="estoque" placeholder="estoque" value="<?= $produto->estoque ?>">
        <select name="ativo">
            <option value="" <?= (isset($produto) && $produto->ativo == "") ? 'selected' : "" ?> selected>Selecione a situação</option>
            <option value=1 <?= (isset($produto) && $produto->ativo == "1") ? 'selected' : "" ?>>Ativo</option>
            <option value=0 <?= (isset($produto) && $produto->ativo == "0") ? 'selected' : "" ?>>Inativo</option>
        </select>
        <button type="submit">Cadastrar</button>
    </form>

    <h4>Carrossel</h4>
    
    <button type="button" class="btn btn-danger mx-1" data-toggle="modal" data-target="#cadastrar-carrossel"><i class="bi-image-fill"></i> Inserir</button>

    <div class="modal fade" id="cadastrar-carrossel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content text-dark">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"><i class="bi-person-fill-slash"></i> Deletar conta?</h5>
                </div>

                <div class="modal-body">
                    <p class="my-auto">Deseja <b>deletar</b> sua conta?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <form action="perfil/deletar" method="POST">
                        <button type="submit" class="btn btn-danger">Deletar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
        if(count($carrossel_produto) > 0){
            foreach($carrossel_produto as $carrossel){
    ?>
        <img src="/public/img/produto/carrossel/<?= $carrossel->nome_arquivo ?>" alt="imagem" width="40px">
    <?php
            }
        }else{
    ?>
        <p>Não há imagem no carrossel</p>
    <?php
        }
    ?>

<?php
    require_once __DIR__ . '/../layout/bottom.php';
?>