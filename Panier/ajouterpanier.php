<?php
require 'init.var.php';

if(isset($_GET['id'])){
    $data=array('id' => $_GET['id']);                   
    $req='SELECT idprod FROM catalogue WHERE idprod = :id';
    
    $qry = $db->prepare($req);
    $qry->execute($data);
    $result=$qry->fetchAll(PDO::FETCH_OBJ);  
    
    if(!isset($_SESSION['panier'][$result[0]->idprod]))
    {
        $_SESSION['panier'][$result[0]->idprod]=1;    
    }else{
         $_SESSION['panier'][$result[0]->idprod]=$_SESSION['panier'][$result[0]->idprod]+1;
    }
      
    die("Le produit a bien ete ajoute <a href='getdata.php'>retour au catalogue</a>");
    
}else{
    die("aucun produit selectionne");
}
?>

    
 