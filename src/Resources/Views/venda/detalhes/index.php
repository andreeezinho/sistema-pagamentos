<h1>Detalhes da compra</h1>

<p>TOTAL: R$ <?= $venda->total ?></p>
<p>TOTAL: R$ <?= $venda->situacao ?></p>

<?php
    if($venda->situacao != "cancelada"){
        if(!$pagamento){
?>
    <form action="/compras/<?= $venda->uuid ?>/gerar-pagamento" method="POST">
        <button type="submit">GERAR PIX</button>
    </form>
<?php
    }else{
        if($venda->situacao != "concluida"){
?>
    <img src="data:image/jpeg;base64,<?= $pagamento->qr_code ?>" width="250px">
    <p><?= $pagamento->codigo ?></p>
<?php
            }
        }   
    }
?>

<div>
    <?php
        if(count($produtos) > 0){
            foreach($produtos as $produto){
    ?>
        <div style="border: 1px solid black">
            <img src="/public/img/produto/<?= $produto->imagem ?>" alt="Imagem do Produto" width="100px">
            <p>nome: <?= $produto->nome ?></p>
            <p>Quant: <?= $produto->quantidade ?></p>
            <p>preco: <?= $produto->preco ?></p>
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

<?php
    if($venda->situacao == 'aguardando pagamento'){
?>
    <form action="/compras/<?= $venda->uuid ?>/cancelar" method="post">
        <button type="submit">Cancelar</button>
    </form>
<?php
    }
?>

<a href="/compras">Voltar</a>