<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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

<script src="<?= URL_SITE ?>/public/js/script.js"></script>
</body>
</html>