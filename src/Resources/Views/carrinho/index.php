<h1>Carrinho aqui</h1>

<div>
    <?php
        if(count($carrinhoProduto) > 0 || !is_null($carrinhoProduto)){
            foreach($carrinhoProduto as $produto){
    ?>
        <div style="border: 1px solid black">
            <img src="public/img/produto/<?= $produto->imagem ?>" alt="Imagem do Produto" width="100px">
            <p>nome: <?= $produto->nome ?></p>
            <p>Quant: <?= $produto->quantidade ?></p>
            <p>preco: <?= $produto->preco ?></p>
            <div style="display: flex">
                <form action="carrinho/produto/<?= $produto->uuid_produto ?>/subtrair" method="POST">
                    <button type="submit">-</button>
                </form>
                <form action="carrinho/produto/<?= $produto->uuid_produto ?>/acrescentar" method="POST">
                    <button type="submit">+</button>
                </form>
            </div>
        </div>
    <?php
            }
        }
    ?>
</div>