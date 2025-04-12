<h1>Todas as suas compras</h1>

<form action="/compras" method="GET">
    <select name="situacao">
        <option value="" selected>Selecione a situação da compra</option>
        <option value="aguardando pagamento">Aguardando Pagamento</option>
        <option value="concluida">Concluída</option>
        <option value="cancelada">Cancelada</option>
    </select>

    <input type="date" name="data">

    <button type="submit">Pesquisar</button>
</form>

<div>
    <?php
        if(count($vendas) > 0){
            foreach($vendas as $venda){
    ?>
        <div style="border: 1px solid black">
            <p>Total: R$<?= $venda->total ?></p>
            <p>Feita em <?= date('d/m/Y', strtotime($venda->created_at)) ?></p>
            <p>Situação: <?= $venda->situacao ?></p>
            <form action="/compras/<?= $venda->uuid ?>/cancelar" method="post">
                <button type="submit">Cancelar</button>
            </form>
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