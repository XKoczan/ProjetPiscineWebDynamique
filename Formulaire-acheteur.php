<head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="Formulaire-panier.css">
        <link rel="icon" href="ECE-Paris.ico" />
        <title>ECE Amazon Formulaire d'inscription acheteur</title>
</head>

<?php
//Connection à la base de données en PDO
    $host='localhost';
    $username='root';
    $password='';
    $database='ecesales';

    try{$db=new PDO('mysql:host='.$host.';dbname='.$database,$username,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
       }catch(PDOException $e){
        die('connection impossible');
    }
//Si le bouton est pressé
if(isset($_POST['Inscription'])){
    
if($_POST['Mdp']==$_POST['Mdp2']){
    
    //On génère un random pour la variable de sécurité sel présente aussi dans notre BDD
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $sel="";
    $charactersLength = strlen($characters);
    for($i=0;$i<32;$i++)
    {
         $sel .= $characters[rand(0, $charactersLength - 1)];
    }
    //On sécurise le mot de passe
    $mdp=hash("sha3-256",$_POST['Mdp'].$sel);
    
    //On concatene les infos de paiement dans une variable
    $paiement=$_POST["Type_carte"].$_POST["Numero_carte"].$_POST["Nom_carte"].$_POST["Date_expiration"].$_POST["Code_securite"];
    $paiement=hash("sha3-256",$paiement);

    //insertion dans bdd
    $insertdb = $db->prepare('INSERT INTO acheteur(email,sel,password,nom,prenom,paiement,adresse1,adresse2,ville,codepostal,pays,numerodetel) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)');
    $insertdb->execute(array($_POST['Email'],$sel,$mdp,$_POST['Nom'],$_POST['Prenom'],$paiement,$_POST['Adresse1'],$_POST['Adresse2'],$_POST['Ville'],$_POST['Code_postal'],$_POST['Pays'],$_POST['Telephone']));
    
    //Si on a bien 1 élément pris en compte
    if($insertdb->rowCount()==1)
    {
        
        echo '<div id="inscription_message">Votre inscription a bien été prise en compte</div>';
    }
    
}else{
        echo "Les mots de passes ne sont pas identiques";
    
    }
    
    
}

?>
<html id="acheteur">
    
    <a href="ProjetPiscine.html"><img id="logo" src="ECE-Paris.jpg" width= 20% height= 20%></a>
    <form  action="" method="post">
        
        <h3 id="section">Informations générales</h3>
        <img src="user.png" style="float : right">
            <div class="form-group">
                Nom:
                <input type="text" name="Nom" placeholder="Nom" required>
            </div>
             <div class="form-group"> 
                Prénom:
                <input type="text" name="Prenom" placeholder="Prénom" required>
            </div>
             <div class="form-group"> 
                 Adresse1
                <input type="text" name="Adresse1" placeholder="Adresse1" required>
            </div>
            <div class="form-group"> 
                 Adresse2
                <input type="text" name="Adresse2" placeholder="Adresse2">
            </div>
        <div class="form-group"> 
                Ville:
                <input type="text" class="form-control" name="Ville" id="champ" placeholder="Paris" required><br>
            </div>
            <div class="form-group"> 
                Code postal:
                <input type="number" class="form-control" name="Code_postal" id="champ" placeholder="75000" required><br>
            </div>
            <div class="form-group"> 
                Pays:
                <input type="text" class="form-control" name="Pays" id="champ" placeholder="Pays" required><br>
            </div>
            <div class="form-group"> 
                Téléphone:
                <input type="tel" class="form-control" name="Telephone" id="champ" placeholder="06 65 xx xx xx" required><br>
            </div>
             <div class="form-group"> 
                 Email:
                <input type="email" name="Email" placeholder="Email" required>
            </div>
             <div class="form-group"> 
                 Mot de passe:
                <input type="password" name="Mdp" placeholder="Mot de passe" required>
            </div>
             <div class="form-group"> 
                 Vérifier le mot de passe:
                <input type="password" name="Mdp2" placeholder="Mot de passe" required>
            </div>

        <h3 id="section">Informations de paiement:</h3><br>
                <img src="carte.png" style="float : right">
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
                    <input type="number" name="Code_securite"  placeholder="123" required><br>
                </div>

        <input type="submit" id="bouton" name="Inscription" value="S'inscrire">
        
    </form>
    
</html>