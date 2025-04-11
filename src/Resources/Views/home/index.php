<h1>HOME</h1>
<form action="/" method="get">
<input type="text" name="nome" placeholder="nome">
<button type="submit">Search</button>
</form>
<a href="/dashboard">dash</a>
<a href="/produtos">produtos</a>
<a href="/carrinho">carrinho</a>

<?php
    if(count($produtos) > 0){
        foreach($produtos as $produto){
?>
    <div>
        <img src="/public/img/produto/<?= $produto->imagem ?>" alt="Imagem produto" width="100px">
        <p><?= $produto->nome ?></p>
        <p><?= $produto->descricao ?></p>
        <p><?= $produto->preco ?></p>
        <p><?= $produto->estoque ?></p>
        <p><?= $produto->ativo ?></p>

        <form action="/carrinho/produto/<?= $produto->uuid ?>/adicionar" method="POST">
            <input type="number" name="quantidade" value=1>
            <button type="submit">No carrinho</button>
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
