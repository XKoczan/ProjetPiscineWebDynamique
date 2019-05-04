<!DOCTYPE html>
<html>
    
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <title>ECE Amazon</title>
        <link rel="icon" href="ECE-Paris.ico" />
        <link rel="stylesheet" href="ProjetPiscine.css">
        <script type="text/javascript" src="ProjetPiscine.js"></script>
        
        
    </head>
    
    <header>
            <a href="ProjetPiscine.html"><img id="logo" src="ECE-Paris.jpg" width= 20% height= 20%></a>
            <p id="lien-inscription"><a href="Formulaire-acheteur.php">S'inscrire</a></p>
            <nav class="navbar navbar-expand-md">

                 <div class="collapse navbar-collapse row"  id="navi">

                     <ul class="navbar-nav">

                        <li class="dropdown col-lg-2" id="navielem"><a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Catégories<span lass="caret"></span></a>

                            <ul class="dropdown-menu">
                              <li><a href="Livres.php" title="Livres">Livres</a></li>
                              <li><a href="Musique.php" title="Musique">Musique</a></li>
                              <li><a href="Vetements.php" title="Vetements">Vêtements</a></li>
                              <li><a href="Sport_loisirs.php" title="Sports_loisirs">Sports et Loisirs</a></li>
                            </ul>
                         </li>

                         <li class="dropdown col-lg-2" id="navielem"><a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Ventes flash<span lass="caret"></span></a>

                            <ul class="dropdown-menu">
                                Best sellers
                              <li><a href="VFlivres.php" title="Livres">Livres</a></li>
                              <li><a href="VFmusique.php" title="Musique">Musique</a></li>
                              <li><a href="VFvetements.php" title="Vetements">Vêtements</a></li>
                              <li><a href="VFsport_loisirs.php" title="Sports_loisirs">Sports et Loisirs</a></li>
                            </ul>
                         </li>                 

                         <li class="nav-item col-lg-2" id="navielem"><a class="nav-link" href="formulaireconnexionvendeur.php">Vendre</a></li>
                         <li class="nav-item col-lg-2" id="navielem"><a class="nav-link" href="formulaireconnexionacheteur.php?origine=header">Votre compte</a></li>
                         <li class="nav-item col-lg-2" id="navielem"><a class="nav-link" href="formulaireconnexionadmin.php">Admin</a></li>
                         <li class="nav-item col-lg-2" id="navielem"><div class ='pagepanier'><a href='panier.php'><img src='panier.jpg' style='height:100%; width:100%;'></a></div></li>
                         
                     </ul>
                 </div>
            </nav>
        </header>  
        
    <body>
        
        <div id="carrousel">
            <ul>
                <li><img src="france1.jpg" width="700" height="400"></li>
                <li><img src="france2.jpg" width="700" height="400"></li>
                <li><img src="france3.jpg" width="700" height="400"></li>
                <li><img src="france4.jpg" width="700" height="400"></li>
                <li><img src="france5.jpg" width="700" height="400"></li>
                <li><img src="france6.jpg" width="700" height="400"></li>
                <li><img src="france7.jpg" width="700" height="400"></li>
            
            </ul>
        </div>
        
    </body>
    
    <footer class="page-footer">
            
            <div class="container">
                <div class="row">
                    <p class="col-lg-4" id="description">
                     37, quai de Grenelle, 75015 Paris, France <br>
                     info@webDynamique.ece.fr <br>
                     +33 01 02 03 04 05 <br>
                     +33 01 03 02 05 04
                     </p>

                    <div  class="row col-lg-5" id="equipe">
                        <div  class="col-lg-3" id="equipier">
                            <img src="Xavier.jpg" class="rounded-circle" >
                            <p>Xavier Koczan</p>
                        </div>
                        <div  class="col-lg-3" id="equipier">
                            <img src="Jean.jpg" class="rounded-circle" >
                            <p>Jean Prouvost Filippini</p>
                        </div>
                            <div  class="col-lg-3" id="equipier">
                            <img src="Guillaume.JPG" class="rounded-circle" >
                        <p>Guillaume Le Loher</p>
                        </div>

                    </div>
                    <div class="col-lg-5" id="hyperlien">
                        <a href="#"  id="contact">Nous Contacter!</a>
                        <a href="#"  id="suivre">Nous Suivre!</a>
                        <a href="#"  id="faq">FAQ</a>
                    </div>
                </div>    
            </div>
            
            
        </footer>
    
</html>

