<?php
require 'init.var.php';

$prixtotal=0;
foreach($_SESSION as $elem)
{
    foreach($elem as $key=>$value)
    {
        ;                   
    $req="SELECT * FROM catalogue WHERE idprod =$key";
    
    $qry = $db->prepare($req);
    $qry->execute();
    $results=$qry->fetchAll(PDO::FETCH_OBJ); 
       foreach($results as $result)
       {
           echo ("
                <tr>
                    <td><img src='$result->photos'</td><br>
                    <h6><td>Idprod: $result->idprod</td><br>
                    <td>Nom: $result->nom</td> <br>
                    <td>Prix: $result->prix €</td></h6>
                     <a href='supprimerpanier.php?id=$result->idprod'>Supprimer du panier</a><br>
                </tr>
                ");
           $prixtotal+=$result->prix;
       }
    }
   
    
   echo "<h4>Prix total du panier :$prixtotal €" ;
    
    echo"<h6><a href='getdata.php''>Retour au catalogue</a></h6>";
}
    