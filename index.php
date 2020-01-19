
<?php require 'pages/header.php'; ?>

<?php
require './classes/Anuncios.php';
require './classes/Usuarios.php';
require './classes/Categorias.php';
$a = new Anuncios();
$u = new Usuarios();
$c = new Categorias();

$filtros = array(
    'categoria' => '',
    'preco' => '',
    'estado' => ''
);
if(isset($_GET['filtros']))
{
    $filtros = $_GET['filtros'];
}

$total_anuncios = $a->getTotalAnuncios($pdo,$filtros);
$total_usuarios = $u->getTotalUsuarios($pdo);
$p = 1;
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $p = addslashes($_GET['p']);
}
$por_pagina = 2;
$total_paginas = ceil($total_anuncios / $por_pagina);


$ultimos_anuncios = $a->getUltimosAnuncios($pdo, $p, $por_pagina,$filtros);
$categorias = $c->getLista($pdo);
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->



<div class="container-fluid">
    <div class="jumbotron">
        <h2>Nós temos hoje <?php echo $total_anuncios; ?> anúncios</h2>
        <p>E mais de <?php echo $total_usuarios; ?> usuários cadastrados</p>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <h4>Pesquisa Avançada</h4>

            <form method="GET">
                <div class="form-group">
                    <label for="categoria">Categoria:</label>
                    <select id="categoria" name="filtros[categoria]" class="form-control">
                        <option></option>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>" <?php echo ($cat['id'] == $filtros['categoria'])? 'selected ="selected"':'' ?> "><?php echo utf8_encode($cat['nome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="preco">Preço:</label>
                    <select id="preco" name="filtros[preco]" class="form-control">
                        <option></option>
                        <option value="0-50" <?php echo ($filtros['preco'] == '0-50')?'selected ="selected"':'' ?>>R$ 0 - 50</option>
                        <option value="51-100" <?php echo ($filtros['preco'] == '51-100')?'selected ="selected"':'' ?>>R$ 51 - 100</option>
                        <option value="101-200" <?php echo ($filtros['preco'] == '101-200')?'selected ="selected"':'' ?>>R$ 101 - 200</option>
                        <option value="201-500" <?php echo ($filtros['preco'] == '201-500')?'selected ="selected"':'' ?>>R$ 201 - 500</option>
                        <option value="500-10000000" <?php echo ($filtros['preco'] == '500-10000000')?'selected ="selected"':'' ?>> Mais de R$500 </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="estado">Estado de Conservação:</label>
                    <select name="filtros[estado]" id="estado" class="form-control">
                        <option></option>
                        <option value="1" <?php echo ($filtros['estado'] == '1')?'selected ="selected"':'' ?>>Ruim</option>
                        <option value="2" <?php echo ($filtros['estado'] == '2')?'selected ="selected"':'' ?>>Bom</option>
                        <option value="3" <?php echo ($filtros['estado'] == '3')?'selected ="selected"':'' ?>>Ótimo</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-info" value="Buscar"/>
                </div>
            </form>




        </div>
        <div class="col-sm-9">
            <h3>Ultimos anuncios</h3>

            <table class="table table-sm">
                <tbody>

                    <?php foreach ($ultimos_anuncios as $ultimo_anuncio): ?>
                        <tr>
                            <td>
                                <?php if (!empty($ultimo_anuncio['url'])): ?>
                                    <img src="assets/images/anuncios/<?php echo $ultimo_anuncio['url']; ?>" 
                                         border="0" height="50"/>
                                     <?php else: ?>
                                    <img src="assets/images/default.jpg" height="50" border="0"/>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="produto.php?id=<?php echo $ultimo_anuncio['id']; ?>"><?php echo $ultimo_anuncio['titulo']; ?></a><br>
                                <?php echo utf8_encode($ultimo_anuncio['categoria']); ?>
                            </td>
                            <td>
                                R$ <?php echo number_format($ultimo_anuncio['valor'], 2); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php for ($q = 1; $q <= $total_paginas; $q++): ?>
                        <li class="page-item <?php echo($p == $q) ? 'active' : ''; ?>">
                        <a class="page-link"  href="index.php?<?php
                        $w = $_GET;
                        $w['p'] = $q;
                        echo http_build_query($w);
                        ?>"><?php echo $q; ?>
                        </a>
                        </li>
                        <?php endfor; ?>
                </ul>
            </nav>
        </div>

    </div>
</div>

<?php
require 'pages/footer.php';
