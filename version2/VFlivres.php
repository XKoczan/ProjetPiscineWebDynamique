<?php

require 'init.var.php';
require 'header.php';
    $req="SELECT * FROM `catalogue` WHERE categorie LIKE 'livre' ORDER BY `catalogue`.`nb_vente` DESC";
    $qry = $db->prepare($req);
    $qry->execute();
    $items=$qry->fetchAll(PDO::FETCH_OBJ);
    $i=0;
echo("<header><h1>BestSellers Livres</h1></header>");
    
        foreach($items as $item)
        {
           if($item->Stock!=0 && $i<3)
            {
                echo ("
                    <div class ='catalogue'>
                        <div class='pic'><img src='$item->photos' style='height:100%; width:100%;'></div>
                        <div class='elem2'>$item->nom</div>
                        <div class='elem2'>$item->prix €</div>
                        <div class='panierpic'><a href='ajouterpanier.php?id=$item->idprod' rel='nofollow'><img src='panier.jpg' style='height:100%; width:100%;'></a></div>
                        <div class='desc'> Description du produit: $item->description</div>
                    </div>
                    ");
               $i+=1;
            }
        }
require'footer.php';
?>