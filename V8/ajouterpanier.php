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
if(isset($_POST['id'])){
    // Si la valeur reçu est égale à 1 (on distingue le cas ou on arrive sur la page sans savoir les différentes variations d'items)
    if($_POST['val']==1)
    {
        // Requete sql : on cherche l'ensemble des items de notre base de donnée ayant comme ID de produit la valeur reçue la page précédente
        $data=array('id' => $_POST['id']);
        $req='SELECT * FROM catalogue c, cataloguemodele cm WHERE c.idprod = cm.idprod AND cm.idprod = :id';

        $qry = $db->prepare($req);
        $qry->execute($data);
        // On les stock dans un tableau d'objets
        $result=$qry->fetchAll(PDO::FETCH_OBJ);  
        // Si ce tableau ne contient qu'un seul objet (il n'y a qu'une variation de l'item)
        if(count($result)==1)
        {
            // Si aucun item n'a encore été ajouté au panier
            if(!isset($_SESSION['panier'][$result[0]->idmodele]))
            {
                // On ajoute celui ci
                $_SESSION['panier'][$result[0]->idmodele]=1;    
                echo("Le produit a bien ete ajoute <a href='$namefic'>retour au catalogue</a>");
            }//Sinon
            else{ //On inscrit la quantité de cet item dans le panier à la variable temporaire
                $temp=$_SESSION['panier'][$result[0]->idmodele];
                // On vérifie que celle ci n'excède pas le nombre d'items contenus en stock pour cet id
                 if($temp >= $result[0]->stock)
                    {
                        // Si elle est excédentaire on affiche un message d'erreur
                        echo("vous avez atteint le nombre maximum d'articles disponibles pour ce produit <a href='javascript:history.back()'>retour au catalogue</a>");
                    }
                //Sinon
                else{// On incrémente la quatité de l'item dans notre panier 
                    $_SESSION['panier'][$result[0]->idmodele]+=1;
                    // On envoie un message de confirmation et une proposition de retour au catalogue
                     echo("Le produit a bien ete ajoute <a href='$namefic'>retour au catalogue</a>");}

                }

        }// Si le tableau ne contient pas qu'un seul objet (il y a plusieurs variations de l'item)
        else{
            // On demande à l'utilisateur de choisir quelle variation de l'item il souhaite
            echo("<header><h1>Veuillez choisir votre article </h1></header>");
            // On affiche les objets qu'ils peut sélectionner
            foreach($result as $item)
            {
                // S'il sont encore en stock
               if($item->stock!=0)
                {
                   // On n'affiche que la première photo de la liste de photos
                 $photo=explode(';',$item->photos);
                    // Si l'utilisateur sélectionne cet item, on relance la page avec une valeur égale à 2
                  echo ("
                    <div class ='catalogue'>
                        <div class='pic'><img src='$photo[0]' style='height:100%; width:100%;'></div>
                        <div class='nommodele'>$item->nommodele</div>
                        <div class='prix'>$item->prix €</div>
                        <div class='panierpic'>
                             <form action='ajouterpanier.php' method ='post'>
                                <input type='hidden' name='val' value='2'>
                                <input type='hidden' name='nomfic' value='Vetements.php'>
                                <button id ='button' name='id' value ='$item->idmodele' type='submit'><img src='panier.jpg' style='height:100%; width:100%;'>
                                </button>
                            </form>
                        </div>
                        <div class='desc'> Description du produit: $item->description <a href='photos.php'>voir photos de l'article</a></div>
                    </div>
                    ");  


                }
            }
        }
    } // Si la valeur est égale à 2
    if($_POST['val']==2)
     {  
        // On recherche directement la variation désirée 
        $data=array('id' => $_POST['id']);
        $req='SELECT * FROM catalogue c, cataloguemodele cm WHERE c.idprod = cm.idprod AND cm.idmodele = :id';

        $qry = $db->prepare($req);
        $qry->execute($data);
        // On la stock dans un tableau d'objets
        $result=$qry->fetchAll(PDO::FETCH_OBJ);
        // on l'ajoute au panier
        if(!isset($_SESSION['panier'][$result[0]->idmodele]))
            {
                $_SESSION['panier'][$result[0]->idmodele]=1;    
                echo("Le produit a bien ete ajoute <a href='$namefic'>retour au catalogue</a>");
            }else{
                $temp=$_SESSION['panier'][$result[0]->idmodele];
               
                 if($temp >= $result[0]->stock)
                    {
                        echo("vous avez atteint le nombre maximum d'articles disponibles pour ce produit <a href='$namefic'>retour au catalogue</a>");
                    }
                else{$_SESSION['panier'][$result[0]->idmodele]+=1;
                     echo("Le produit a bien ete ajoute <a href='$namefic'>retour au catalogue</a>");}

                }

        
    }
    
}
    
    
    
    
    
else{ // Si l'id n'est pas reçu, on affiche un message d'erreur
    die("aucun produit selectionne");
}

// On affiche le pied de page
require 'footer.php';
?>

    
 