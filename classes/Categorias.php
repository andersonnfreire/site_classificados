<?php

/**
 * Description of categorias
 *
 * @author andersonfreire
 */
class Categorias {
    function getLista($pdo)
    {
        $array = array();
        $sql = $pdo->query("SELECT * FROM categorias");
        if($sql->rowCount()>0)
        {
            $array = $sql->fetchAll();
        }
        return $array;
    }
}
