<h1>HOME</h1>
<h1>Admin: <?= $_SESSION['user']->is_admin ?></h1>
<form action="/" method="get">
<input type="text" name="nome" placeholder="nome">
<button type="submit">Search</button>
</form>
<a href="/dashboard">dash</a>
<a href="/produtos">produtos</a>

<?php
    if(count($produtos) > 0){
        foreach($produtos as $produto){
?>
    <div>
        <p><?= $produto->nome ?></p>
        <p><?= $produto->descricao ?></p>
        <p><?= $produto->preco ?></p>
        <p><?= $produto->estoque ?></p>
        <p><?= $produto->ativo ?></p>
    </div>
<?php
        }
    }else{
?>
    <p>Não há produtos</p>
<?php
    }
?>
