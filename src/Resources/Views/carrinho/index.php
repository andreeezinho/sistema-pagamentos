<h1>Carrinho aqui</h1>

<p>Total: <?= $total ?? null ?></p>

<div>
    <?php
        if($carrinhoProduto && count($carrinhoProduto) > 0){
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
                
                <form action="carrinho/produto/<?= $produto->uuid_produto ?>/remover" method="POST">
                    <button type="submit">Remover do carrinho</button>
                </form>
            </div>
        </div>
    <?php
            }
        }else{
    ?>
        <p>Não há produtos...</p>
    <?php
        }
    ?>
</div>

<form action="/carrinho/finalizar" method="POST">
    <input type="number" name="desconto" placeholder="Desconto">
    <select name="endereco" id="endereco">
        <option value="1">Endereço de teste</option>
    </select>
    <button type="submit">Finalizar</button>
</form>