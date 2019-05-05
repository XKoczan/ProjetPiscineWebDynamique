<!DOCTYPE html>
<html>
<body>
<h4>Modifier la page vendeur</h4>
<form method="POST" enctype="multipart/form-data">
    <table>
        <tr>
            <td>Image de Profil: </td>
            <td><input type="file" name="profil" id="profil" placeholder="Insérez votre photo de profil" required> </td>
        </tr>
        <tr>
            <td>Image de fond </td>
            <td><input type="file" name="fond" id="fond" placeholder="Insérez votre photo de fond" required></td>
        </tr>
        <tr>
            <td><input type="submit" name="Modifier"></td>
        </tr>
    </table>
</form>
</body>
<?php
session_start();
//au dessus un formulaire pour récupérer les nouvelles images
//on initialise ici les variables de connexion et créé la connexion
$servername = "localhost";
$username = "root";
$password = "";
$dbname="ecesale";
$conn = mysqli_connect($servername, $username, $password,$dbname);
//on vérifie que la connexion a bien été établie
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//on écrit et éxécute la requête SQL pour pouvoir récupérer le nom du vendeur et les noms des anciennes images
$sql="SELECT nom , photo, fond FROM vendeur WHERE idvendeur LIKE ".$_SESSION['id'];
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result))
    {
        $nom=$row['nom'];
        $fond=$row['fond'];
        $profil=$row['photo'];
    }
}
//on défini le dossier cible, on le créé si il ne l'est pas (par sécurité pour le fonctionnement du code). 
$target_dir="vendeur/".$nom."/";
if(!is_dir($target_dir))
        {
            mkdir($target_dir,0777,"recursive");
        }
//on définit une variable de retour si le code s'éxécute correctement
$canreturn=true;
//cette partie s'enclenche quand les champs sont remplis et que le bouton est appuyé
if(isset($_POST['Modifier']))
{
    //on définit le filepath des deux fichiers, et on récupère leurs extensions pour après
    $target_fond=$target_dir.basename($_FILES["fond"]["name"]);
    $filetypefond=strtolower(pathinfo($target_fond,PATHINFO_EXTENSION));
    $target_profil=$target_dir.basename($_FILES["profil"]["name"]);
    $filetypeprofil=strtolower(pathinfo($target_profil,PATHINFO_EXTENSION));
    //on vérifie que le fichier existe et a été upload
    if(file_exists($_FILES['profil']['tmp_name']) && is_uploaded_file($_FILES['profil']['tmp_name']))
    {
        //on vérifie que le fichier est une image
        $check=getimagesize($_FILES["profil"]["tmp_name"]);
        if($check !== false)
        {
            //on vérifie que le fichier n'existe pas déjà dans le dossier pour ne pas avoir à le reupload
            if(!file_exists($target_profil))
            {
                if ($_FILES["profil"]["size"] < 550000)
                {
                    if($filetypeprofil =="jpg" || $filetypeprofil == "png" || $filetypeprofil == "jpeg")
                    {
                        if (move_uploaded_file($_FILES["profil"]["tmp_name"], $target_profil)) 
                        {
                            unlink("vendeur"."/".$nom."/".$profil);
                            $sql="UPDATE vendeur SET photo='".$_FILES["profil"]["name"]."' WHERE idvendeur=".$_SESSION['id'];
                            mysqli_query($conn, $sql);
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
                            unlink("vendeur"."/".$nom."/".$fond);
                            $sql="UPDATE vendeur SET fond='".$_FILES["fond"]["name"]."' WHERE idvendeur=".$_SESSION['id'];
                            mysqli_query($conn, $sql);
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
    if($canreturn==true)
    {
        header("Location:http://www.localhost/pagevendeur.php");
    }
}
?>

</html>