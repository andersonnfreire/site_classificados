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
                . "WHERE id_usuario =:usua");
        $sql->bindValue(":usua",$_SESSION['cLogin']);
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
    function excluirAnuncio($pdo, $id) {
        
        $sql = $pdo->prepare("DELETE FROM anuncios_imagens WHERE id_anuncio =:idanuncio");
        $sql->bindValue(":idanuncio",$id);
        $sql->execute();
        
        $sql = $pdo->prepare("DELETE FROM anuncios WHERE id =:aid");
        $sql->bindValue(":aid",$id);
        $sql->execute();
    }
    function excluirFoto($pdo, $id) {
        
        $sql = $pdo->prepare("SELECT id_anuncio FROM anuncios_imagens WHERE id =:idd");
        $sql->bindValue(":idd",$id);
        $sql->execute();        
        
        if($sql->rowCount()>0)
        {
            $row = $sql->fetch();
            $id_anuncio = $row['id_anuncio'];
        }
        
        $sql = $pdo->prepare("DELETE FROM anuncios_imagens WHERE id =:i");
        $sql->bindValue(":i",$id);
        $sql->execute();
        
        return $id_anuncio;
        
    }
    function getAnuncio($pdo, $id) {
        $array = array();
        $sql = $pdo->prepare("SELECT * FROM anuncios WHERE id =:aid");
        
        $sql->bindValue(":aid",$id);
        $sql->execute();
        
        if($sql->rowCount()>0)
        {
            $array = $sql->fetch();
            $array['fotos'] = array();
            
            $sql = $pdo->prepare("SELECT id, url FROM anuncios_imagens WHERE id_anuncio =:id");
            $sql->bindValue(":id",$id);
            $sql->execute();
            
            if($sql->rowCount() > 0)
            {
                $array['fotos'] = $sql->fetchAll();
            }
        }
        return $array;
    }
    function editAnuncio($pdo,$id,$titulo,$categoria,$valor,$descricao,$estado,$fotos)
    {
        $sql = $pdo->prepare("UPDATE anuncios SET id_usuario =:ausuario,id_categoria =:acategoria,"
                . "titulo =:atitulo ,descricao =:adescricao, valor =:avalor, estado =:aestado, id =:aid");
        
        $sql->bindValue(":acategoria",$categoria);
        $sql->bindValue(":ausuario",$_SESSION['cLogin']);
        $sql->bindValue(":atitulo",$titulo);
        $sql->bindValue(":adescricao",$descricao);
        $sql->bindValue(":avalor",floatval($valor));
        $sql->bindValue(":aestado",$estado);
        $sql->bindValue(":aid",$id);
        $sql->execute();
        
        if(count($fotos) > 0)
        {
            for($q = 0;$q < count($fotos['tmp_name']);$q++)
            {
                $tipo = $fotos['type'][$q];
                if(in_array($tipo, array('image/jpeg','image/png')))
                {
                    $tmpname = md5(time().rand(0, 9999).'.jpg'); // gera novo nome
                    move_uploaded_file($fotos['tmp_name'][$q],'assets/images/anuncios/'.$tmpname); // salva na pasta de imagens do servidor
                    
                    //Processo de redimensionar a imagem
                    list($width_orig, $height_orig) = getimagesize('assets/images/anuncios/'.$tmpname);
                    
                    $ratio = $width_orig/$height_orig;
                    
                    $width = 500;
                    $height = 500;
                    
                    if(($width/$height) > $ratio)
                    {
                        $width = $height*$ratio;
                    }
                    else
                    {
                        $height = $width/$ratio;
                    }
                    $img = imagecreatetruecolor($width, $height);
                    if($tipo == 'image/jpeg')
                    {
                        $origi = imagecreatefromjpeg('assets/images/anuncios/'.$tmpname);
                    }
                    elseif($tipo == 'image/png')
                    {
                        $origi = imagecreatefrompng('assets/images/anuncios/'.$tmpname);
                    }
                    
                    
                    imagecopyresampled($img, $origi, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                    //salva a imagem nova
                    imagejpeg($img, 'assets/images/anuncios/'.$tmpname,80);
                    
                    //inserindo no banco
                    $sql = $pdo->prepare("INSERT INTO anuncios_imagens SET id_anuncio =:id, url =:u");
                    $sql->bindValue(":id",$id);
                    $sql->bindValue(":u", $tmpname);
                    $sql->execute();
                    
                }
            }
        }
        
    }
    
}
