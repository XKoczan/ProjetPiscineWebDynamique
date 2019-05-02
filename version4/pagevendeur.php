<!DOCTYPE html>
<html>
<?php
session_start();
$_SESSION['is_admin']=false;
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
$sql="SELECT nom, photo, fond FROM vendeur WHERE idvendeur LIKE ".$_SESSION["id"];
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) 
    {
            ?>
    <body style="background-image:url(/vendeur/<?php echo $row['nom']; ?>/<?php echo $row['fond']; ?>">
        <img id="profilepicture" src="/vendeur/<?php echo $row['nom']; ?>/<?php echo $row['photo']; ?>" alt="Il manque une image de profil" />
        <div id="nom"><?php echo $row['nom']; ?></div>
        <a id="modifier" href="modifiervendeur.php">Modifier la page</a>
        <a id="ajouter" href="Vendre.php">Ajouter un produit</a>
    </body>
    <?php
    }
}
mysqli_close($conn);
?>
    
