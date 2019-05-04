<?php
// Appel des initialisations
require 'init.var.php';
// Si un objet a bien élé sélectionné
if(isset($_GET['id'])){
    // Nous le cherchons dans le panier
    foreach($_SESSION['panier'] as $id=>$elem)
    {
        // Si on le trouve
        
        if($id == $_GET['id'])
        {
            // On le retire du panier
            unset($_SESSION['panier'][$id]);
            break;
        }
    }// On confirme la suppresison puis on redirige vers le panier
    echo("Le produit a bien ete supprime <a href='panier.php'>retour au panier</a>");
    
}else{// On affiche un signal d'erreur
    echo("aucun produit selectionne");
}
?>
