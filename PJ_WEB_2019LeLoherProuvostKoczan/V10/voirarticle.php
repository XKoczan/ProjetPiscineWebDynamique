<html>
<head>
<link rel="stylesheet" href="http://getbootstrap.com/dist/css/bootstrap.min.css"/>
<link rel="stylesheet" href="ProjetPiscine.css"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
</head>
<?php
session_start();
if(!isset($_SESSION['panier']))
{
  $_SESSION['panier']=array();
}
if(isset($_POST['acheter']))
{
  // Si aucun item n'a encore été ajouté au panier
  if(!isset($_SESSION['panier'][$_POST["idmodele"]]))
  {
      // On ajoute celui ci
      $_SESSION['panier'][$_POST["idmodele"]]=1;    
      header("Location:/V10/panier.php");
  }//Sinon
  else{ //On inscrit la quantité de cet item dans le panier à la variable temporaire
      $temp=$_SESSION['panier'][$_POST["idmodele"]];
      // On vérifie que celle ci n'excède pas le nombre d'items contenus en stock pour cet id
       if($temp >= $_POST["stock"])
          {
              // Si elle est excédentaire on affiche un message d'erreur
              echo("vous avez atteint le nombre maximum d'articles disponibles pour ce produit <a href='panier.php'>Voir le panier</a>");
          }
      //Sinon
      else{// On incrémente la quatité de l'item dans notre panier 
          $_SESSION['panier'][$_POST["idmodele"]]+=1;
          // On envoie un message de confirmation et une proposition de retour au catalogue
          header("Location:/V10/panier.php");}
      }
}
require "header.php";
$servername = "localhost";
$username = "root";
$password = "";
$dbname="ecesale";
//create connection
$conn = mysqli_connect($servername, $username, $password,$dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if(!isset($_GET['set_modele'])){
    $sql="SELECT * FROM cataloguemodele cm, catalogue c WHERE c.idprod=".$_POST['id']." AND c.idprod = cm.idprod ORDER BY cm.`nb_vente` DESC";
}else{
    $sql="SELECT * FROM cataloguemodele cm, catalogue c WHERE cm.idmodele=".$_GET['modele']." AND cm.idprod=c.idprod";
}
$result = mysqli_query($conn, $sql);
$i=0;
while($row = mysqli_fetch_assoc($result)) 
{
    if($i==0)
    {
        $nom=$row['nom'];
        $variante=$row['variantes'];
        $variantes=explode(";",$variante);
        $nommodele=$row['nommodele'];
        $idmodele=$row['idmodele'];
        $prix=$row['prix'];
        $photo=$row['photos'];
        $photos=explode(";",$photo);
        $idprod=$row['idprod'];
        $video=$row['video'];
        $description=$row['description'];
        $stock=$row['stock'];
    }
    $tempid=$row['idmodele'];
    $tempnom=$row['nommodele'];
    if(!isset($_GET['set_modele']))
    {
      if($i==0){
        $nommodeles=$row['nommodele'];
        $idmodeles=strval($idmodele);
      }else{
        $nommodeles=$nommodeles.";".$tempnom;
        $idmodeles=$idmodeles.";".strval($tempid);
      }
    }
    $i=1;
}
if(isset($_GET['set_modele']))
{
  $nommodeles=$_GET['nommodeles'];
  $idmodeles=$_GET['idmodeles'];
}
?>

<body>
<h1><?php echo $nom."  ".$nommodele ?></h1>
<div id="carouselExampleControls" class="catalogue" data-interval="false">
  <div class="carousel-inner">
    <?php
    for($i=0;$i<sizeof($photos);$i++)
    {
      if($i==0)
      {
        echo "<div class='carousel-item active'><img class='d-block w-100' src='/V10/catalogue/".$idprod."/".$photos[$i]."' alt='First slide'></div>";
      }
      else{
        echo"<div class='carousel-item'><img class='d-block w-100' src='/V10/catalogue/".$idprod."/".$photos[$i]."' alt='".$photos[$i]."'></div>";
      }
    }
    if($video!="")
    {
      echo"<div class='carousel-item'><video controls class='d-block w-100' src='/V10/catalogue/".$idprod."/".$video."'></video></div>";
    }
    ?>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
    <div class="infos2">
    <div class="prix2">Prix: <?php echo $prix ?>€</div><br>
    <div class="description">Description: <?php echo $description ?></div><br>
    <div class="stock">Stock: <?php echo $stock ?></div><br>
</div> 
</div>
       
    


<?php
  if(!is_null($nommodeles))
  {
    echo"<div class='boutons_modeles'>Modèles:";
    $array_modeles=explode(";",$idmodeles);
    $array_nom_modeles=explode(";",$nommodeles);
    for($j=0;$j<sizeof($array_modeles);$j++)
    {
      echo"<form method='get'><input type='hidden' name='idmodeles' value='".$idmodeles."'><input type='hidden' name='nommodeles' value='".$nommodeles."'><input type='hidden' name='modele' value='".$array_modeles[$j]."'><input type='submit' name='set_modele' value='".$array_nom_modeles[$j]."' class='boutonmodele'></form><br>";
    }
    echo"</div>";
  }
  if(!is_null($variante))
  {
    echo"<div class='boutons_variantes'>Variantes:<form method='POST'>";
    for($j=0;$j<sizeof($variantes);$j++)
    {
      echo"<input type='radio' name='variante' value='".$variantes[$j]."'><br>";
    }
    echo"</div><div class='acheter'>";

  }else{
    echo"<div class='acheter'><form method='POST'>";
  }
  echo"<input type=hidden name='idmodele' value='".$idmodele."'><input type=hidden name='stock' value='".$stock."'><input type=hidden name='id' value='".$idprod."'>";
  ?>
  <input type="submit" id="acheter" name="acheter">
 