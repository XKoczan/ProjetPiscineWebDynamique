<!DOCTYPE html>
<head>
    <title>Mon Compte</title>
    <link rel="stylesheet" href="moncompte.css" />
</head>
<body>
<?php
//on initialise les variables et appelons les header et footer. On a aussi attribuer un fichier css plus haut
session_start();
require "header.php";
require "footer.php";
$servername = "localhost";
$username = "root";
$password = "";
$dbname="ecesale";

//on créé une connexion SQL
$conn = mysqli_connect($servername, $username, $password,$dbname);

// on vérifie que la connexion fonctionne
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
    //on écrit la requête pour récupérer les informations de l'utilisateur
    $sql="SELECT email, nom, prenom, adressel1, adressel2, ville, codepostal, pays, numerodetel FROM acheteur WHERE idacheteur LIKE ".$_SESSION["id"];
    $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
        //on va afficher les informations de l'utilisateur mise en page
        while($row = mysqli_fetch_assoc($result)) 
        {   

            ?>  
                    <h2> Information sur votre compte:</h2>
                    <div id='nom'>
                        <h4>Nom: <?php echo $row["nom"];?></h4><br>
                        <h4>Prénom: <?php echo $row["prenom"];?></h4><br>
                    </div>
                    <div id='email'>
                        <h4>Adresse e-mail: <?php echo $row["email"];?></h4><br>                       
                    </div>
                    <div id='adresse'>
                        <h3>Adresse</h3><br>                               
                         <h4>Adresse Ligne 1: <?php echo $row["adressel1"];?></h4><br>
                            <h4>Adresse Ligne 2: <?php echo $row["adressel2"];?></h4><br>
                            <h4>Ville: <?php echo $row["ville"];?></h4><br>
                            <h4>Code Postal: <?php echo $row["codepostal"];?></h4><br>
                            <h4>Pays: <?php echo $row["pays"];?></h4><br>
                            <h4>Numéro de téléphone: <?php echo $row["numerodetel"];?></h4><br>
                    </div>
                    
                <?php           
        }
    }
mysqli_close($conn);
?>
</body>
</html>