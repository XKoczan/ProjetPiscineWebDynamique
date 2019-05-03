<?php
// Appel des initialisations
require 'init.var.php';
// Affichage de l'entête
require 'header.php';   
// On sélectionne l'ensemble des items du catalogue
$req="SELECT * FROM cataloguemodele cm, catalogue c WHERE c.idprod = cm.idprod ORDER BY cm.idprod ASC";
    $qry = $db->prepare($req);
    $qry->execute();
// On les stocke dans un tableau d'objet
    $items=$qry->fetchAll(PDO::FETCH_OBJ);
$i=0;
$produit=0;
// On affiche le catalogue
echo("<header><h1>Catalogue</h1></header>");
    // On parcourt notre tableau
    foreach($items as $item)
    { // si le stock de l'objet n'est pas nul
       if($item->stock!=0)
        {
           // on affiche le modele de l'objet après vérification (l'id de l'objet précédent doit être différent du suivant)
           if($produit != $item->idprod && $i<1)
           {// Si l'admin sélectionne un objet on envoie vers la pageitem.php qui le supprimera
              echo ("
                <div class ='catalogue'>
                    <div class='pic'><img src='$item->photos' style='height:100%; width:100%;'></div>
                    <div class='nommodele'>$item->nom</div>
                    <div class='prix'>$item->prix €</div>
                    <div class='panierpic'>
                        <form action='pageitem.php' method ='post'>
                        <input type='hidden' name='val' value='1'>
                        <input type='hidden' name='nomfic' value='admincatalogue.php'>
                        <button name='id' value ='$item->idprod' type='submit'><img src='trash.jpg' style='height:100%; width:100%;'>
                        </button>
                        </form>
                    </div>
                    <div class='desc'> Description du produit: $item->idprod</div>
                </div>
                ");  
               
           }
            
        }
        // on chage stock l'id dans une varibke pour la vérification
        $produit=$item->idprod;
    }
    

require'footer.php';
?>