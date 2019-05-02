<?php

require 'init.var.php';
require 'header.php';
    $req="SELECT * FROM cataloguemodele cm, catalogue c WHERE c.categorie LIKE 'Sport_loisir' AND c.idprod = cm.idprod ORDER BY cm.idprod ASC";
    $qry = $db->prepare($req);
    $qry->execute();
    $items=$qry->fetchAll(PDO::FETCH_OBJ);
$i=0;
$produit=0;
echo("<header><h1>Sports et loisirs</h1></header>");

    foreach($items as $item)
    {
       if($item->stock!=0)
        {
           if($produit != $item->idprod && $i<1)
           {
              echo ("
                <div class ='catalogue'>
                    <div class='pic'><img src='$item->photos' style='height:100%; width:100%;'></div>
                    <div class='nommodele'>$item->nom</div>
                    <div class='prix'>$item->prix €</div>
                    <div class='panierpic'>
                        <form action='ajouterpanier.php' method ='post'>
                        <input type='hidden' name='val' value='1'>
                        <input type='hidden' name='nomfic' value='Sport_loisirs.php'>
                        <button name='id' value ='$item->idprod' type='submit'><img src='panier.jpg' style='height:100%; width:100%;'>
                        </button>
                        </form>
                    </div>
                    <div class='desc'> Description du produit: $item->idprod</div>
                </div>
                ");  
           }
            
        }
        $produit=$item->idprod;
    }
require'footer.php';
?>
