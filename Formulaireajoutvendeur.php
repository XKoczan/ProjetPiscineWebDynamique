<head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="Formulaire-panier.css">
        <link rel="icon" href="ECE-Paris.ico" />
        <title>ECE Amazon Formulaire d'ajout de vendeur'</title>
</head>

<?php
//Connection à la base de données en PDO
    $host='localhost';
    $username='root';
    $password='';
    $database='ecesale';

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

    //insertion dans bdd
    $insertdb = $db->prepare('INSERT INTO vendeur(email,sel,password,nom,photo,fond) VALUES(?,?,?,?,?,?)');
    $insertdb->execute(array($_POST['Email'],$sel,$mdp,$_POST['Nom'],$_POST['image'],$_POST['Fond']));
    
    //Si on a bien 1 élément pris en compte
    if($insertdb->rowCount()==1)
    {
        
        echo '<div id="inscription_message">ajout vendeur effectué</div>';
    }
    
}else{
        echo "Les mots de passes ne sont pas identiques";
    
    }
    
    
}

?>
<html>
    
    <a href="ProjetPiscine.html"><img id="logo" src="ECE-Paris.jpg" width= 20% height= 20%></a>
    <form  action="" method="post">
        
        <h3 id="section">Informations générales du vendeur pour ajout</h3>
        <img src="user.png" style="float : right">
            <div class="form-group">
                Nom:
                <input type="text" name="Nom" placeholder="Nom" required>
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
            <div class="form-group">
                Photo:
                <input type="text" name="image" placeholder="Nom de la photo .png .jpg" required>
            </div>
            <div class="form-group">
                Image photo
                <input type="file" name="Image_photo">
            </div>
            <div class="form-group">
                Fond:
                <input type="text" name="Fond" placeholder="Nom du fond .jpg .png" required>
            </div>
        <div class="form-group">
                Image fond
                <input type="file" name="Image_fond">
            </div>
        
        <input type="submit" id="bouton" name="Inscription" value="Ajouter Vendeur">
        
    </form>
    
</html>