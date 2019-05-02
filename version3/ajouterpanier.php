<?php
require 'init.var.php';
require 'header.php';

$temp=1;
$namefic=isset($_POST['nomfic'])?$_POST['nomfic']: "";
if(isset($_POST['id'])){
    if($_POST['val']==1)
    {
        $data=array('id' => $_POST['id']);
        $req='SELECT * FROM catalogue c, cataloguemodele cm WHERE c.idprod = cm.idprod AND cm.idprod = :id';

        $qry = $db->prepare($req);
        $qry->execute($data);
        $result=$qry->fetchAll(PDO::FETCH_OBJ);  
        
        if(count($result)==1)
        {
            if(!isset($_SESSION['panier'][$result[0]->idmodele]))
            {
                $_SESSION['panier'][$result[0]->idmodele]=1;    
                echo("Le produit a bien ete ajoute <a href='$namefic'>retour au catalogue</a>");
            }else{
                $temp=$_SESSION['panier'][$result[0]->idmodele];
                
                 if($temp >= $result[0]->stock)
                    {
                        echo("vous avez atteint le nombre maximum d'articles disponibles pour ce produit <a href='javascript:history.back()'>retour au catalogue</a>");
                    }
                else{$_SESSION['panier'][$result[0]->idmodele]+=1;
                     echo("Le produit a bien ete ajoute <a href='$namefic'>retour au catalogue</a>");}

                }

        }
        else{

            echo("<header><h1>Veuillez choisir votre article </h1></header>");

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
                             <form action='ajouterpanier.php' method ='post'>
                                <input type='hidden' name='val' value='2'>
                                <input type='hidden' name='nomfic' value='Vetements.php'>
                                <button name='id' value ='$item->idmodele' type='submit'><img src='panier.jpg' style='height:100%; width:100%;'>
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
        $req='SELECT * FROM catalogue c, cataloguemodele cm WHERE c.idprod = cm.idprod AND cm.idmodele = :id';

        $qry = $db->prepare($req);
        $qry->execute($data);
        $result=$qry->fetchAll(PDO::FETCH_OBJ);
        
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
    
    
    
    
    
else{
    die("aucun produit selectionne");
}
?>

    
 