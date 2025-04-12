<h1>Todas as suas compras</h1>

<div>
    <?php
        if(count($vendas) > 0){
            foreach($vendas as $venda){
    ?>
        <div style="border: 1px solid black">
            <p>Total: R$<?= $venda->total ?></p>
            <p>Feita em <?= date('d/m/Y', strtotime($venda->created_at)) ?></p>
            <a href="/compras/<?= $venda->uuid ?>/detalhes">Abrir compra</a>
        </div>
    <?php
            }
        }else{
    ?>
        <p>Não há compras...</p>
    <?php
        }
    ?>
</div>