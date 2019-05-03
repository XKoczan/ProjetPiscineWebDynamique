<!DOCTYPE html>
<head>
    <title>Mon Compte</title>
</head>
<body>
<?php
session_start();
require 'header.php';
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
    $sql="SELECT email, nom, prenom, adressel1, adressel2, ville, codepostal, pays, numerodetel FROM acheteur WHERE idacheteur LIKE ".$_SESSION["id"];
    $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) 
        {
            ?>  
                
                    <div id='nom'>
                        <h4>Nom:</h4> <?php echo $row["nom"];?><br>
                        <h4>Prénom:</h4> <?php echo $row["prenom"];?><br>
                    </div>
                    <div id='adresse'>
                        <h3>Adresse</h3>                                <h4>Adresse Ligne 1</h4> <?php echo $row["adressel1"];?><br>
                            <h4>Adresse Ligne 2</h4> <?php echo $row["adressel2"];?><br>
                            <h4>Ville</h4> <?php echo $row["ville"];?><br>
                            <h4>Code Postal</h4> <?php echo $row["codepostal"];?><br>
                            <h4>Pays</h4> <?php echo $row["pays"];?><br>
                            <h4>Numéro de téléphone</h4> <?php echo $row["numerodetel"];?><br>
                    </div>
                    <div id='email'>
                        <h4>Adresse e-mail</h4> <?php echo $row["pays"];?><br>                       
                    </div>
                    
                <?php           
        }
    }
mysqli_close($conn);
require 'footer.php';
?>
</body>