<?php


    $mysqli = new mysqli('127.0.0.1', 'root', '','ecesales');
    $query="";
    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') '
                . $mysqli->connect_error);
    }
    echo '<p>Connection OK '. $mysqli->host_info.'</p>';
    echo '<p>Server '.$mysqli->server_info.'</p>';
    
$query = "SELECT * FROM catalogue WHERE categorie LIKE 'vetement'";
$array=array();
$comp=array();
$compteur = 0;




 
if ($result = $mysqli->query($query)) {
 
    /* fetch associative array */
    while ($row = $result->fetch_assoc()) {
        $field1name = $row["idprod"];
        $field2name = $row["nom"];
        $field3name = $row["fournisseur"];
        $field4name = $row["categorie"];
        $field5name = $row["couleur"];
        $field6name = $row["taille"];
        $field7name = $row["prix"];
        $field8name = isset($row["photos"])?$row["photos"]: "";
        $field9name = isset($row["vidéo"])?$row["vidéo"]: "";
        $field10name = $row["description"];
        
         foreach($row as $key => $value)
        {
            $comp[$compteur]=$value;
        }
        
        echo ("<html>
                <tr> 
                                    
                  <td><img src='.$field8name.' ></td><br>
                  <h6><td>'.$field2name.'</td><br>
                  <td>Couleur: '.$field5name.'</td><br> 
                  <td>Taille:'.$field6name.'</td><br>
                   
                  <td>Prix:'.$field7name.'€</td><br>
                  <td>Fournisseur: '.$field3name.'</td><br>
                  <td>Description: '.$field10name.'</td></h6><br>
                  <td>Compteur :'.$compteur.'</td><br>;
                  
                  <td><a href='\article.php?id=".$row["idprod"]."'>Fiche de l'objet</a></td><br>
              </tr>
              
              </html>");
      

    }
    
   
    /* free result set */
    $result->free();
}




?>

