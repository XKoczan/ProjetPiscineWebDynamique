
<style>
    
    
     .catalogue{
        padding: 2em;
        height:150px; 
        width:250px;
        float : left;
        
    }
     .pagepanier {
        
        border-style: solid;
        border-color:antiquewhite;
        height:25px; 
        width:40;
        float : right;
        
    }
    
     .pic{
        border-style: solid;
        border-color: antiquewhite;
        height:100px; 
        width:240px;
    }
   
    .elem2 {
        
        border-style: solid;
        border-color: antiquewhite;
        height:25px; 
        width:94px;
        float : left;
        
    }
     .panierpic {
        
        border-style: solid;
        border-color: antiquewhite;
        height:25px; 
        width:40;
        float : left;
        
    }
    
    
    
    .tab{
        width:1000px;
        height: 56px;
    }
    
    .tab1{        
        float: left;
        border-style:solid;
        border-color:cadetblue;
        width:100px;
        height: 50px;
    }
        
    .elem{
        
        width:1000px;
        height: 56px;
    }
    .elem1{
        border-style: solid;
        border-color: cadetblue;
        height:50px; 
        width:100px;
        float : left;
        
    }
   
    .supp{
        float : left;
        height:50px; 
        width:100px;
    }
     
</style>


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
    
