<?php
require 'init.var.php';
require 'header.php';

foreach($_SESSION as $elem)
{
    foreach($elem as $key=>$value)
    {                      
    $req="SELECT * FROM cataloguemodele cm, catalogue c WHERE c.idprod = cm.idprod AND idmodele =$key";
    
    $qry = $db->prepare($req);
    $qry->execute();
    $results=$qry->fetchAll(PDO::FETCH_OBJ); 
    
       foreach($results as $result)
       {
           
            $stock=$result->stock - $value;
            $nb_vendu=$result->nb_vente + $value;
           
            $req="UPDATE cataloguemodele SET stock='$stock', nb_vente='$nb_vendu' WHERE idmodele=$key ";
    
            $qry = $db->prepare($req);
            $qry->execute();
           
            unset($_SESSION['panier'][$key]);
            break;
       }
    }
   
require'footer.php';
}