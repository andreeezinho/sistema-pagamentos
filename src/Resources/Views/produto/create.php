<form action="/produtos/cadastro" method="POST" enctype="multipart/form-data">
    <input type="text" name="nome" placeholder="nome">
    <input type="text" name="descricao" placeholder="descricao">
    <input type="text" name="codigo" placeholder="codigo">
    <input type="number" name="preco" placeholder="preco">
    <input type="number" name="estoque" placeholder="estoque">
    <select name="ativo">
        <option value="" selected>Selecione a situação</option>
        <option value=1>Ativo</option>
        <option value=0>Inativo</option>
    </select>
    <input type="file" name="imagem" placeholder="imagem">
    <button type="submit">Cadastrar</button>
</form>