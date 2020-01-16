<?php
/**
 * Description of usuarios
 *
 * @author andersonfreire
 */
class Usuarios {
    
    function cadastrar($pdo,$nome,$email,$senha,$telefone)
    {
        $sql = $pdo->prepare("SELECT id FROM usuarios where email =:email");
        $sql->bindValue(":email",$email);
        $sql->execute();
        
        if($sql->rowCount() == 0)
        {
            $sql = $pdo->prepare("INSERT INTO usuarios SET nome =:nome, email =:email, senha =:senha, telefone =:telefone");
            $sql->bindValue(":nome",$nome);
            $sql->bindValue(":email",$email);
            $sql->bindValue(":senha", md5($senha));
            $sql->bindValue(":telefone", $telefone);
            $sql->execute();
            return true;
        }
        else
        {
            return false;
        }
        
    }
    
    
    
}
