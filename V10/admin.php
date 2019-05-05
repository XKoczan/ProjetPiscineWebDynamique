<html>
<?php 
    // Appel des initialisations 
    require 'init.var.php';
    // Affichage du header
    require 'header.php';
    if(!isset($_SESSION))
    {
        session_start();

    }
// on créé une variable de session pour montrer que l'utilisateur est un admin
    if(!isset($_SESSION['is_admin']))
    {
        $_SESSION['is_admin']=array();
    }
    // On affiche les différentes fonctionnalités du comptes admin?>
<h2>
    
    <button><a href="Vendre.php">Ajouter un article</a></button>
    <button><a href="admincatalogue.php?origine=admin">Supprimer un article</a></button>
    <button><a href="Formulaireajoutvendeur.php">Ajouter un compte</a></button>
    <button><a href="adminsuppressvendeur.php">Supprimer un compte</a></button>
</h2>
<?php
    // On affiche le footer
    require 'footer.php' ?>
    
</html>