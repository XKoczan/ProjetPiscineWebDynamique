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
           // On concatène ces caractéristiques dans le message à envoyer
            $message2 .= 'Nom :'.$result->nom.' Quantite :'.$value.' Prix unite :'.$result->prix.' '."\r\n";
           // on incrémente le prix total du panier
           $prixtotal+=$value*$result->prix;
       }
    }
// On récupère le mail de l'acheteur sur la BDD

    foreach($items as $item)
    {
             
   
        
    if(isset($_POST['mail'])){
    //On complète les éléments nécessaire pour envoyer le mail avec l'adresse client
     $to = $item->email;
     $subject = 'Confirmation de commande chez ECE Amazon';
     $message = 'Bonjour M./Mme. '.$_POST['Nom_carte'].','. "\r\n".'Nous avons le plaisir de vous confirmer votre commande chez ECE Amazon. '."\r\n".'Vous avez commandez les produits suivants :'."\r\n".$message2."\r\n".'Prix total de la commande: '.$prixtotal."\r\n".'Numero carte bleue :'.$_POST['Numero_carte']."\r\n".'Merci de votre achat'."\r\n";
     $headers = 'De: EceAmazon@webmaster.com' . "\r\n" .
     'Reply-To: EceAmazon@webmaster.com' . "\r\n" .
     'X-Mailer: PHP/' . phpversion();
    
    // On utilise la fonction mail()

     mail($to, $subject, $message, $headers);
    // On confirme l'envoie du mail
             echo (" mail envoyé ");  
        header('Location:/V10/stock_nbvendu.php');
        }
    }
require'footer.php';

?>
<html>
    
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="Formulaire-panier.css">
        <title>ECE Amazon Formulaire panier</title>
    </head>
    
    <body>
                
        <h2 >Veuillez renseigner les informations suivantes pour compléter votre commande:</h2>
             
        <form class="needs-validation" method="post">
            
            <h3 id="section">Informations de paiement:</h3><br>
            <div class="form-group"> 
                Type de carte de paiement:            
                    <Select name="Type_carte" id="champ">
                        <Option>Visa</Option>
                        <Option>MasterCard</Option>
                        <Option>American Express</Option>
                        <Option>PayPal</Option>
                    </Select><br>
            </div>
            <div class="form-group"> 
                Numéro de carte:
                <input type="number" name="Numero_carte" id="champ" required><br>
            </div>
            <div class="form-group"> 
                Nom de carte:
                <input type="text" name="Nom_carte" id="champ" placeholder="M Dupont" required><br>
            </div>
            <div class="form-group"> 
                Date d'expiration:
                <input type="month" name="Date_expiration"  placeholder="09/2019" required><br>
            </div>
            <div class="form-group"> 
                Code de sécurité bancaire:
                <input type="number" name="Code-securite"  placeholder="123" required><br>
            </div>
            <button type='submit' name='mail' value='panier.php' >Commander</button>
        </form>
    
    </body>
    
</html>


