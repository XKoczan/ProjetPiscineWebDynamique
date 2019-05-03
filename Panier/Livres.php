<?php

  require 'init.var.php';
    $req="SELECT * FROM catalogue WHERE categorie LIKE 'livre'";
    $qry = $db->prepare($req);
    $qry->execute();
    $items=$qry->fetchAll(PDO::FETCH_OBJ);

echo('<a href="ProjetPiscine.html"><img id="logo" src="ECE-Paris.jpg" width= 20% height= 20%></a>');
echo("<header>
        <h1>Livres
            <div class='pagepanier'>
                <a href='panier.php'><img src='panier.jpg' style='height:100%; width:100%;'></a>
            </div>
           
        </h1>
         <div class='logoece'>
                <a href='ProjetPiscine.html'><img id='logo' src='ECE-Paris.jpg' width= 20% height= 20%></a>
            </div>
    </header>");
    foreach($items as $item)
    {
        echo ("
                <div class ='catalogue'>
                    <div class='pic'><img src='$item->photos' style='height:100%; width:100%;'></div>
                        <div class ='row'>
                            <div class='elem2 col-lg-2'>$item->nom</div>
                            <div class='elem2 col-lg-2'>$item->prix €</div>
                        </div>
                    
                    <div class='panierpic'><a href='ajouterpanier.php?id=$item->idprod' rel='nofollow'><img src='panier.jpg' style='height:100%; width:100%;'></a></div>
                </div>
                ");
    }

?>
