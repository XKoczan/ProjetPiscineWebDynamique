<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname="ecesale";
$fichiersource=isset($_POST['fichiersource'])?$_POST['fichiersource']: "";
//create connection
$conn = mysqli_connect($servername, $username, $password,$dbname);

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
        $sql = "SELECT idacheteur, login, sel, password FROM acheteur WHERE login='".$login."'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) 
        {
            $password=hash('sha3-256',$password.$row['sel']);
            if($password==$row["password"])
            {
                $_SESSION['id']=$row["idacheteur"];
                header("Location:http://www.localhost/moncompte.php");
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
mysqli_close($conn);




if ($fichiersource =='pannier.php')
{
    echo("<html>
<body>

<form method='POST'>
    <table>
        <tr>
            <td>Login: </td>
            <td><input type='text' name='login' default='login'></td>
        </tr>
        <tr>
            <td>Password: </td>
            <td><input type='text' name='password' default='password'></td>
        </tr>
        <tr>
            <td><button type='submit' name='Connexion'>Connexion<a href='Formulaire-acheteur.php'></a></button></td>
        </tr>
    </table>
</form>
</body>
</html>");
}
else{
echo("<html>
<body>

<form method='POST''>
    <table>
        <tr>
            <td>Login: </td>
            <td><input type='text' name='login' default='login'></td>
        </tr>
        <tr>
            <td>Password: </td>
            <td><input type='text' name='password' default='password'></td>
        </tr>
        <tr>
            <td><button type='submit' name='Connexion'>Connexion<a href='moncompte.php'></a></button></td>
        </tr>
    </table>
</form>
</body>
</html>");
    
    
}
?>
