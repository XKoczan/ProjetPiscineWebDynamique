<?php
// Appel du fichier d'initialisation
require 'init.var.php';
// Appel de l'en-tête
require 'header.php';
// Variable temporaire pour la verification des stocks
$temp=1;
// On récupère le nom de la page précédente pour un éventuel retour
$namefic=isset($_POST['nomfic'])?$_POST['nomfic']: "";

// Si l'id est bien récupéré
if(isset($_POST['id']))
{    // Si la valeur reçu est égale à 1 (on distingue le cas ou on arrive sur la page sans savoir les différentes variations d'items)
    if($_POST['val']==1)
    {
        // Requete sql : on cherche l'ensemble des items de notre base de donnée ayant comme ID de produit la valeur reçue la page précédente
        $data=array('id' => $_POST['id']);
        $req='SELECT * FROM catalogue c, cataloguemodele cm WHERE c.idprod = cm.idprod AND cm.idprod = :id';

        $qry = $db->prepare($req);
        $qry->execute($data);
        // On les stock dans un tableau d'objets
        $result=$qry->fetchAll(PDO::FETCH_OBJ);  
        // Si ce tableau ne contient aucun objet
        if(count($result)==0)
        {
            //Il n'y a aucun item à supprimer
            echo("<header><h1>Il n'y a aucun article à supprimer </h1></header>");;
        }
        if(count($result)==1)
        {// Si ce tableau ne contient qu'un seul objet (il n'y a qu'une variation de l'item)
            // On Supprime l'article
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
        }//sinon 
        else{

            // On lance une boucle d'affichage
            foreach($result as $item)
            {
                //Si le stock n'est pas null
               if($item->stock!=0)
                {
                   // On affiche la premiere photo de l'item
                 $photo=explode(';',$item->photos);
                   // lorsque l'item est sélectionné, on recharge la page avec la valeur 2
                  echo ("
                    <div class ='catalogue'>
                        <div class='pic'><img src='$photo[0]' style='height:100%; width:100%;'></div>
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
    }// Si la valeur est égale à 2
    if($_POST['val']==2)
     {      
            // On supprime l'item avec l'id correspondant
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

    
 