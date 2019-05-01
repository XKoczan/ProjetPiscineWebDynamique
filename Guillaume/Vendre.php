<? php 
            $mysqli = new mysqli('127.0.0.1', 'root', '', 'famille');

        if ($mysqli->connect_error) {
            die('Connect Error (' . $mysqli->connect_errno . ') '
                    . $mysqli->connect_error);
        }
        echo '<p>Connection OK '. $mysqli->host_info.'</p>';
        echo '<p>Server '.$mysqli->server_info.'</p>';


        $nom=isset($_POST['Nom'])?$_POST['Nom'] : "";
        $fournisseur=isset($_POST['Fournisseur'])?$_POST['Fournisseur'] : "";
        $categorie=isset($_POST['Categorie'])?$_POST['Categorie'] : "";
        $couleur=isset($_POST['Couleur'])?$_POST['Couleur'] : "";
        $taille=isset($_POST['Taille'])?$_POST['Taille'] : "";
        $prix=isset($_POST['Prix'])?$_POST['Prix'] : "";
        $photo=isset($_POST['Photo'])?$_POST['Photo'] : "";
        $video=isset($_POST['Video'])?$_POST['Video'] : "";
        $description=isset($_POST['Description'])?$_POST['Description'] : "";

        if($categorie!="" && $prix="")
        {echo ("Vente soumise");}
        else{echo("Vente non soumise, revoyez les éléments dans les champs");}
?>
     