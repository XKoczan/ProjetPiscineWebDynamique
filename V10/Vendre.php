<!DOCTYPE html>
<?php session_start();
//initialisation des variables de connexion et connexion au serveur SQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname="ecesale";
$conn = mysqli_connect($servername, $username, $password,$dbname);
// Vérification que la connexion a bien été faite
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}
//traiter le formulaire quand le bouton est appuyé (on vérifie aussi que les deux autres boutons ont été appuyé d'abord)
if(isset($_POST['test'])){
    if($_POST['varianteclicked']=="true" && $_POST['modeleclicked']=="true"){
    //récupération du nombre de photos, de variantes
    $nbvariantes=(int) $_POST['variantenb'];
    $variante="";
    $nbphoto=$_POST['nbphoto'];
    $canreturn=true;
    //requête SQL d'insertion dans catalogue dans le cas où il n'y a pas de variante
    if($nbvariantes ==0)
    {
        //on distingue si l'utilisateur est un administrateur, auquel cas idvendeur est null. idvendeur null indique que le site vend l'objet
        if(isset($_SESSION['is_admin']))
        {
            $sql = "INSERT INTO catalogue (nom, categorie)
        VALUES ('".$_POST['Nom']."', '".$_POST['Categorie']."')";
        }else{
            $sql = "INSERT INTO catalogue (nom, idvendeur, categorie)
        VALUES ('".$_POST['Nom']."', ".$_SESSION['id'].", '".$_POST['Categorie']."')";
        }
    }else{
        //récupération dans une string de toutes les variantes, on les sépare par des ; pour pouvoir utiliser explode afin de les récupérer
        for($i=0; $i<$nbvariantes; $i++)
        {
            if($i==0)
            {
                $variante .=$_POST["variante".strval($i)];
            }
            else{
                $variante =$variante.";".$_POST["variante".strval($i)];
            }
        }
        //a nouveau distinction admin / pas admin
        if(isset($_SESSION['is_admin']))
        {
            $sql = "INSERT INTO catalogue (nom, categorie, variantes)
            VALUES ('".$_POST['Nom']."','".$_POST['Categorie']."', '".$variante."')";
        }else{
            $sql = "INSERT INTO catalogue (nom, idvendeur, categorie, variantes)
            VALUES ('".$_POST['Nom']."', ".$_SESSION['id'].", '".$_POST['Categorie']."', '".$variante."')";
        }
    }
    //récupération du nombre de modèle
    $nbmodele=(int) $_POST['modelenb'];
    //on essaie de réaliser la requête SQL, interdit de quitter la page si elle rate
    if (mysqli_query($conn, $sql)) {
    } else {
        echo "il y a eu une erreur lors de l'ajout de l'article";
        $canreturn=false;
    }
    //on upload et récupère les noms des photos, on effectue des vérifications sur le fichier en même temps afin de s'assurer de sa nature
    $id_article=mysqli_insert_id($conn);
    for($i=0; $i<$nbmodele; $i++)
    {
        $target_dir="catalogue"."/".$id_article."/";
        if(!is_dir($target_dir)){
            mkdir($target_dir,0777,true);
        }
        $photo="";
        for($j=0; $j<$nbphoto; $j++)
        {
            
            $target_photo=$target_dir.basename($_FILES[$i."photo".$j]["name"]);
            $filetypephoto=strtolower(pathinfo($target_photo,PATHINFO_EXTENSION));
            if(file_exists($_FILES[$i."photo".$j]['tmp_name']) && is_uploaded_file($_FILES[$i."photo".$j]['tmp_name']))
            {
                $check=getimagesize($_FILES[$i."photo".$j]["tmp_name"]);
                if($check !== false)
                {
                    if(!file_exists($target_photo))
                    {
                        if ($_FILES[$i."photo".$j]["size"] < 550000)
                        {
                            if($filetypephoto =="jpg" || $filetypephoto == "png" || $filetypephoto == "jpeg")
                            {
                                if (move_uploaded_file($_FILES[$i."photo".$j]["tmp_name"], $target_photo)) 
                                {
                                    if($j==0)
                                    {
                                        $photo =$photo.$_FILES[$i."photo".$j]["name"];
                                    }else{
                                        $photo =$photo.";".$_FILES[$i."photo".$j]["name"];
                                    }
                                }
                                else
                                {
                                    echo "Il y a eu une erreur lors de l'upload d'une photo.Réessayez";
                                    $canreturn=false;
                                }
                            }
                            else
                            {
                                echo "Une photo n'est pas enregistré sous un format autorisé (jpg,png,jpeg)";
                                $canreturn=false;
                            }
                        }
                        else
                        {
                            echo "Une photo est trop volumineuse";
                            $canreturn=false;
                        }
                    }
                }
                else
                {
                    echo "Un fichier photo n'est pas une image";
                    $canreturn=false;
                }
            }
            else{
                if($j==0)
                {
                    $photo =$photo.$_FILES[$i."photo".$j]["name"];
                }else{
                    $photo =$photo.";".$_FILES[$i."photo".$j]["name"];
                }
            }
        }
        $video="";
        //on upload maintenant la video et on recupere son nom. Comme pour les photos, l'upload est blindé. Nous avons choisi les MIME les plus courant
        $target_video=$target_dir.basename($_FILES[$i."video"]["name"]);
        $filetypevideo=strtolower(pathinfo($target_video,PATHINFO_EXTENSION));
        //on vérifie que l'utilisateur a bien upload un fichier
        if(file_exists($_FILES[$i.'video']['tmp_name']) && is_uploaded_file($_FILES[$i.'video']['tmp_name']))
        {
                if ($_FILES[$i.'video']["size"] < 10000000)
                {
                    if($filetypevideo =="mp4" || $filetypevideo == "ogg" || $filetypevideo == "webm" || $filetypevideo == "ogv")
                    {
                        if (move_uploaded_file($_FILES[$i."video"]["tmp_name"], $target_video)) 
                        {
                            $video=$video.$_FILES[$i."video"]["name"];
                        }
                        else
                        {
                            echo "Il y a eu une erreur lors de l'upload d'une vidéo. Réessayez";
                            $canreturn=false;
                        }
                    }
                    else
                    {
                        echo "Une vidéo n'est pas enregistré sous un format autorisé (mp4,ogg,webm, ogv)";
                        $canreturn=false;
                    }
                }
                else
                {   
                    echo "Une vidéo est trop volumineuse";
                    $canreturn=false;
                }
        }
        //on distingue la requête en fonction du nombre de modèle car un article avec un seul modèle n'a pas de nom de modèle
        if($nbmodele == 1)
        {
            $sql = "INSERT INTO cataloguemodele (prix, idprod, photos, video, description, stock, nb_vente)
            VALUES (".$_POST[$i."prix"].", ".$id_article.", '".$photo."', '".$video."', '".$_POST[$i.'Description']."', ".$_POST[$i.'stock'].", 0)";
        }else{
            $sql = "INSERT INTO cataloguemodele (nommodele, prix, idprod, photos, video, description, stock, nb_vente)
            VALUES ('".$_POST[$i.'nommodele']."', ".$_POST[$i."prix"].", ".$id_article.", '".$photo."', '".$video."', '".$_POST[$i.'Description']."', ".$_POST[$i.'stock'].", 0)";
        }
        if (mysqli_query($conn, $sql)) {
        } else {
            $canreturn=false;
        }
    }
    //si le code c'est passé sans encombre, on laisse l'utilisateur retourner à sa page d'origine
    if($canreturn==true)
    {
        if(isset($_SESSION['is_admin']))
        {
            header("Location:http://www.localhost/admin.php");
        }else{
            header("Location:http://www.localhost/pagevendeur.php");
        }
    }
}else{
    echo"<span>vous devez appuyer sur les deux autres boutons d'abord</span>";
}
}
require 'header.php';
?>
<html>
    <head>
    <meta charset="utf-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="Formulaire-panier.css">
        <link rel="icon" href="ECE-Paris.ico" />
            <script type='text/javascript'>
                function addvariante(){
                    //cette fonction sert à faire apparaitre dynamiquement les boutons pour rentrer les variantes en maintenant la mise en page
                    // Number of inputs to create
                    var number = document.getElementById("variante").value;
                    //on stock que le bouton a été clické
                    var is_clicked = document.getElementById("varianteclicked");
                    is_clicked.value="true";
                    //on stock le nombre rentré dans une variable caché pour que l'utilisateur ne puisse pas casser le code
                    var nbvariante = document.getElementById("variantenb");
                    nbvariante.value = number.toString();
                    // Container <div> where dynamic content will be placed
                    var container = document.getElementById("container");
                    // Clear previous contents of the container
                    while (container.hasChildNodes()) {
                        container.removeChild(container.lastChild);
                    }
                    for (i=0;i<number;i++){
                        // Append a node with a random text
                        // Create an <input> element, set its type and name attributes
                        var div=document.createElement("div");
                        div.classList.add("form-group");
                        var input = document.createElement("input");
                        input.type = "text";
                        input.name = "variante" + i;
                        input.classList.add("champ");
                        input.classList.add("form-control");
                        input.required;
                        container.appendChild(div);
                        div.appendChild(document.createTextNode("variante " + (i+1)));
                        div.appendChild(input);
                        // Append a line break 
                        container.appendChild(document.createElement("br"));
                    }
                }
                function addmodele(){
                    //cette fonction sert à faire apparaitre dynamiquement les champs correspondant aux informations d'un modèle

                    // Number of inputs to create
                    var number = document.getElementById("modele").value;

                    //on stock que le bouton a été clické
                    var is_clicked = document.getElementById("modeleclicked");
                    is_clicked.value="true";
                    //on stock le nombre rentré dans une variable caché pour que l'utilisateur ne puisse pas casser le code
                    var nbvariante = document.getElementById("modelenb");
                    nbvariante.value = number.toString();

                    // Container <div> where dynamic content will be placed
                    var container = document.getElementById("modeleconteneur");
                    // Clear previous contents of the container
                    while (container.hasChildNodes()) {
                        container.removeChild(container.lastChild);
                    }
                    if(number==0)
                    {
                        //on force à au moins un modèle
                        number=1;
                    }
                    var nbphoto = document.getElementById("nbphoto").value;
                    if(nbphoto==0)
                    {
                        nbphoto=1;
                    }
                    while (container.hasChildNodes()) 
                    {
                        container.removeChild(container.lastChild);
                    }
                    for (j=0;j<number;j++){
                        //on créé une division par modèle, division qu'on va peupler avec les fields, faire attention a bien nomer chaque champ
                        var modelediv=document.createElement("div");
                        container.appendChild(modelediv);
                        modelediv.classList.add("modele");
                        var d=document.createElement("header");
                        var b=j+1;
                        d.appendChild(document.createTextNode("Modele "+b));
                        modelediv.appendChild(d);
                        //les paragraphes suivants servent à créer chaque champ en maintenant la mise en page
                        //pour le nom de modèle on vérifie qu'il y a plus d'un modèle
                        if(number !=1)
                        {
                            var div5=document.createElement("div");
                            var input5=document.createElement("input");
                            input5.name=j+"nommodele";
                            input5.type="text";
                            input5.required;
                            input5.classList.add("champ");
                            input5.classList.add("form-control");
                            div5.classList.add("form-group");
                            modelediv.appendChild(div5);
                            div5.appendChild(document.createTextNode("Nom du modèle:"));
                            div5.appendChild(input5);
                        }
                        //important d'ajouter toutes les class à chaque division et champ, et à bien paramétrer les champs
                        var div=document.createElement("div");
                        var input=document.createElement("input");
                        input.name=j+"prix";
                        input.type="text";
                        input.required;
                        input.classList.add("champ");
                        input.classList.add("form-control");
                        div.classList.add("form-group");
                        modelediv.appendChild(div);
                        div.appendChild(document.createTextNode("Prix"));
                        div.appendChild(input);

                        //pour les photos on fait apparaitre n champs, n correspondant au nombre de photos rentré par l'utilisateur
                        for(i=0; i<nbphoto; i++)
                        {
                            var div2=document.createElement("div");
                            var input2=document.createElement("input");
                            input2.name=j+"photo"+i;
                            input2.type="file";
                            input2.required;
                            input2.classList.add("champ");
                            input2.classList.add("form-control");
                            div2.classList.add("form-group");
                            modelediv.appendChild(div2);
                            div2.appendChild(document.createTextNode("Photo "+i+":"));
                            div2.appendChild(input2);
                        }

                        var div3=document.createElement("div");
                        var input3=document.createElement("input");
                        input3.name=j+"video";
                        input3.type="file";
                        input3.classList.add("champ");
                        input3.classList.add("form-control");
                        div3.classList.add("form-group");
                        modelediv.appendChild(div3);
                        div3.appendChild(document.createTextNode("Vidéo:"));
                        div3.appendChild(input3);

                        var div4=document.createElement("div");
                        var input4=document.createElement("input");
                        input4.name=j+"Description";
                        input4.type="text";
                        input4.required;
                        input4.placeholder="Entrez votre description";
                        input4.classList.add("champ");
                        input4.classList.add("form-control");
                        div4.classList.add("form-group");
                        modelediv.appendChild(div4);
                        div4.appendChild(document.createTextNode("Description:"));
                        div4.appendChild(input4);

                        var div7=document.createElement("div");
                        var input7=document.createElement("input");
                        input7.name=j+"stock";
                        input7.type="text";
                        input7.required;
                        input7.classList.add("champ");
                        input7.classList.add("form-control");
                        div7.classList.add("form-group");
                        modelediv.appendChild(div7);
                        div7.appendChild(document.createTextNode("Stock:"));
                        div7.appendChild(input7);
                    }
                }
                //le formulaire est adapté à accueillir des fichiers grâce à l'attribut enctype
            </script>

        </head>
        <title>ECE Amazon Formulaire de vente</title>
    </head>
    
    <body>
        <h1>Formulaire de vente:</h1>
        <h3>Compléter le formulaire afin de mettre en vente votre article:</h3>
        
            <form method="post" class="needs-validation" enctype="multipart/form-data">
                
                <div class="form-group"> 
                    Nom de l'article:
                    <input type="text" class="form-control" name="Nom" class="champ" placeholder="Entrer Nom" required><br>
                </div>
                <div class="form-group">
                    Catégorie
                    <Select name="Categorie" size="1">
                            <OPTION>Livres</OPTION>
                            <OPTION>Musique</OPTION>
                            <OPTION>Vetements</OPTION>
                            <OPTION>Loisirs et sports</OPTION>
                        </Select>
                    <br>
                </div>
                
                <div class="form-group">
                    Nombre de photos de l'article (minima de 1 photo):
                    <input type="number" class="form-control" name="nbphoto" id="nbphoto" placeholder="Entrez le nombre de photos">
                </div>
                <div class="form-group"> 
                    Nombre de variantes:
                    <input type="number" class="form-control" name="variante" class="champ" id="variante" placeholder="0 si pas de variante" ><input type="button" name="variablebutton"value="Définir nombre de variantes" onclick="addvariante()"/><input type="hidden" id="varianteclicked" name="varianteclicked"value="false"><input type="hidden" id="variantenb" name="variantenb" value=""><br>
                </div>
                <div id="container" ></div>
                <div class="form-group"> 
                    Nombre de modèles:
                    <input type="number" class="form-control" name="nbmodele" class="champ" id="modele" placeholder="Entrez votre nombre de modèle" ><input type="button" name="modelebutton" value="Définir nombre de modèles" onclick="addmodele()"/><input type="hidden" id="modeleclicked" name="modeleclicked" value="false"><input type="hidden" id="modelenb" name="modelenb" value=""><br>
                </div>
                <div id="modeleconteneur"></div>
                <input type="submit" name="test" id="bouton" value="Mettre en vente">
            </form>
    </body>
</html>
     