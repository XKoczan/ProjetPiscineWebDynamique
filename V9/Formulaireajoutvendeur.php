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
    $target_dir="vendeur/".$_POST['Nom']."/";
    if(!is_dir($target_dir))
    {
        mkdir($target_dir,0777,"recursive");
    }
    $target_fond=$target_dir.basename($_FILES["fond"]["name"]);
    $filetypefond=strtolower(pathinfo($target_fond,PATHINFO_EXTENSION));
    $target_profil=$target_dir.basename($_FILES["profil"]["name"]);
    $filetypeprofil=strtolower(pathinfo($target_profil,PATHINFO_EXTENSION));
    if(file_exists($_FILES['profil']['tmp_name']) && is_uploaded_file($_FILES['profil']['tmp_name']))
    {
        $check=getimagesize($_FILES["profil"]["tmp_name"]);
        if($check !== false)
        {
            if(!file_exists($target_profil))
            {
                if ($_FILES["profil"]["size"] < 550000)
                {
                    if($filetypeprofil =="jpg" || $filetypeprofil == "png" || $filetypeprofil == "jpeg")
                    {
                        if (move_uploaded_file($_FILES["profil"]["tmp_name"], $target_profil)) 
                        {
                            $profil=$_FILES['profil']['name'];
                        }
                        else
                        {
                            ?><span><?php echo "Il y a eu une erreur lors de l'upload.Réessayez";?></span><?php
                            $canreturn=false;
                        }
                    }
                    else
                    {
                        ?><span><?php echo "l'image de profil n'est pas enregistré sous un format autorisé";?></span><?php
                        $canreturn=false;
                    }
                }
                else
                {
                    ?><span><?php echo "Le fichier profil est trop volumineux";?></span><?php
                    $canreturn=false;
                }
            }
        }
        else
        {
            ?><span><?php echo "Le fichier profil n'est pas une image";?></span><?php
            $canreturn=false;
        }
    }
    if(file_exists($_FILES['fond']['tmp_name']) && is_uploaded_file($_FILES['fond']['tmp_name']))
    {
        $check=getimagesize($_FILES["fond"]["tmp_name"]);
        if($check !== false)
        {
            if(!file_exists($target_fond))
            {
                if ($_FILES["fond"]["size"] < 550000)
                {
                    if($filetypefond =="jpg" || $filetypefond == "png" || $filetypefond == "jpeg")
                    {
                        if (move_uploaded_file($_FILES["fond"]["tmp_name"], $target_fond)) 
                        {
                            $fond=$_FILES["fond"]["name"];
                        }
                        else
                        {
                            ?><span><?php echo "Il y a eu une erreur lors de l'upload.Réessayez";?></span><?php
                            $canreturn=false;
                        }
                    }
                    else
                    {
                        ?><span><?php echo "l'image de fond n'est pas enregistré sous un format autorisé";?></span><?php
                        $canreturn=false;
                    }
                }
                else
                {
                    ?><span><?php echo "Le fichier de fond est trop volumineux";?></span><?php
                    $canreturn=false;
                }
            }
        }
        else
        {
            ?><span><?php echo "Le fichier de fond n'est pas une image";?></span><?php
            $canreturn=false;
        }
    }
    //insertion dans bdd
    $insertdb = $db->prepare('INSERT INTO vendeur(email,sel,password,nom,photo,fond) VALUES(?,?,?,?,?,?)');
    $insertdb->execute(array($_POST['Email'],$sel,$mdp,$_POST['Nom'],$profil,$fond));
    
    //Si on a bien 1 élément pris en compte
    if($insertdb->rowCount()==1)
    {
        
        header("Location:admin.php");
    }
    
}else{
        echo "Les mots de passes ne sont pas identiques";
    
    }
    
    
}
require 'header.php';
require 'footer.php';
?>

<html>
<head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="Formulaire-panier.css">
        <link rel="icon" href="ECE-Paris.ico" />
        <title>ECE Amazon Formulaire d'ajout de vendeur'</title>
</head>

    
    
    <form method="post" enctype="multipart/form-data">
        
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
                Image de profil
                <input type="file" name="profil" required>
            </div>
        <div class="form-group">
                Image de fond
                <input type="file" name="fond" required>
            </div>
        
        <input type="submit" id="bouton" name="Inscription" value="Ajouter Vendeur">
        
    </form>
    
</html>