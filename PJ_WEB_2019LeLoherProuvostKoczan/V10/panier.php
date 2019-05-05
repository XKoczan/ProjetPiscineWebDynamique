<?php
// Appel des initialisations
require 'init.var.php';
// Appel du header
require 'header.php';
$prixtotal=0;
// On affiche les différents types d'informations du panier
echo("<header><h1>Votre Panier</h1></header>
                <div class='panier'>
                    <div class='tab'>
                        <div class='tab1'>Image</div>
                        <div class='tab1'>Nom</div>
                        <div class='tab1'>Quantite</div>
                        <div class='tab1'>Prix unit</div>
                        <div class='tab1'>Prix lot</div>
                    </div>
                </div>");
    // Boucle de d'affichage du panier
    foreach($_SESSION['panier']  as $key=>$value)
    {                      
    // Pour chaque element contenu dans la Session panier
    
    $req="SELECT * FROM cataloguemodele cm, catalogue c WHERE c.idprod = cm.idprod AND idmodele =$key";
    
    $qry = $db->prepare($req);
    $qry->execute();
    // On stock les items correspondants dans un tableau d'objets
    $results=$qry->fetchAll(PDO::FETCH_OBJ); 
        // Pour chaque objet
       foreach($results as $result)
       {
           // On multiplie le prix par la quantité
           $price=$result->prix*$value;
           // On affiche ensuite les informations de l'objet
           echo ("
                
                    <div class='elem'>
                        <div class='elem1'>
                            <td><img src='/V10/catalogue/$result->idprod/$result->photos' style='height:100%; width:100%;'></td><br>
                        </div>
                        <div class='elem1'>$result->nom</div>
                        <div class='elem1'>$value</div>
                        <div class='elem1'>$result->prix</div>
                        <div class='elem1'>$price</div>
                        
                        <div class='supp'>
                            <a href='supprimerpanier.php?id=$result->idmodele'><img src='del2.png' style='height:40%; width:20%;'></a><br>
                        </div> 
                        
                    </div>

                    
               
        
                ");
           // On additionne les prix des lots d'objets dans la variable prix total
           $prixtotal+=$value*$result->prix;
       }
    }
   
    // On affiche le prix total
   echo "<h4>Prix total du panier :$prixtotal €" ;
    // On envoie l'utilisateur sur le formulaire de connexion à son compte
    echo"<h3><form action='formulaireconnexionacheteur.php' methode='post'>
                
                <button type='submit' name='fichiersource' value='panier.php'>Acheter</button>
                
                
                </form>
        </h3>";
    // On affiche le footer
require'footer.php';

    