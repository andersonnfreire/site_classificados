
<?php require 'pages/header.php'; ?>

<?php
require './classes/Anuncios.php';
require './classes/Usuarios.php';
$a = new Anuncios();
$u = new Usuarios();

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = addslashes($_GET['id']);
} else {
    ?>
    <script type="text/javascript">window.location.href = "index.php"</script>
    <?php
    exit;
}
$info = $a->getAnuncio($pdo, $id)
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->



<div class="container-fluid">

    <div class="row">
        
        <div class="col-sm-5"><br>
            <div id="meuCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    
                    <?php foreach ($info['fotos'] as $chave => $foto): ?>
                        <div class="carousel-item <?php echo ($chave=='0')?'active':'';?>" data-interval="2000">
                            <img src="assets/images/anuncios/<?php echo $foto['url'];?>" class="d-block w-100" alt="...">
                    </div>
                    <?php endforeach; ?>
                </div>
                <a class="carousel-control-prev" href="#meuCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#meuCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

        </div>
        <div class="col-sm-7"><br>

            <h1><?php echo utf8_encode($info['titulo']);?></h1>
            <h4><?php echo utf8_encode($info['categoria']);?></h4>
            <p><?php echo utf8_encode($info['descricao']);?></p>
            <br/><br/>
            <h3>R$:<?php echo number_format($info['valor'], 2);?></h3>
            <h3>Telefone: <?php echo $info['telefone'];?></h3>
        </div>

    </div>
</div>

<?php
require 'pages/footer.php';
