<?php require 'pages/header.php'; ?>

<?php
if (empty($_SESSION['cLogin'])) {
    ?>
    <script type="text/javascript">window.location.href = "login.php";</script>
    <?php
    exit;
}
?>


<div class="container">
    <h1>Meus Anúncios</h1>
    <a href="add-anuncio.php" class="btn btn-dark">Adicionar Anúncio</a>

    <table class="table table-striped">
        <thead>

            <tr>
                <th>Foto</th>
                <th>Titulo</th>
                <th>Valor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <?php
        require './classes/Anuncios.php';
        $a = new Anuncios();
        $anuncios = $a->getMeusAnuncios($pdo);

        foreach ($anuncios as $anuncio):
            ?>
            <tr>
                <td>
                    <?php if (!empty($anuncio['url'])): ?>
                        <img src="assets/images/anuncios/<?php echo $anuncio['url']; ?>" 
                             border="0" height="75"/>
                         <?php else: ?>
                        <img src="assets/images/default.jpg" height="75" border="0"/>
                    <?php endif; ?>
                </td>
                <td><?php echo $anuncio['titulo']; ?></td>
                <td>R$ <?php echo number_format($anuncio['valor'], 2); ?></td>
                <td>
                    <a href="editar-anuncio.php?id=<?php echo $anuncio['id']; ?>"><i class="material-icons">
                            edit
                        </i></a>
                    <a href="excluir-anuncio.php?id=<?php echo $anuncio['id']; ?>"><i class="material-icons">
                            delete
                        </i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php require './pages/footer.php'; ?>
