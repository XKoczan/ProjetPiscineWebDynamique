<?php
require 'init.var.php';
require 'header.php';

$temp=1;
$namefic=isset($_POST['nomfic'])?$_POST['nomfic']: "";


if(isset($_POST['id']))
{
    if($_POST['val']==1)
    {
        $data=array('id' => $_POST['id']);
        $req='SELECT * FROM catalogue c, cataloguemodele cm WHERE c.idprod = cm.idprod AND cm.idprod = :id';

        $qry = $db->prepare($req);
        $qry->execute($data);
        $result=$qry->fetchAll(PDO::FETCH_OBJ);  
        if(count($result)==0)
        {
            echo("<header><h1>Il n'y a aucun article à supprimer </h1></header>");;
        }
        if(count($result)==1)
        {
            echo("<header><h1>Veuillez choisir l'article à supprimer </h1></header>");
            $data=array('id' => $_POST['id']);
            $req='DELETE FROM catalogue  WHERE idprod = :id';
            $qry = $db->prepare($req);
            $qry->execute($data); 
            
            $req='DELETE FROM cataloguemodele  WHERE idprod = :id';
            $qry = $db->prepare($req);
            $qry->execute($data);
            echo(   "Supression réussie 
                        <button><a href='$namefic'>retour au catalogue</a></button>
                        <button><a href='admin.php'>retour au menu administrateur</a></button>");
        }
        else{

            
            foreach($result as $item)
            {

               if($item->stock!=0)
                {

                  echo ("
                    <div class ='catalogue'>
                        <div class='pic'><img src='$item->photos' style='height:100%; width:100%;'></div>
                        <div class='nommodele'>$item->nommodele</div>
                        <div class='prix'>$item->prix €</div>
                        <div class='panierpic'>
                             <form action='pageitem.php' method ='post'>
                                <input type='hidden' name='val' value='2'>
                                <button id ='button' name='id' value ='$item->idmodele' type='submit'><img src='trash.jpg' style='height:100%; width:100%;'>
                                </button>
                            </form>
                        </div>
                        <div class='desc'> Description du produit: $item->description</div>
                    </div>
                    ");  


                }
            }
        }
    }
    if($_POST['val']==2)
     {  
            
            $data=array('id' => $_POST['id']);
            $req='DELETE FROM cataloguemodele  WHERE idmodele = :id';
            $qry = $db->prepare($req);
            $qry->execute($data);
            echo(   "Supression réussie 
                        <button><a href='$namefic'>retour au catalogue</a></button>
                        <button><a href='admin.php'>retour au menu administrateur</a></button>");
    }
    
}
       
    
else{
    die("aucun produit selectionne");
}


require 'footer.php';
?>

    
 