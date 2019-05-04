<!DOCTYPE html>
<html>
<body>
<h4>Modifier la page vendeur</h4>
<form method="POST" enctype="multipart/form-data">
    <table>
        <tr>
            <td>Image de Profil: </td>
            <td><input type="file" name="profil" id="profil"></td>
        </tr>
        <tr>
            <td>Image de fond </td>
            <td><input type="file" name="fond" id="fond"></td>
        </tr>
        <tr>
            <td><input type="submit" name="Modifier"></td>
        </tr>
    </table>
</form>
</body>
<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname="ecesale";

//create connection
$conn = mysqli_connect($servername, $username, $password,$dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
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
$target_dir="vendeur/".$nom."/";
if(!is_dir($target_dir))
        {
            mkdir($target_dir,0777,"recursive");
        }
$canreturn=true;
if(isset($_POST['Modifier']))
{
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