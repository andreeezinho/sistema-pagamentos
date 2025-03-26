<a href="produtos/cadastro">CADASTRAR</a>
<?php
    if(count($produtos) > 0){
        foreach($produtos as $produto){
?>
    <div>
        <a href="produtos/<?= $produto->uuid ?>/editar">EDITAR</a>
        <p><?= $produto->nome ?></p>
        <p><?= $produto->descricao ?></p>
        <p><?= $produto->preco ?></p>
        <p><?= $produto->codigo ?></p>
        <p><?= $produto->estoque ?></p>
        <p><?= $produto->ativo ?></p>
        <form action="produtos/<?= $produto->uuid ?>/deletar" method="post">
            <button type="submit">Deletar</button>
        </form>
    </div>
<?php
        }
    }else{
?>
    <p>Não há produtos</p>
<?php
    }
?>