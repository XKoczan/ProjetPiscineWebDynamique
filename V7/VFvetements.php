<?php
// Appel aux initialisations
require 'init.var.php';
// Inclusion de l'en-tête
require 'header.php';
// Requete sql
    $req="SELECT * FROM cataloguemodele cm, catalogue c WHERE c.categorie LIKE 'vetement' AND c.idprod = cm.idprod ORDER BY cm.`nb_vente` DESC";
    // Preparation de la requete
    $qry = $db->prepare($req);
    // Execution de la requete
    $qry->execute();
    // Stockage des valeurs sous formes d'objets dans un tableau 
    $items=$qry->fetchAll(PDO::FETCH_OBJ);
    // Initialisation de la variable de condition
    $i=0;
// Titre de la page
echo("<header><h1>BestSellers Vetements</h1></header>");
// Boucle d'affichage des items    
        foreach($items as $item)
        {
            // Verification des stocks
           if($item->stock!=0 && $i<3)
            {
               // Affichage de l'article
               echo ("
                <div class ='catalogue'>
                    <div class='pic'><img src='$item->photos' style='height:100%; width:100%;'></div>
                    <div class='nommodele'>$item->nom</div>
                    <div class='prix'>$item->prix €</div>
                    <div class='panierpic'>
                        <form action='ajouterpanier.php' method ='post'>
                        <input type='hidden' name='val' value='1'>
                        <input type='hidden' name='nomfic' value='VFvetements.php'>
                        <button id ='button' name='id' value ='$item->idprod' type='submit'><img src='panier.jpg' style='height:100%; width:100%;'>
                        </button>
                        </form>
                    </div>
                    <div class='desc'> Description du produit: $item->idprod</div>
                </div>
                "); 
               // Incrémentation de la variable de condition
               $i+=1;
            }
        }
// Inclusion du footer
require'footer.php';
?>