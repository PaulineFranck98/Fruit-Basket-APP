<?php 

     session_start();
     require 'functions.php';
     if(isset($_SESSION['success'])){
        echo "<div class='alert-success'>". $_SESSION['success']. "</div>";
        unset($_SESSION['success']);
     }
     if(isset($_SESSION['error'])){
        echo "<div class='alert-error'>". $_SESSION['error']. "</div>";
        unset($_SESSION['error']);
     }
     
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/d004286c36.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Ms+Madi&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <title>Ajout produit</title>
</head>
<body>
    <!-- <div class="titre">
        <p>Nombre de produits en session : <?= nombreProduitsSession()?> </p> -->
        <!-- form contient 2 attributs : 
            - action -> indique la cible du formulaire, le fichier à atteindre lorsque l'utilisateur soumet le formulaire 
            - method -> précise par quelle méthode HTTP les données du formulaire seront transmises au serveur  
            -> ici, on utilise : POST pour ne pas polluer l'URL avec les données sur formulaire  -->
    <header>
        <h1>Fruit'<span class='mot-vert'>n</span>'Click  <i class="fa-regular fa-lemon" style="color: #8dd912;"></i></h1>
        <h2 class="slogan">le fruit à portée de click</h2>
        <nav>
            <ul>
                <li><a href="recap.php">Mon panier <i class="fa-solid fa-basket-shopping" style="color: #8dd912;"></i></a></li>
                <li><a href="">Nos engagements</i></a></li>
                <li><a href="">Contact</i></a></li>
                <li><a href="">A propos</a></li>
                <li><a href="">Actualités</a></li>
                
            </ul>
        </nav>
    </header>
        <div class="container">
            <figure>
                <img src="fruitsboom3.jpg" class="image">
            </figure>
            <div class="form-container1">
                <h2 class="titre2">Ajouter un nouveau produit</h2>
                <div class="form-container">
                    <form action="traitement.php?action=add" method="post">
                        <div class=form-group>
                            <label>
                                Nom du produit :
                                <!-- chaque input dispose d'un attribut "name"
                                -> va permettre à la requête de classer le contenu de la saisie dans des clés portant le nom choisi 
                                -> ainsi, var_dump($_POST) donnera : "name"-> "", "price"-> "", "qtt"-> "",  après saisie et soumission-->
                                <input type="text" name="name"> 
                            </label> 
                        </div> 
                        <div class=form-group>
                            <label>
                                Prix du produit :
                                <!-- possède attribut name -->
                                <input type="number" step="any" name="price"> 
                            </label> 
                        </div>
                        <div class=form-group>
                            <label>
                                Quantité désirée :
                                <!-- possède attribut name -->
                                <input type="number" name="qtt" value="1"> 
                            </label> 
                        </div> 
                        <div class=form-group>
                            <!-- possède AUSSI attribut name : permettra de vérifier côté serveur que le formulaire a bien été validé par l'utilisateur -->
                            <input type="submit" name="submit" value="Ajouter le produit">
                        </div>
                    </form>
                </div>
            </div>
        </div> 
   
 
        
  
</body>
</html>