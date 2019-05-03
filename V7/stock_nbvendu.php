<?php
// Appel des initialisations
require 'init.var.php';
// Affichage de l'en-tête
require 'header.php';

// Boucle d'update
foreach($_SESSION as $elem)
{
    // pour chaque element du panier
    foreach($elem as $key=>$value)
    {                     
    // On selecitonne leurs liens dans la base de donnée
    $req="SELECT * FROM cataloguemodele cm, catalogue c WHERE c.idprod = cm.idprod AND idmodele =$key";
    
    $qry = $db->prepare($req);
    $qry->execute();
    // On les enregistre dans un tableau d'objets
    $results=$qry->fetchAll(PDO::FETCH_OBJ); 
        // Pour chaque objet
       foreach($results as $result)
       {
            // On update son stock et son nombre de vente
            $stock=$result->stock - $value;
            $nb_vendu=$result->nb_vente + $value;
           // On intègre dans la base de donnée
            $req="UPDATE cataloguemodele SET stock='$stock', nb_vente='$nb_vendu' WHERE idmodele=$key ";
    
            $qry = $db->prepare($req);
            $qry->execute();
           // On retire l'objet du panier
            unset($_SESSION['panier'][$key]);
            break;
       }
    }
    // On remercie pour l'achat et on redirige vers la page principale
echo ("<h1>Merci pour votre achat</h1><br>
        <button><a href='ProjetPiscine.php'>Retour à la page principale</a></button>");
        
    
// On affiche le footer   
require'footer.php';
}