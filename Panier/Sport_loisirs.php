<a href='ProjetPiscine.html'><img id='logo' src='ECE-Paris.jpg' width= 20% height= 20%></a>

<?php

  require 'init.var.php';
    $req="SELECT * FROM catalogue WHERE categorie LIKE 'sport_loisir'";
    $qry = $db->prepare($req);
    $qry->execute();
    $items=$qry->fetchAll(PDO::FETCH_OBJ);
    
echo("<header><h1>Sports et Loisirs</h1></header>");

    foreach($items as $item)
    {
        echo ("
                <div class ='catalogue'>
                    <div class='pic'><img src='$item->photos' style='height:100%; width:100%;'></div>
                    <div class='elem2 '>$item->nom</div>
                    <div class='elem2 '>$item->prix €</div>
                    <div class='panierpic'><a href='ajouterpanier.php?id=$item->idprod' rel='nofollow'><img src='panier.jpg' style='height:100%; width:100%;'></a></div>
                </div>
                ");
    }

?>