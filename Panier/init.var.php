<?php
  $host='localhost';
    $username='root';
    $password='';
    $database='ecesales';

    try{$db=new PDO('mysql:host='.$host.';dbname='.$database,$username,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
       }catch(PDOException $e){
        die('connection impossible');
    }
if(!isset($_SESSION))
    {
        session_start();

    }
    if(!isset($_SESSION['panier']))
    {
        $_SESSION['panier']=array();
    }
?>
    
