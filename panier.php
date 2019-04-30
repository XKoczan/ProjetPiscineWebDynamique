<?php
    session_start();
    include_once("fonctionspanier.php");
   // $_SESSION['contenu']['quantite']=array();

    $id=isset($_POST['panier'])? : "";
    
if(panier())
{
    ajouterelem($id,"");
}

echo('<form action="Livres.php" method="post">
            
            <input type="submit" name="Retour au catalogue">
            </form>');
?>