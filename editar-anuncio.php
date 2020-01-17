<?php require 'pages/header.php'; ?>

<?php
if (empty($_SESSION['cLogin'])) {
    ?>
    <script type="text/javascript">window.location.href = "login.php";</script>
    <?php
    exit;
}
require './classes/Anuncios.php';
$a = new Anuncios();
if (isset($_POST['titulo']) && !empty($_POST['titulo'])) {
    $titulo = addslashes($_POST['titulo']);
    $categoria = addslashes($_POST['categoria']);
    $valor = addslashes($_POST['valor']);
    $descricao = addslashes($_POST['descricao']);
    $estado = addslashes($_POST['estado']);

    if (isset($_FILES['fotos'])) {
        $fotos = $_FILES['fotos'];
    } else {
        $fotos = array();
    }
    $fotos = $_FILES['fotos'];
    $a->editAnuncio($pdo, $_GET['id'], $titulo, $categoria, $valor, $descricao, $estado, $fotos);
    ?>
    <div class="alert alert-success">
        Produto editado com sucesso!
    </div>
    <?php
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $info = $a->getAnuncio($pdo, $_GET['id']);
} else {
    ?>
    <script type="text/javascript">window.location.href = "meus-anuncios.php";</script>
    <?php
    exit;
}
?>
<div class="container">
    <h1>Meus Anúncios - Editar Anúncio</h1>

    <form method="POST" enctype="multipart/form-data">
        <div>
            <label for="categoria">Categoria:</label>
            <select name="categoria" id="categoria" class="form-control">
<?php
require './classes/Categorias.php';
$c = new Categorias();
$cats = $c->getLista($pdo);
foreach ($cats as $cat):
    ?>
                    <option value="<?php echo $cat['id']; ?>" <?php echo ($info['id_categoria'] == $cat['id']) ? 'selected="selected"' : ''; ?>><?php echo utf8_encode($cat['nome']); ?></option>
                    <?php
                endforeach;
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="titulo">Titulo:</label>
            <input type="text" name="titulo" value="<?php echo $info['titulo']; ?>" id="titulo" class="form-control">
        </div>
        <div class="form-group">
            <label for="valor">Valor:</label>
            <input type="text" name="valor" id="valor" value="<?php echo $info['valor']; ?>" class="form-control">
        </div>
        <div class="form-group">
            <label for="descricao">Descrição:</label>
            <textarea class="form-control" name="descricao"><?php echo $info['descricao']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="estado">Estado de Conservação:</label>
            <select name="estado" id="estado" class="form-control">
                <option value="0" <?php echo ($info['estado'] == '0') ? 'selected="selected"' : ''; ?>>Ruim</option>
                <option value="1" <?php echo ($info['estado'] == '1') ? 'selected="selected"' : ''; ?>>Bom</option>
                <option value="2" <?php echo ($info['estado'] == '2') ? 'selected="selected"' : ''; ?>>Ótimo</option>
            </select>
        </div>
        <div class="form-group">

            <label for="add_foto">Fotos do anúncio:</label>
            <input type="file" name="fotos[]" multiple class="form-control-file"/>
            <br>
            <div class="card">
                <div class="card-header">
                    Fotos do Anúncio
                </div>
                <br>
                <div class="card-body">
                <?php foreach($info['fotos'] as $ft): ?>
                    <div class="foto_item">
                        <img src="assets/images/anuncios/<?php echo $ft['url']; ?>"
                             class="foto_item img" border="0" />
                        <a href="excluir-foto.php?id=<?php echo $ft['id'];?>" class="btn btn-dark">Excluir Imagem</a>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>
            <br>
            <input type="submit" value="Salvar" class="btn btn-dark">
            </form>


        </div>    


<?php require './pages/footer.php'; ?>        