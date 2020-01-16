<?php require './pages/header.php'; ?>

<?php
   require './classes/Usuarios.php';
   $u = new Usuarios();
   
   if(isset($_POST['email']) && !empty($_POST['email']))
   {
       $email = addslashes($_POST['email']);
       $senha = md5($_POST['senha']);
       
       if($u->fazerLogin($pdo,$email,$senha))
       {
           ?>
<script type="text/javascript">window.location.href="./";</script>
           <?php
       }
       else
       {
           ?>
            <div class="alert alert-danger">
            Usuário e/ou Senha errados!        
            </div>
           <?php 
       }
       
       
   }
   
?>
<div class="container">
    <h1>Iniciar Sessão</h1>
    
    <form method="POST">
        <div class="form-group">
            <label for="email">Seu E-mail:</label>
            <input type="email" name="email" id="email" required="required" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="senha">Sua Senha:</label>
            <input type="password" name="senha" id="senha" class="form-control"/>
        </div>
        <input type="submit" value="Fazer Login" class="btn btn-dark"/>
    </form>
</div>

<?php require './pages/footer.php';?>






