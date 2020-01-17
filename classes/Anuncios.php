<?php

/**
 * Description of anuncios
 *
 * @author andersonfreire
 */
class Anuncios {
    function getMeusAnuncios($pdo)
    {
        $array = array();
        $sql = $pdo->prepare("SELECT *, 
            "."(select anuncios_imagens.url from anuncios_imagens where "
                . "anuncios_imagens.id_anuncio = anuncios.id limit 1)as url FROM anuncios "
                . "WHERE id_usuario =:usuario");
        $sql->bindValue(":usuario",$_SESSION['cLogin']);
        $sql->execute();
        
        if($sql->rowCount()>0)
        {
            $array = $sql->fetchAll();
        }
        return $array;
    }
    function addAnuncio($pdo,$titulo,$categoria,$valor,$descricao,$estado)
    {
        $sql = $pdo->prepare("INSERT INTO anuncios SET id_usuario =:ausuario,id_categoria =:acategoria,"
                . "titulo =:atitulo ,descricao =:adescricao, valor =:avalor, estado =:aestado");
        
        $sql->bindValue(":acategoria",$categoria);
        $sql->bindValue(":ausuario",$_SESSION['cLogin']);
        $sql->bindValue(":atitulo",$titulo);
        $sql->bindValue(":adescricao",$descricao);
        $sql->bindValue(":avalor",floatval($valor));
        $sql->bindValue(":aestado",$estado);
        $sql->execute();
    }
}
