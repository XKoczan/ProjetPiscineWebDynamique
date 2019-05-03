<?php
require 'init.var.php';
require 'header.php';    
if(isset($_POST['id']))
{
    $data=array('id' => $_POST['id']);  
    $req='DELETE FROM vendeur WHERE idvendeur = :id';
    $qry = $db->prepare($req);
    $qry->execute($data); 
    header("Location:http://www.localhost/admin.php");
}
$req="SELECT * FROM vendeur";
$qry = $db->prepare($req);
$qry->execute();
$items=$qry->fetchAll(PDO::FETCH_OBJ);
echo("<header><h1>Liste des vendeurs</h1></header>");

foreach($items as $item)
{
    echo ("
        <div class ='catalogue'>
        <div class='pic'><img src='/vendeur/$item->nom/$item->photo' style='height:100%; width:100%;'></div>
        <div class='nom'>$item->nom</div>
        <div class='panierpic'>
        <form method='post'>
        <input type='hidden' name='val' value='1'>
        <button name='id' value ='$item->idvendeur' type='submit'><img src='trash.jpg' style='height:100%; width:100%;'>
        </button>
        </form>
        ");             
}
require'footer.php';
?>