<?php

    $host='localhost';
    $username='root';
    $password='';
    $database='ecesales';

    try{$db=new PDO('mysql:host='.$host.';dbname='.$database,$username,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
       }catch(PDOException $e){
        die('connection impossible');
    }
    
    $req="SELECT * FROM catalogue";
    $qry = $db->prepare($req);
    $qry->execute();
    $items=$qry->fetchAll(PDO::FETCH_OBJ);
    
    foreach($items as $item)
    {
        echo ("<html>
                <tr>
                    <td><img src='$item->photos'</td><br>
                    <h6><td>Idprod: $item->idprod</td><br>
                    <td>Nom: $item->nom</td> <br>
                    <td>Prix: $item->prix €</td></h6>
                </tr>
                </html>");
    }
    if(!isset($_SESSION))
    {
        session_start();
    }
    if(isset($_SESSION['panier'])){
        $_SESSION['panier']=array();
    }


?>