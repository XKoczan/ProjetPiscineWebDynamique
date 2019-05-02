<?php
require 'init.var.php';
require 'header.php';
$prixtotal=0;
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
           $price=$result->prix*$value;
           echo ("
                
                    <div class='elem'>
                        <div class='elem1'>
                            <td><img src='$result->photos' style='height:100%; width:100%;'></td><br>
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
           $prixtotal+=$value*$result->prix;
       }
    }
   
    
   echo "<h4>Prix total du panier :$prixtotal €" ;
    echo"<h3><form action='formulaireconnexionacheteur.php' methode='post'>
                
                <button type='submit' name='fichiersource' value='panier.php'>Acheter</button>
                
                </form>
        </h3>";
require'footer.php';
}
    