<?php

require 'init.var.php';
require 'header.php';
    
    $prixtotal=0;
    $req="SELECT email FROM acheteur";
    $qry = $db->prepare($req);
    $qry->execute();
    $items=$qry->fetchAll(PDO::FETCH_OBJ);

$prixtotal=0;
$message2="";
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

    foreach($_SESSION['panier']  as $key=>$value)
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
            $message2 .= 'Nom :'.$result->nom.' Quantite :'.$value.' Prix unite :'.$result->prix.' '."\r\n";
           $prixtotal+=$value*$result->prix;
       }
    }
// On récupère le mail de l'acheteur sur la BDD

    foreach($items as $item)
    {
              echo ("<div class='nommodele'>$item->email</div>");  
        
   }
        if(isset($_POST['mail'])){
    //On complète les éléments nécessaire pour envoyer le mail avec l'adresse client
     $to = $item->email;
     $subject = 'Confirmation de commande chez ECE Amazon';
     $message = 'Bonjour !'."\r\n".'Nous avons le plaisir de vous confirmer votre commande chez ECE Amazon. '."\r\n".'Vous avez commandez les produits suivants :'."\r\n".$message2."\r\n".' prix total de la commande: '.$prixtotal."\r\n".'Merci de votre achat';
     $headers = 'De: EceAmazon@webmaster.com' . "\r\n" .
     'Reply-To: EceAmazon@webmaster.com' . "\r\n" .
     'X-Mailer: PHP/' . phpversion();
    
    // On utilise la fonction mail()

     mail($to, $subject, $message, $headers);
    // On confirme l'envoie du mail
             echo (" mail envoyé ");  
        }
    
require'footer.php';

?>

<html>
<h1>  envoie du mail bouton </h1>
     <form  action="" method="post">
         <h2><button type="submit" name="mail" >Commander</button></h2>
    </form>

</html>