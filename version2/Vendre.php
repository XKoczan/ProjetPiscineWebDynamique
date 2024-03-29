<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="Formulaire-panier.css">
        <link rel="icon" href="ECE-Paris.ico" />
        <head>
            <script type='text/javascript'>
                function addvariante(){
                    // Number of inputs to create
                    var number = document.getElementById("variante").value;
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
                    // Number of inputs to create
                    var number = document.getElementById("modele").value;
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
                        var b=j+1
                        d.appendChild(document.createTextNode("Modele "+b));
                        modelediv.appendChild(d);
                        
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
                        input3.required;
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
            </script>

        </head>
        <title>ECE Amazon Formulaire de vente</title>
    </head>
    
    <body>
        <header>
                <a href="ProjetPiscine.html"><img id="logo" src="ECE-Paris.jpg" width= 20% height= 20%></a>
        </header>
        <h1>Formulaire de vente:</h1>
        <h3>Compléter le formulaire afin de mettre en vente votre article:</h3>
        
            <form action="Vendre.php" method="post" class="needs-validation" enctype="multipart/form-data">
                
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
                    <input type="number" class="form-control" name="variante" class="champ" id="variante" placeholder="0 si pas de variante" ><a href="#" id="boutonvariante" onclick="addvariante()">Définir</a><br>
                </div>
                <div id="container" ></div>
                <div class="form-group"> 
                    Nombre de modèles:
                    <input type="text" class="form-control" name="nbmodele" class="champ" id="modele" placeholder="Entrez votre nombre de modèle" ><a href="#" id="boutonmodele" onclick="addmodele()">Définir</a><br>
                </div>
                <div id="modeleconteneur"></div>
                <input type="submit" name="submit" id="bouton" value="Mettre en vente">
            </form>
    </body>
</html>
<? php 
session_start();
            
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
if(isset($_POST['submit'])){
    $nbvariantes=$_POST['variante'];
    $variante="";
    $nbphoto=$_POST['nbphoto'];
    for($i=0; $i<$nbvariante; $i++)
    {
        $variante .=$_POST["variante".strval($i)]; 
    }
    $sql = "INSERT INTO catalogue (nom, idvendeur, categorie, variantes)
    VALUES (".$_POST['Nom'].", ".$_SESSION['id'].", ".$_POST['Categorie'].", ".$variante.")";
    $nbmodele=$_POST['nbmodele'];
    if (mysqli_query($conn, $sql)) {
    } else {
        ?><span><?php echo "il y a eu une erreur lors de l'ajout de l'article";?></span><?php;
        $canreturn=false;
    }
    //on upload et récupère les noms des photos
    $id_article=mysqli_insert_id($con);
    for($i=0; $i<$nbmodele; $i++)
    {
        $target_dir="/catalogue"."/".$id_article."/".$i."/";
        for($j=0; $j<$nbphoto; $j++)
        {
            $photo="";
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
                                    if(j==1)
                                    {
                                        $photo =$photo.$_FILES[$i."photo".$j]["name"];
                                    }else{
                                        $photo =$photo.";".$_FILES[$i."photo".$j]["name"];
                                    }
                                }
                                else
                                {
                                    echo "<span>Il y a eu une erreur lors de l'upload d'une photo.Réessayez</span>";
                                    $canreturn=false;
                                }
                            }
                            else
                            {
                                echo "<span>Une photo n'est pas enregistré sous un format autorisé (jpg,png,jpeg)</span>";
                                $canreturn=false;
                            }
                        }
                        else
                        {
                            echo "<span>Une photo est trop volumineuse</span>";
                            $canreturn=false;
                        }
                    }
                }
                else
                {
                    echo "<span>Un fichier photo n'est pas une image</span>";
                    $canreturn=false;
                }
            }
        }

        //on upload maintenant la video et on recupere le nom
        $target_video=$target_dir.basename($_FILES[$j."video"]["name"]);
        $filetypevideo=strtolower(pathinfo($target_video,PATHINFO_EXTENSION));
        if(file_exists($_FILES[$j.'video']['tmp_name']) && is_uploaded_file($_FILES[$j.'video']['tmp_name']))
        {
            $check=getimagesize($_FILES[$j.'video']["tmp_name"]);
            if($check !== false)
            {
                if ($_FILES[$j.'video']["size"] < 10000000)
                {
                    if($filetypevideo =="mp4" || $filetypevideo == "ogg" || $filetypevideo == "webm" || $filetypevideo == "ogv")
                    {
                        if (move_uploaded_file($_FILES[$j."video"]["tmp_name"], $target_video)) 
                        {
                            $video=$_FILES[$j."video"]["name"];
                        }
                        else
                        {
                            echo "<span>Il y a eu une erreur lors de l'upload d'une vidéo. Réessayez</span>";
                            $canreturn=false;
                        }
                    }
                    else
                    {
                        echo "<span>Une vidéo n'est pas enregistré sous un format autorisé (jpg,png,jpeg)</span>";
                        $canreturn=false;
                    }
                }
                else
                {
                    echo "<span>Une vidéo est trop volumineuse</span>";
                    $canreturn=false;
                }
            }
        }

        //requête insert en cas d'un seul modèle
        if($nbmodele == 1)
        {
            
            $sql = "INSERT INTO cataloguemodele (prix, idprod, photos, video, description, stock)
            VALUES (".$_POST[$i."Prix"].", ".$id_article.", ".$photo.", ".$video.", ".$_POST[$i.''].", ".$_POST[$i.'stock'].")";
        }else{
            $sql = "INSERT INTO cataloguemodele (nom, prix, idprod, photos, video, description, stock)
            VALUES (".$_POST[$i.'nommodele'].", ".$_POST[$i."Prix"].", ".$id_article.", ".$photo.", ".$video.", ".$_POST[$i.''].", ".$_POST[$i.'stock'].")";
        }
        if (mysqli_query($conn, $sql)) {
        } else {
            $canreturn=false;
        }
    }
    if($canreturn==true)
    {
        header("Location:http://www.localhost/pagevendeur.php");
    }
}
?>
     