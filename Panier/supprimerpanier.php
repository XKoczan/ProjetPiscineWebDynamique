<?php
require 'init.var.php';

if(isset($_GET['id'])){
    foreach($_SESSION['panier'] as $id=>$elem)
    {
        
        if($id == $_GET['id'])
        {
            unset($_SESSION['panier'][$id]);
            break;
        }
    }
    die("Le produit a bien ete ajoute <a href='panier.php'>retour au catalogue</a>");
    
}else{
    die("aucun produit selectionne");
}
?>
