<?php
// Initialisations
// Hostname
  $host='localhost';
// Username    
$username='root';
//Password    
$password='';
// Nom de la database    
$database='ecesale';
// On ouvre la database avec les informations précédentes
    try{$db=new PDO('mysql:host='.$host.';dbname='.$database,$username,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
       }catch(PDOException $e){
        die('connection impossible');
    }

// Declaration de la variable de Sessino Panier
// Si aucune session n'est démarée alors on en démarre une 
if(!isset($_SESSION))
    {
        session_start();

    }
// si aucune variable de session ne correspond à panier, on en crée une
    if(!isset($_SESSION['panier']))
    {
        $_SESSION['panier']=array();
    }
?>
    
