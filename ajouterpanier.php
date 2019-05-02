<?php
require 'init.var.php';
$temp=1;

if(isset($_GET['id'])){
    $data=array('id' => $_GET['id']);                   
    $req='SELECT * FROM catalogue c, cataloguemodele cm WHERE c.idprod = cm.idprod AND cm.idmodele = :id';
    
    $qry = $db->prepare($req);
    $qry->execute($data);
    $result=$qry->fetchAll(PDO::FETCH_OBJ);  
    $temp2=$result[0]->stock;
    
    if(!isset($_SESSION['panier'][$result[0]->idmodele]))
    {
        $_SESSION['panier'][$result[0]->idmodele]=1;    
        echo("Le produit a bien ete ajoute <a href='javascript:history.back()'>retour au catalogue</a>");
    }else{
        
        foreach($_SESSION as $elem){
            
            foreach($elem as $value)
                {
                    
                    $temp=$value;
                    
                    
                }
                }
         if($temp >= $result[0]->stock)
        {
            echo("vous avez atteint le nombre maximum d'articles disponibles pour ce produit <a href='javascript:history.back()'>retour au catalogue</a>");
        }
        else{$_SESSION['panier'][$result[0]->idmodele]+=1;
             echo("Le produit a bien ete ajoute <a href='javascript:history.back()'>retour au catalogue</a>");}
         
        }
   
    }
    
    
    
else{
    die("aucun produit selectionne");
}
?>

    
 