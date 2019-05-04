<?php
// APpel des initialisations
require 'init.var.php';
// Affichage du header
require 'header.php';
    // On Selectionne les emaims des acheteurs
    $req="SELECT email FROM acheteur";
    $qry = $db->prepare($req);
    $qry->execute();
    // On les stock dans un tableau d'objets
    $items=$qry->fetchAll(PDO::FETCH_OBJ);
// On initialise le prix du panier
$prixtotal=0;
// On initialise une variable massage pour l'envoi du mail
$message2="";
// On récapitule le panier :
echo("<header><h1>Récapitulatif de votre Panier</h1></header>
                <div class='panier'>
                    <div class='tab'>
                        <div class='tab1'>Image</div>
                        <div class='tab1'>Nom</div>
                        <div class='tab1'>Quantite</div>
                        <div class='tab1'>Prix unit</div>
                        <div class='tab1'>Prix lot</div>
                    </div>
                </div>");
    // On recherche dans la variable de session 'panier'
    foreach($_SESSION['panier']  as $key=>$value)
    {    
    // Pour chaque id stocké dans la variable de session panier,
    // On récupère ses données issues de la database
    $req="SELECT * FROM cataloguemodele cm, catalogue c WHERE c.idprod = cm.idprod AND idmodele =$key";
    
    $qry = $db->prepare($req);
    $qry->execute();
    // On les stocke dans un tableau d'objets
    $results=$qry->fetchAll(PDO::FETCH_OBJ); 
        // Pour chaque items de ce tableau
       foreach($results as $result)
       {
           // On incrémente son prix en fonction de la quantité 
           $price=$result->prix*$value;
           // On affiche ses caractéristiques
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
           // On concatène ces caractéristiques dans le message à envoyer
            $message2 .= 'Nom :'.$result->nom.' Quantite :'.$value.' Prix unite :'.$result->prix.' '."\r\n";
           // on incrémente le prix total du panier
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
     $message = 'Bonjour !'."\r\n".'Nous avons le plaisir de vous confirmer votre commande chez ECE Amazon. '."\r\n".'Vous avez commandé les produits suivants :'."\r\n".$message2."\r\n".' prix total de la commande: '.$prixtotal."\r\n";
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
<h1>  envoi du mail bouton </h1>
    <form action='stock_nbvendu.php' methode='post'>
        <button type='submit' name='fichiersource' value='panier.php'>Commander</button>                               
    </form>

</html>