
<?php require 'pages/header.php'; ?>

<?php
require './classes/Anuncios.php';
require './classes/Usuarios.php';
$a = new Anuncios();
$u = new Usuarios();
$total_anuncios = $a->getTotalAnuncios($pdo);
$total_usuarios = $u->getTotalUsuarios($pdo);

$p = 1;
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $p = addslashes($_GET['p']);
}
$por_pagina = 2;
$total_paginas = ceil($total_anuncios / $por_pagina);
$ultimos_anuncios = $a->getUltimosAnuncios($pdo, $p, $por_pagina);
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
                    <?php for($q=1; $q <=$total_paginas;$q++):?>
                    <li class="page-item <?php echo($p==$q)?'active':'';?>"><a class="page-link"  href="index.php?p=<?php echo $q;?>"><?php echo $q;?></a></li>
                    <?php endfor;?>
                </ul>
            </nav>
        </div>

    </div>
</div>

<?php require 'pages/footer.php';
