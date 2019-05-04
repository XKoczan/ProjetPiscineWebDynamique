<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname="ecesale";

//create connection
$conn = mysqli_connect($servername, $username, $password,$dbname);
if(isset($_SESSION['is_admin']))
{
    unset($_SESSION['is_admin']);
}
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


if(isset($_POST['Connexion'])){
    if(empty($_POST['login'])||empty($_POST['password'])){
        ?><span><?php echo "Remplissez tout les champs";?></span><?php
    }
    else{
        $login=htmlspecialchars($_POST['login']);
        $password=htmlspecialchars($_POST['password']);
        $sql = "SELECT idacheteur, email, sel, password FROM acheteur WHERE email='".$login."'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) 
        {
            $password=hash('sha3-256',$password.$row['sel']);
            if($password==$row["password"])
            {
                $_SESSION['id']=$row["idacheteur"];
                if($_GET['origine']=="header")
                {
                    header("Location:http://www.localhost/moncompte.php");
                }
                else{
                    header("Location:http://www.localhost/formulairepanier.php");
                }
            }
            else
            {
                ?><span><?php echo "Nom d'utilisateur ou mot de passe incorrect".$password.$login;?></span><?php
            }

        }
    } else {
        ?><span><?php echo "Nom d'utilisateur incorrect ou mot de passe incorrect".$password.$login;?></span><?php
    }
    }
    
}
require 'header.php';
require 'footer.php';
mysqli_close($conn);
?>
<html>
<head>
    <link rel="stylesheet" href="formulaireconnexion.css">
</head>
<body>
<h1> Formulaire de Connexion </h1>
<form method="POST">
    <table>
        <tr>
            <td>Login: </td>
            <td><input type="text" name="login" class="champ"placeholder="login"></td>
        </tr>
        <tr>
            <td>Password: </td>
            <td><input type="text" name="password" class="champ" placeholder="password"></td>
        </tr>
        <tr>
            <td><input type="submit" class="valider" name="Connexion"></td>
        </tr>
    </table>
<a id="creercompte" href="formulaireacheteur">Pas de compte? Inscrivez-vous.</a>
</form>
</body>
</html>