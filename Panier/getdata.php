<?php

  require 'init.var.php';
    $req="SELECT * FROM catalogue";
    $qry = $db->prepare($req);
    $qry->execute();
    $items=$qry->fetchAll(PDO::FETCH_OBJ);
    
    foreach($items as $item)
    {
        echo ("
                <tr>
                    <td><img src='$item->photos'</td><br>
                    <h6><td>Idprod: $item->idprod</td><br>
                    <td>Nom: $item->nom</td> <br>
                    <td>Prix: $item->prix €</td></h6>
                    
                    <a href='ajouterpanier.php?id=$item->idprod' rel='nofollow'>Ajouter au panier</a><br>
                </tr>
                ");
    }
?>
<a href='panier.php'>Panier</a>